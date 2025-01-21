<?php

namespace App\Http\Controllers\WMSCONTROLLER\WMS_AUTRE;

use App\Http\Controllers\Controller;
use App\Models\WMSModel\V_Parite;
use App\Models\WMSModel\WMS\Client_StockWMS;
use App\Models\WMSModel\WMS\EntreeWMS;
use App\Models\WMSModel\WMS\EntreeWMS_Cellule;
use App\Models\WMSModel\WMS\ReservationWMS;
use App\Models\WMSModel\WMS\RetourWMS;
use App\Models\WMSModel\WMS\SortieWMS;
use App\Models\WMSModel\WMS\StockWMS;
use App\Models\WMSModel\WMS\StockWMS_Cellule;
use App\Models\WMSModel\WMS\WMS_WMS_RETOUR;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WMSController extends Controller
{
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

    // public function ajout_entree_wms_par_bc($iddonnebc, $idFamillewms)
    // {
    //     $famillewms = Famillewmss::find($idFamillewms);
    //     $data = V_donne_bc::where('id_donne_bc', $iddonnebc)->first();
    //     $data['idfamillewms'] = $idFamillewms;
    //     $catwms = Categoriewmss::where('etat', 0)->get();
    //     $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
    //     $utilisation = UtilisationWMS::where('etat', 0)->get();
    //     $client = Tiers::where('idacteur', 1)->get();
    //     $fournisseur = Tiers::where('idacteur', 2)->get();
    //     $uniteCommande = UniteMesureMatierePremiere::where('etat', 0)->get();
    //     $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
    //     $cellule = V_Rack_Cellule::where('section', 'ILIKE', '%wms%')->get();

    //     // return $cellule;

    //     return view('WMS.wms.entreewms', compact('data', 'catwms', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'uniteCommande', 'uniteMonetaire', 'cellule', 'iddonnebc', 'famillewms'));
    // }

    public function ajout_entre_wms(Request $request)
    {
        $data = $request->all();
        $cellule = $request->input('cellule');
        $parite = $this->verif_parite($data['datefacturation']);
        $data['resterecevoir'] = (float)$data['qtecommande'] - (float)$data['qteentree'];
        $validationData = EntreeWMS::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($parite == false) {
            $errorMessage = 'Il n\'y a pas encore de parité sur le mois choisi';

            return back()->withErrors(['error' => $errorMessage])->withInput($data);
        }
        $data['prixunitaire'] = $this->conversion_devise_euro($data['prixunitaire'], $data['idunitemonetaire'], $data['datefacturation']);
        if ($validator->fails() || empty($cellule)) {
            $errors = $validator->errors();
            if (empty($cellule)) {
                $errors->add('cellule', 'Veuillez choisir la/les cellules à utiliser');
            }
            dd($errors);
            return redirect()->back()->withErrors($errors)->withInput($data);
        }
        try {
            DB::beginTransaction();
            $entreeWMS = new EntreeWMS($data);
            $res = $entreeWMS->save();
            $this->ajout_cellule_wms_entree($cellule, $entreeWMS->id);
            $idstockWMS = $this->ajout_stock_wms($data, $cellule);
            $entreeWMS->idstockwms = $idstockWMS;
            $entreeWMS->save();
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

    // public function ajout_magasin($dataEntree)
    // {
    //     $getMagasin = Magasin::where('id_donne_bc', $dataEntree['iddonnebc'])->first();

    //     if (! empty($getMagasin)) {
    //         $getMagasin->quantite += $dataEntree['qteentree'];

    //         // Calcul de la nouvelle valeur de 'reste', mais en s'assurant qu'elle ne devienne pas négative.
    //         $getMagasin->reste = max(0, $getMagasin->reste - $dataEntree['resterecevoir']);

    //         $getMagasin->save();
    //     } else {
    //         $dataMagasin = [];
    //         $dataMagasin['id_donne_bc'] = $dataEntree['iddonnebc'];
    //         $dataMagasin['datearrivereelle'] = $dataEntree['dateentree'];
    //         $dataMagasin['bl'] = $dataEntree['numerobl'];
    //         $dataMagasin['quantite'] = $dataEntree['qterecu'];
    //         $dataMagasin['reste'] = $dataEntree['resterecevoir'];
    //         $dataMagasin['numero'] = $dataEntree['numerofacture'];
    //         $magasin = new Magasin($dataMagasin);
    //         $magasin->save();
    //     }
    // }

    public function ajout_cellule_wms_entree($cellule, $identrewms)
    {
        for ($i = 0; $i < count($cellule); $i++) {
            $celluleEntree = new EntreeWMS_Cellule();
            $celluleEntree->idcellule = $cellule[$i];
            $celluleEntree->identreewms = $identrewms;
            $celluleEntree->save();
        }
    }

    public function ajout_cellule_wms_stock($cellule, $idstockwms)
    {
        for ($i = 0; $i < count($cellule); $i++) {
            // This will either find the existing record or create and save a new one
            StockWMS_Cellule::firstOrCreate([
                'idcellule' => $cellule[$i],
                'idstockwms' => $idstockwms,
            ]);
        }
    }

    public function ajout_stock_wms($dataEntree, $cellule)
    {
        $dataStockTiersModele = [];
        $dataStockTiersModele['idclient'] = $dataEntree['idclient'];
        $dataStockTiersModele['modele'] = $dataEntree['modele'];
        $dataStock = [];

        $dataStock['idclassematierepremiere'] = $dataEntree['idclassematierepremiere'];
        $dataStock['reference'] = $dataEntree['reference'];
        $dataStock['idfamillewms'] = $dataEntree['idfamillewms'];
        $dataStock['designation'] = $dataEntree['designation'];
        $dataStock['couleur'] = $dataEntree['couleur'];
        $dataStock['idfournisseur'] = $dataEntree['idfournisseur'];
        $dataStock['saison'] = $dataEntree['saison'];
        $dataStock['qtestock'] = $dataEntree['qteentree'];
        $dataStock['prixunitaire'] = $dataEntree['prixunitaire'];
        $dataStock['idunitemesurematierepremiere'] = $dataEntree['idunitemesurematierepremiere'];
        $stockwms = new StockWMS($dataStock);
        $stockwms->save();
        $dataStockTiersModele['idstockwms'] = $stockwms->id;
        $stockTiersModele = new Client_StockWMS($dataStockTiersModele);
        $stockTiersModele->save();
        $this->ajout_cellule_wms_stock($cellule, $stockwms->id);

        return $stockwms->id;
    }
    public function verif_quantite_stock($idStock, $qteSortie)
    {
        $stock = StockWMS::find($idStock);
        if ($stock->qtestock < $qteSortie) {
            return false;
        }

        return true;
    }
    public function retrait_stock($idStock, $qteSortie)
    {
        $stock = StockWMS::find($idStock);
        $stock->qtestock -= $qteSortie;
        $stock->save();
    }
    public function sortie_stock_wms(Request $request)
    {
        $data = $request->all();

        $stockWMS =  StockWMS::find($data['idstockwms']);
        $data['idfamillewms'] = $stockWMS->idfamillewms;
        $data['prixunitaire'] = $stockWMS->prixunitaire;
        if ($this->verif_quantite_stock($data['idstockwms'], $data['qtesortie']) == false) {
            $errorMessage = 'Quantité insuffisante';

            return back()->withErrors(['error' => $errorMessage]);
        }
        if ($data['typeSortie'] == 1) {
            if ($this->verif_quantite_reservation($data['idstockwms'], $data['qtesortie']) == false) {
                $errorMessage = 'Quantité insuffisante, une réservation est en cours';
                return back()->withErrors(['error' => $errorMessage]);
            }
        }
        $validationData = SortieWMS::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            // TODO: Supprimer le dd
            dd($errors);
            return redirect()->back()->withErrors($errors)->withInput();
        }
        try {
            DB::beginTransaction();
            $sortiewms = new SortieWMS($data);
            $res = $sortiewms->save();
            $this->retrait_stock($data['idstockwms'], $data['qtesortie']);
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

    public function obsolete_Accessoire($idstockaccessoire)
    {
        $stockAccessoire = StockWMS::find($idstockaccessoire);

        if (!$stockAccessoire) {
            return back()->withErrors(['error' => 'Accessoire introuvable']);
        }

        if ($stockAccessoire->idclassematierepremiere == 2) {
            return back()->withErrors(['error' => 'Un accessoire de classe current ne peut pas être obsolète']);
        }

        $stockAccessoire->obsolete = 1;

        if ($stockAccessoire->save()) {
            return back()->with('success', 'Le accessoire a été marqué comme obsolète avec succès.');
        }

        return back()->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour du wms.']);
    }
    public function verif_quantite_retour($qteSortie, $qteRetour)
    {
        if ($qteRetour > $qteSortie) {
            return false;
        }
        return true;
    }
    public function retrait_sortie_wms($sortie, $qteRetour)
    {
        $sortie->qtesortie -= $qteRetour;

        $sortie->save();
    }
    public function retour_stock_wms($sortie, $qteRetour)
    {
        $stockwms = StockWMS::find($sortie->idstockwms);
        $prixTotaleEntree = $sortie->prixunitaire * $qteRetour;
        $prixTotaleStock = $stockwms->qtestock * $stockwms->prixunitaire;
        $stockwms->qtestock += $qteRetour;
        $stockwms->prixunitaire = ($prixTotaleEntree + $prixTotaleStock) / $stockwms->qtestock;

        $stockwms->save();
    }
    public function retour_wms(Request $request)
    {
        $data = $request->all();
        $sortie = SortieWMS::find($data['idsortiewms']);
        if ($this->verif_quantite_retour($sortie->qtesortie, $data['qteretour']) == false) {
            $errorMessage = 'Quantité retourner en excès de la sortie';

            return back()->withErrors(['error' => $errorMessage]);
        }
        $validationData = RetourWMS::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withErrors($errors)->withInput();
        }
        try {
            DB::beginTransaction();
            $retourwms = new RetourWMS($data);
            $res = $retourwms->save();
            $this->retour_stock_wms($sortie, $data['qteretour']);
            $this->retrait_sortie_wms($sortie, $data['qteretour']);
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
    function map_entree_wms($data, $dataStock, $dataStockCLient)
    {
        $data['code'] = $dataStock->code;
        $data['couleur'] = $dataStock->couleur;
        $data['idfournisseur'] = $dataStock->idfournisseur;
        $data['idfamillewms'] = $dataStock->idfamillewms;
        $data['idclassematierepremiere'] = $dataStock->idclassematierepremiere;
        $data['designation'] = $dataStock->designation;
        $data['designation'] = $dataStock->designation;
        $data['reference'] = $dataStock->reference;
        $data['idunitemesurematierepremiere'] = $dataStock->idunitemesurematierepremiere;
        $data['saison'] = $dataStock->saison;
        $data['idclient'] = $dataStockCLient->idclient;
        $data['modele'] = $dataStockCLient->modele;
        return $data;
    }
    // TODO: A faire
    public function insert_rajout(Request $request)
    {
        $data = $request->except('cellule');
        $DataStock = StockWMS::find($data['idstockwms']);
        $DataStockCLient = Client_StockWMS::where('idstockwms', $data['idstockwms'])->first();
        $data = $this->map_entree_wms($data, $DataStock, $DataStockCLient);
        $parite = $this->verif_parite($data['datefacturation']);
        $data['resterecevoir'] = $data['qtecommande'] - $data['qteentree'];
        // dd($data);
        $cellule = $request->input('cellule');
        $validationData = EntreeWMS::getValidationRules();
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
            dd($errors);
            return redirect()->back()->withErrors($errors)->withInput();
        }
        try {
            DB::beginTransaction();
            $this->rajout_stock_wms($data, $cellule);
            $entreeWMS = new EntreeWMS($data);
            $res = $entreeWMS->save();
            $this->ajout_cellule_wms_entree($cellule, $entreeWMS->id);
            // $this->ajout_magasin($data);
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

    public function rajout_stock_wms($data, $cellule)
    {
        $dataStockTiersModele = [];
        $dataStockTiersModele['idclient'] = $data['idclient'];
        $dataStockTiersModele['modele'] = $data['modele'];
        $stockwms = StockWMS::find($data['idstockwms']);
        $prixTotaleEntree = $data['prixunitaire'] * $data['qteentree'];
        $prixTotaleStock = $stockwms->qtestock * $stockwms->prixunitaire;
        $stockwms->qtestock += $data['qteentree'];
        $stockwms->prixunitaire = ($prixTotaleEntree + $prixTotaleStock) / $stockwms->qtestock;

        $stockwms->save();
        $dataStockTiersModele['idstockwms'] = $stockwms->id;
        $stockTiersModele = Client_StockWMS::firstOrCreate($dataStockTiersModele);
        $stockTiersModele->save();
        // TODO: A voir si on va faire les cellules unique ou avec doublon
        $this->ajout_cellule_wms_stock($cellule, $data['idstockwms']);
    }
    function retourWMSWMS(Request $request)
    {
        $data = $request->all();
        // ? Retour fournisseur
        if ($data['idtyperetour'] == 1) {
            $entreewms = EntreeWMS::find($data['identreewms']);
            $stockwms = StockWMS::find($entreewms->idstockwms);
            $quantiteRetour = $data['quantite'];
            if ($quantiteRetour > $entreewms->qteentree) {
                return redirect()->back()->withErrors(['error' => 'Quantité selectionner est supérieur à la quantité reçue']);
            }
            $entreewms->qteentree = $entreewms->qteentree - $quantiteRetour;
            $prixTotaleRetour = $quantiteRetour * $this->conversion_devise_euro($entreewms->prixunitaire, $entreewms->idunitemonetaire, $entreewms->datefacturation);
            $prixTotaleStock = $stockwms->qtestock * $stockwms->prixunitaire;
            $nouveauPrixTotale = $prixTotaleStock - $prixTotaleRetour;
            $stockwms->qtestock = $stockwms->qtestock - $quantiteRetour;
            $stockwms->prixunitaire = $nouveauPrixTotale / $stockwms->qtestock;
            $data['identreewms'] = $entreewms->id;
            $data['idstockwms'] = $entreewms->idstockwms;
            $validationData = WMS_WMS_RETOUR::getValidationRules();
            $rules = $validationData['rules'];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $errors = $validator->errors();
                dd($errors);
                return redirect()->back()->withInput()->withErrors($errors);
            }
            try {
                DB::beginTransaction();
                $retourFournisseur = new WMS_WMS_RETOUR($data);
                $entreewms->save();
                $stockwms->save();
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
            $entreewms = EntreeWMS::where('idstockwms', $data['idstockwms'])->orderBy('dateentree', 'desc')->first();
            if (!isset($entreewms)) {
                return redirect()->back()->withErrors(['error' => 'Aucune entrée pour ce stock']);
            }
            $stockwms = StockWMS::find($data['idstockwms']);
            $quantiteRetour = $data['quantite'];
            if ($quantiteRetour > $stockwms->qtestock) {
                return redirect()->back()->withErrors(['error' => 'Quantité selectionner est supérieur à la quantité reçue']);
            }
            $prixTotaleRetour = $quantiteRetour * $this->conversion_devise_euro($entreewms->prixunitaire, $entreewms->idunitemonetaire, $entreewms->datefacturation);
            $prixTotaleStock = $stockwms->qtestock * $stockwms->prixunitaire;
            $nouveauPrixTotale = $prixTotaleStock - $prixTotaleRetour;
            $stockwms->qtestock = $stockwms->qtestock - $quantiteRetour;
            $stockwms->prixunitaire = $nouveauPrixTotale / $stockwms->qtestock;
            $data['identreewms'] = $entreewms->id;
            $validationData = WMS_WMS_RETOUR::getValidationRules();
            $rules = $validationData['rules'];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->back()->withInput()->withErrors($errors);
            }
            try {
                DB::beginTransaction();
                $retourFournisseur = new WMS_WMS_RETOUR($data);
                $stockwms->save();
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
            $entreewms = EntreeWMS::where('idstockwms', $data['idstockwms'])->orderBy('dateentree', 'desc')->first();
            if (!isset($entreewms)) {
                return redirect()->back()->withErrors(['error' => 'Aucune entrée pour ce stock']);
            }
            $stockwms = StockWMS::find($data['idstockwms']);
            $quantiteRetour = $data['quantite'];
            if ($quantiteRetour > $entreewms->qteentree) {
                return redirect()->back()->withErrors(['error' => 'Quantité selectionner est supérieur à la quantité reçue']);
            }
            $prixTotaleRetour = $quantiteRetour * $this->conversion_devise_euro($entreewms->prixunitaire, $entreewms->idunitemonetaire, $entreewms->datefacturation);
            $prixTotaleStock = $stockwms->qtestock * $stockwms->prixunitaire;
            $nouveauPrixTotale = $prixTotaleStock + $prixTotaleRetour;
            $stockwms->qtestock = $stockwms->qtestock + $quantiteRetour;
            $stockwms->prixunitaire = $nouveauPrixTotale / $stockwms->qtestock;
            $data['identreewms'] = $entreewms->id;
            $validationData = WMS_WMS_RETOUR::getValidationRules();
            $rules = $validationData['rules'];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->back()->withInput()->withErrors($errors);
            }
            try {
                DB::beginTransaction();
                $retourFournisseur = new WMS_WMS_RETOUR($data);
                $stockwms->save();
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
            $stockwms = StockWMS::find($data['idstockwms']);
            // dd($stockwms);
            $quantiteRetour = $data['quantite'];
            if ($quantiteRetour > $stockwms->qtestock) {
                return redirect()->back()->withErrors(['error' => 'Quantité selectionner est supérieur à la quantité reçue']);
            }
            $stockwms->qtestock = $stockwms->qtestock - $quantiteRetour;
            $data['prixunitaire'] = $stockwms->prixunitaire;
            $validationData = WMS_WMS_RETOUR::getValidationRules();
            $rules = $validationData['rules'];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->back()->withInput()->withErrors($errors);
            }
            try {
                DB::beginTransaction();
                $retourFournisseur = new WMS_WMS_RETOUR($data);
                $stockwms->save();
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
    function verif_quantite_reservation($idstockwms, $quantiteSortie)
    {
        $stock = StockWMS::find($idstockwms);
        $reservationQte = ReservationWMS::where('idstockwms', $idstockwms)
            ->where('validation', 0)
            ->where('etat', 0)
            ->sum('qtereserve');
        $quantiteResteReservation = $stock->qtestock - $reservationQte;
        if ($quantiteSortie > $quantiteResteReservation) {
            return false;
        }
        return true;
    }
    public function sortie_reservation_wms(Request $request)
    {
        $data = $request->all();

        $reservation = ReservationWMS::find($data['idreservation']);
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
            $stockResponse = $this->sortie_stock_wms($request, 0);

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
    public function ajout_reservation_wms(Request $request)
    {
        $data = $request->all();
        if ($this->verif_stock_reserver($data['idstockwms'], $data['qtereserve']) == false) {
            // TODO: Better error message
            $errorMessage = 'Quantité retourner en excès de la sortie';
            return back()->withErrors(['error' => $errorMessage]);
        }
        $validationData = ReservationWMS::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->withInput()->withErrors($errors);
        }
        try {
            DB::beginTransaction();
            $reservation = new ReservationWMS($data);
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
        $stock = StockWMS::where('id', $idStockTissu)->first();
        $qteReservation = ReservationWMS::where('idstockwms', $idStockTissu)
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
            $reservationWMS = ReservationWMS::find($idreservation);
            $reservationWMS->validation = 0;
            $res = $reservationWMS->save();
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
            $reservationWMS = ReservationWMS::find($idreservation);
            $reservationWMS->etat = 1;
            $res = $reservationWMS->save();
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
            $reservationWMS = ReservationWMS::find($idreservation);
            $reservationWMS->etat = 1;
            $reservationWMS->validation = 1;
            $res = $reservationWMS->save();
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
}
