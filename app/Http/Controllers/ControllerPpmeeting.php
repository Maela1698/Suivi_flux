<?php

namespace App\Http\Controllers;
use App\Models\DataPro;

use App\Models\FiltreDemande;
use App\Models\Ppmeeting;
use App\Models\Saison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerPpmeeting extends Controller
{
    public static function listeDemandeForPpmeeting(Request $request)
    {
        $listes = DB::table('v_ppmeeting')->where('id_etat',2)->where('etat',0);
        $hasFilters = false;
        $hasFilters = false;
        $nomSaison = null;
        if ($request->idSaison) {
            $listes->where('id_saison', $request->input('idSaison'));
            $nomSaison = Saison::where('id', $request->idSaison)->pluck('type_saison')->first();
            $hasFilters = true;
        }
        $nomTiers = null;
        if ($request->idTiers) {
            $listes->where('id_tiers', $request->input('idTiers'));
            $nomTiers = FiltreDemande::where('id_tiers', $request->idTiers)->pluck('nomtier')->first();
            $hasFilters = true;
        }
        if ($request->modele) {
            $listes->where('nom_modele', 'ILIKE', '%' . $request->input('modele') . '%');
            $hasFilters = true;
        }
        $nomStyle = null;
        if ($request->idStyle ) {
            $listes->where('id_style', $request->input('idStyle'));
            $nomStyle = FiltreDemande::where('id_style',$request->idStyle)->pluck('nom_style')->first();
        }
        if(!$hasFilters){
            $listes->limit(100);
        }
        $liste = $listes->get();
        return view('PLANNING.PPMEETING.listedemandeforppmeeting', data: compact('liste'));
    }
    public static function ajoutedisponibilite(Request $request)
    {
        $iddemande = $request->input('iddemande');
        $idrecap = $request->input('idrecap');
        $tissus = $request->input('tissus');
        $accy = $request->input('accy');
        $okprod = $request->input('okprod');
        Ppmeeting::insertDisponibilite($iddemande,$tissus,$accy,$okprod);
        return redirect()->route('PLANNING.detailRecap',['idDemande'=>$iddemande,'idRecap'=>$idrecap]);
    }
    public static function modifdisponibilite(Request $request)
    {
        $iddemande = $request->input('iddemande');
        $idrecap = $request->input('idrecap');
        $tissus = $request->input('tissus');
        $accy = $request->input('accy');
        $okprod = $request->input('okprod');
        Ppmeeting::updateDisponibilite($iddemande,$tissus,$accy,$okprod);
        return redirect()->route('PLANNING.detailRecap',['idDemande'=>$iddemande,'idRecap'=>$idrecap]);
    }
}
