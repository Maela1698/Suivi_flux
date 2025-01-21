<?php

namespace App\Models\DATA_MACRO;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DataMacro extends Model
{
    use HasFactory;


    protected $table = 'v_filtre_data';

    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'demande_client_id',
        'id_recap_commande',
        'numerocommande',
        'id_saison',
        'type_saison',
        'nom_client',
        'nom_modele',
        'id_style',
        'nom_style',
        'efficience',
        'effectif',
        'pointdev',
        'theme',
        'qte',
        'etdrevise',
        'etdinitial',
        'etdpropose',
        'podate',
        'podateprev',
        'bcclient',
        'mois_date_max',
        'disponibilite as disponibilite_data',
        'tissu_max',
        'accy_max',
        'date_bc_tissu_prev',
        'date_bc_tissu_reelle',
        'date_bc_accy_prev',
        'date_bc_accy_reelle',
        'ok_prod',
        'smv_prod',
        'smv_finition',
        'prix_print',
        'smv_brod_main',
        'nombre_points',
        'dateinspection',
        'destination',
        'taillemin',
        'taillemax',
        'taille_base',
        'type_incontern',
        'type_phase',
        'id_stade_specifique',
        'designation_stade_specifique',
        'types_valeur_ajoutee',
        'etats_valeur_ajoutee',
        'id',
        'disponibilite as disponibilite_vrai',
        'propositionInline',
        'inline',
        'outline',
        'capacite',
        'jourProd',
        'minuteGrmt',
        'etatJourSpe',
        'commentaire',
        'qte_coupe',
        'id_chaine',
        'designation',
        'idConformite'
    ];

    // pour les filtres
    public static function rechercheStadeSpecifique()
    {
        $stade = DB::select('select * from stadespecifique');
        return self::hydrate($stade);
    }
    public static function rechercheLavage()
    {
        $lavage = DB::select('select * from lavage');
        return self::hydrate($lavage);
    }

    // end pour les filtres

    public static function findDatas()
    {
        $select = DB::select('select * from v_data_details');
        return self::hydrate($select);
    }
    public static function detailsData1($demande_client_id)
    {
        $details = DB::select(
            'select distinct  * from v_data_details where demande_client_id=?',
            [$demande_client_id]
        );
        return self::hydrate($details);
    }
    public static function detailsData($demande_client_id)
    {
        $details = DB::select(
            'select distinct  * from v_filtre_data where demande_client_id=?  limit 1',
            [$demande_client_id]
        );
        return self::hydrate($details);
    }
    public static function detailsDataPrint($demande_client_id)
    {
        $details = DB::select(
            'select distinct  * from v_filtre_data_print where demande_client_id=?  limit 1',
            [$demande_client_id]
        );
        return self::hydrate($details);
    }
    public static function getEfficienceStyle()
    {
        $details = DB::select('select efficience from style');
        return self::hydrate($details);
    }
    public static function getEffectifStyle()
    {
        $details = DB::select('select effectif from style');
        return self::hydrate($details);
    }

    // changé ce 28/11/2024
    public static function getTempsTotal($demande_client_id)
    {
        $select = DB::select(
            'select (smv_prod+smv_finition) as temps_total from v_data_details where demande_client_id=?  limit 1',
            [$demande_client_id]
        );
        return self::hydrate($select);
    }


    /////////////////////DATA ////
    // ok
    public static function calculCapacitePrint($demande_client_id)
    {
        $capacite_heure = DB::select(
            'select ((efficience*effectif*(8+0)*60)/prix_print)as capacite_print from v_data_details where demande_client_id=?  limit 1',
            [$demande_client_id]
        );
        return self::hydrate($capacite_heure);
    }
    public static function calculCapaciteBm($demande_client_id)
    {
        $heure_normal = 8;
        $heure_supp = DB::select('select heuresup from dataprod where iddemandeclient =? ', [$demande_client_id]);
        $heure_travail = $heure_normal + $heure_supp[0]->heuresup;

        $effectif_bm = DB::table('databrodmain')
            ->where('iddemandeclient', $demande_client_id)
            ->value('effectif_bm');

        if (is_null($effectif_bm)) {
            $capacite_bm = DB::select(
                'SELECT ((efficience * effectif *?)) AS capacite_bm
            FROM v_data_details
            WHERE demande_client_id = ?
            LIMIT 1',
                [$heure_travail, $demande_client_id]
            );
        } else {
            $capacite_bm = DB::select(
                'SELECT ((efficience * ? * ?)) AS capacite_bm
            FROM v_data_details
            WHERE  demande_client_id = ?
            LIMIT 1',
                [$effectif_bm, $heure_travail, $demande_client_id]
            );
        }

        return self::hydrate($capacite_bm);
    }

    public static function calculCapaciteBmc($demande_client_id)
    {
        // 14 000 000 PAR DEFAULT
    }
    ////////////////////END DATA TSOTRA


    ////////////////////////////////////////////////////////////////DATA ET MACRO PROD////////////////////////
    public static function getTempsTotalParMois()
    {
        $select = DB::select(
            'SELECT DATE_TRUNC(\'month\',
               CASE
                   WHEN inline IS NOT NULL THEN inline
                   ELSE disponibilite_data
               END
           ) AS mois,
           EXTRACT(YEAR FROM
               CASE
                   WHEN inline IS NOT NULL THEN inline
                   ELSE disponibilite_data
               END
           ) AS annee,
           SUM(smv_prod + smv_finition) AS temps_total
        FROM v_filtre_data
        GROUP BY annee, mois
        ORDER BY annee, mois'
        );

        return self::hydrate($select);
    }

    // ok
    public static function calculminprod($demande_client_id)
    {
        $details = DB::select(
            'select smv_prod,qte,(smv_prod*qte) as min_prod from v_data_details
        where demande_client_id=?  limit 1',
            [$demande_client_id]
        );
        return self::hydrate($details);
    }

    // ok
    public static function calculChargeHeure($demande_client_id)
    {
        $minuteprod = self::calculminprod($demande_client_id);
        $minuteprod = $minuteprod[0]->min_prod ? (is_numeric($minuteprod[0]->min_prod) ? $minuteprod[0]->min_prod : 0) : 0;
        $charge_heure = $minuteprod / 60;
        return $charge_heure;
    }

    // CHARGE USINE
    // ok
    public static function calculChargeMensuelle($demande_client_id)
    {
        $chargeheure = self::calculChargeHeure($demande_client_id);
        $capacite_heure = self::calculCapaciteChaine($demande_client_id);

        $charge_mensuelle = $chargeheure / $capacite_heure;
        return $charge_mensuelle;
    }
    // UPDATED : 08-10-2024 : CAPACITE HEURE PROD = CAPACITE USINE par DEMANDECLIENT

    // ok
    public static function calculCapaciteChaine($demande_client_id)
    {
        $heure_normal = 8;
        $heure_supp = DB::select('select heuresup from dataprod where iddemandeclient = ?', [$demande_client_id]);
        $heure_sup_valeur = isset($heure_supp[0]) ? $heure_supp[0]->heuresup : 0;
        $heure_travail = $heure_normal + $heure_sup_valeur;

        $select = DB::select(
            'select ((effectif * (efficience/100) * ? * 60)/(smv_prod+smv_finition)) as cap_chaine,effectif,efficience
             from v_data_details
             where demande_client_id = ?
             limit 1',
            [$heure_travail, $demande_client_id]

        );
        $result = $select[0]->cap_chaine;
        return $result;
    }
    // ok
    public static function findQte($demande_client_id)
    {
        $select = DB::select(
            'select qte from v_data_details
            where demande_client_id=? limit 1',
            [$demande_client_id]
        );

        $result = self::hydrate($select)->first();
        return $result ? $result->qte : 0;
    }
    // ok
    public static function calculNbJProd($demande_client_id)
    {
        $qte_prov = self::findQte($demande_client_id);
        $capacite_chaine = self::calculCapaciteChaine($demande_client_id);

        if (empty($capacite_chaine) || $capacite_chaine == 0) {
            return 1;
        }

        $nbjprod = $qte_prov / $capacite_chaine;

        return $nbjprod;
    }

    // ok
    public static function calculNbJProdPrint($demande_client_id)
    {
        $qte_prov = self::findQte($demande_client_id);
        $capacite_chaine = self::calculCapacitePrint($demande_client_id);

        if (empty($capacite_chaine->capacite_print) || $capacite_chaine->capacite_print == 0) {
            return 1;
        }

        $nbjprod = $qte_prov / $capacite_chaine;

        return $nbjprod;
    }

    public static function getJoursFerie($mois, $annee)
    {
        $joursFeries = DB::select('select * from jours_feries where mois=? and annee=? group by id,mois,annee ', [$mois, $annee]);
        return self::hydrate($joursFeries);
    }

    public static function hasJoursFeriesForMonth($mois, $annee)
    {
        $joursFeries = self::getJoursFerie($mois, $annee);

        if ($joursFeries->isEmpty()) {
            return [
                'message' => 'Aucun jour férié pour ce mois.',
                'status' => false,
                'count' => 0
            ];
        } else {
            return [
                'message' => 'Il y a des jours fériés pour ce mois.',
                'joursFeries' => $joursFeries,
                'status' => true,
                'count' => $joursFeries->count()
            ];
        }
    }
    //  NEW OUTLINE 27 09 2024 01:52 || 04-10-2024 || 08-10-2024 || 16-10-2024 || 06-11-2024
    public static function calculOutline($demande_client_id)
    {
        $nb_j_prod = self::calculNbJProd($demande_client_id);

        $disponibilite = DB::table('v_filtre_data')
            ->where('demande_client_id', $demande_client_id)
            ->first(['inline', 'propositioninline', 'disponibilite_data', 'disponibilite_vrai']);

        if (
            empty($disponibilite->inline) &&
            empty($disponibilite->propositioninline) &&
            is_null($disponibilite->disponibilite_data) &&
            is_null($disponibilite->disponibilite_vrai)
        ) {
            return 0;
        }

        $dateString = $disponibilite->inline
            ?? $disponibilite->propositioninline
            ?? $disponibilite->disponibilite_data
            ?? $disponibilite->disponibilite_vrai;

        $disponibiliteDate = Carbon::parse($dateString);

        $mois = $disponibiliteDate->format('m');
        $annee = $disponibiliteDate->format('Y');

        $joursFeries = self::hasJoursFeriesForMonth($mois, $annee);

        // Ajoute les jours en sautant les dimanches
        $outlineDate = $disponibiliteDate;
        $joursAjoutes = 0;

        while ($joursAjoutes < ($nb_j_prod - $joursFeries['count'])) {
            $outlineDate->addDay();
            if (!$outlineDate->isSunday()) { // Ne pas compter les dimanches
                $joursAjoutes++;
            }
        }
        return $outlineDate->toDateString(); // Retourner la nouvelle date au format YYYY-MM-DD
    }
    // updated : 16-10-2024 || 06-11-2024
    public static function calculOutlinePrint($demande_client_id)
    {
        $nb_j_prod = self::calculNbJProd($demande_client_id);

        $disponibilite = DB::table('v_filtre_data_print')
            ->where('demande_client_id', $demande_client_id)
            ->first(['inline', 'propositioninline', 'disponibilite_data']);

        if (
            empty($disponibilite->inline) &&
            empty($disponibilite->propositioninline) &&
            is_null($disponibilite->disponibilite_data)
        ) {
            return 0;
        }

        $dateString = $disponibilite->inline
            ?? $disponibilite->propositioninline
            ?? $disponibilite->disponibilite_data;

        $disponibiliteDate = Carbon::parse($dateString);

        $mois = $disponibiliteDate->format('m');
        $annee = $disponibiliteDate->format('Y');

        // $joursOuvrables = Macro::countJourOuvrable($mois, $annee);
        $joursFeries = self::hasJoursFeriesForMonth($mois, $annee);

        // $outline = $disponibiliteDate->addDays($nb_j_prod + $joursOuvrables - $joursFeries['count']);
        $outline = $disponibiliteDate->addDays($nb_j_prod - $joursFeries['count']);


        return $outline->toDateString();
    }

    // FONCTION HAHAFANTARANA HOE EFA AO VE NY TISSU ACCY OKPROD
    public static function checkValues($iddemandeclient)
    {
        $record = DB::select('SELECT * FROM v_data_all_details WHERE demande_client_id = ?', [$iddemandeclient]);

        if (empty($record)) {
            return null;
        }

        $data = $record[0];

        $disponibiliteValue = is_null($data->ok_prod) ? 10 : 100;
        $tissuMaxValue = is_null($data->tissu_max) ? 20 : 200;
        $accyMaxValue = is_null($data->accy_max) ? 30 : 300;

        return [
            'ok_prod' => $disponibiliteValue,
            'tissu_max' => $tissuMaxValue,
            'accy_max' => $accyMaxValue
        ];
    }

    //08-10-2024
    // ok
    public static function calculInlineProposeeProd($demande_client_id)
    {
        $disponibilite = DB::table('v_filtre_data')
            ->where('demande_client_id', $demande_client_id)
            ->first(['disponibilite_data']);

        if (is_null($disponibilite->disponibilite_data)) {
            return null;
        }

        $disponibiliteData = !is_null($disponibilite->disponibilite_data) ? Carbon::parse($disponibilite->disponibilite_data) : null;

        $maxDate =  $disponibiliteData;

        $nouvelleDate = $maxDate->addDays(7);

        return $nouvelleDate;
    }

    // A METTRE PLUS TARD DANS UNE CLASS CHAINE/LISTEMACHINE
    public static function findAllChaine()
    {
        $select = DB::select('select * from chaine');
        return self::hydrate($select);
    }
    public static function findAllListeMachine()
    {
        $select = DB::select('select * from listemachine');
        return self::hydrate($select);
    }
    // A METTRE PLUS TARD DANS UNE CLASS CHAINE/LISTEMACHINE






















    /////////////////////////////////////////////////// MACRO PROD/////////////////////////////////////////////////

    ///////////POUR TOUS
    public static function getNbAnnee()
    {
        $select = DB::select('SELECT COUNT(DISTINCT annee) AS nombre_annees FROM jours_feries');
        return self::hydrate($select);
    }
    public static function getAnneeBase()
    {
        $select = DB::select('SELECT DISTINCT annee FROM jours_feries ORDER BY annee');
        return self::hydrate($select);
    }

    // SUM HEURE SUPP
    public static function getSumHeureSupMois($mois)
    {
        $select = DB::table('dataprod')
            ->select(DB::raw('SUM(heuresup) as total_heuresup'))
            ->whereRaw('EXTRACT(MONTH FROM COALESCE(inline, propositionInline,disponibilite)) = ?', [$mois])
            ->groupBy(DB::raw('EXTRACT(YEAR FROM  COALESCE(inline, propositionInline,disponibilite)), EXTRACT(MONTH FROM  COALESCE(inline, propositionInline,disponibilite))'))
            ->first();
        return $select ? $select->total_heuresup : 0;
    }
    public static function getSumHeureSupMoisPrint($mois)
    {
        $select = DB::table('dataprint')
            ->select(DB::raw('SUM(heuresup) as total_heuresup'))
            ->whereRaw('EXTRACT(MONTH FROM COALESCE(inline, propositionInline,disponibilite)) = ?', [$mois])
            ->groupBy(DB::raw('EXTRACT(YEAR FROM  COALESCE(inline, propositionInline,disponibilite)), EXTRACT(MONTH FROM  COALESCE(inline, propositionInline,disponibilite))'))
            ->first();
        return $select ? $select->total_heuresup : 0;
    }
    public static function getSumHeureSupMoisBm($mois)
    {
        $select = DB::table('databrodmain')
            ->select(DB::raw('SUM(heuresup) as total_heuresup'))
            ->whereRaw('EXTRACT(MONTH FROM COALESCE(inline, propositionInline,disponibilite)) = ?', [$mois])
            ->groupBy(DB::raw('EXTRACT(YEAR FROM  COALESCE(inline, propositionInline,disponibilite)), EXTRACT(MONTH FROM  COALESCE(inline, propositionInline,disponibilite))'))
            ->first();
        return $select ? $select->total_heuresup : 0;
    }
    public static function getSumHeureSupMoisBmc($mois)
    {
        $select = DB::table('databrodmachine')
            ->select(DB::raw('SUM(heuresup) as total_heuresup'))
            ->whereRaw('EXTRACT(MONTH FROM COALESCE(inline, propositionInline,disponibilite)) = ?', [$mois])
            ->groupBy(DB::raw('EXTRACT(YEAR FROM  COALESCE(inline, propositionInline,disponibilite)), EXTRACT(MONTH FROM  COALESCE(inline, propositionInline,disponibilite))'))
            ->first();
        return $select ? $select->total_heuresup : 0;
    }
    public static function getAbsenceMoisAnnee($mois, $annee, $id_type_macrocharge)
    {
        if (!is_int($mois) || !is_int($annee)) {
            return 407;
        }

        // Gestion des valeurs spécifiques en fonction de l'id_type_macrocharge
        switch ($id_type_macrocharge) {
            case 1:
                return 407;
            case 2:
                return 3;
            case 3:
                return 13;
            case 4:
            case 5:
                return 0;
            default:
                break;
        }

        $result = DB::table('v_macrocharge_combine')
            ->select('effectif_macro', 'absence')
            ->where('mois', $mois)
            ->where('annee', $annee)
            ->where('id_type_macrocharge', [$id_type_macrocharge])
            ->first();

        // Vérification des résultats
        if (!$result || is_null($result->effectif_macro) || is_null($result->absence)) {
            return 407;
        }

        // Calcul du produit effectif macro - absence
        $produit = $result->effectif_macro - ($result->effectif_macro * $result->absence);
        $produit_arrondi = round($produit, 0);

        return $produit_arrondi;
    }
    public static function getEfficienceMoisDisponibilite($mois, $annee, $id_type_macrocharge)
    {
        if (!is_int($mois) || !is_int($annee)) {
            return 0.55 * 100;
        }

        switch ($id_type_macrocharge) {
            case 1:
                return 0.55 * 100;
            case 2:
                return 0.03 * 100;
            case 3:
                return 0.13 * 100;
            case 4:
                return 100;
            case 5:
                return 0;
            default:
                break;
        }

        $result = DB::table('v_macrocharge_combine')
            ->select('efficience_macro')
            ->where('mois', $mois)
            ->where('annee', $annee)
            ->where('id_type_macrocharge', [$id_type_macrocharge])
            ->first();

        return $result->efficience_macro ?? 0.55 * 100;
    }


    // CAPACITE HEURE MENSUELLE PROD
    public static function getCapaciteHeureUsine($effectif_macro, $efficience, $heure_total, $filters = [], $inline = null, $disponibilite_vrai = null, $disponibilite_data = null)
    {
        $query = Macro::query();

        if (!empty($filters['mois'])) {
            $query->where('mois', $filters['mois']);
        } elseif (!empty($inline) && empty($disponibilite_data) && empty($disponibilite_vrai)) {
            $query->where('mois', $inline);
        } elseif (!empty($disponibilite_vrai) && empty($disponibilite_data) && empty($inline)) {
            $query->where('mois', $disponibilite_vrai);
        } elseif (!empty($disponibilite_data) && empty($disponibilite_vrai) && empty($inline)) {
            $query->where('mois', $disponibilite_data);
        }

        $filterableFields = ['idSaison', 'idtiers', 'nom_client', 'id_stade_specifique', 'designation', 'type_lavage', 'type_valeur_ajoutee', 'modele', 'startMois', 'endMois', 'startDispo', 'endDispo', 'idStyle'];

        foreach ($filterableFields as $field) {
            if (isset($filters[$field]) && $filters[$field]) {
                $query->where($field, 'ILIKE', '%' . $filters[$field] . '%');
            }
        }

        $temps_total_collection = self::getTempsTotalParMois();

        $temps_total = 0;
        if ($temps_total_collection->isNotEmpty()) {
            foreach ($temps_total_collection as $item) {
                $temps_total += $item->temps_total;
            }
        }

        if ($temps_total == 0) {
            return 0;
        }

        $resultats = ($efficience  * ($effectif_macro  / 100) * $heure_total * 60) / $temps_total;

        return $resultats;
    }
    public static function getChargeHeure($mois, $annee)
    {
        $result = DB::table('v_filtre_data')
            ->select('minutegrmt')
            ->whereRaw('EXTRACT(MONTH FROM COALESCE(inline, propositionInline,disponibilite_data)) = ?', [$mois])
            ->whereRaw('EXTRACT(YEAR FROM COALESCE(inline,propositionInline, disponibilite_data)) = ?', [$annee])
            ->get();

        $sommeHeureGrmt = 0;

        foreach ($result as $row) {
            if (is_null($row->minutegrmt) || $row->minutegrmt == 0) {
                continue;
            }

            $heuregrmt = $row->minutegrmt / 60;
            $sommeHeureGrmt += $heuregrmt;
        }

        return round($sommeHeureGrmt, 2);
    }
    public static function getPourcentageCharge($chargeheure, $capheuremois)
    {
        if ($chargeheure == 0 || $capheuremois == 0) {
            return 0;
        }
        $resultats = $chargeheure / $capheuremois;
        $resultats = $resultats * 100;
        return $resultats;
    }


    /////////////////////////////////////////////////// MACRO PRINT/////////////////////////////////////////////////

    public static function calculInlineProposeePrint($demande_client_id)
    {
        $disponibilite = DB::table('v_filtre_data')
            ->where('demande_client_id', $demande_client_id)
            ->first(['disponibilite_data']);

        if (is_null($disponibilite->disponibilite_data)) {
            return null;
        }

        $disponibiliteData = !is_null($disponibilite->disponibilite_data) ? Carbon::parse($disponibilite->disponibilite_data) : null;

        $maxDate = $disponibiliteData;

        $nouvelleDate = $maxDate->addDays(2);

        return $nouvelleDate;
    }
    public static function getSmv_Print_TotalParMois()
    {
        $select = DB::select(
            'SELECT DATE_TRUNC(\'month\',
               CASE
                   WHEN inline IS NOT NULL THEN inline
                   ELSE disponibilite_data
               END
           ) AS mois,
           EXTRACT(YEAR FROM
               CASE
                   WHEN inline IS NOT NULL THEN inline
                   ELSE disponibilite_data
               END
           ) AS annee,
           SUM(prix_print) AS prix_print_total
        FROM v_filtre_data
        GROUP BY annee, mois
        ORDER BY annee, mois'
        );

        return self::hydrate($select);
    }

    public static function getCapaciteHeureUsinePrint($effectif_macro, $efficience, $heure_total, $filters = [], $inline = null, $disponibilite_vrai = null, $disponibilite_data = null)
    {
        $query = Macro::query();

        if (!empty($filters['mois'])) {
            $query->where('mois', $filters['mois']);
        } elseif (!empty($inline) && empty($disponibilite_data) && empty($disponibilite_vrai)) {
            $query->where('mois', $inline);
        } elseif (!empty($disponibilite_vrai) && empty($disponibilite_data) && empty($inline)) {
            $query->where('mois', $disponibilite_vrai);
        } elseif (!empty($disponibilite_data) && empty($disponibilite_vrai) && empty($inline)) {
            $query->where('mois', $disponibilite_data);
        }

        $filterableFields = ['idSaison', 'idtiers', 'nom_client', 'id_stade_specifique', 'designation', 'type_lavage', 'type_valeur_ajoutee', 'modele', 'startMois', 'endMois', 'startDispo', 'endDispo', 'idStyle'];

        foreach ($filterableFields as $field) {
            if (isset($filters[$field]) && $filters[$field]) {
                $query->where($field, 'ILIKE', '%' . $filters[$field] . '%');
            }
        }

        $prix_print_total_collection = self::getSmv_Print_TotalParMois();


        $prix_print_total = 0;
        if ($prix_print_total_collection->isNotEmpty()) {
            foreach ($prix_print_total_collection as $item) {
                $prix_print_total += $item->prix_print_total;
            }
        }

        if ($prix_print_total == 0) {
            return 0;
        }

        $resultats = ($efficience  * ($effectif_macro  / 100) * $heure_total * 60) / $prix_print_total;

        return $resultats;
    }

    /////////////////////////////////////////////////// MACRO BM/////////////////////////////////////////////////
    public static function getSmv_HeureBm_TotalParMois()
    {
        $select = DB::select(
            'SELECT DATE_TRUNC(\'month\',
               CASE
                   WHEN inline IS NOT NULL THEN inline
                   ELSE disponibilite_data
               END
           ) AS mois,
           EXTRACT(YEAR FROM
               CASE
                   WHEN inline IS NOT NULL THEN inline
                   ELSE disponibilite_data
               END
           ) AS annee,
           SUM(smv_brod_main) AS smv_brod_main_total
        FROM v_filtre_data
        GROUP BY annee, mois
        ORDER BY annee, mois'
        );

        return self::hydrate($select);
    }

    public static function getCapaciteHeureUsineBm($effectif_macro, $efficience, $heure_total, $filters = [], $inline = null, $disponibilite_vrai = null, $disponibilite_data = null)
    {
        $query = Macro::query();

        if (!empty($filters['mois'])) {
            $query->where('mois', $filters['mois']);
        } elseif (!empty($inline) && empty($disponibilite_data) && empty($disponibilite_vrai)) {
            $query->where('mois', $inline);
        } elseif (!empty($disponibilite_vrai) && empty($disponibilite_data) && empty($inline)) {
            $query->where('mois', $disponibilite_vrai);
        } elseif (!empty($disponibilite_data) && empty($disponibilite_vrai) && empty($inline)) {
            $query->where('mois', $disponibilite_data);
        }

        $filterableFields = ['idSaison', 'idtiers', 'nom_client', 'id_stade_specifique', 'designation', 'type_lavage', 'type_valeur_ajoutee', 'modele', 'startMois', 'endMois', 'startDispo', 'endDispo', 'idStyle'];

        foreach ($filterableFields as $field) {
            if (isset($filters[$field]) && $filters[$field]) {
                $query->where($field, 'ILIKE', '%' . $filters[$field] . '%');
            }
        }

        $bm_total_collection = self::getSmv_HeureBm_TotalParMois();


        $smv_brod_main_total = 0;
        if ($bm_total_collection->isNotEmpty()) {
            foreach ($bm_total_collection as $item) {
                $smv_brod_main_total += $item->smv_brod_main_total;
            }
        }

        if ($smv_brod_main_total == 0) {
            return 0;
        }

        $resultats = ($efficience  * ($effectif_macro  / 100) * $heure_total);

        return $resultats;
    }
    public static function getChargeHeureBm($mois, $annee)
    {
        $result = DB::table('v_filtre_data')
            ->select('smv_brod_main', 'qte')
            ->whereRaw('EXTRACT(MONTH FROM COALESCE(inline, disponibilite_data)) = ?', [$mois])
            ->whereRaw('EXTRACT(YEAR FROM COALESCE(inline, disponibilite_data)) = ?', [$annee])
            ->get();

        $sommeBrodMain = 0;

        foreach ($result as $row) {
            if (is_null($row->smv_brod_main) || $row->smv_brod_main == 0) {
                continue;
            }

            $BrodMain = $row->smv_brod_main * $row->qte;
            $sommeBrodMain += $BrodMain;
        }

        return round($sommeBrodMain, 2);
    }


    /////////////////////////////////////////////////// MACRO BMC/////////////////////////////////////////////////
    public static function get_smv_nbpoint_TotalParMois()
    {
        $select = DB::select(
            'SELECT DATE_TRUNC(\'month\',
           CASE
               WHEN inline IS NOT NULL THEN inline
               ELSE disponibilite_data
           END
       ) AS mois,
       EXTRACT(YEAR FROM
           CASE
               WHEN inline IS NOT NULL THEN inline
               ELSE disponibilite_data
           END
       ) AS annee,
       SUM(nombre_points) AS nombre_points_total
        FROM v_filtre_data
        GROUP BY annee, mois
        ORDER BY annee, mois'
        );

        return self::hydrate($select);
    }
    public static function getCapaciteHeureUsineBmc($joursOuvrables, $efficience, $heure_total, $filters = [], $inline = null, $disponibilite_vrai = null, $disponibilite_data = null)
    {
        $query = Macro::query();

        if (!empty($filters['mois'])) {
            $query->where('mois', $filters['mois']);
        } elseif (!empty($inline) && empty($disponibilite_data) && empty($disponibilite_vrai)) {
            $query->where('mois', $inline);
        } elseif (!empty($disponibilite_vrai) && empty($disponibilite_data) && empty($inline)) {
            $query->where('mois', $disponibilite_vrai);
        } elseif (!empty($disponibilite_data) && empty($disponibilite_vrai) && empty($inline)) {
            $query->where('mois', $disponibilite_data);
        }

        $filterableFields = ['idSaison', 'idtiers', 'nom_client', 'id_stade_specifique', 'designation', 'type_lavage', 'type_valeur_ajoutee', 'modele', 'startMois', 'endMois', 'startDispo', 'endDispo', 'idStyle'];

        foreach ($filterableFields as $field) {
            if (isset($filters[$field]) && $filters[$field]) {
                $query->where($field, 'ILIKE', '%' . $filters[$field] . '%');
            }
        }

        $bmc_total_collection = self::get_smv_nbpoint_TotalParMois();


        $smv_nb_point_total = 0;
        if ($bmc_total_collection->isNotEmpty()) {
            foreach ($bmc_total_collection as $item) {
                $smv_nb_point_total += $item->nombre_points_total;
            }
        }

        if ($smv_nb_point_total == 0) {
            return 0;
        }

        $cap_defaut = 122745;

        $resultats = ($cap_defaut * $heure_total * $joursOuvrables * $efficience);

        return $resultats;
    }
    public static function getChargeHeureBmc($qte)
    {
        $bmc_total_collection = self::get_smv_nbpoint_TotalParMois();
        $smv_nb_point_total = 0;

        if ($bmc_total_collection->isNotEmpty()) {
            foreach ($bmc_total_collection as $item) {
                $smv_nb_point_total += $item->nombre_points_total;
            }
        }

        if ($smv_nb_point_total == 0) {
            return 0;
        }

        $resultats = 0;
        foreach ($bmc_total_collection as $item) {
            $resultat_partiel = $qte * $item->nombre_points_total;
            $resultats += $resultat_partiel;
        }

        return $resultats;
    }


    /////////////////////////////////////////////////// MACRO LBT/////////////////////////////////////////////////
    public static function get_smv_poids_TotalParMois()
    {
        $select = DB::select(
            'SELECT
            DATE_TRUNC(\'month\',
                CASE
                    WHEN d.inline IS NOT NULL THEN d.inline
                    ELSE d.disponibilite
                END
            ) AS mois,
            EXTRACT(YEAR FROM
                CASE
                    WHEN d.inline IS NOT NULL THEN d.inline
                    ELSE d.disponibilite
                END
            ) AS annee,
            d.iddemandeclient AS demande_client_id,
            SUM(d.poids * v.qte) AS poids_total
        FROM v_filtre_data v
        JOIN datalbt d ON v.demande_client_id = d.iddemandeclient
        GROUP BY annee, mois, demande_client_id,iddemandeclient
        ORDER BY annee, mois, demande_client_id'
        );

        return self::hydrate($select);
    }
    public static function getChargeHeureLbt($qte)
    {
        $lbt_total_collection = self::get_smv_poids_TotalParMois();
        $poids_total_par_mois = [];

        if ($lbt_total_collection->isNotEmpty()) {
            foreach ($lbt_total_collection as $item) {
                $mois = $item->mois;

                if (!isset($poids_total_par_mois[$mois])) {
                    $poids_total_par_mois[$mois] = 0;
                }

                $poids_total_par_mois[$mois] += $item->poids_total;
            }
        }

        if (empty($poids_total_par_mois)) {
            return 0;
        }

        $resultats = 0;

        foreach ($poids_total_par_mois as $mois => $poids_total) {
            // Vérifier si $qte est un tableau
            if (is_array($qte)) {
                // S'assurer que le tableau contient une valeur pour ce mois spécifique
                if (isset($qte[$mois])) {
                    $resultat_partiel = $qte[$mois] * $poids_total;
                } else {
                    $resultat_partiel = 0;
                }
            } else {
                $resultat_partiel = $qte * $poids_total;
            }

            $resultats += $resultat_partiel;
        }

        return $resultats;
    }
    public static function pourcentagelbt($mois, $annee)
    {
        // Capacité fixe
        $capacite = 420;

        // Récupérer les poids totaux par mois
        $poids_total_collection = self::get_smv_poids_TotalParMois();

        // Vérifier si la collection n'est pas vide
        if ($poids_total_collection->isNotEmpty()) {
            // Filtrer les données pour le mois et l'année spécifiés
            $filtre = $poids_total_collection->first(function ($item) use ($mois, $annee) {
                return $item->mois == $mois && $item->annee == $annee;
            });

            // Si une correspondance est trouvée
            if ($filtre) {
                // Calculer le pourcentage : (poids_total / capacité) * 100
                $pourcentage = ($filtre->poids_total / $capacite) * 100;

                // Retourner le pourcentage pour ce mois et cette année
                return [
                    'mois' => $mois,
                    'annee' => $annee,
                    'demande_client_id' => $filtre->demande_client_id,
                    'poids_total' => $filtre->poids_total,
                    'pourcentage' => $pourcentage
                ];
            }
        }

        // Si aucune donnée n'est trouvée, retourner un tableau vide ou une valeur par défaut
        return null;
    }



    // pour les checkboxes
    public static function getSelectedValuesDataProd($iddemandeclient)
    {
        $etatjourspe = DB::table('dataprod')
            ->where('iddemandeclient', $iddemandeclient)
            ->value('etatjourspe');

        if ($etatjourspe) {
            return array_map('trim', explode(',', $etatjourspe));
        }

        return [];
    }
    public static function getSelectedValuesDataPrint($iddemandeclient)
    {
        $etatjourspe = DB::table('dataprint')
            ->where('iddemandeclient', $iddemandeclient)
            ->value('etatjourspe');

        if ($etatjourspe) {
            return array_map('trim', explode(',', $etatjourspe));
        }

        return [];
    }
    public static function getSelectedValuesDataBm($iddemandeclient)
    {
        $etatjourspe = DB::table('databrodmachine')
            ->where('iddemandeclient', $iddemandeclient)
            ->value('etatjourspe');

        if ($etatjourspe) {
            return array_map('trim', explode(',', $etatjourspe));
        }

        return [];
    }
    public static function getSelectedValuesDataBmc($iddemandeclient)
    {
        $etatjourspe = DB::table('databrodmain')
            ->where('iddemandeclient', $iddemandeclient)
            ->value('etatjourspe');

        if ($etatjourspe) {
            return array_map('trim', explode(',', $etatjourspe));
        }

        return [];
    }
    public static function getSelectedValuesDataLbt($iddemandeclient)
    {
        $etatjourspe = DB::table('datalbt')
            ->where('iddemandeclient', $iddemandeclient)
            ->value('etatjourspe');

        if ($etatjourspe) {
            return array_map('trim', explode(',', $etatjourspe));
        }

        return [];
    }
    public static function getValeurAjouteesDataLbt($iddemandeclient)
    {
        $valeurajoutee = DB::table('datalbt')
            ->where('iddemandeclient', $iddemandeclient)
            ->value('valeurajoutee');

        if ($valeurajoutee) {
            return array_map('trim', explode(',', $valeurajoutee));
        }
        return [];
    }
    // end pour les checkboxes

    // pour les boutons afficher ou non
    public static function checkPrint($idDemandeClient)
    {
        return DB::table('v_valeurajouteedemande')
            ->where('id_demande_client', $idDemandeClient)
            // ->where('type_valeur_ajoutee', 'Serigraphie')
            ->exists();
    }
    public static function checkBrodMain($idDemandeClient)
    {
        return DB::table('v_valeurajouteedemande')
            ->where('id_demande_client', $idDemandeClient)
            // ->where('type_valeur_ajoutee', 'Broderie main')
            ->exists();
    }
    public static function checkBrodMachine($idDemandeClient)
    {
        return DB::table('v_valeurajouteedemande')
            ->where('id_demande_client', $idDemandeClient)
            ->where('type_valeur_ajoutee', 'Broderie machine')
            ->exists();
    }
    public static function checkLbt($idDemandeClient)
    {
        return DB::table('v_lavagedemandeclient')
            ->where('id_demande_client', $idDemandeClient)
            ->exists();
    }

    public static function estdispo($demande_client_id)
    {
        $result = DB::select(' select estdispo from v_mois_annee_estdispo where demande_client_id=? ', [$demande_client_id]);
        return $result;
    }
}
