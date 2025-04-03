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
use App\Models\WMSModel\ReservationTissu;
use App\Models\WMSModel\Retour_Tissu;
use App\Models\WMSModel\SortieTissu;
use App\Models\WMSModel\StockTissu;
use App\Models\WMSModel\StockTissu_Tiers_Modele;
use App\Models\WMSModel\UtilisationWMS;
use App\Models\WMSModel\V_Parite;
use App\Models\WMSModel\V_Rack_Cellule;
use App\Models\WMSModel\WMS\WMS_TISSU_RETOUR;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TissuController extends Controller
{
    function modif_entree_tissu(Request $request)
    {
        $data = $request->all();
        // Check if idstocktissu exists in SortieTissu
        $sortieTissu = SortieTissu::where('idstocktissu', $data['idstocktissu'])->first();
        // if ($sortieTissu) {
        //     return redirect()->back()->withErrors(['error' => "Cette entrée a déja une ou plusieurs sortie donc ne peu plus être modifier"]);
        // }

        // Update EntreeTissu
        $entreeTissu = EntreeTissu::find($data['identreetissu']);
        //$data['tauxecart'] = ($entreeTissu->qterecu / $data['qtecommande']) * 100;
        $data['resterecevoir'] = $data['qtecommande'] - $entreeTissu->qterecu;
        if ($entreeTissu) {
            $entreeTissu->update($data);
        } else {
            return redirect()->back()->withErrors(['error' => 'EntreeTissu not found.']);
        }

        // Update StockTissu
        $stockTissu = StockTissu::find($data['idstocktissu']);
        if ($stockTissu) {
            $stockTissu->update($data);
        } else {
            return redirect()->back()->withErrors(['error' => 'StockTissu not found.']);
        }

        return redirect()->back()->with('success', 'Entree modifier avec succès');
    }
    public function conversion_devise_euro($prixUnitaire, $idUniteMonetaire, $dateFacturation)
    {
        $carbonDate = Carbon::parse($dateFacturation);
        $month = $carbonDate->format('m');
        $year = $carbonDate->format('Y');
        $parite = V_Parite::where('mois', $month)->where('annee', $year)->first();
        if ($idUniteMonetaire == 2) { //*Dollar
            $prixUnitaire = $prixUnitaire / $parite->valeur;
        }
        if ($idUniteMonetaire == 3) { //*MGA
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
        $data = $request->all();
        $cellule = $request->input('cellule');
        $parite = $this->verif_parite($data['datefacturation']);
        $validationData = EntreeTissu::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($parite == false) {
            $errorMessage = 'Il n\'y a pas encore de parité sur le mois choisi';

            return back()->withErrors(['error' => $errorMessage])->withInput($data);
        }
        // $data['prixunitaire'] = $this->conversion_devise_euro($data['prixunitaire'], $data['idunitemonetaire'], $data['datefacturation']);
        if ($validator->fails() || empty($cellule)) {
            $errors = $validator->errors();
            if (empty($cellule)) {
                $errors->add('cellule', 'Veuillez choisir la/les cellules à utiliser');
            }

            return redirect()->back()->withErrors($errors)->withInput($data);
        }
        //$data['tauxecart'] = ($data['qterecu'] / $data['qtecommande']) * 100;
        $data['resterecevoir'] = $data['qtecommande'] - $data['qterecu'];
        try {
            DB::beginTransaction();
            $entreeTissu = new EntreeTissu($data);
            $res = $entreeTissu->save();
            $this->ajout_cellule_tissu_entree($cellule, $entreeTissu->id);
            $idstocktissu = $this->ajout_stock_tissu($data, $cellule);
            $entreeTissu->idstocktissu = $idstocktissu;
            $entreeTissu->save();
            if (isset($data['iddonnebc'])) {
                $this->ajout_magasin($data);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement des données, veuillez réessayer.' . $e;

            return back()->withInput($data)->withErrors(['error' => $errorMessage]);
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
        $dataStock['grammage'] = $dataEntree['grammage'];
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
        $dataStock['prixunitaire'] = $this->conversion_devise_euro($dataEntree['prixunitaire'], $dataEntree['idunitemonetaire'], $dataEntree['datefacturation']);
        $dataStock['idunitemesurematierepremiere'] = $dataEntree['idunitemesurematierepremiere'];
        $dataStock['idfamilletissus'] = $dataEntree['idfamilletissus'];
        $stockTissu = new StockTissu($dataStock);
        // dd($stockTissu);
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
    function map_entree_tissu($data, $dataStock, $dataStockCLient)
    {
        $data['couleur'] = $dataStock->couleur;
        $data['composition'] = $dataStock->composition;
        $data['idfournisseur'] = $dataStock->idfournisseur;
        $data['idfamilletissus'] = $dataStock->idfamilletissus;
        $data['idcategorietissus'] = $dataStock->idcategorietissus;
        $data['idutilisationwms'] = $dataStock->idutilisationwms;
        $data['idclassematierepremiere'] = $dataStock->idclassematierepremiere;
        $data['designation'] = $dataStock->designation;
        $data['reftissu'] = $dataStock->reference;
        $data['idunitemesurematierepremiere'] = $dataStock->idunitemesurematierepremiere;
        $data['saison'] = $dataStock->saison;
        $data['idclient'] = $dataStockCLient->idclient;
        return $data;
    }

    public function insert_rajout(Request $request) 
    {
        $data = $request->except('cellule');
        $DataStock = StockTissu::find($data['idstocktissu']);
        $DataStockCLient = EntreeTissu::where('idstocktissu', $data['idstocktissu'])->first();
        $data = $this->map_entree_tissu($data, $DataStock, $DataStockCLient);
        $parite = $this->verif_parite($data['datefacturation']);
        $cellule = $request->input('cellule');
        $validationData = EntreeTissu::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($parite == false) {
            $errorMessage = 'Il n\'y a pas encore de parité sur le mois choisi';

            return back()->withErrors(['error' => $errorMessage]);
        }
        // $data['prixunitaire'] = $this->conversion_devise_euro($data['prixunitaire'], $data['idunitemonetaire'], $data['datefacturation']);
        if ($validator->fails() || empty($cellule)) {
            $errors = $validator->errors();
            if (empty($cellule)) {
                $errors->add('cellule', 'Veuillez choisir la/les cellules à utiliser');
            }

            return redirect()->back()->withErrors($errors)->withInput($data);
        }
        //$data['tauxecart'] = ($data['qterecu'] / $data['qtecommande']) * 100;
        $data['resterecevoir'] = $data['qtecommande'] - $data['qterecu'];
        try {
            DB::beginTransaction();
            $this->rajout_stock_tissu($data, $cellule);
            $entreeTissu = new EntreeTissu($data);
            $res = $entreeTissu->save();
            $this->ajout_cellule_tissu_entree($cellule, $entreeTissu->id);
            if (isset($data['iddonnebc'])) {
                $this->ajout_magasin($data);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement des données, veuillez réessayer.' . $e;

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
        $prixTotaleEntree = $this->conversion_devise_euro($data['prixunitaire'], $data['idunitemonetaire'], $data['datefacturation']) * $data['qterecu'];
        $prixTotaleStock = $stockTissu->qtestock * $stockTissu->prixunitaire;
        $stockTissu->qtestock += $data['qterecu'];
        $stockTissu->prixunitaire = ($prixTotaleEntree + $prixTotaleStock) / $stockTissu->qtestock;

        $stockTissu->save();
        // $dataStockTiersModele['idstocktissu'] = $stockTissu->id;
        // $stockTiersModele = StockTissu_Tiers_Modele::firstOrCreate($dataStockTiersModele);
        // $stockTiersModele->save();
        // TODO: A voir si on va faire les cellules unique ou avec doublon
        $this->ajout_cellule_tissu_stock($cellule, $data['idstocktissu']);
    }
    function verif_quantite_reservation($idstocktissu, $quantiteSortie)
    {
        $stock = StockTissu::find($idstocktissu);
        $reservationQte = ReservationTissu::where('idstocktissu', $idstocktissu)
            ->where('validation', 0)
            ->where('etat', 0)
            ->sum('qtereserve');
        $quantiteResteReservation = $stock->qtestock - $reservationQte;
        if ($quantiteSortie > $quantiteResteReservation) {
            return false;
        }
        return true;
    }
    public function sortie_stock_tissu(Request $request)
    {
        $data = $request->all();
        if ($data['obsolete'] == null) {
            $data['obsolete'] = 0;
        }
        if (!isset($data['prixunitaire'])) {
            $data['prixunitaire'] = StockTissu::find($data['idstocktissu'])->value('prixunitaire');
        }
        if ($this->verif_quantite_stock($data['idstocktissu'], $data['qtesortie']) == false) {
            $errorMessage = 'Quantité insuffisante';
            return back()->withErrors(['error' => $errorMessage]);
        }
        if ($data['typeSortie'] == 1) {
            if ($this->verif_quantite_reservation($data['idstocktissu'], $data['qtesortie']) == false) {
                $errorMessage = 'Quantité insuffisante, une réservation est en cours';
                return back()->withErrors(['error' => $errorMessage]);
            }
        }
        $validationData = SortieTissu::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            dd($errors);
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
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement des données, veuillez réessayer.' . $e;

            return back()->withInput()->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
    public function sortie_reservation_tissu(Request $request)
    {
        $data = $request->all();
        if ($data['obsolete'] == null) {
            $data['obsolete'] = 0;
        }
        $reservation = ReservationTissu::find($data['idreservation']);
        if ($reservation->qtereserve < $data['qtesortie']) {
            $errorMessage = 'La quantité réservée n\'est pas suffisante';
            return back()->withErrors(['error' => $errorMessage]);
        }
        $quantiteReste = $reservation->qtereserve - $data['qtesortie'];
        try {
            DB::beginTransaction();

            // Update reservation quantity
            $reservation->qtereserve = $quantiteReste;
            $res = $reservation->save();

            // Call sortie_stock_tissu and pass the request
            $stockResponse = $this->sortie_stock_tissu($request, 0);

            // Check if sortie_stock_tissu returns an error
            if ($stockResponse instanceof \Illuminate\Http\RedirectResponse && $stockResponse->getSession()->has('errors')) {
                DB::rollBack();
                return $stockResponse;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement des données, veuillez réessayer.' . $e;

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
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement des données, veuillez réessayer.' . $e;

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

    public function ajout_reservation_Tissu(Request $request)
    {
        $data = $request->all();
        if ($this->verif_stock_reserver($data['idstocktissu'], $data['qtereserve']) == false) {
            // TODO: Better error message
            $errorMessage = 'Quantité retourner en excès de la sortie';
            return back()->withErrors(['error' => $errorMessage]);
        }
        $validationData = ReservationTissu::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->withInput()->withErrors($errors);
        }
        try {
            DB::beginTransaction();
            $reservation = new ReservationTissu($data);
            $res = $reservation->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement des données, veuillez réessayer.' . $e;

            return back()->withInput()->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }

    public function verif_stock_reserver($idStockTissu, $qteReserver)
    {
        $stock = StockTissu::where('id', $idStockTissu)->first();
        $qteReservation = ReservationTissu::where('idstocktissu', $idStockTissu)
            ->where('etat', 0)
            ->where('validation', 0)
            ->sum('qtereserve');
        $resteStockReserve = $stock->qtestock - $qteReservation;
        if ($qteReserver > $resteStockReserve) {
            return false;
        }
        return true;
    }

    public function validation_reservation($idreservation)
    {
        try {
            DB::beginTransaction();
            $reservationTissu = ReservationTissu::find($idreservation);
            $reservationTissu->validation = 0;
            $res = $reservationTissu->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus de validation, veuillez réessayer.' . $e;

            return back()->withInput()->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure de validation s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }

    public function refus_reservation($idreservation)
    {
        try {
            DB::beginTransaction();
            $reservationTissu = ReservationTissu::find($idreservation);
            $reservationTissu->etat = 1;
            $res = $reservationTissu->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus de validation, veuillez réessayer.' . $e;

            return back()->withInput()->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure de refus s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
    public function annulation_reservation($idreservation)
    {
        try {
            DB::beginTransaction();
            $reservationTissu = ReservationTissu::find($idreservation);
            $reservationTissu->etat = 1;
            $reservationTissu->validation = 1;
            $res = $reservationTissu->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'annulation, veuillez réessayer.' . $e;

            return back()->withInput()->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'annulation s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
    public function obsolete_Tissu($idstocktissu)
    {
        $stockTissu = StockTissu::find($idstocktissu);

        if (!$stockTissu) {
            return back()->withErrors(['error' => 'Tissu introuvable']);
        }

        if ($stockTissu->idclassematierepremiere == 2) {
            return back()->withErrors(['error' => 'Un tissu de classe current ne peut pas être obsolète']);
        }

        $stockTissu->obsolete = 1;

        if ($stockTissu->save()) {
            return back()->with('success', 'Le tissu a été marqué comme obsolète avec succès.');
        }

        return back()->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour du tissu.']);
    }
    function retourTissuWMS(Request $request)
    {
        $data = $request->all();
        // ? Retour fournisseur
        if ($data['idtyperetour'] == 1) {
            $entreeTissu = EntreeTissu::find($data['identreetissu']);
            $stockTissu = StockTissu::find($entreeTissu->idstocktissu);
            $quantiteRetour = $data['quantite'];
            if ($quantiteRetour > $entreeTissu->qterecu) {
                return redirect()->back()->withErrors(['error' => 'Quantité selectionner est supérieur à la quantité reçue']);
            }
            //$entreeTissu->qterecu = $entreeTissu->qterecu - $quantiteRetour;
            //$entreeTissu->tauxecart = ($entreeTissu->qterecu / $entreeTissu->qtecommande) * 100;
            $prixTotaleRetour = $quantiteRetour * $this->conversion_devise_euro($entreeTissu->prixunitaire, $entreeTissu->idunitemonetaire, $entreeTissu->datefacturation);
            $prixTotaleStock = $stockTissu->qtestock * $stockTissu->prixunitaire;
            $nouveauPrixTotale = $prixTotaleStock - $prixTotaleRetour;
            $stockTissu->qtestock = $stockTissu->qtestock - $quantiteRetour;
            if ($stockTissu->qtestock <= 0) {
                $stockTissu->prixunitaire = 0;
            } else {
                $stockTissu->prixunitaire = $nouveauPrixTotale / $stockTissu->qtestock;
            }
            $data['identreetissu'] = $entreeTissu->id;
            $data['idstocktissu'] = $entreeTissu->idstocktissu;
            $validationData = WMS_TISSU_RETOUR::getValidationRules();
            $rules = $validationData['rules'];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->back()->withInput()->withErrors($errors);
            }
            try {
                DB::beginTransaction();
                $retourFournisseur = new WMS_TISSU_RETOUR($data);
                //$entreeTissu->save();
                $stockTissu->save();
                $res = $retourFournisseur->save();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $errorMessage = 'Une anomalie est survenue lors du processus de retour, veuillez réessayer.' . $e;

                return redirect()->back()->withInput()->withErrors(['error' => $errorMessage]);
            }
            $message = $res ? 'La procédure de retour s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
            $status = $res ? 'success' : 'error';
            return redirect()->back()->with($status, $message);
        }
        // ? Retour manque
        if ($data['idtyperetour'] == 2) {
            $entreeTissu = EntreeTissu::where('idstocktissu', $data['idstocktissu'])->orderBy('dateentree', 'desc')->first();
            if (!isset($entreeTissu)) {
                return redirect()->back()->withErrors(['error' => 'Aucune entrée pour ce stock']);
            }
            $stockTissu = StockTissu::find($data['idstocktissu']);
            $quantiteRetour = $data['quantite'];
            if ($quantiteRetour > $stockTissu->qtestock) {
                return redirect()->back()->withErrors(['error' => 'Quantité selectionner est supérieur à la quantité reçue']);
            }
            $prixTotaleRetour = $quantiteRetour * $this->conversion_devise_euro($entreeTissu->prixunitaire, $entreeTissu->idunitemonetaire, $entreeTissu->datefacturation);
            $prixTotaleStock = $stockTissu->qtestock * $stockTissu->prixunitaire;
            $nouveauPrixTotale = $prixTotaleStock - $prixTotaleRetour;
            $stockTissu->qtestock = $stockTissu->qtestock - $quantiteRetour;
            if ($stockTissu->qtestock <= 0) {
                $stockTissu->prixunitaire = 0;
            } else {
                $stockTissu->prixunitaire = $nouveauPrixTotale / $stockTissu->qtestock;
            }

            $data['identreetissu'] = $entreeTissu->id;
            $validationData = WMS_TISSU_RETOUR::getValidationRules();
            $rules = $validationData['rules'];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->back()->withInput()->withErrors($errors);
            }
            try {
                DB::beginTransaction();
                $retourFournisseur = new WMS_TISSU_RETOUR($data);
                $stockTissu->save();
                $res = $retourFournisseur->save();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $errorMessage = 'Une anomalie est survenue lors du processus de retour, veuillez réessayer.' . $e;

                return redirect()->back()->withInput()->withErrors(['error' => $errorMessage]);
            }
            $message = $res ? 'La procédure de retour s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
            $status = $res ? 'success' : 'error';
            return redirect()->back()->with($status, $message);
        }
        // ? Retour surplus
        if ($data['idtyperetour'] == 3) {
            $entreeTissu = EntreeTissu::where('idstocktissu', $data['idstocktissu'])->orderBy('dateentree', 'desc')->first();
            if (!isset($entreeTissu)) {
                return redirect()->back()->withErrors(['error' => 'Aucune entrée pour ce stock']);
            }
            $stockTissu = StockTissu::find($data['idstocktissu']);
            $quantiteRetour = $data['quantite'];
            /*if ($quantiteRetour > $entreeTissu->qterecu) {
                return redirect()->back()->withErrors(['error' => 'Quantité selectionner est supérieur à la quantité reçue']);
            }*/
            $prixTotaleRetour = $quantiteRetour * $this->conversion_devise_euro($entreeTissu->prixunitaire, $entreeTissu->idunitemonetaire, $entreeTissu->datefacturation);
            $prixTotaleStock = $stockTissu->qtestock * $stockTissu->prixunitaire;
            $nouveauPrixTotale = $prixTotaleStock + $prixTotaleRetour;
            $stockTissu->qtestock = $stockTissu->qtestock + $quantiteRetour;
            $stockTissu->prixunitaire = $nouveauPrixTotale / $stockTissu->qtestock;
            $data['identreetissu'] = $entreeTissu->id;
            $validationData = WMS_TISSU_RETOUR::getValidationRules();
            $rules = $validationData['rules'];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->back()->withInput()->withErrors($errors);
            }
            try {
                DB::beginTransaction();
                $retourFournisseur = new WMS_TISSU_RETOUR($data);
                $stockTissu->save();
                $res = $retourFournisseur->save();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $errorMessage = 'Une anomalie est survenue lors du processus de retour, veuillez réessayer.' . $e;

                return redirect()->back()->withInput()->withErrors(['error' => $errorMessage]);
            }
            $message = $res ? 'La procédure de retour s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
            $status = $res ? 'success' : 'error';
            return redirect()->back()->with($status, $message);
        }
        // ? Retour inventaire
        if ($data['idtyperetour'] == 4) {
            $stockTissu = StockTissu::find($data['idstocktissu']);
            // dd($stockTissu);
            $quantiteRetour = $data['quantite'];
            if ($quantiteRetour > $stockTissu->qtestock) {
                return redirect()->back()->withErrors(['error' => 'Quantité selectionner est supérieur à la quantité reçue']);
            }
            $stockTissu->qtestock = $stockTissu->qtestock + $quantiteRetour;
            $data['prixunitaire'] = $stockTissu->prixunitaire;
            $validationData = WMS_TISSU_RETOUR::getValidationRules();
            $rules = $validationData['rules'];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->back()->withInput()->withErrors($errors);
            }
            try {
                DB::beginTransaction();
                $retourFournisseur = new WMS_TISSU_RETOUR($data);
                $stockTissu->save();
                $res = $retourFournisseur->save();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $errorMessage = 'Une anomalie est survenue lors du processus de retour, veuillez réessayer.' . $e;

                return redirect()->back()->withInput()->withErrors(['error' => $errorMessage]);
            }
            $message = $res ? 'La procédure de retour s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
            $status = $res ? 'success' : 'error';
            return redirect()->back()->with($status, $message);
        }
    }
}
