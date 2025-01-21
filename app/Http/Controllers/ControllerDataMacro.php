<?php

namespace App\Http\Controllers;

use App\Models\BmcPlanning;
use App\Models\BmPlanning;
use App\Models\RetroPlanning;
use Carbon\Carbon;
use App\Models\Style;
use App\Models\Lavage;
use App\Models\Saison;
use App\Models\ValeurAjoute;
use Illuminate\Http\Request;
use App\Models\StadeSpecifique;
use App\Models\DATA_MACRO\Macro;
use App\Models\DATA_MACRO\DataBm;
use App\Models\DATA_MACRO\VMacro;
use App\Models\DATA_MACRO\DataBmc;
use App\Models\DATA_MACRO\DataLbt;
use App\Models\DATA_MACRO\DataPro;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\DATA_MACRO\DataMacro;
use App\Models\DATA_MACRO\DataPrint;
use Illuminate\Support\Facades\Cache;
use App\Models\DATA_MACRO\MacroDetail;
use App\Models\PrintPlanning;

class ControllerDataMacro extends Controller
{
    //pour les filtres
    public static function recherchemodele(Request $request)
    {
        $stade = $request->get('type_saison');
        $stade = DB::select('select * from stadespecifique where designation=?', [$stade]);
        return response()->json($stade);
    }
    public static function recherchestadespecifique(Request $request)
    {
        $query = $request->get('designation');

        $stades = StadeSpecifique::where('designation', 'ILIKE', '%' . $query . '%')
            ->where('etat', 0)
            ->get();

        return response()->json($stades);
    }
    // end pour les filtres




    // --------------SHOW
    public static function showlistData(Request $request)
    {
        // Initialisation des filtres de la requête
        $filters = [
            'idSaison' => $request->input('idSaison'),
            'idtiers' => $request->input('idtiers'),
            'nom_client' => $request->input('nom_client'),
            'id_stade_specifique' => $request->input('id_stade_specifique'),
            'designation' => $request->input('designation'),
            'type_lavage' => $request->input('type_lavage'),
            'type_valeur_ajoutee' => $request->input('type_valeur_ajoutee'),
            'modele' => $request->input('modele'),
            'startMois' => $request->input('startMois'),
            'endMois' => $request->input('endMois'),
            'startDispo' => $request->input('startDispo'),
            'endDispo' => $request->input('endDispo'),
            'idStyle' => $request->input('idStyle')
        ];
        // $column=['id_saison','id_tiers','id_stade_specifique'];

        // Récupérer les données de DataMacro avec les filtres
        $dts = DataMacro::query();

        // filtres
        if ($request->idSaison) {
            $dts->where('id_saison', $request->input('idSaison'),);
        }

        $nom_client = null;
        if ($request->idtiers) {
            $dts->where('id_tier', $request->input('idtiers'));
            $nom_client = DataMacro::where('id_tier', $request->idtiers)->pluck('nom_client')->first();
        }

        if ($request->type_valeur_ajoutee) {
            $valeurRecherchee = $request->input('type_valeur_ajoutee');
            $dts->whereRaw("',' || types_valeur_ajoutee || ',' ILIKE ?", ['%,' . $valeurRecherchee . ',%']);
        }

        if ($request->idStyle) {
            $dts->where('id_style', 'ILIKE', '%' . $request->input('idStyle') . '%');
        }

        if ($request->startMois && $request->endMois) {
            $dts->whereBetween('disponibilite_data', [$request->input('startMois'), $request->input('endMois')]);
        }

        if ($request->startDispo && $request->endDispo) {
            $dts->whereBetween('disponibilite_data', [$request->input('startDispo'), $request->input('endDispo')]);
        }

        if ($request->modele) {
            $dts->where('modele', 'ILIKE', '%' . $request->input('modele'));
        }

        $etat = $request->input('etat');

        if ($etat === '100') {
            $dts->whereNotNull('disponibilite_data');
        } elseif ($etat === '200') {
            $dts->whereNull('disponibilite_data');
        }

        if ($request->designation) {
            $dts->where('designation_stade_specifique', 'ILIKE', '%' . $request->input('designation'));
        }

        if ($request->type_lavage) {
            $filtre = DB::table('v_filtre_data_all')->pluck('demande_client_id');

            $all_id_demande_lavage = collect();

            $demande_with_lavage = DB::table('v_lavagedemandeclient')
                ->select('id_demande_client')
                ->whereIn('id_demande_client', $filtre)
                ->where('type_lavage', 'ILIKE', '%' . $request->input('type_lavage') . '%')
                ->pluck('id_demande_client');

            $demande_with_valeurajoutee = DB::table('datalbt as d')
                ->select('d.iddemandeclient')
                ->whereIn('d.iddemandeclient', $filtre)
                ->whereRaw("(',' || d.valeurajoutee || ',') ILIKE ?", ['%,' . 'lavage' . ',%'])
                ->orWhereRaw("(',' || d.valeurajoutee || ',') ILIKE ?", ['%,' . 'blanchiment' . ',%'])
                ->orWhereRaw("(',' || d.valeurajoutee || ',') ILIKE ?", ['%,' . 'teinture' . ',%'])
                ->pluck('iddemandeclient');

            $all_id_demande_lavage = $all_id_demande_lavage->merge($demande_with_lavage)->merge($demande_with_valeurajoutee);

            // Ajouter la condition au queryset principal si des résultats existent
            if (!$all_id_demande_lavage->isEmpty()) {
                $dts->whereIn('demande_client_id', $all_id_demande_lavage);
            }
        }

        $dts = $dts->get();
        // end filtres

        $values = [];
        $qte = [];
        $demande_clients = [];
        $estdispo = null;

        foreach ($dts as $dt) {
            // check les Date TAOKP
            $values[$dt->demande_client_id] = $dt->checkValues($dt->demande_client_id);

            $effectif = $dt->effectif;
            $efficience = $dt->efficience;
            $qte[$dt->demande_client_id] = $dt->qte;
            $demande_clients[$dt->demande_client_id] = $dt;
            $estdispo = DataMacro::estdispo($dt->demande_client_id);
            // $estdispo = DataMacro::estdispo(1);
            // dd($estdispo);
        }

        $startMois = null;
        $endMois = null;
        $effectif = null;
        $efficience = null;
        $inline = $dts[0]->inline ?? null;
        $disponibilite_data = $dts[0]->disponibilite_data ?? null;

        $estdispo = DataMacro::estdispo($dts[0]->demande_client_id);
        // dd($estdispo);

        if (!empty($dts[0])) {
            $demande_client_id = $dts[0]->demande_client_id;

            $commande = DB::table('dataprod')->where('iddemandeclient', $demande_client_id)->first();
            if ($commande) {
                $disponibilite = Carbon::parse($commande->inline ?? $commande->propositioninline);
                $startMois = $disponibilite->startOfMonth()->format('Y-m-d');
                $endMois = $disponibilite->endOfMonth()->format('Y-m-d');
                $mois = $disponibilite->month;
                $annee = $disponibilite->year;
            }
        }

        /////////////////////////////MACRO//////////////////////////////////////

        // ceci est pour Prod
        $query_macro = DB::select('select * from v_macrocharge_combine where id_type_macro=1 order by annee,mois');
        $result = [];
        foreach ($query_macro as $mc) {
            $annee_macro = $mc->annee;
            $mois_macro = $mc->mois;
            $heure_t_macro = $mc->heuretravail;
            // Initialisation d'un sous-tableau pour chaque mois et année
            $mois_result = [];
            // Deuxième boucle : Effectuer les calculs par mois et année
            // $jour_ouvrables_macro = Macro::countJourOuvrable($mois_macro, $annee_macro);
            $jour_ouvrables_macro = $mc->jours_ouvrables;
            $absence_macro = DataMacro::getAbsenceMoisAnnee($mois_macro, $annee_macro, 1);
            $effectif_macro = $mc->effectif_macro;
            $efficience_macro_calcul = DataMacro::getEfficienceMoisDisponibilite($mois_macro, $annee_macro, 1);
            $heure_travail = 8;
            $heure_total = 0;
            $heure_sup_calcul = DataMacro::getSumHeureSupMois($mois_macro);
            $heure_total =  $heure_travail + $heure_sup_calcul;
            $current_effectif = $effectif ?? $effectif_macro;
            $current_efficience = $efficience ?? $efficience_macro_calcul;
            // $capacite_heureUsine = DataMacro::getCapaciteHeureUsine($current_effectif, $current_efficience, $heure_total, $filters, $inline, $disponibilite_data);
            $capacite_heureUsine = $mc->capacite_mois;
            $charge_heure_prod = DataMacro::getChargeHeure($mois_macro, $annee_macro);
            $pourcentage_charge = DataMacro::getPourcentageCharge($charge_heure_prod, $capacite_heureUsine);
            // $pourcentage_estdispo =  $mc->pourcentage_estdispo;
            // $pourcentage_estdispo = Macro::percentage_disp($mois_macro, $annee_macro);
            $macrochargeid = $mc->id;

            $mois_result[] = [
                'annee' => $annee_macro,
                'mois' => $mois_macro,
                'jour_ouvrable' => $jour_ouvrables_macro,
                'effectif_macro' => $effectif_macro,
                'absence_macro' => $absence_macro,
                'efficience_macro' => $efficience_macro_calcul,
                'heure_t' => $heure_t_macro,
                'heures_sup' => $heure_sup_calcul,
                'capacite_heure_usine' => $capacite_heureUsine,
                'charge_heure_prod' => $charge_heure_prod,
                'pourcentage_charge' => $pourcentage_charge,
                // 'pourcentage_estdispo' => $pourcentage_estdispo,
                'macrochargeid' => $macrochargeid,
            ];
            $result[$annee_macro][$mois_macro] = $mois_result;
        }
        //end pour Prod

        // ceci est pour Print
        $query_macro_print = DB::select('select * from v_macrocharge_combine where id_type_macro=2 order by annee,mois');
        $resultprint = [];
        foreach ($query_macro_print as $mc) {
            $annee_macro = $mc->annee;
            $mois_macro = $mc->mois;
            $heure_t_macro = $mc->heuretravail;

            // Initialisation d'un sous-tableau pour chaque mois et année
            $mois_result = [];

            // Deuxième boucle : Effectuer les calculs par mois et année
            // $jour_ouvrables_macro = Macro::countJourOuvrable($mois_macro, $annee_macro);
            $jour_ouvrables_macro = $mc->jours_ouvrables;
            $absence_macro = DataMacro::getAbsenceMoisAnnee($mois_macro, $annee_macro, 2);
            $effectif_macro = $mc->effectif_macro;
            $efficience_macro_calcul = DataMacro::getEfficienceMoisDisponibilite($mois_macro, $annee_macro, 2);
            $heure_travail = 8;
            $heure_total = 0;
            $heure_sup_calcul = DataMacro::getSumHeureSupMoisPrint($mois_macro);
            $heure_total =  $heure_travail + $heure_sup_calcul;


            $current_effectif = $effectif ?? $effectif_macro; // Prioritize dataprod 'effectif'
            $current_efficience = $efficience ?? $efficience_macro_calcul;

            $capacite_heureUsine = DataMacro::getCapaciteHeureUsinePrint($current_effectif, $current_efficience, $heure_total, $filters, $inline, $disponibilite_data);
            $charge_heure = DataMacro::getChargeHeure($mois_macro, $annee_macro);
            $pourcentage_charge = DataMacro::getPourcentageCharge($charge_heure, $capacite_heureUsine);

            $mois_result[] = [
                'annee' => $annee_macro,
                'mois' => $mois_macro,
                'jour_ouvrable' => $jour_ouvrables_macro,
                'effectif_macro' => $effectif_macro,
                'absence_macro' => $absence_macro,
                'efficience_macro' => $efficience_macro_calcul,
                'heure_t' => $heure_t_macro,
                'heures_sup' => $heure_sup_calcul,
                'capacite_heure_usine' => $capacite_heureUsine,
                'charge_heure' => $charge_heure,
                'pourcentage_charge' => $pourcentage_charge,
            ];

            $resultprint[$annee_macro][$mois_macro] = $mois_result;
        }
        //   end print

        // ceci est pour bm
        $query_macro_bm = DB::select('select * from v_macrocharge_combine where id_type_macro=3 order by annee,mois');
        $resultbm = [];
        foreach ($query_macro_bm as $mc) {
            $annee_macro = $mc->annee;
            $mois_macro = $mc->mois;
            $heure_t_macro = $mc->heuretravail;

            // Initialisation d'un sous-tableau pour chaque mois et année
            $mois_result = [];

            // Deuxième boucle : Effectuer les calculs par mois et année
            // $jour_ouvrables_macro = Macro::countJourOuvrable($mois_macro, $annee_macro);
            $jour_ouvrables_macro = $mc->jours_ouvrables;
            $absence_macro = DataMacro::getAbsenceMoisAnnee($mois_macro, $annee_macro, 3);
            $effectif_macro = $mc->effectif_macro;
            $besoin_effectif = $mc->besoin_effectif;
            $efficience_macro_calcul = DataMacro::getEfficienceMoisDisponibilite($mois_macro, $annee_macro, 3);
            $heure_travail = 8;
            $heure_total = 0;
            $heure_sup_calcul = DataMacro::getSumHeureSupMoisBm($mois_macro);
            $heure_total =  $heure_travail + $heure_sup_calcul;


            $current_effectif = $effectif_macro + $besoin_effectif ?? $effectif_macro;
            $current_efficience = $efficience ?? $efficience_macro_calcul;

            $capacite_heureUsine = DataMacro::getCapaciteHeureUsineBm($current_effectif, $current_efficience, $heure_total, $filters, $inline, $disponibilite_data);
            $charge_heure = DataMacro::getChargeHeureBm($mois_macro, $annee_macro);
            $pourcentage_charge = DataMacro::getPourcentageCharge($charge_heure, $capacite_heureUsine);

            $mois_result[] = [
                'annee' => $annee_macro,
                'mois' => $mois_macro,
                'jour_ouvrable' => $jour_ouvrables_macro,
                'effectif_macro' => $current_effectif,
                'absence_macro' => $absence_macro,
                'efficience_macro' => $efficience_macro_calcul,
                'heure_t' => $heure_t_macro,
                'heures_sup' => $heure_sup_calcul,
                'capacite_heure_usine' => $capacite_heureUsine,
                'charge_heure' => $charge_heure,
                'pourcentage_charge' => $pourcentage_charge,
                'besoin_effectif' => $besoin_effectif,
            ];

            $resultbm[$annee_macro][$mois_macro] = $mois_result;
        }
        //   end bm

        // ceci est pour bmc
        $query_macro_bmc = DB::select('select * from v_macrocharge_combine where id_type_macro=4 order by annee,mois');
        $resultbmc = [];
        foreach ($query_macro_bmc as $mc) {
            $annee_macro = $mc->annee;
            $mois_macro = $mc->mois;
            $heure_t_macro = $mc->heuretravail;

            $demande_client_id = null;
            foreach ($demande_clients as $id => $demande) {
                if ($demande->mois == $mois_macro && $demande->annee == $annee_macro) {
                    $demande_client_id = $id;
                    break;
                }
            }

            $mois_result = [];

            // $jour_ouvrables_macro = Macro::countJourOuvrable($mois_macro, $annee_macro);
            $jour_ouvrables_macro = $mc->jours_ouvrables;
            $effectif_macro = $mc->effectif_macro;
            $besoin_effectif = $mc->besoin_effectif;
            $efficience_macro_calcul = DataMacro::getEfficienceMoisDisponibilite($mois_macro, $annee_macro, 4);
            $heure_travail = 8;
            $heure_total = 0;
            $heure_sup_calcul = DataMacro::getSumHeureSupMoisBm($mois_macro);
            $heure_total =  $heure_travail + $heure_sup_calcul;


            $current_effectif = $effectif_macro + $besoin_effectif ?? $effectif_macro;
            $current_efficience = $efficience ?? $efficience_macro_calcul;

            $capacite_heureUsine = DataMacro::getCapaciteHeureUsineBmc($jour_ouvrables_macro, $current_efficience, $heure_total, $filters, $inline, $disponibilite_data);

            if ($demande_client_id !== null && isset($qte[$demande_client_id])) {
                $charge_heure = DataMacro::getChargeHeureBmc($qte[$demande_client_id]);
            } else {
                $charge_heure = 0;
            }

            $pourcentage_charge = DataMacro::getPourcentageCharge($charge_heure, $capacite_heureUsine);

            $mois_result[] = [
                'annee' => $annee_macro,
                'mois' => $mois_macro,
                'jour_ouvrable' => $jour_ouvrables_macro,
                'effectif_macro' => $current_effectif,
                'absence_macro' => $absence_macro,
                'efficience_macro' => $efficience_macro_calcul,
                'heure_t' => $heure_t_macro,
                'heures_sup' => $heure_sup_calcul,
                'capacite_heure_usine' => $capacite_heureUsine,
                'charge_heure' => $charge_heure,
                'pourcentage_charge' => $pourcentage_charge,
                'besoin_effectif' => $besoin_effectif,
            ];

            $resultbmc[$annee_macro][$mois_macro] = $mois_result;
        }
        //   end bmc


        // ceci est pour lbt
        $query_macro_lbt = DB::select('select * from v_macrocharge_combine where id_type_macro=5 order by annee,mois');
        $resultlbt = [];
        foreach ($query_macro_lbt as $mc) {
            $annee_macro = $mc->annee;
            $mois_macro = $mc->mois;
            $heure_t_macro = $mc->heuretravail;

            $mois_result = [];

            // $jour_ouvrables_macro = Macro::countJourOuvrable($mois_macro, $annee_macro);
            $jour_ouvrables_macro = $mc->jours_ouvrables;
            $effectif_macro = $mc->effectif_macro;
            $besoin_effectif = $mc->besoin_effectif;
            $efficience_macro_calcul = DataMacro::getEfficienceMoisDisponibilite($mois_macro, $annee_macro, 5);
            $heure_travail = 8;
            $heure_total = 0;
            $heure_total =  $heure_travail + $heure_sup_calcul;
            $poids_total = DataMacro::get_smv_poids_TotalParMois();

            $current_effectif = $effectif_macro + $besoin_effectif ?? $effectif_macro;
            $current_efficience = $efficience ?? $efficience_macro_calcul;

            $capacite_heureUsine = 420;
            $charge_heure = DataMacro::getChargeHeureLbt($qte);
            // $pourcentage_charge = DataMacro::getPourcentageCharge($charge_heure, $capacite_heureUsine);
            $pourcentage_charge = DataMacro::pourcentagelbt($mois_macro, $annee_macro);
            // $pourcentage_charge = DataMacro::pourcentagelbt();

            $mois_result[] = [
                'annee' => $annee_macro,
                'mois' => $mois_macro,
                'jour_ouvrable' => $jour_ouvrables_macro,
                'effectif_macro' => $current_effectif,
                'absence_macro' => $absence_macro,
                'efficience_macro' => $efficience_macro_calcul,
                'heure_t' => $heure_t_macro,
                'heures_sup' => $heure_sup_calcul,
                'capacite_heure_usine' => $capacite_heureUsine,
                'charge_heure' => $charge_heure,
                'pourcentage_charge' => $pourcentage_charge,
                'besoin_effectif' => $besoin_effectif,
                'poids' => $poids_total,
            ];

            $resultlbt[$annee_macro][$mois_macro] = $mois_result;
        }
        //   end lbt

        $lavages = Lavage::all();
        $valeursAjoutees = ValeurAjoute::all();
        $styles = Style::all();
        $macro = Macro::all();

        return view(
            'Planning.Data_Macro.listeData',
            [
                'dts' => $dts,
                'values' => $values,
                'valeursAjoutees' => $valeursAjoutees,
                'lavages' => $lavages,
                'styles' => $styles,
                'startMois' => $startMois,
                'endMois' => $endMois,
                'query_macro' => $query_macro,
                'result' => $result,
                'resultprint' => $resultprint,
                'resultbm' => $resultbm,
                'resultbmc' => $resultbmc,
                'resultlbt' => $resultlbt,
                'estdispo' => $estdispo
            ]
        );
    }

    // 11/10/2024 : pour AJAX DES DATATABLES : ATT POUR LE MOMENT  A FINIR
    public function getDataJson(Request $request)
    {
        $id_type_macro = $request->input('id_type_macro');

        $query_macro = DB::select('select id_type_macro from type_macrocharge where id_type_macro=?', [$id_type_macro]);


        return response()->json($query_macro);
    }

    public static function showdataprod($iddemandeclient)
    {
        $deets1 = DataMacro::detailsData1($iddemandeclient);


        // misy dataprod ireto,depuis v_filtre_data
        $deets = DataMacro::detailsData($iddemandeclient);

        $chaine = DataMacro::findAllChaine();
        $minute_prod = DataMacro::calculminprod($iddemandeclient);
        $capacite_j = DataMacro::calculCapaciteChaine($iddemandeclient);

        $nb_j_prod = DataMacro::calculNbJProd($iddemandeclient);

        if (isset($deets[0]->jourprod)) {
            $nb_j_prod = $deets[0]->jourprod;
        }

        $outline = DataMacro::calculOutline($iddemandeclient);
        $details = DataPro::findDataProdByIdDmd($iddemandeclient);
        $selectedValues = DataMacro::getSelectedValuesDataProd($iddemandeclient);

        $hasPrint = DataMacro::checkPrint($iddemandeclient);
        $hasBm = DataMacro::checkBrodMain($iddemandeclient);
        $hasBmc = DataMacro::checkBrodMachine($iddemandeclient);
        $hasLbt = DataMacro::checkLbt($iddemandeclient);

        $inlinep = DataMacro::calculInlineProposeeProd($iddemandeclient);
        // $inlinep = Carbon::parse($inlinep)->format('d/m/Y');
        return view('Planning.Data_Macro.dataprod', compact(
            'deets1',
            'deets',
            'chaine',
            'minute_prod',
            'capacite_j',
            'nb_j_prod',
            'outline',
            'details',
            'selectedValues',
            'hasPrint',
            'hasBm',
            'hasBmc',
            'hasLbt',
            'inlinep'
        ));
    }
    public static function showdataprint($iddemandeclient)
    {
        $deets1 = DataMacro::detailsData1($iddemandeclient);
        $deets = DataMacro::detailsDataPrint($iddemandeclient);
        $chaine = DataMacro::findAllChaine();
        $minute_prod = DataMacro::calculminprod($iddemandeclient);
        $capacite_j = DataMacro::calculCapaciteChaine($iddemandeclient);
        $capacite_print = DataMacro::calculCapacitePrint($iddemandeclient);
        $nb_j_prod_print = DataMacro::calculNbJProdPrint($iddemandeclient);

        if (isset($deets[0]->jourprod)) {
            $nb_j_prod = $deets[0]->jourprod;
        }

        $outline = DataMacro::calculOutline($iddemandeclient);
        $details = DataPrint::findDataPrintByIdDmd($iddemandeclient);
        $selectedValues = DataMacro::getSelectedValuesDataPrint($iddemandeclient);
        $hasPrint = DataMacro::checkPrint($iddemandeclient);
        $hasBm = DataMacro::checkPrint($iddemandeclient);
        $hasBmc = DataMacro::checkPrint($iddemandeclient);
        $hasLbt = DataMacro::checkPrint($iddemandeclient);

        $outline_print = DataMacro::calculOutlinePrint($iddemandeclient);

        if (!$details || empty($details)) {
            $details = [];
        }
        $inlinep_print = DataMacro::calculInlineProposeePrint($iddemandeclient);
        return view('Planning.Data_Macro.dataprint', compact(
            'deets1',
            'deets',
            'capacite_print',
            'chaine',
            'minute_prod',
            'capacite_j',
            'nb_j_prod_print',
            'outline',
            'details',
            'selectedValues',
            'hasPrint',
            'hasBm',
            'hasBmc',
            'hasLbt',
            'inlinep_print',
            'outline_print',
        ));
    }
    public static function showdatabm($iddemandeclient)
    {
        $deets1 = DataMacro::detailsData1($iddemandeclient);
        $deets = DataMacro::detailsData($iddemandeclient);
        $chaine = DataMacro::findAllChaine();
        $minute_prod = DataMacro::calculminprod($iddemandeclient);

        $capacite_j = DataMacro::calculCapaciteChaine($iddemandeclient);


        $capacite_bm = DataMacro::calculCapaciteBm($iddemandeclient);
        $nb_j_prod = DataMacro::calculNbJProd($iddemandeclient);
        if (isset($deets[0]->jourprod)) {
            $nb_j_prod = $deets[0]->jourprod;
        }
        $outline = DataMacro::calculOutline($iddemandeclient);
        $deets = DataMacro::detailsData($iddemandeclient);
        $heuregrmt = DataMacro::calculChargeHeure($iddemandeclient);
        $details = DataBm::findDataBmByIdDmd($iddemandeclient);
        $selectedValues = DataMacro::getSelectedValuesDataBm($iddemandeclient);
        $hasPrint = DataMacro::checkPrint($iddemandeclient);
        $hasBm = DataMacro::checkPrint($iddemandeclient);
        $hasBmc = DataMacro::checkPrint($iddemandeclient);
        $hasLbt = DataMacro::checkPrint($iddemandeclient);
        $inlinep = DataMacro::calculInlineProposeeProd($iddemandeclient);

        return view('Planning.Data_Macro.databm', compact(
            'deets1',
            'deets',
            'capacite_bm',
            'chaine',
            'minute_prod',
            'capacite_j',
            'nb_j_prod',
            'outline',
            'heuregrmt',
            'details',
            'selectedValues',
            'hasPrint',
            'hasBm',
            'hasBmc',
            'hasLbt',
            'inlinep'
        ));
    }
    public static function showdatabmc($iddemandeclient)
    {
        $deets1 = DataMacro::detailsData1($iddemandeclient);
        $deets = DataMacro::detailsData($iddemandeclient);
        $chaine = DataMacro::findAllChaine();
        $minute_prod = DataMacro::calculminprod($iddemandeclient);
        $capacite_j = DataMacro::calculCapaciteChaine($iddemandeclient);
        $capacite_bmc = DataMacro::calculCapaciteBmc($iddemandeclient);
        $nb_j_prod = DataMacro::calculNbJProd($iddemandeclient);
        if (isset($deets[0]->jourprod)) {
            $nb_j_prod = $deets[0]->jourprod;
        }
        $outline = DataMacro::calculOutline($iddemandeclient);
        $deets = DataMacro::detailsData($iddemandeclient);
        $heuregrmt = DataMacro::calculChargeHeure($iddemandeclient);
        $listemachine = DataMacro::findAllListeMachine();
        $details = DataBmc::findDataBmcByIdDmd($iddemandeclient);
        $selectedValues = DataMacro::getSelectedValuesDataBmc($iddemandeclient);
        $hasPrint = DataMacro::checkPrint($iddemandeclient);
        $hasBm = DataMacro::checkPrint($iddemandeclient);
        $hasBmc = DataMacro::checkPrint($iddemandeclient);
        $hasLbt = DataMacro::checkPrint($iddemandeclient);
        $inlinep = DataMacro::calculInlineProposeeProd($iddemandeclient);

        if (!$details || empty($details)) {
            $details = [];
        }
        return view('Planning.Data_Macro.databmc', compact(
            'deets1',
            'deets',
            'capacite_bmc',
            'chaine',
            'minute_prod',
            'capacite_j',
            'nb_j_prod',
            'outline',
            'heuregrmt',
            'listemachine',
            'details',
            'selectedValues',
            'hasPrint',
            'hasBm',
            'hasBmc',
            'hasLbt',
            'inlinep'
        ));
    }
    public static function showdatalbt($iddemandeclient)
    {
        $deets1 = DataMacro::detailsData1($iddemandeclient);
        $deets = DataMacro::detailsData($iddemandeclient);
        $chaine = DataMacro::findAllChaine();
        $minute_prod = DataMacro::calculminprod($iddemandeclient);
        $capacite_j = DataMacro::calculCapaciteChaine($iddemandeclient);
        $capacite_bm = DataMacro::calculCapaciteBm($iddemandeclient);
        $nb_j_prod = DataMacro::calculNbJProd($iddemandeclient);
        if (isset($deets[0]->jourprod)) {
            $nb_j_prod = $deets[0]->jourprod;
        }
        $outline = DataMacro::calculOutline($iddemandeclient);
        $deets = DataMacro::detailsData($iddemandeclient);
        $heuregrmt = DataMacro::calculChargeHeure($iddemandeclient);
        $details = DataLbt::findDataLbtByIdDmd($iddemandeclient);
        $selectedValues = DataMacro::getSelectedValuesDataLbt($iddemandeclient);
        $valeursajoutees = DataMacro::getValeurAjouteesDataLbt($iddemandeclient);
        $hasPrint = DataMacro::checkPrint($iddemandeclient);
        $hasBm = DataMacro::checkPrint($iddemandeclient);
        $hasBmc = DataMacro::checkPrint($iddemandeclient);
        $hasLbt = DataMacro::checkPrint($iddemandeclient);
        $inlinep = DataMacro::calculInlineProposeeProd($iddemandeclient);


        if (!$details || empty($details)) {
            $details = [];
        }
        $listemachine = DataMacro::findAllListeMachine();
        $poids = DataLbt::findoidsDataLbtByIdDmd($iddemandeclient);

        return view('Planning.Data_Macro.datalbt', compact(
            'deets1',
            'deets',
            'capacite_bm',
            'chaine',
            'minute_prod',
            'capacite_j',
            'nb_j_prod',
            'outline',
            'heuregrmt',
            'details',
            'listemachine',
            'poids',
            'selectedValues',
            'valeursajoutees',
            'hasPrint',
            'hasBm',
            'hasBmc',
            'hasLbt',
            'inlinep'
        ));
    }
    public function getQte($demande_client_id)
    {
        $qte = DB::table('v_filtre_data')
            ->where('demande_client_id', $demande_client_id)
            ->value('qte');

        return response()->json(['qte' => $qte]);
    }
    // --------------END SHOW


    // -------------- CREATE
    public static function createDataProd(Request $request)
    {
        $request->validate([
            'demande_client_id' => 'required|numeric',
            'min_prod' => 'required|string',
            'capacite_j' => 'required|numeric',
            'qte_coupe' => 'required|numeric',
            'inlinep' => 'required|date',
            'inliner' => 'nullable|date',
            'outline' => 'nullable|date',
            'chaine' => 'required|exists:chaine,id_chaine',
            'nb_j_prod' => 'required|string',
            'etatjourspe' => 'nullable|string',
            'commentaire' => 'nullable|string',
            // 'qte_coupe'=>'nul'
        ]);

        // Vérification que inline est >= disponibilite
        $disponibiliteCheck = DataPro::where('iddemandeclient', $request->input('demande_client_id'))
            // ->where('id_chaine', $request->input('chaine'))
            ->where('disponibilite', '>', $request->input('inliner'))
            ->first();

        if ($disponibiliteCheck) {
            return redirect()->back()->withErrors('La date d\'inline doit être supérieure ou égale à la date de disponibilité.');
        }

        $existingDataProd = DataPro::where('iddemandeclient', $request->input('demande_client_id'))
            ->where('id_chaine', $request->input('chaine'))
            ->where(function ($query) use ($request) {
                $query->where(function ($subQuery) use ($request) {
                    // Vérifie si inliner se trouve entre inline et outline
                    $subQuery->where('inline', '<=', $request->input('inliner'))
                        ->where('outline', '>=', $request->input('inliner'));
                })
                    ->orWhere(function ($subQuery) use ($request) {
                        $subQuery->where('inline', '=', $request->input('inliner'))
                            ->orWhere('propositioninline', '=', $request->input('inliner'));
                    });
            })
            ->first();

        $outlineCheck = DataPro::where('id_chaine', $request->input('chaine'))
            ->where('inline', '<=', $request->input('inliner'))
            ->where('outline', '>=', $request->input('inliner'))
            ->first();

        if ($outlineCheck) {
            return redirect()->back()->withErrors('La chaîne est déjà réservée pour cette demande jusqu\'au ' . $outlineCheck->outline . '. Veuillez choisir une autre chaîne.');
        }


        // dd($existingDataProd, $request->input('inliner'), $request->input('inlinep'));


        if ($existingDataProd) {
            return redirect()->back()->withErrors('La chaîne est déjà réservée pour cette demande jusqu\'au ' . $existingDataProd->outline . '. Veuillez choisir une autre chaîne.');
        }

        // Concaténation des valeurs des cases à cocher si elles sont cochées
        $etatjourspe = [];

        if ($request->has('ferie')) {
            $etatjourspe[] = $request->input('ferie'); // ajoute 100 si coché
        }
        if ($request->has('samedi')) {
            $etatjourspe[] = $request->input('samedi'); // ajoute 400 si coché
        }
        if ($request->has('dimanche')) {
            $etatjourspe[] = $request->input('dimanche'); // ajoute 200 si coché
        }
        if ($request->has('shift')) {
            $etatjourspe[] = $request->input('shift'); // ajoute 300 si coché
        }

        // Concaténation des valeurs avec une virgule, espace ou autre séparateur

        $etatjourspe = implode(', ', $etatjourspe);

        $inlinep = Carbon::parse($request->input('inlinep'));
        $propositionInline = $inlinep->addDays(7)->format('Y-m-d');
        $data = [
            'demande_client_id' => $request->input('demande_client_id'),
            'disponibilite' => $request->input('inlinep'),
            'id_chaine' => $request->input('chaine'),
            'propositionInline' => $propositionInline,
            'inline' => $request->input('inliner'),
            'outline' => $request->input('outline'),
            'capacite' => $request->input('capacite_j'),
            'jourprod' => $request->input('nb_j_prod'),
            'minuteGrmt' => $request->input('min_prod'),
            'etatjourspestr' => $etatjourspe,
            'commentaire' => $request->input('commentaire'),
            'qte_coupe' => $request->input('qte_coupe'),
            'heuresup' => $request->input('heuresup'),
        ];
        DataPro::insertDataProd($data);

        //RETRO PLANNING
        $idlast = RetroPlanning::getLastDataProd();
        $qteprev = $request->input('qteprev');
        $smv_prod = $request->input('smv_prod');
        $qtereel = $qteprev;
        for($i = 0, $j = 0; $j < $request->input('nb_j_prod'); $i++) {
            $currentDate = Carbon::parse($request->input('inliner'))->addDays($i);
            // Check if the current day is Saturday or Sunday
            if ($currentDate->isSaturday() || $currentDate->isSunday()) {
                continue; // Skip this day and go to the next iteration
            }
            RetroPlanning::create([
                'iddemandeclient' => $request->input('demande_client_id'),
                'id_data_prod' => $idlast,
                'id_chaine' => $request->input('chaine'),
                'inlinechacun' => $currentDate,
                'heuretravail' => 8 + $request->input('heuresup'),
                'efficience' => $request->input('efficience'),
                'efficiencereel' => 0,
                'effectif' => $request->input('effectif'),
                'capacitereel' => $request->input('capacite_j'),
                'qtereel' => $qtereel,
                'commentaire' => "",
                'charge' => (($qtereel*$smv_prod/60)/($request->input('effectif')*8*$request->input('efficience')))*100
            ]);
            // Décrémenter qtereel pour la prochaine itération
            $qtereel -= $request->input('capacite_j');
            $j++;
        }
        $request->session()->put('efficience',$request->input('efficience'));
        $request->session()->put('effectif',$request->input('effectif'));
        $request->session()->put('heuretravail',8 + $request->input('heuresup'));
        $request->session()->put('capacite',$request->input('capacite_j'));
        //RETRO PLANNING

        return redirect()->route('LRP.dataprod', [
            'iddemandeclient' => $request->input('demande_client_id')
        ])->with('success', 'Données ajoutées avec succès.');
    }
    public static function createDataPrint(Request $request)
    {
        $request->validate([
            'demande_client_id' => 'required|numeric',
            // 'smv' => 'required|numeric',
            'min_prod' => 'required|numeric',
            'capacite_j' => 'required|numeric',
            // 'besoin_loading' => 'nullable|numeric',
            'temps_print' => 'required|numeric',
            'inlinep' => 'required|date',
            'inliner' => 'nullable|date',
            'outline' => 'nullable|date',
            'nb_j_prod' => 'required|numeric',
            'commentaire' => 'nullable|string',
            'etatjourspe' => 'nullable|string',
            'minuteGrmt' => $request->input('min_prod'),
            'effectif' => 'nullable|numeric',
            'efficience' => 'nullable|numeric',
            'heuresup' => 'nullable|numeric'
        ]);

        // Concaténation des valeurs des cases à cocher si elles sont cochées
        $etatjourspe = [];

        if ($request->has('ferie')) {
            $etatjourspe[] = $request->input('ferie'); // ajoute 100 si coché
        }
        if ($request->has('dimanche')) {
            $etatjourspe[] = $request->input('dimanche'); // ajoute 200 si coché
        }
        if ($request->has('shift')) {
            $etatjourspe[] = $request->input('shift'); // ajoute 300 si coché
        }

        // Concaténation des valeurs avec une virgule, espace ou autre séparateur
        $etatjourspe = implode(', ', $etatjourspe);

        $data = [
            'demande_client_id' => $request->input('demande_client_id'),
            'disponibilite' => $request->input('inlinep'),
            'temps_print' => $request->input('temps_print'),
            'propositionInline' => $request->input('inlinep'),
            'inline' => $request->input('inliner'),
            'outline' => $request->input('outline'),
            'capacite' => $request->input('capacite_j'),
            'jourprod' => $request->input('nb_j_prod'),
            // 'smv' => $request->input('smv'),
            'minuteGrmt' => $request->input('min_prod'),
            'besoin_loading' => $request->input('capacite_j'),
            'etatjourspestr' => $etatjourspe,
            'commentaire' => $request->input('commentaire'),
            'effectif' => $request->input('effectif'),
            'efficience' => $request->input('cefficience'),
            'heuresup' => $request->input('heuresup'),
        ];
        // dd($request->all());
        DataPrint::insertDataPrint($data);

         //RETRO PLANNING
         $idlast = PrintPlanning::getLastDataPrint();
         $qteprev = $request->input('qteprev');
        //  $smv_print = PrintPlanning::getSmvPrintById($request->input('demande_client_id'));
         $qtereel = $qteprev;
         for($i = 0, $j = 0; $j < $request->input('nb_j_prod'); $i++) {
             $currentDate = Carbon::parse($request->input('inliner'))->addDays($i);
             // Check if the current day is Saturday or Sunday
             if ($currentDate->isSaturday() || $currentDate->isSunday()) {
                 continue; // Skip this day and go to the next iteration
             }
             PrintPlanning::create([
                 'iddemandeclient' => $request->input('demande_client_id'),
                 'id_data_print' => $idlast,
                 'inlinechacun' => $currentDate,
                 'capacitetheorique' => $request->input('capacite_j'),
                 'capacitereel' => $request->input('capacite_j'),
                 'effectif' => $request->input('effectif'),
                 'efficience' => $request->input('efficience') ?? 70 ,
                 'heuretravail' => 8 + $request->input('heuresup'),
                 'qtereel' => $qtereel,
                //  'charge' => ($smv_print*$qtereel/($request->input('effectif')*(8 + $request->input('heuresup')*60*$request->input('efficience'))))*100
                 'charge' => ($request->input('effectif')*(8 + $request->input('heuresup')*60*$request->input('efficience')))
             ]);
             // Décrémenter qtereel pour la prochaine itération
             $qtereel -= $request->input('capacite_j');
             $j++;
         }
         //RETRO PLANNING

        return redirect()->route('LRP.dataprint', [

            'iddemandeclient' => $request->input('demande_client_id')
        ])->with('success', 'Données ajoutées avec succès.');
    }
    public static function createDataBm(Request $request)
    {
        $request->validate([
            'demande_client_id' => 'required|numeric',
            'tempsbrod' => 'required|numeric',
            'capacite_bm' => 'required|numeric',
            'capacite_j' => 'required|numeric',
            'inlinep' => 'required|date',
            'inliner' => 'nullable|date',
            'outline' => 'nullable|date',
            'nb_j_prod' => 'required|numeric',
            'heuregrmt' => 'numeric',
            'commentaire' => 'nullable|string',
            'etatjourspe' => 'nullable|string',
            'effectif_brod_main' => 'nullable|string',
            'efficience' => 'nullable|string',
            'heuresupp' => 'nullable|integer',
        ]);

        $etatjourspe = [];

        if ($request->has('ferie')) {
            $etatjourspe[] = $request->input('ferie'); // ajoute 100 si coché
        }
        if ($request->has('dimanche')) {
            $etatjourspe[] = $request->input('dimanche'); // ajoute 200 si coché
        }
        if ($request->has('shift')) {
            $etatjourspe[] = $request->input('shift'); // ajoute 300 si coché
        }
        if ($request->has('samedi')) {
            $etatjourspe[] = $request->input('samedi'); // ajoute 300 si coché
        }
        $etatjourspe = implode(', ', $etatjourspe);
        $data = [
            'demande_client_id' => $request->input('demande_client_id'),
            'disponibilite' => $request->input('inlinep'),
            'tempsbrod' => $request->input('tempsbrod'),
            'propositionInline' => $request->input('inlinep'),
            'inline' => $request->input('inliner'),
            'outline' => $request->input('outline'),
            'capacite' => $request->input('capacite_bm'),
            'jourprod' => $request->input('nb_j_prod'),
            'heuregrmt' => $request->input('heuregrmt'),
            'besoin_loading' => $request->input('capacite_j'),
            'etatjourspe' => $etatjourspe,
            'commentaire' => $request->input('commentaire'),
            'effectif_bm' => $request->input('effectif_brod_main'),
            'efficience' => $request->input('efficience'),
            'heuresup' => $request->input('heuresupp'),
        ];

        // dd($request->all());
        // dd($request->input('demande_client_id'));
        DataBm::insertDataBm($data);

        //RETRO PLANNING
        $idlast = BmPlanning::getLastDataBm();
        $qteprev = $request->input('qteprev');
        $smv_brod = $request->input('tempsbrod');
        $qtereel = $qteprev;
        for($i = 0, $j = 0; $j < $request->input('nb_j_prod'); $i++) {
            $currentDate = Carbon::parse($request->input('inliner'))->addDays($i);
            // Check if the current day is Saturday or Sunday
            if ($currentDate->isSaturday() || $currentDate->isSunday()) {
                continue; // Skip this day and go to the next iteration
            }
            BmPlanning::create([
                'iddemandeclient' => $request->input('demande_client_id'),
                'id_data_bm' => $idlast,
                'inlinechacun' => $currentDate,
                'capacitetheorique' => $request->input('capacite_j'),
                'capacitereel' => $request->input('capacite_j'),
                'effectif' => $request->input('effectif_brod_main'),
                'efficience' => $request->input('efficience'),
                'heuretravail' => 8 + $request->input('heuresupp'),
                'qtereel' => $qtereel,
                'charge' => (($smv_brod*$qtereel)/($request->input('effectif_brod_main')*(8 + $request->input('heuresupp'))*$request->input('efficience')))*100
            ]);
            // Décrémenter qtereel pour la prochaine itération
            $qtereel -= $request->input('capacite_j');
            $j++;
        }
        //RETRO PLANNING

        return redirect()->route('LRP.databm', [

            'iddemandeclient' => $request->input('demande_client_id')
        ])->with('success', 'Données ajoutées avec succès.');
    }
    public static function createDataBmc(Request $request)
    {
        $request->validate([
            'demande_client_id' => 'required|numeric',
            'nb_points' => 'required|numeric',
            'capacite_bmc' => 'required|numeric',
            'capacite_j' => 'required|numeric',
            'inlinep' => 'required|date',
            'inliner' => 'nullable|date',
            'outline' => 'nullable|date',
            'nb_j_prod' => 'required|numeric',
            'heuregrmt' => 'numeric',
            'commentaire' => 'nullable|string',
            'etatjourspe' => 'nullable|string',
            'effectif_brod_main' => 'nullable|string',
            'efficience' => 'nullable|string',
            'idlistemachine' => 'required|numeric',
        ]);

        // Concaténation des valeurs des cases à cocher si elles sont cochées
        $etatjourspe = [];

        if ($request->has('ferie')) {
            $etatjourspe[] = $request->input('ferie'); // ajoute 100 si coché
        }
        if ($request->has('dimanche')) {
            $etatjourspe[] = $request->input('dimanche'); // ajoute 200 si coché
        }
        if ($request->has('shift')) {
            $etatjourspe[] = $request->input('shift'); // ajoute 300 si coché
        }

        // Concaténation des valeurs avec une virgule, espace ou autre séparateur
        $etatjourspe = implode(', ', $etatjourspe);

        $data = [
            'demande_client_id' => $request->input('demande_client_id'),
            'disponibilite' => $request->input('inlinep'),
            'nb_points' => $request->input('nb_points'),
            'propositionInline' => $request->input('inlinep'),
            'inline' => $request->input('inliner'),
            'outline' => $request->input('outline'),
            'capacite' => $request->input('capacite_lbt'),
            'idlistemachine' => $request->input('idlistemachine'),
            'jourprod' => $request->input('nb_j_prod'),
            'heuregrmt' => $request->input('heuregrmt'),
            'besoin_loading' => $request->input('capacite_j'),
            'etatjourspe' => $etatjourspe,
            'commentaire' => $request->input('commentaire'),
            'effectif_bm' => $request->input('effectif_brod_main'),
            'efficience' => $request->input('efficience'),
        ];
        // dd($request->all());
        DataBmc::insertDataBmc($data);

        //RETRO PLANNING
        $idlast = BmcPlanning::getLastDataBmc();
        $qteprev = $request->input('qteprev');
        $nombrepoint = $request->input('nb_points');
        $qtereel = $qteprev;
        for($i = 0, $j = 0; $j < $request->input('nb_j_prod'); $i++) {
            $currentDate = Carbon::parse($request->input('inliner'))->addDays($i);
            // Check if the current day is Saturday or Sunday
            if ($currentDate->isSaturday() || $currentDate->isSunday()) {
                continue; // Skip this day and go to the next iteration
            }
            BmcPlanning::create([
                'iddemandeclient' => $request->input('demande_client_id'),
                'id_data_bmc' => $idlast,
                'inlinechacun' => $currentDate,
                'capacitetheorique' => $request->input('capacite_j'),
                'capacitereel' => $request->input('capacite_j'),
                'qtereel' => $qtereel,
                'charge' => (($nombrepoint*$qtereel)/4000000*100)
            ]);
            // Décrémenter qtereel pour la prochaine itération
            $qtereel -= $request->input('capacite_j');
            $j++;
        }
        //RETRO PLANNING

        return redirect()->route('LRP.databm', [
            'iddemandeclient' => $request->input('demande_client_id') // Utilisez la clé correcte
        ])->with('success', 'Données ajoutées avec succès.');
    }
    public static function createDataLbt(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'demande_client_id' => 'required|numeric',
            'poids' => 'required|numeric',
            'heure' => 'nullable|numeric',
            'capacite_lbt' => 'required|numeric',
            'idlistemachine' => 'required|numeric',
            'nb_j_prod' => 'required|numeric',
            'inlinep' => 'required|date',
            'inliner' => 'nullable|date',
            'outline' => 'nullable|date',
            'heuregrmt' => 'nullable|numeric',
            'commentaire' => 'nullable|string',
            'etatjourspe' => 'nullable|string',
            'besoin_loading' => 'nullable|numeric',
            'efficience' => 'nullable|string',
            'valeurajoutee' => 'nullable|string',
            'heuresupp' => 'nullable|string'
        ]);


        $etatjourspe = [];

        if ($request->has('ferie')) {
            $etatjourspe[] = $request->input('ferie'); // ajoute 100 si coché
        }
        if ($request->has('dimanche')) {
            $etatjourspe[] = $request->input('dimanche'); // ajoute 200 si coché
        }
        if ($request->has('shift')) {
            $etatjourspe[] = $request->input('shift'); // ajoute 300 si coché
        }
        if ($request->has('samedi')) {
            $etatjourspe[] = $request->input('samedi'); // ajoute 400 si coché
        }


        $valeurajoutee = [];

        if ($request->has('lavage')) {
            $valeurajoutee[] = $request->input('lavage');
        }
        if ($request->has('blanchiment')) {
            $valeurajoutee[] = $request->input('blanchiment');
        }
        if ($request->has('teinture')) {
            $valeurajoutee[] = $request->input('teinture');
        }
        // Concaténation des valeurs avec une virgule, espace ou autre séparateur
        $etatjourspe = implode(', ', $etatjourspe);
        $valeurajoutee = implode(', ', $valeurajoutee);

        try {
            $data = [
                'iddemandeClient' => $request->input('demande_client_id'),
                'disponibilite' => $request->input('inlinep'),
                'poids' => $request->input('poids'),
                'propositioninline' => $request->input('inlinep'),
                'inline' => $request->input('inliner'),
                'outline' => $request->input('outline'),
                'heure' => $request->input('heure'),
                'efficience' => $request->input('efficience'),
                'capacite' => $request->input('capacite_lbt'),
                'jourprod' => $request->input('nb_j_prod'),
                'heuregrmt' => $request->input('heuregrmt'),
                'besoin_loading' => $request->input('besoin_loading'),
                'idlistemachine' => $request->input('idlistemachine'),
                'etatjourspe' => $etatjourspe,
                'commentaire' => $request->input('commentaire'),
                'valeurajoutee' => $request->input('valeurajoutee'),
                // 'effectif' => $request->input('effectif_brod_main'),
            ];

            DataLbt::insertDataLbt($data);

            return redirect()->route('LRP.datalbt', [
                'iddemandeclient' => $request->input('demande_client_id') // Utilisez la clé correcte
            ])->with('success', 'Données ajoutées avec succès.');

            //     return redirect()->route('LRP.successPage')->with('success', 'Les données ont été ajoutées avec succès.');
        } catch (\Exception $errors) {
            return redirect()->back()->withErrors(['msg' => 'Erreur lors de l\'insertion: ' . $errors->getMessage()]);
        }
    }
    // -------------- END CREATE


    // -------------- UPDATE
    public static function updateDataProd(Request $request)
    {
        $request->validate([
            'demande_client_id' => 'required|numeric',
            'min_prod' => 'required|numeric',
            'capacite_j' => 'required|string',
            'qte_coupe' => 'required|numeric',
            'inlinep' => 'required|date',
            'inliner' => 'nullable|date',
            'outline' => 'nullable|date',
            'chaine' => 'required|exists:chaine,id_chaine',
            'nb_j_prod' => 'required|numeric',
            'etatjourspe' => 'nullable|string',
            'commentaire' => 'nullable|string',

            'id' => 'numeric',
            // 'qte_coupe' => $request->input('qte_coupe'),
        ]);

        $etatjourspe = [];

        if ($request->has('ferie')) {
            $etatjourspe[] = $request->input('ferie');
        }
        if ($request->has('dimanche')) {
            $etatjourspe[] = $request->input('dimanche');
        }
        if ($request->has('shift')) {
            $etatjourspe[] = $request->input('shift');
        }

        $etatjourspe = implode(', ', $etatjourspe);

        $id = $request->input('id');
        $data = [
            'demande_client_id' => $request->input('demande_client_id'),
            'propositionInline' => $request->input('inlinep'),
            'id_chaine' => $request->input('chaine'),
            'inline' => $request->input('inliner'),
            'outline' => $request->input('outline'),
            'capacite' => $request->input('capacite_j'),
            'jourprod' => $request->input('nb_j_prod'),
            'minuteGrmt' => $request->input('min_prod'),
            'etatjourspestr' => $etatjourspe,
            'commentaire' => $request->input('commentaire'),
            'qte_coupe' => $request->input('qte_coupe'),
            'heuresup' => $request->input('heuresup'),

        ];

        DataPro::updateDataProd($id, $data);

        return redirect()->route('LRP.dataprod', [
            'iddemandeclient' => $request->input('demande_client_id')
        ])->with('success', 'Données modifiées avec succès.');
    }
    public static function updateDataPrint(Request $request)
    {
        $request->validate([
            'demande_client_id' => 'required|numeric',
            'min_prod' => 'required|numeric',
            'capacite_j' => 'required|string',
            // 'besoin_loading' => 'required|numeric',
            'temps_print' => 'required|numeric',
            'inlinep' => 'required|date',
            'inliner' => 'nullable|date',
            'outline' => 'nullable|date',
            'nb_j_prod' => 'required|numeric',
            'commentaire' => 'nullable|string',
            // 'etatjourspe' => 'nullable|string',
            'effectif' => 'nullable|numeric',
            'efficience' => 'nullable|numeric',
            'heuresup' => 'nullable|numeric',
            'id' => 'numeric',
        ]);

        $etatjourspe = [];

        if ($request->has('ferie')) {
            $etatjourspe[] = $request->input('ferie');
        }
        if ($request->has('dimanche')) {
            $etatjourspe[] = $request->input('dimanche');
        }
        if ($request->has('shift')) {
            $etatjourspe[] = $request->input('shift');
        }

        $etatjourspe = implode(', ', $etatjourspe);

        $data = [
            'demande_client_id' => $request->input('demande_client_id'),
            'disponibilite' => $request->input('inlinep'),
            'temps_print' => $request->input('temps_print'),
            'propositioninline' => $request->input('inlinep'),
            'inline' => $request->input('inliner'),
            'outline' => $request->input('outline'),
            'capacite' => $request->input('capacite_j'),
            'jourprod' => $request->input('nb_j_prod'),
            'minuteGrmt' => $request->input('min_prod'),
            'besoin_loading' => $request->input('capacite_j'),
            'etatjourspe' => $etatjourspe,
            'commentaire' => $request->input('commentaire'),
            'effectif' => $request->input('effectif'),
            'efficience' => $request->input('efficience'),
            'heuresup' => $request->input('heuresup'),

        ];
        $id = $request->input('id');
        // dd($request->all());
        DataPrint::updateDataPrint($id, $data);

        return redirect()->route('LRP.dataprint', [
            'iddemandeclient' => $request->input('demande_client_id')
        ])->with('success', 'Données mises à jour avec succès.');
    }
    public static function updateDataBmc(Request $request)
    {
        $request->validate([
            'id' => 'numeric',
            'demande_client_id' => 'required|numeric',
            'nb_points' => 'required|numeric',
            'idlistemachine' => 'required|numeric',
            'capacite_bmc' => 'required|numeric',
            'besoin_loading' => 'required|numeric',
            'inlinep' => 'required|date',
            'inliner' => 'nullable|date',
            'outline' => 'nullable|date',
            'nb_j_prod' => 'required|numeric',
            'heuregrmt' => 'numeric',
            'commentaire' => 'nullable|string',
            'etatjourspe' => 'nullable|string',
            'effectif_brod_main' => 'nullable|string',
            'efficience' => 'nullable|string',
        ]);

        // Concaténation des valeurs des cases à cocher si elles sont cochées
        $etatjourspe = [];

        if ($request->has('ferie')) {
            $etatjourspe[] = $request->input('ferie');
        }
        if ($request->has('dimanche')) {
            $etatjourspe[] = $request->input('dimanche');
        }
        if ($request->has('shift')) {
            $etatjourspe[] = $request->input('shift');
        }

        // Concaténation des valeurs avec une virgule
        $etatjourspe = implode(', ', $etatjourspe);
        $id = $request->input('id');
        $data = [
            'demande_client_id' => $request->input('demande_client_id'),
            'disponibilite' => $request->input('inlinep'),
            'nb_points' => $request->input('nb_points'),
            'propositionInline' => $request->input('inlinep'),
            'inline' => $request->input('inliner'),
            'outline' => $request->input('outline'),
            'capacite' => $request->input('capacite_bmc'),
            'jourprod' => $request->input('nb_j_prod'),
            'heuregrmt' => $request->input('heuregrmt'),
            'besoin_loading' => $request->input('besoin_loading'),
            'etatjourspe' => $etatjourspe,
            'commentaire' => $request->input('commentaire'),
            'effectif_bm' => $request->input('effectif_brod_main'),
            'efficience' => $request->input('efficience'),
            'idlistemachine' => $request->input('idlistemachine'),
        ];

        $updatedDataBmc = DataBmc::updateDataBmc($id, $data);

        if ($updatedDataBmc) {
            return redirect()->route('LRP.databmc', [
                'iddemandeclient' => $request->input('demande_client_id')
            ])->with('success', 'Données mises à jour avec succès.');
        } else {
            return redirect()->back()->with('error', 'Échec de la mise à jour des données.');
        }
    }
    public static function updateDataBm(Request $request)
    {
        $request->validate([
            'id' => 'numeric',
            'demande_client_id' => 'required|numeric',
            'tempsbrod' => 'required|numeric',
            'capacite_bm' => 'required|numeric',
            'besoin_loading' => 'required|numeric',
            'inlinep' => 'required|date',
            'inliner' => 'nullable|date',
            'outline' => 'nullable|date',
            'nb_j_prod' => 'required|numeric',
            'heuregrmt' => 'numeric',
            'commentaire' => 'nullable|string',
            'etatjourspe' => 'nullable|string',
            'effectif_brod_main' => 'nullable|string',
            'efficience' => 'nullable|string'
        ]);

        $etatjourspe = [];

        if ($request->has('ferie')) {
            $etatjourspe[] = $request->input('ferie');
        }
        if ($request->has('dimanche')) {
            $etatjourspe[] = $request->input('dimanche');
        }
        if ($request->has('shift')) {
            $etatjourspe[] = $request->input('shift');
        }

        $etatjourspe = implode(', ', $etatjourspe);

        $data = [
            'demande_client_id' => $request->input('demande_client_id'),
            'disponibilite' => $request->input('inlinep'),
            'tempsbrod' => $request->input('tempsbrod'),
            'propositionInline' => $request->input('inlinep'),
            'inline' => $request->input('inliner'),
            'outline' => $request->input('outline'),
            'capacite' => $request->input('capacite_bm'),
            'jourprod' => $request->input('nb_j_prod'),
            'heuregrmt' => $request->input('heuregrmt'),
            'besoin_loading' => $request->input('besoin_loading'),
            'etatjourspe' => $etatjourspe,
            'commentaire' => $request->input('commentaire'),
            'effectif_bm' => $request->input('effectif_brod_main'),
            'efficience' => $request->input('efficience')
        ];

        $id = $request->input('id');
        DataBm::updateDataBm($id, $data);

        return redirect()->route('LRP.databm', [
            'iddemandeclient' => $request->input('demande_client_id')
        ])->with('success', 'Données mises à jour avec succès.');
    }
    public static function updateDataLbt(Request $request)
    {
        $request->validate([
            'demande_client_id' => 'required|numeric',
            'poids' => 'required|numeric',
            'heure' => 'nullable|string',
            'capacite_lbt' => 'required|numeric',
            'idlistemachine' => 'required|numeric',
            'nb_j_prod' => 'required|numeric',
            'inlinep' => 'nullable|date',
            'inliner' => 'nullable|date',
            'outline' => 'nullable|date',
            'heuregrmt' => 'numeric',
            'commentaire' => 'nullable|string',
            'etatjourspe' => 'nullable|string',
            'besoin_loading' => 'required|numeric',
            'efficience' => 'nullable|string',
            'valeurajoutee' => 'nullable|string',
            'heuresupp' => 'nullable|string'
        ]);

        // Gestion des états spécifiques et valeurs ajoutées
        $etatjourspe = [];

        if ($request->has('ferie')) {
            $etatjourspe[] = $request->input('ferie'); // ajoute 100 si coché
        }
        if ($request->has('dimanche')) {
            $etatjourspe[] = $request->input('dimanche'); // ajoute 200 si coché
        }
        if ($request->has('shift')) {
            $etatjourspe[] = $request->input('shift'); // ajoute 300 si coché
        }

        $valeurajoutee = [];

        if ($request->has('lavage')) {
            $valeurajoutee[] = $request->input('lavage');
        }
        if ($request->has('blanchiment')) {
            $valeurajoutee[] = $request->input('blanchiment');
        }
        if ($request->has('teinture')) {
            $valeurajoutee[] = $request->input('teinture');
        }

        // Concaténation des valeurs
        $etatjourspe = implode(', ', $etatjourspe);
        $valeurajoutee = implode(', ', $valeurajoutee);
        $id = $request->input('id');
        try {
            // Création du tableau de données à mettre à jour
            $data = [
                'iddemandeclient' => $request->input('demande_client_id'),
                'disponibilite' => $request->input('inlinep'),
                'poids' => $request->input('poids'),
                'propositioninline' => $request->input('inlinep'),
                'inline' => $request->input('inliner'),
                'outline' => $request->input('outline'),
                'heure' => $request->input('heure'),
                'efficience' => $request->input('efficience'),
                'capacite' => $request->input('capacite_lbt'),
                'jourprod' => $request->input('nb_j_prod'),
                'heuregrmt' => $request->input('heuregrmt'),
                'besoin_loading' => $request->input('besoin_loading'),
                'idlistemachine' => $request->input('idlistemachine'),
                'etatjourspe' => $etatjourspe,
                'commentaire' => $request->input('commentaire'),
                'valeurajoutee' => $valeurajoutee,
            ];

            // Mise à jour des données en fonction de l'ID
            // DataLbt::where('id', $id)->update($data);


            // $updatedDataLbt = DataBmc::updateDataLbt($id, $data);

            // if ($updatedDataLbt) {
            //     return redirect()->route('LRP.databmc', [
            //         'numerocommande' => $request->input('numerocommande'),
            //         'iddemandeclient' => $request->input('demande_client_id')
            //     ])->with('success', 'Données mises à jour avec succès.');
            // } else {
            //     return redirect()->back()->with('error', 'Échec de la mise à jour des données.');
            // }

            DataLbt::updateDataLbt($id, $data);
            // Redirection après mise à jour
            return redirect()->route('LRP.datalbt', [
                'iddemandeclient' => $request->input('demande_client_id')
            ])->with('success', 'Données mises à jour avec succès.');
        } catch (\Exception $errors) {
            return redirect()->back()->withErrors(['msg' => 'Erreur lors de la mise à jour: ' . $errors->getMessage()]);
        }
    }
    // -------------- END UPDATE

    // -------------- START MACRO ----------------------------------------------------------
    public static function showajoutmacro()
    {
        $type_macro = Macro::getAllTypeMacro();
        return view('Planning.Data_Macro.ajoutermacro', compact('type_macro'));
    }
    public function getMacroData(Request $request)
    {
        $typeMacroId = $request->input('type_macro');
        $macroData = [];

        switch ($typeMacroId) {
            case 1:
                $macroData = [
                    'effectif' => 422,
                    'efficience' => 55,
                    'absence' => 0.036,
                    'besoin_effectif' => null,
                ];
                break;
            case 2:
                $macroData = [
                    'effectif' => 3,
                    'efficience' => 70,
                    'absence' => 0.036,
                    'besoin_effectif' => null,
                ];
                break;
            case 3:
                $macroData = [
                    'effectif' => 13,
                    'efficience' => 55,
                    'absence' => 0.03,
                    'besoin_effectif' => 0,
                ];
                break;
            case 4:
                $macroData = [
                    'effectif' => 422,
                    'efficience' => 100,
                    'absence' => null,
                    'besoin_effectif' => null,
                ];
                break;
            case 5:
                $macroData = [
                    'effectif' => 422,
                    'efficience' => 55,
                    'absence' => null, //c'est quand c'est à ce niveau qu'il faut que absence soit fermée
                    'besoin_effectif' => null,
                ];
                break;
            default:
                break;
        }

        return response()->json($macroData);
    }


    // public function countJourOuvrableAjax(Request $request)
    // {
    //     $mois = $request->get('mois');
    //     $annee = $request->get('annee');

    //     if ($mois && $annee) {
    //         $cacheKey = "jours_ouvrables_{$mois}_{$annee}";
    //         $joursOuvrables = Cache::remember($cacheKey, 3600, function () use ($mois, $annee) {
    //             return Macro::findJourOuvrable($mois, $annee);
    //         });

    //         return response()->json(['joursOuvrables' => $joursOuvrables]);
    //     }

    //     return response()->json(['joursOuvrables' => 0]);
    // }

    public function countJourOuvrableAjax(Request $request)
    {
        $mois = $request->get('mois');
        $annee = $request->get('annee');

        if ($mois && $annee) {
            $cacheKey = "jours_ouvrables_{$mois}_{$annee}";

            // Log des paramètres
            Log::info("Requête pour jours ouvrables : mois=$mois, annee=$annee");

            $joursOuvrables = Cache::remember($cacheKey, 3600, function () use ($mois, $annee) {
                return Macro::findJourOuvrable($mois, $annee);
            });

            // Log du résultat
            Log::info("Jours ouvrables trouvés : $joursOuvrables");

            return response()->json(['joursOuvrables' => $joursOuvrables]);
        }

        return response()->json(['joursOuvrables' => 0]);
    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Insérer dans la table macrocharge2 avec une requête brute
            DB::insert('INSERT INTO macrocharge2 (id_type_macro, mois, annee, jourOuvrable, absence, heureTravail, heureSup, etat)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->input('macro'),
                $request->input('mois'),
                $request->input('annee'),
                $request->input('jours_ouvrables'),
                $request->input('absence', 0.036),
                $request->input('heureTravail', 8),
                $request->input('heureSup', 0),
                $request->input('etat', 0)
            ]);

            // Récupérer l'ID de la dernière insertion
            $macrocharge2Id = DB::getPdo()->lastInsertId();

            // Insérer dans la table macrocharge_details
            DB::insert('INSERT INTO macrocharge_details (macrocharge2_id, effectif, efficience, besoin_effectif)
            VALUES (?, ?, ?, ?)', [
                $macrocharge2Id,
                $request->input('effectif', 0),
                $request->input('efficience', 0),
                $request->input('besoin_effectif', 0)
            ]);

            // Confirmer la transaction
            DB::commit();

            return redirect()->route('LRP.listeajoutmacro')->with('success', 'Données ajoutées avec succès.');
        } catch (\Exception $errors) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erreur lors de l\'insertion: ' . $errors->getMessage());
        }
    }


    // 25/10/2024
    public function getProchaineDispo(Request $request)
    {
        $id_chaine = $request->input('id_chaine');

        $prochaine_dispo = DataPro::getInlineRMaxAndNbj($id_chaine);

        return response()->json(['prochaine_dispo' => $prochaine_dispo]);
    }

    // 05/12/2024
    public function showUpdateMacro(Request $request, $idmacro)
    {
        $macro = DB::select('select * from v_macrocharge_combine where id=?', [$idmacro]);
        $type_macro = Macro::getAllTypeMacro();
        // renvoyer le $macro dans la view, et aussi il faut tout de même envoyer idmacro
        return view('PLANNING.Data_Macro.updatemacro', [
            'idmacro' => $idmacro,
            'macro' => $macro,
            'type_macro' => $type_macro,
        ]);
    }
    public function updateMacro(Request $request)
    {
        $idmacro = $request->input('idmacro');
        try {
            // Mettre à jour la table macrocharge2
            DB::update(
                'UPDATE macrocharge2
            SET id_type_macro = COALESCE(?, id_type_macro),
                mois = COALESCE(?, mois),
                annee = COALESCE(?, annee),
                jourOuvrable = COALESCE(?, jourOuvrable),
                absence = COALESCE(?, absence),
                heureTravail = COALESCE(?, heureTravail),
                heureSup = COALESCE(?, heureSup),
                etat = COALESCE(?, etat)
            WHERE id = ?',
                [
                    $request->input('macro'),
                    $request->input('mois'),
                    $request->input('annee'),
                    $request->input('jours_ouvrables'),
                    $request->input('absence'),
                    $request->input('heureTravail'),
                    $request->input('heureSup'),
                    $request->input('etat'),
                    $idmacro
                ]
            );

            // Mettre à jour la table macrocharge_details
            DB::update(
                'UPDATE macrocharge_details
            SET effectif = COALESCE(?, effectif),
                efficience = COALESCE(?, efficience),
                besoin_effectif = COALESCE(?, besoin_effectif)
            WHERE macrocharge2_id = ?',
                [
                    $request->input('effectif'),
                    $request->input('efficience'),
                    $request->input('besoin_effectif'),
                    $idmacro
                ]
            );

            return redirect()->route('LRP.listeajoutmacro')->with('success', 'Données mises à jour avec succès.');
        } catch (\Exception $errors) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $errors->getMessage());
        }
    }


    // -------------- END MACRO ----------------------------------------------------------

}
