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
    public static function listeDemandeForPpmeeting(Request $request){
        $listes = DB::table('v_ppmeeting')->where('id_etat', 2)->where('etat', 0);
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
        if ($request->idStyle) {
            $listes->where('id_style', $request->input('idStyle'));
            $nomStyle = FiltreDemande::where('id_style', $request->idStyle)->pluck('nom_style')->first();
        }
        if (!$hasFilters) {
            $listes->limit(100);
        }
        $liste = $listes->get();
        $ids = $liste->pluck('id')->toArray();
        $idsString = implode(',', $ids);
        $statPPM = DB::select("SELECT * FROM f_stat_liste_ppm(ARRAY[$idsString])");
        $statTrace = DB::select("SELECT * FROM f_stat_liste_trace(ARRAY[$idsString])");
        if (!empty($statPPM)) {
            $stat_ppm = $statPPM[0];
            $stat_ppm->taux_fini = (number_format($stat_ppm->taux_fini, 2)*100);
            $stat_ppm->taux_retard = (number_format($stat_ppm->taux_retard, 2)*100);
            $stat_ppm->taux_abs = (number_format($stat_ppm->taux_abs, 2)*100);
        }
        else {
            $stat_ppm = (object) [
                'nb_ppm' => 0,
                'taux_fini' => 0,
                'taux_retard' => 0,
                'taux_abs' => 0
            ];
        }
        if(!empty($statTrace)){
            $stat_trace = $statTrace[0];
            $stat_trace->taux_fini = (number_format($stat_trace->taux_fini, 2)*100);
            $stat_trace->taux_retard = (number_format($stat_trace->taux_retard, 2)*100);
        }
        else {
            $stat_trace = (object) [
                'nb_trace' => 0,
                'taux_fini' => 0,
                'taux_retard' => 0
            ];
        } 
        $chaine = Ppmeeting::getAllChaine();
        $nomTiers=$request->input('nomTiers');
        $idTiers=$request->input('idTiers');
        $modele=$request->input('modele');
        if($nomTiers==null){
            $idTiers="";
        }
        return view('PLANNING.PPMEETING.listedemandeforppmeeting', data: compact('nomTiers','idTiers','modele','chaine', 'liste','stat_ppm','stat_trace'));
    }

    public static function ajoutedisponibilite(Request $request)
    {
        $iddemande = $request->input('iddemande');
        $idrecap = $request->input('idrecap');
        $tissus = $request->input('tissus');
        $accy = $request->input('accy');
        $okprod = $request->input('okprod');
        Ppmeeting::insertDisponibilite($iddemande, $tissus, $accy, $okprod);
        return redirect()->route('PLANNING.detailRecap', ['idDemande' => $iddemande, 'idRecap' => $idrecap]);
    }
    public static function modifdisponibilite(Request $request)
    {
        $iddemande = $request->input('iddemande');
        $idrecap = $request->input('idrecap');
        $tissus = $request->input('tissus');
        $accy = $request->input('accy');
        $okprod = $request->input('okprod');
        Ppmeeting::updateDisponibilite($iddemande, $tissus, $accy, $okprod);
        return redirect()->route('PLANNING.detailRecap', ['idDemande' => $iddemande, 'idRecap' => $idrecap]);
    }

    public static function ajoutPPMeeting(Request $request)
    {
        $demandePasse = $request->input('demandePasse');
        $daty = $request->input('daty');

        $dateppmeeting = $request->input('dateppmeeting');
        $heureppmeeting = $request->input('heureppmeeting');
        $effectifPrevu = $request->input('effectifPrevu');
        $effectifReel = $request->input('effectifReel');
        $chaine = $request->input('chaineMeeting');
        $fini = $request->input('fini');
        if($fini==null){
            $fini=false;
        }
        $dateChaine = $request->input('dateChaine');
        $dateCoupe = $request->input('dateCoupe');
        $dateFinition = $request->input('dateFinition');
        $commentaire = $request->input('commentaire');
        $isMeetingExiste = Ppmeeting::isMeetingExiste($dateppmeeting);
        $erreur = "";
        if (empty($daty)) {
            if ($isMeetingExiste == 0) {
                $id_meeting = Ppmeeting::insertPPMeeting($dateppmeeting);
                Ppmeeting::insertDetailMeeting($id_meeting, $heureppmeeting, $effectifPrevu, $effectifReel, $demandePasse, $commentaire, $chaine, $dateChaine, $dateCoupe, $dateFinition);
            } elseif ($isMeetingExiste != 0) {
                $id_meeting = $isMeetingExiste;
                $compteDetail = Ppmeeting::compteModeleInMeeting($id_meeting);
                if ($compteDetail < 4) {
                    Ppmeeting::insertDetailMeeting($id_meeting, $heureppmeeting, $effectifPrevu, $effectifReel, $demandePasse, $commentaire, $chaine, $dateChaine, $dateCoupe, $dateFinition);
                } else {

                    $erreur = "Vous avez atteint le nombre maximal de modèle pour ce meeting";
                }
            }
        } else {
            if ($daty == $dateppmeeting) {
                $id_meeting = Ppmeeting::isMeetingExiste($dateppmeeting);
                Ppmeeting::updateDetailMeeting($id_meeting, $heureppmeeting, $effectifPrevu, $effectifReel, $commentaire, $chaine, $dateChaine, $dateCoupe, $dateFinition,$fini, $demandePasse);
            } else {
                if ($isMeetingExiste == 0) {
                    $id_meeting = Ppmeeting::insertPPMeeting($dateppmeeting);
                    Ppmeeting::updateDetailMeeting($id_meeting, $heureppmeeting, $effectifPrevu, $effectifReel, $commentaire, $chaine, $dateChaine, $dateCoupe, $dateFinition,$fini, $demandePasse);
                } elseif ($isMeetingExiste != 0) {
                    $id_meeting = $isMeetingExiste;
                    $compteDetail = Ppmeeting::compteModeleInMeeting($id_meeting);
                    if ($compteDetail < 4 ) {
                        Ppmeeting::updateDetailMeeting($id_meeting, $heureppmeeting, $effectifPrevu, $effectifReel, $commentaire, $chaine, $dateChaine, $dateCoupe, $dateFinition,$fini, $demandePasse);
                    } else {

                        $erreur = "Vous avez atteint le nombre maximal de modèle pour ce meeting";
                    }
                }
            }
        }
        $nomTiers=$request->input('nomTiers');
        $idTiers=$request->input('idTiers');
        $modele=$request->input('modele');
        if($nomTiers==null){
            $idTiers="";
        }

        return redirect()->route('LRP.listeDemandeForPpmeeting',['nomTiers' => $nomTiers, 'idTiers' => $idTiers, 'modele' => $modele])->with('error', $erreur);
    }
}
