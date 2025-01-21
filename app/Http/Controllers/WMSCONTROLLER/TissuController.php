<?php

namespace App\Http\Controllers\WMSCONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\CategorieTissus;
use App\Models\ClasseMatierePremiere;
use App\Models\FamilleTissus;
use App\Models\Tiers;
use App\Models\UniteMesureMatierePremiere;
use App\Models\UniteMonetaire;
use App\Models\V_donne_bc;
use App\Models\WMSModel\Cellule_EntreeTissu;
use App\Models\WMSModel\Cellule_StockTissu;
use App\Models\WMSModel\EntreeTissu;
use App\Models\WMSModel\Magasin;
use App\Models\WMSModel\Retour_Tissu;
use App\Models\WMSModel\SortieTissu;
use App\Models\WMSModel\StockTissu;
use App\Models\WMSModel\StockTissu_Tiers_Modele;
use App\Models\WMSModel\UtilisationWMS;
use App\Models\WMSModel\V_Parite;
use App\Models\WMSModel\V_Rack_Cellule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TissuController extends Controller
{
    public function conversion_devise_euro($prixUnitaire, $idUniteMonetaire, $dateFacturation)
    {
        $carbonDate = Carbon::parse($dateFacturation);
        $month = $carbonDate->format('m');
        $year = $carbonDate->format('Y');
        $parite = V_Parite::where('mois', $month)->where('annee', $year)->first();
        if ($idUniteMonetaire == 2) {//*Dollar
            $prixUnitaire = $prixUnitaire / $parite->valeur;
        }
        if ($idUniteMonetaire == 3) {//*MGA
            $prixUnitaire = $prixUnitaire / $parite->deviseeuro;
        }

        return $prixUnitaire;
    }

    public function ajout_entree_tissu_par_bc($iddonnebc, $idFamilleTissu)
    {
        $familleTissu = FamilleTissus::find($idFamilleTissu);
        $data = V_donne_bc::where('id_donne_bc', $iddonnebc)->first();
        $data['idfamilletissu'] = $idFamilleTissu;
        $catTissu = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $uniteCommande = UniteMesureMatierePremiere::where('etat', 0)->get();
        $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
        $cellule = V_Rack_Cellule::where('section', 'ILIKE', '%Tissu%')->get();

        // return $cellule;

        return view('WMS.Tissu.entreeTissu', compact('data', 'catTissu', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'uniteCommande', 'uniteMonetaire', 'cellule', 'iddonnebc', 'familleTissu'));
    }

    public function ajout_entre_tissu(Request $request)
    {
        $data = $request->except('cellule');
        $cellule = $request->input('cellule');
        $parite = $this->verif_parite($data['datefacturation']);
        $validationData = EntreeTissu::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($parite == false) {
            $errorMessage = 'Il n\'y a pas encore de parité sur le mois choisi';

            return back()->withErrors(['error' => $errorMessage]);
        }
        $data['prixunitaire'] = $this->conversion_devise_euro($data['prixunitaire'], $data['idunitemonetaire'], $data['datefacturation']);
        if ($validator->fails() || empty($cellule)) {
            $errors = $validator->errors();
            if (empty($cellule)) {
                $errors->add('cellule', 'Veuillez choisir la/les cellules à utiliser');
            }

            return redirect()->back()->withErrors($errors)->withInput();
        }
        $data['tauxecart'] = ($data['qterecu'] / $data['qtecommande']) * 100;
        $data['resterecevoir'] = $data['qtecommande'] - $data['qterecu'];
        try {
            DB::beginTransaction();
            $entreeTissu = new EntreeTissu($data);
            $res = $entreeTissu->save();
            $this->ajout_cellule_tissu_entree($cellule, $entreeTissu->id);
            $idstocktissu = $this->ajout_stock_tissu($data, $cellule);
            $entreeTissu->idstocktissu = $idstocktissu;
            $entreeTissu->save();
            $this->ajout_magasin($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement des données, veuillez réessayer.'.$e;

            return back()->withInput()->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }

    public function ajout_magasin($dataEntree)
    {
        $getMagasin = Magasin::where('id_donne_bc', $dataEntree['iddonnebc'])->first();

        if (! empty($getMagasin)) {
            $getMagasin->quantite += $dataEntree['qterecu'];

            // Calcul de la nouvelle valeur de 'reste', mais en s'assurant qu'elle ne devienne pas négative.
            $getMagasin->reste = max(0, $getMagasin->reste - $dataEntree['resterecevoir']);

            $getMagasin->save();
        } else {
            $dataMagasin = [];
            $dataMagasin['id_donne_bc'] = $dataEntree['iddonnebc'];
            $dataMagasin['datearrivereelle'] = $dataEntree['dateentree'];
            $dataMagasin['bl'] = $dataEntree['numerobl'];
            $dataMagasin['quantite'] = $dataEntree['qterecu'];
            $dataMagasin['reste'] = $dataEntree['resterecevoir'];
            $dataMagasin['numero'] = $dataEntree['numerofacture'];
            $magasin = new Magasin($dataMagasin);
            $magasin->save();
        }

    }

    public function ajout_cellule_tissu_entree($cellule, $identretissu)
    {
        for ($i = 0; $i < count($cellule); $i++) {
            $celluleEntree = new Cellule_EntreeTissu();
            $celluleEntree->idcellule = $cellule[$i];
            $celluleEntree->identreetissu = $identretissu;
            $celluleEntree->save();
        }
    }

    public function ajout_cellule_tissu_stock($cellule, $idstocktissu)
    {
        for ($i = 0; $i < count($cellule); $i++) {
            // This will either find the existing record or create and save a new one
            Cellule_StockTissu::firstOrCreate([
                'idcellule' => $cellule[$i],
                'idstocktissu' => $idstocktissu,
            ]);
        }
    }

    public function ajout_stock_tissu($dataEntree, $cellule)
    {
        $dataStockTiersModele = [];
        $dataStockTiersModele['idclient'] = $dataEntree['idclient'];
        $dataStockTiersModele['modele'] = $dataEntree['modele'];
        $dataStock = [];

        $dataStock['idcategorietissus'] = $dataEntree['idcategorietissus'];
        $dataStock['idclassematierepremiere'] = $dataEntree['idclassematierepremiere'];
        $dataStock['idutilisationwms'] = $dataEntree['idutilisationwms'];
        $dataStock['reference'] = $dataEntree['reftissu'];
        $dataStock['designation'] = $dataEntree['designation'];
        $dataStock['composition'] = $dataEntree['composition'];
        $dataStock['couleur'] = $dataEntree['couleur'];
        $dataStock['idfournisseur'] = $dataEntree['idfournisseur'];
        $dataStock['saison'] = $dataEntree['saison'];
        $dataStock['laize'] = $dataEntree['laize'];
        $dataStock['qtestock'] = $dataEntree['qterecu'];
        $dataStock['prixunitaire'] = $dataEntree['prixunitaire'];
        $dataStock['idunitemesurematierepremiere'] = $dataEntree['idunitemesurematierepremiere'];
        $dataStock['idfamilletissus'] = $dataEntree['idfamilletissus'];
        $stockTissu = new StockTissu($dataStock);
        $stockTissu->save();
        $dataStockTiersModele['idstocktissu'] = $stockTissu->id;
        $stockTiersModele = new StockTissu_Tiers_Modele($dataStockTiersModele);
        $stockTiersModele->save();
        $this->ajout_cellule_tissu_stock($cellule, $stockTissu->id);

        return $stockTissu->id;
    }

    public function rajout_stock($iddonnebc, $idStock)
    {
        $stock = StockTissu::find($idStock);
        $data = V_donne_bc::where('id_donne_bc', $iddonnebc)->first();
        $data['idfamilletissu'] = $stock->idfamilletissus;
        $catTissu = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $uniteCommande = UniteMesureMatierePremiere::where('etat', 0)->get();
        $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
        $cellule = V_Rack_Cellule::where('section', 'ILIKE', '%Tissu%')->get();

        return view('WMS.Tissu.rajout-tissu', compact('data', 'catTissu', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'uniteCommande', 'uniteMonetaire', 'cellule', 'iddonnebc', 'stock'));

    }

    public function verif_parite($date)
    {
        $carbonDate = Carbon::parse($date);
        $month = $carbonDate->format('m');
        $year = $carbonDate->format('Y');
        $parite = V_Parite::where('mois', $month)->where('annee', $year)->first();
        if (empty($parite)) {
            return false;
        }

        return true;
    }

    public function insert_rajout(Request $request)
    {
        $data = $request->except('cellule');
        $parite = $this->verif_parite($data['datefacturation']);
        $cellule = $request->input('cellule');
        $validationData = EntreeTissu::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($parite == false) {
            $errorMessage = 'Il n\'y a pas encore de parité sur le mois choisi';

            return back()->withErrors(['error' => $errorMessage]);
        }
        $data['prixunitaire'] = $this->conversion_devise_euro($data['prixunitaire'], $data['idunitemonetaire'], $data['datefacturation']);
        if ($validator->fails() || empty($cellule)) {
            $errors = $validator->errors();
            if (empty($cellule)) {
                $errors->add('cellule', 'Veuillez choisir la/les cellules à utiliser');
            }

            return redirect()->back()->withErrors($errors)->withInput();
        }
        $data['tauxecart'] = ($data['qterecu'] / $data['qtecommande']) * 100;
        $data['resterecevoir'] = $data['qtecommande'] - $data['qterecu'];
        try {
            DB::beginTransaction();
            $this->rajout_stock_tissu($data, $cellule);
            $entreeTissu = new EntreeTissu($data);
            $res = $entreeTissu->save();
            $this->ajout_cellule_tissu_entree($cellule, $entreeTissu->id);
            $this->ajout_magasin($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement des données, veuillez réessayer.'.$e;

            return back()->withInput()->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }

    public function rajout_stock_tissu($data, $cellule)
    {
        $dataStockTiersModele = [];
        $dataStockTiersModele['idclient'] = $data['idclient'];
        $dataStockTiersModele['modele'] = $data['modele'];
        $stockTissu = StockTissu::find($data['idstocktissu']);
        $prixTotaleEntree = $data['prixunitaire'] * $data['qterecu'];
        $prixTotaleStock = $stockTissu->qtestock * $stockTissu->prixunitaire;
        $stockTissu->qtestock += $data['qterecu'];
        $stockTissu->prixunitaire = ($prixTotaleEntree + $prixTotaleStock) / $stockTissu->qtestock;

        $stockTissu->save();
        $dataStockTiersModele['idstocktissu'] = $stockTissu->id;
        $stockTiersModele = StockTissu_Tiers_Modele::firstOrCreate($dataStockTiersModele);
        $stockTiersModele->save();
        // TODO: A voir si on va faire les cellules unique ou avec doublon
        $this->ajout_cellule_tissu_stock($cellule, $data['idstocktissu']);
    }

    public function sortie_stock_tissu(Request $request)
    {
        $data = $request->all();
        if ($this->verif_quantite_stock($data['idstocktissu'], $data['qtesortie']) == false) {
            $errorMessage = 'Quantité insuffisante';

            return back()->withErrors(['error' => $errorMessage]);
        }
        $validationData = SortieTissu::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect()->back()->withErrors($errors)->withInput();
        }
        try {
            DB::beginTransaction();
            $sortieTissu = new SortieTissu($data);
            $res = $sortieTissu->save();
            $this->retrait_stock($data['idstocktissu'], $data['qtesortie']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement des données, veuillez réessayer.'.$e;

            return back()->withInput()->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }

    // *Verifie si la quantité est pas
    public function verif_quantite_stock($idStock, $qteSortie)
    {
        $stock = StockTissu::find($idStock);
        if ($stock->qtestock < $qteSortie) {
            return false;
        }

        return true;
    }

    public function retrait_stock($idStock, $qteSortie)
    {
        $stock = StockTissu::find($idStock);
        $stock->qtestock -= $qteSortie;
        $stock->save();
    }

    public function verif_quantite_retour($qteSortie, $qteRetour)
    {
        if ($qteRetour > $qteSortie) {
            return false;
        }

        return true;
    }

    public function retour_tissu(Request $request)
    {
        $data = $request->all();
        $sortie = SortieTissu::find($data['idsortietissu']);
        if ($this->verif_quantite_retour($sortie->qtesortie, $data['qteretour']) == false) {
            $errorMessage = 'Quantité retourner en excès de la sortie';

            return back()->withErrors(['error' => $errorMessage]);
        }
        $validationData = Retour_Tissu::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect()->back()->withErrors($errors)->withInput();
        }
        try {
            DB::beginTransaction();
            $retourTissu = new Retour_Tissu($data);
            $res = $retourTissu->save();
            $this->retour_stock_tissu($sortie, $data['qteretour']);
            $this->retrait_sortie_tissu($sortie, $data['qteretour']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement des données, veuillez réessayer.'.$e;

            return back()->withInput()->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);

    }

    public function retrait_sortie_tissu($sortie, $qteRetour)
    {
        $sortie->qtesortie -= $qteRetour;

        $sortie->save();
    }

    public function retour_stock_tissu($sortie, $qteRetour)
    {
        $stockTissu = StockTissu::find($sortie->idstocktissu);
        $prixTotaleEntree = $sortie->prixunitaire * $qteRetour;
        $prixTotaleStock = $stockTissu->qtestock * $stockTissu->prixunitaire;
        $stockTissu->qtestock += $qteRetour;
        $stockTissu->prixunitaire = ($prixTotaleEntree + $prixTotaleStock) / $stockTissu->qtestock;

        $stockTissu->save();
    }
}
