<?php

namespace App\Http\Controllers\WMSCONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\WMSModel\Consommable\Cellule_Entree_Consommable;
use App\Models\WMSModel\Consommable\Cellule_Stock_Consommable;
use App\Models\WMSModel\Consommable\Client_StockConsommable;
use App\Models\WMSModel\Consommable\EntreeConsommable;
use App\Models\WMSModel\Consommable\StockConsommable;
use App\Models\WMSModel\V_Parite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConsommableController extends Controller
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
    public function ajout_cellule_consommable_entree($cellule, $identreeconsommable)
    {
        for ($i = 0; $i < count($cellule); $i++) {
            $celluleEntree = new Cellule_Entree_Consommable();
            $celluleEntree->idcellule = $cellule[$i];
            $celluleEntree->identreeconsommable = $identreeconsommable;
            $celluleEntree->save();
        }
    }

    public function ajout_entre_consommable(Request $request)
    {
        $data = $request->all();
        $cellule = $request->input('cellule');
        $parite = $this->verif_parite($data['datefacturation']);
        $validationData = EntreeConsommable::getValidationRules();
        $rules = $validationData['rules'];
        $data['resterecevoir'] = $data['qtecommande'] - $data['qterecu'];
        $data['prixunitaire'] = $this->conversion_devise_euro($data['prixunitaire'], $data['idunitemonetaire'], $data['datefacturation']);

        $validator = Validator::make($data, $rules);

        // Handle 'parite' check failure
        if ($parite == false) {
            $errorMessage = 'Il n\'y a pas encore de parité sur le mois choisi';
            return back()->withErrors(['error' => $errorMessage])->withInput();
        }

        // Handle validation errors or missing 'cellule'
        if ($validator->fails() || empty($cellule)) {
            $errors = $validator->errors();
            if (empty($cellule)) {
                $errors->add('cellule', 'Veuillez choisir la/les cellules à utiliser');
            }

            return back()->withErrors($errors)->withInput();
        }

        try {
            DB::beginTransaction();
            $entreeConsommable = new EntreeConsommable($data);
            $res = $entreeConsommable->save();
            $this->ajout_cellule_consommable_entree($cellule, $entreeConsommable->id);
            $idstockconsommable = $this->ajout_stock_consommable($data, $cellule);
            $entreeConsommable->idstockconsommable = $idstockconsommable;
            $entreeConsommable->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement des données, veuillez réessayer. ' . $e->getMessage();
            return back()->withErrors(['error' => $errorMessage])->withInput();
        }

        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }

    public function ajout_cellule_consommable_stock($cellule, $idstockconsommable)
    {
        for ($i = 0; $i < count($cellule); $i++) {
            // This will either find the existing record or create and save a new one
            Cellule_Stock_Consommable::firstOrCreate([
                'idcellule' => $cellule[$i],
                'idstockconsommable' => $idstockconsommable,
            ]);
        }
    }
    public function ajout_stock_consommable($dataEntree, $cellule)
    {
        $dataStockTiersModele = [];
        $dataStockTiersModele['idclient'] = $dataEntree['idclient'];
        $dataStockTiersModele['modele'] = $dataEntree['modele'];
        $dataStock = [];

        $dataStock['reference'] = $dataEntree['reference'];
        $dataStock['designation'] = $dataEntree['designation'];
        $dataStock['couleur'] = $dataEntree['couleur'];
        $dataStock['idfournisseur'] = $dataEntree['idfournisseur'];
        $dataStock['saison'] = $dataEntree['saison'];
        $dataStock['qtestock'] = $dataEntree['qterecu'];
        $dataStock['prixunitaire'] = $dataEntree['prixunitaire'];
        $dataStock['idunitemesurematierepremiere'] = $dataEntree['idunitemesurematierepremiere'];
        $stockConsommable = new StockConsommable($dataStock);
        $stockConsommable->save();
        $dataStockTiersModele['idstockconsommable'] = $stockConsommable->id;
        $stockTiersModele = new Client_StockConsommable($dataStockTiersModele);
        $stockTiersModele->save();
        $this->ajout_cellule_consommable_stock($cellule, $stockConsommable->id);
        return $stockConsommable->id;
    }
    // public function insert_rajout(Request $request)
    // {
    //     $data = $request->except('cellule');
    //     $parite = $this->verif_parite($data['datefacturation']);
    //     $cellule = $request->input('cellule');
    //     $validationData = EntreeTissu::getValidationRules();
    //     $rules = $validationData['rules'];
    //     $validator = Validator::make($data, $rules);
    //     if ($parite == false) {
    //         $errorMessage = 'Il n\'y a pas encore de parité sur le mois choisi';

    //         return back()->withErrors(['error' => $errorMessage]);
    //     }
    //     $data['prixunitaire'] = $this->conversion_devise_euro($data['prixunitaire'], $data['idunitemonetaire'], $data['datefacturation']);
    //     if ($validator->fails() || empty($cellule)) {
    //         $errors = $validator->errors();
    //         if (empty($cellule)) {
    //             $errors->add('cellule', 'Veuillez choisir la/les cellules à utiliser');
    //         }

    //         return redirect()->back()->withErrors($errors)->withInput();
    //     }
    //     $data['tauxecart'] = ($data['qterecu'] / $data['qtecommande']) * 100;
    //     $data['resterecevoir'] = $data['qtecommande'] - $data['qterecu'];
    //     try {
    //         DB::beginTransaction();
    //         $this->rajout_stock_tissu($data, $cellule);
    //         $entreeTissu = new EntreeTissu($data);
    //         $res = $entreeTissu->save();
    //         $this->ajout_cellule_tissu_entree($cellule, $entreeTissu->id);
    //         $this->ajout_magasin($data);
    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement des données, veuillez réessayer.' . $e;

    //         return back()->withInput()->withErrors(['error' => $errorMessage]);
    //     }
    //     $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
    //     $status = $res ? 'success' : 'error';

    //     return back()->with($status, $message);
    // }

    // public function rajout_stock_tissu($data, $cellule)
    // {
    //     $dataStockTiersModele = [];
    //     $dataStockTiersModele['idclient'] = $data['idclient'];
    //     $dataStockTiersModele['modele'] = $data['modele'];
    //     $stockTissu = StockTissu::find($data['idstocktissu']);
    //     $prixTotaleEntree = $data['prixunitaire'] * $data['qterecu'];
    //     $prixTotaleStock = $stockTissu->qtestock * $stockTissu->prixunitaire;
    //     $stockTissu->qtestock += $data['qterecu'];
    //     $stockTissu->prixunitaire = ($prixTotaleEntree + $prixTotaleStock) / $stockTissu->qtestock;

    //     $stockTissu->save();
    //     $dataStockTiersModele['idstocktissu'] = $stockTissu->id;
    //     $stockTiersModele = StockTissu_Tiers_Modele::firstOrCreate($dataStockTiersModele);
    //     $stockTiersModele->save();
    //     // TODO: A voir si on va faire les cellules unique ou avec doublon
    //     $this->ajout_cellule_tissu_stock($cellule, $data['idstocktissu']);
    // }
}
