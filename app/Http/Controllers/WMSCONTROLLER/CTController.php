<?php

namespace App\Http\Controllers\WMSCONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\CategorieTissus;
use App\Models\ClasseMatierePremiere;
use App\Models\Tiers;
use App\Models\UniteMesureMatierePremiere;
use App\Models\UniteMonetaire;
use App\Models\V_donne_bc;
use App\Models\WMSModel\Cellule;
use App\Models\WMSModel\EntreeCT;
use App\Models\WMSModel\UtilisationWMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CTController extends Controller
{
    public function ajout_entree_ct_par_bc($iddonnebc)
    {
        $data = V_donne_bc::where('id_donne_bc', $iddonnebc)->first();
        $catTissu = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $uniteCommande = UniteMesureMatierePremiere::where('etat', 0)->get();
        $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
        $cellule = Cellule::where('idrack', 1)
            ->where('etat', 0)->get();

        //return $data;

        return view('WMS.CT.entreeCT', compact('data', 'catTissu', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'uniteCommande', 'uniteMonetaire', 'cellule'));
    }

    public function ajout_entre_ct(Request $request)
    {
        $data = $request->all();
        $validationData = EntreeCT::getValidationRules();
        $rules = $validationData['rules'];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            // return response()->json(['errors' => $validator->errors()], 422);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['tauxecart'] = ($data['qterecu'] / $data['qtecommande']) * 100;
        $data['resterecevoir'] = $data['qtecommande'] - $data['qterecu'];
        try {
            DB::beginTransaction();
            $entreeCT = new EntreeCT($data);
            $res = $entreeCT->save();
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
}
