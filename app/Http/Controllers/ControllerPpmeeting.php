<?php

namespace App\Http\Controllers;

use App\Models\DataPro;

use App\Models\FiltreDemande;
use App\Models\Ppmeeting;
use App\Models\Saison;
use App\Models\Tiers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerPpmeeting extends Controller
{
    public static function listeDemandeForPpmeeting(Request $request){
        $listes = DB::table('v_ppmeeting')->where('id_etat', 2)->where('etat', 0);
        $hasFilters = false;
        $hasFilters = false;
        $nomSaison = null;
        $clients = Tiers::where('idacteur',1)->get();
     
        $selectedClient = $request->id_client ?? null;
        if (!empty($selectedClient)) {
            $listes = $listes->where('id_tiers', $selectedClient);
        }
      
        $selectedModele = $request->nom_modele ?? '';
        if (!empty($selectedModele)) {
            $listes = $listes->where('nom_modele', 'ilike', '%' . $selectedModele . '%');
        }

        $selectedDatePPM = $request->date_ppm ?? '';
        if (!empty($selectedDatePPM)) {
            list($ppm_debut,$ppm_fin) = explode(' au ',$selectedDatePPM);
            $ppm_debut = Carbon::createFromFormat('d-m-y', $ppm_debut);
            $ppm_fin = Carbon::createFromFormat('d-m-y', $ppm_fin); 
            $listes = $listes->whereBetween('dateppm',[$ppm_debut,$ppm_fin]);
        }

        $selectedDateTrace = $request->date_trace ?? '';
        if (!empty($selectedDateTrace)){
            list($trace_debut,$trace_fin) = explode(' au ',$selectedDateTrace);
            $trace_debut = Carbon::createFromFormat('d-m-y', $trace_debut);
            $trace_fin = Carbon::createFromFormat('d-m-y', $trace_fin); 
            $listes = $listes->whereBetween('datetrace',[$trace_debut,$trace_fin]);
        }

        $selectedDateEx = $request->date_ex ?? '';
        if (!empty($selectedDateEx)) {
            list($ex_debut,$ex_fin) = explode(' au ',$selectedDateEx);
            $ex_debut = Carbon::createFromFormat('d-m-y', $ex_debut);
            $ex_fin = Carbon::createFromFormat('d-m-y', $ex_fin);
            $listes = $listes->whereBetween('ex_factory',[$ex_debut,$ex_fin]);
        }
        if (!$hasFilters) {
            $listes->limit(100);
        }
        $liste = $listes->get();

        if ($liste->isNotEmpty()) {
            $ids = $liste->pluck('id')->toArray();
            $idsString = implode(',', $ids);
            $statPPM = DB::select("SELECT * FROM f_stat_liste_ppm(ARRAY[$idsString])");

            $stat_ppm = $statPPM[0];
            $stat_ppm->taux_fini = (number_format($stat_ppm->taux_fini, 2)*100);
            $stat_ppm->taux_retard = (number_format($stat_ppm->taux_retard, 2)*100);
            $stat_ppm->taux_abs = (number_format($stat_ppm->taux_abs, 2)*100);

            $statTrace = DB::select("SELECT * FROM f_stat_liste_trace(ARRAY[$idsString])");
            $stat_trace = $statTrace[0];
            $stat_trace->taux_fini = (number_format($stat_trace->taux_fini, 2)*100);
            $stat_trace->taux_retard = (number_format($stat_trace->taux_retard, 2)*100);
        } else {
            $statPPM = [];
            $stat_ppm = (object) [
                'nb_ppm' => 0,
                'taux_fini' => 0,
                'taux_retard' => 0,
                'taux_abs' => 0
            ];

            $statTrace = [];
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
        return view('PLANNING.PPMEETING.listedemandeforppmeeting', data: compact('clients','nomTiers','idTiers','modele','chaine', 'liste','stat_ppm','stat_trace'));
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
