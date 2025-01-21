<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Macro;
use App\Models\Saison;
use App\Models\MasterPlan;
// use Illuminate\Support\Facades\Storage;
use App\Models\ValeurAjoute;
use Illuminate\Http\Request;
use App\Models\VRecapMasterPlan;
use Illuminate\Support\Facades\DB;

class ControllerMasterPlan extends Controller
{
    public static function listeMasterPlan(Request $request)
    {
        $filters = [
            'idSaison' => $request->input('idSaison'),
            'demande_client_id' => $request->input('demande_client_id'),
            'type_valeur_ajoutee' => $request->input('type_valeur_ajoutee'),
            'designation_stade_master_plan' => $request->input('designation_stade_master_plan'),
            'nom_style' => $request->input('nom_style'),
            'podateStart' => $request->input('podateStart'),
            'podateTil' => $request->input('podateTil'),
            'etdStart' => $request->input('etdStart'),
            'etdTil' => $request->input('etdTil'),
        ];

        // $masterPlans = VRecapMasterPlan::findAll();
        $masterPlans = VRecapMasterPlan::query();

        $nomSaison = null;
        if ($request->idSaison) {
            $masterPlans->where('id_saison', $request->input('idSaison'));
            $nomSaison = Saison::where('id', $request->idSaison)->pluck('type_saison')->first();
        }

        $nom_client = null;
        if ($request->demande_client_id) {
            $masterPlans->where('demande_client_id', 'ILIKE', '%' . $request->input('demande_client_id') . '%');
            $nom_client = VRecapMasterPlan::where('demande_client_id', $request->demande_client_id)->pluck('nom_client')->first();
        }

        $type_valeur_ajoutee = null;
        if ($request->type_valeur_ajoutee) {
            $masterPlans->where('type_valeur_ajoutee', 'ILIKE', '%' . $request->input('type_valeur_ajoutee') . '%');
        }

        $designation_stade_master_plan = null;
        if ($request->designation_stade_master_plan) {
            $masterPlans->where('designation_stade_master_plan', 'ILIKE', '%' . $request->input('designation_stade_master_plan') . '%');
        }
        $designation_stade_master_plan = DB::select('SELECT * FROM stadeMasterPlan');

        $nom_style = null;
        if ($request->nom_style) {
            $masterPlans->where('nom_style', 'ILIKE', '%' . $request->input('nom_style') . '%');
            // $nom_style = VRecapMasterPlan::where('nom_style', $request->nom_style)->pluck('nom_style')->first();
        }
        $nom_style = DB::select('SELECT * FROM style');

        if ($request->podateStart && $request->podateTil) {
            $masterPlans->whereBetween('podate', [$request->podateStart, $request->podateTil]);
        }
        if ($request->etdStart && $request->etdTil) {
            $masterPlans->whereBetween('etdfinal', [$request->etdStart, $request->etdTil]);
        }

        $masterPlans = $masterPlans->get();

        // Initialize arrays to store retard values
        $retardValues = [];
        // $podatecheked = null;
        // $etdcheked = null;
        foreach ($masterPlans as $plan) {
            $idRecapCommande = $plan->id_recap_commande;
            $iddestination = $plan->id_destination;
            $retardData = MasterPlan::calculerRetard($idRecapCommande);

            $retardValues[$plan->id_recap_commande] = [
                'retardTissu' => $retardData['retardTissu'],
                'retardAccessoire' => $retardData['retardAccessoire'],
            ];

            $podatecheked = $plan->podate;
            $etdcheked = $plan->etdinitial;

            $plan->$podatecheked = VRecapMasterPlan::check_and_insert_podate($idRecapCommande);
            $plan->$etdcheked = VRecapMasterPlan::check_or_update_etdfinal($iddestination);


            // $podatecheked = $plan->$podatecheked;
            // $etdcheked = $plan->$etdcheked;
            // dd('etd checked:', $etdcheked, 'podatechecked :', $podatecheked);
            // $plan->$podatecheked;
            // dd($podatecheked);
            // $plan->$etdcheked = $etdcheked;
            // dd($etdcheked);
            // dd($plan->$etdcheked);
        }

        $valeursAjoutees = ValeurAjoute::getAllValeurAjoute();
        $nb_negoc = VRecapMasterPlan::findNbrNegociation($filters);
        $nb_approv = VRecapMasterPlan::findNbrApprov($filters);
        $nb_transfo = VRecapMasterPlan::findNbrTransfo($filters);
        $nb_cond = VRecapMasterPlan::findNbrCond($filters);
        $nb_expe = VRecapMasterPlan::findNbrExpe($filters);
        $nb_fact = VRecapMasterPlan::findNbrFacturation($filters);


        return view('Planning.RAD.listeMasterPlan', compact(
            'masterPlans',
            'nomSaison',
            'nom_client',
            'nom_style',
            'valeursAjoutees',
            'type_valeur_ajoutee',
            'designation_stade_master_plan',
            'retardValues',
            // 'podateValues',
            // 'etdValues',
            'podatecheked',
            'etdcheked',
            'nb_negoc',
            'nb_approv',
            'nb_transfo',
            'nb_cond',
            'nb_expe',
            'nb_fact'

        ));
    }
    public static function detailsMasterPlan($demande_client_id)
    {

        $masterPlans = VRecapMasterPlan::where('demande_client_id', $demande_client_id)->get();
        $retardValues = [];

        $podatecheked = null;
        $etdcheked = null;

        foreach ($masterPlans as $plan) {
            $idRecapCommande = $plan->id_recap_commande;
            $iddestination = $plan->id_destination;

            $retardData = MasterPlan::calculerRetard($idRecapCommande);

            $retardValues[$plan->id_recap_commande] = [
                'retardTissu' => $retardData['retardTissu'],
                'retardAccessoire' => $retardData['retardAccessoire'],
            ];

            $podatecheked = $plan->poDate;
            $etdcheked = $plan->etdinitial;


            // Assurez-vous que podatecheked et etdcheked sont définis correctement
            $plan->podatecheked = VRecapMasterPlan::check_and_insert_podate($idRecapCommande);
            $plan->etdcheked = VRecapMasterPlan::check_or_update_etdfinal($iddestination);
        }
        $details = VRecapMasterPlan::findByNumeroCommande($demande_client_id);
        $ki = VRecapMasterPlan::calculKIAll($demande_client_id);
        $joursrestants = VRecapMasterPlan::jourrestants($demande_client_id);
        $datediff = VRecapMasterPlan::jourrestantsDate($demande_client_id);
        $progression = VRecapMasterPlan::progression_export($demande_client_id);
        return view('Planning.RAD.detailsMasterPlan', compact(
            'details',
            'ki',
            'joursrestants',
            'datediff',
            'progression',
            'masterPlans',
            'retardValues',
            'podatecheked',
            'etdcheked'
        ));
    }
    public static function showajoutermasterplan()
    {
        $details_recap = MasterPlan::getRecapForMasterPlan();
        return view('Planning.RAD.ajoutermasterplan', compact('details_recap'));
    }
    public static function ajoutermasterplan(Request $request)
    {
        $idrecap = $request->input('idrecap');
        $iddemande = $request->input('iddemandeclient');

        if (is_null($idrecap)) {
            return redirect()->back()->with('error', 'Erreur : idrecap n\'a pas été correctement transmis.');
        }

        $id_destination_masterPlans_query = MasterPlan::getDemandeForMasterPlan($idrecap);
        $iddestinationn = $id_destination_masterPlans_query[0]->id;
        $id_stade_specifique = $request->input('id_stade_specifique');
        $statut = $request->input('statut');
        $etat = 0;

        MasterPlan::insertMasterPlan($idrecap, $iddemande, $iddestinationn, $id_stade_specifique, $statut, $etat);

        return redirect()->route('LRP.showajoutermasterplan')->with('success', 'Données ajoutées avec succès.');
    }
}
