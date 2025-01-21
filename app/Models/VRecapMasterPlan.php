<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\DemandeClient;
// use App\Models\LeadTime;
// use App\Models\RecapCommande;
// use App\Models\Destination;
// use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VRecapMasterPlan extends Model
{

    use HasFactory;


    protected $table = 'v_recap_master_plan';

    // Indiquer que ce modèle est en lecture seule
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'demande_client_id',
        'date_entree',
        'date_livraison',
        'nom_modele',
        'theme',
        'qte_commande_provisoire',
        'photo_commande',
        'etat_demande',
        'nom_client',
        'id_client',
        'nom_style',
        'id_style',
        'type_phase',
        'id_phase',
        'type_saison',
        'id_saison',
        'type_stade',
        'id_stade',
        'type_etat',
        'id_etat',

        'id_recap_commande',
        'etdRevise',
        'etdPropose',
        'date_bc_tissu',
        'date_bc_access',
        'podateprev',
        'podate',
        'bcClient',
        'etat_recap_commande',

        'id_destination',
        'numeroCommande',
        'etdInitial',
        'dateLivraisonExacte',
        'dateInspection',
        'qteOF',
        'etat_destination',

        'id_deststd',
        'designation_destStd',
        'etat_destStd',

        'id_master_plan',
        'date_MP_Initial',
        'date_MP_reel',
        'date_E_init',
        'date_E_reel',
        'date_Prod_Initial',
        'date_Prod_reel',
        'leadTimeReel',
        'nbrJProd',
        'statutCommande',
        'etat_master_plan',

        'id_stade_specifique',
        'designation_stade_specifique',
        'designation_stade_specifique',
        'niveau_stade_specifique',
        'id_stade_master_plan',
        'designation_stade_master_plan',
        'niveau_stade_master_plan',

        'types_valeur_ajoutee',
        'etats_valeur_ajoutee',

        'tissu_max',
        'accy_max',
        'date_bc_tissu_prev',
        'date_bc_tissu_reelle',
        'date_bc_accy_prev',
        'date_bc_accy_reelle',
        'disponibilite',
        'ok_prod'
    ];

    public static function findAll()
    {
        $select = DB::select('select * from v_recap_master_plan');
        return self::hydrate($select);
    }

    public static function findByNumeroCommande($demande_client_id)
    {
        $select = DB::select('select * from v_recap_master_plan where demande_client_id=?', [$demande_client_id]);
        return self::hydrate($select);
    }

    public static function calculKIAll($demande_client_id)
    {
        $select = DB::select('SELECT FLOOR(EXTRACT(EPOCH FROM age(date_MP_reel, CURRENT_DATE)) / 86400)::int AS ki_mp,FLOOR(EXTRACT(EPOCH FROM age(date_e_reel, CURRENT_DATE)) / 86400)::int AS ki_e,
        FLOOR(EXTRACT(EPOCH FROM age(date_prod_reel, CURRENT_DATE)) / 86400)::int AS ki_pr,nbrJProd from v_recap_master_plan where demande_client_id=?', [$demande_client_id]);
        return self::hydrate($select);
    }

    public static function jourrestants($demande_client_id)
    {
        $select = DB::select('SELECT
                    date_MP_reel - date_MP_Initial AS diff_mp_days,
                    date_E_reel - date_E_init AS diff_e_days,
                    date_Prod_reel - date_Prod_Initial AS diff_prod_days,
                    (date_MP_reel - date_MP_Initial) + (date_E_reel - date_E_init) + (date_Prod_reel - date_Prod_Initial) AS jour_restants
                FROM
                    v_recap_master_plan
                WHERE
                    demande_client_id =?', [$demande_client_id]);
        return self::hydrate($select);
    }

    public static function jourrestantsDate($demande_client_id)
    {
        $select = DB::select('SELECT
            date_MP_reel + INTERVAL \'1 day\' * FLOOR(EXTRACT(EPOCH FROM age(date_MP_reel, CURRENT_DATE)) / 86400) AS date_ki_mp,
            date_e_reel + INTERVAL \'1 day\' * FLOOR(EXTRACT(EPOCH FROM age(date_e_reel, CURRENT_DATE)) / 86400) AS date_ki_e,
            date_prod_reel + INTERVAL \'1 day\' * FLOOR(EXTRACT(EPOCH FROM age(date_prod_reel, CURRENT_DATE)) / 86400) AS date_ki_pr
        FROM
            v_recap_master_plan
        WHERE
            demande_client_id =?', [$demande_client_id]);
        return self::hydrate($select);
    }


    public static function progression_export($demande_client_id)
    {
        $select = DB::select("
        SELECT
            current_date,
            leadtimereel,
            (current_date + leadtimereel * interval '1 day') AS jour_export,

            -- Calcul du nombre de jours restant jusqu'à jour_export
            EXTRACT(DAY FROM age((current_date + leadtimereel * interval '1 day'), current_date))::int AS days_left_from_today,

            -- Calcul du pourcentage de days_left_from_today par rapport à leadtimereel
            CASE
                WHEN leadtimereel = 0 THEN 0
                ELSE ROUND((EXTRACT(DAY FROM age((current_date + leadtimereel * interval '1 day'), current_date))::int * 100.0) / leadtimereel, 2)
            END AS percentage_days_left,

            -- Calcul du pourcentage de progression écoulée
            CASE
                WHEN leadtimereel = 0 THEN 100
                ELSE ROUND(100 - ((EXTRACT(DAY FROM age((current_date + leadtimereel * interval '1 day'), current_date))::int * 100.0) / leadtimereel), 2)
            END AS pourcentage_passe,

            -- Calcul du nombre de jours écoulés
            CASE
                WHEN leadtimereel = 0 THEN 0
                ELSE (leadtimereel - EXTRACT(DAY FROM age((current_date + leadtimereel * interval '1 day'), current_date))::int)
            END AS nbr_jour_passe

        FROM
            v_recap_master_plan
        WHERE
            demande_client_id = ?
        ", [$demande_client_id]);

        return self::hydrate($select);
    }

    public static function make_podate_prev($iddemandeclient)
    {
        $podateprev = DB::select('select (date_entree+67) as podateprev from demandeclient where id=?', [$iddemandeclient]);
        return self::hydrate($podateprev);
    }

    public static function getPoDatePrev($idrecapcommande)
    {
        $podateprev = DB::select('select podateprev from recapcommande where id=?', [$idrecapcommande]);
        return self::hydrate($podateprev);
    }

    public static function getPoDate($idrecapcommande)
    {
        $podateprev = DB::select('select receptionbc as podate from recapcommande where id=?', [$idrecapcommande]);
        return self::hydrate($podateprev);
    }


    public static function check_and_insert_podate($idrecapcommande)
    {
        $existingPodateprevResult = self::getPoDatePrev($idrecapcommande);
        $existingPodateprev = $existingPodateprevResult && isset($existingPodateprevResult[0]->podateprev)
            ? $existingPodateprevResult[0]->podateprev
            : null;

        $podateResult = self::getPoDate($idrecapcommande);
        $podate = $podateResult && isset($podateResult[0]->podate)
            ? $podateResult[0]->podate
            : null;

        if ($podate) {
            if ($existingPodateprev && $podate === $existingPodateprev) {
                return 10; // podateprev existe et correspond à podate
            } else {
                // podateprev existe mais ne correspond pas à podate
                return 20;
            }
        }
    }
    // } else {
    //     // Si podate n'existe pas, insérer la valeur de $existingPodateprev dans podate
    //     if ($existingPodateprev) {
    //         // DB::update('UPDATE recapcommande SET podate = ? WHERE id = ?', [$existingPodateprev, $idrecapcommande]);
    //         return 30; // podate a été inséré avec la valeur de $existingPodateprev
    //     } else {
    //         // Pas de valeur podate ou existingPodateprev disponible pour l'insertion
    //         return 40; // Erreur ou valeur manquante
    //     }
    // }


    public static function getEtdInitial($iddestination)
    {
        $podateprev = DB::select('select etdinitial from v_recap_master_plan where id_destination=?', [$iddestination]);
        return self::hydrate($podateprev);
    }
    // public static function getEtdfinal($iddestination)
    // {
    //     $podateprev = DB::select('select etdfinal from v_recap_master_plan where id_destination=?', [$iddestination]);
    //     return self::hydrate($podateprev);
    // }
    // public static function check_or_update_etdfinal($iddestination)
    // {
    //     $etdInitialResult = self::getEtdInitial($iddestination);

    //     $etdInitial = $etdInitialResult && isset($etdInitialResult[0]->etdinitial) ? $etdInitialResult[0]->etdinitial : null;

    //     if ($etdInitial) {
    //         return 10;
    //     } else {
    //         return 20;
    //     }
    //     return $etdInitial;
    // }
    public static function check_or_update_etdfinal($id_destination)
    {
        $etdInitialResult = self::getEtdInitial($id_destination);

        $etdInitial = $etdInitialResult && isset($etdInitialResult[0]->etdinitial) ? $etdInitialResult[0]->etdinitial : null;

        if ($etdInitial) {
            return 10;
        } else {
            return 20;
        }
    }
    // return 30;


    public static function findNbrNegociation($filters = [])
    {
        // Début de la requête SQL
        $query = 'select count(id_stade_master_plan) as nb_negoc from v_recap_master_plan where id_stade_master_plan = ?';
        $bindings = ['1'];

        // Filtre par id de la saison
        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $query .= ' AND id_saison = ?';
            $bindings[] = $filters['idSaison'];
        }

        // Filtre par demande_client_id
        if (isset($filters['demande_client_id']) && $filters['demande_client_id']) {
            $query .= ' AND demande_client_id ILIKE ?';
            $bindings[] = '%' . $filters['demande_client_id'] . '%';
        }

        // Filtre par type_valeur_ajoutee
        if (isset($filters['type_valeur_ajoutee']) && $filters['type_valeur_ajoutee']) {
            $query .= ' AND type_valeur_ajoutee ILIKE ?';
            $bindings[] = '%' . $filters['type_valeur_ajoutee'] . '%';
        }

        // Filtre par designation_stade_master_plan
        if (isset($filters['designation_stade_master_plan']) && $filters['designation_stade_master_plan']) {
            $query .= ' AND designation_stade_master_plan ILIKE ?';
            $bindings[] = '%' . $filters['designation_stade_master_plan'] . '%';
        }

        // Filtre par nom_style
        if (isset($filters['nom_style']) && $filters['nom_style']) {
            $query .= ' AND nom_style ILIKE ?';
            $bindings[] = '%' . $filters['nom_style'] . '%';
        }

        // Filtre par date de PO (podate)
        if (isset($filters['podateStart']) && isset($filters['podateTil'])) {
            $query .= ' AND podate BETWEEN ? AND ?';
            $bindings[] = $filters['podateStart'];
            $bindings[] = $filters['podateTil'];
        }

        // Filtre par ETD (etdfinal)
        if (isset($filters['etdStart']) && isset($filters['etdTil'])) {
            $query .= ' AND etdfinal BETWEEN ? AND ?';
            $bindings[] = $filters['etdStart'];
            $bindings[] = $filters['etdTil'];
        }
        // Exécution de la requête SQL avec les filtres appliqués
        $nbrNegociation = DB::select($query, $bindings);

        return self::hydrate($nbrNegociation);
    }
    public static function findNbrApprov($filters = [])
    {
        // Début de la requête SQL
        $query = 'select count(id_stade_master_plan) as nb_approv from v_recap_master_plan where id_stade_master_plan = ?';
        $bindings = ['2'];

        // Filtre par id de la saison
        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $query .= ' AND id_saison = ?';
            $bindings[] = $filters['idSaison'];
        }

        // Filtre par demande_client_id
        if (isset($filters['demande_client_id']) && $filters['demande_client_id']) {
            $query .= ' AND demande_client_id ILIKE ?';
            $bindings[] = '%' . $filters['demande_client_id'] . '%';
        }

        // Filtre par type_valeur_ajoutee
        if (isset($filters['type_valeur_ajoutee']) && $filters['type_valeur_ajoutee']) {
            $query .= ' AND type_valeur_ajoutee ILIKE ?';
            $bindings[] = '%' . $filters['type_valeur_ajoutee'] . '%';
        }

        // Filtre par designation_stade_master_plan
        if (isset($filters['designation_stade_master_plan']) && $filters['designation_stade_master_plan']) {
            $query .= ' AND designation_stade_master_plan ILIKE ?';
            $bindings[] = '%' . $filters['designation_stade_master_plan'] . '%';
        }

        // Filtre par nom_style
        if (isset($filters['nom_style']) && $filters['nom_style']) {
            $query .= ' AND nom_style ILIKE ?';
            $bindings[] = '%' . $filters['nom_style'] . '%';
        }

        // Filtre par date de PO (podate)
        if (isset($filters['podateStart']) && isset($filters['podateTil'])) {
            $query .= ' AND podate BETWEEN ? AND ?';
            $bindings[] = $filters['podateStart'];
            $bindings[] = $filters['podateTil'];
        }

        // Filtre par ETD (etdfinal)
        if (isset($filters['etdStart']) && isset($filters['etdTil'])) {
            $query .= ' AND etdfinal BETWEEN ? AND ?';
            $bindings[] = $filters['etdStart'];
            $bindings[] = $filters['etdTil'];
        }

        // Exécution de la requête SQL avec les filtres appliqués
        $nbrApprov = DB::select($query, $bindings);

        return self::hydrate($nbrApprov);
    }
    public static function findNbrTransfo($filters = [])
    {
        // Début de la requête SQL
        $query = 'select count(id_stade_master_plan) as nb_transfo from v_recap_master_plan where id_stade_master_plan = ?';
        $bindings = ['3'];

        // Filtre par id de la saison
        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $query .= ' AND id_saison = ?';
            $bindings[] = $filters['idSaison'];
        }

        // Filtre par demande_client_id
        if (isset($filters['demande_client_id']) && $filters['demande_client_id']) {
            $query .= ' AND demande_client_id ILIKE ?';
            $bindings[] = '%' . $filters['demande_client_id'] . '%';
        }

        // Filtre par type_valeur_ajoutee
        if (isset($filters['type_valeur_ajoutee']) && $filters['type_valeur_ajoutee']) {
            $query .= ' AND type_valeur_ajoutee ILIKE ?';
            $bindings[] = '%' . $filters['type_valeur_ajoutee'] . '%';
        }

        // Filtre par designation_stade_master_plan
        if (isset($filters['designation_stade_master_plan']) && $filters['designation_stade_master_plan']) {
            $query .= ' AND designation_stade_master_plan ILIKE ?';
            $bindings[] = '%' . $filters['designation_stade_master_plan'] . '%';
        }

        // Filtre par nom_style
        if (isset($filters['nom_style']) && $filters['nom_style']) {
            $query .= ' AND nom_style ILIKE ?';
            $bindings[] = '%' . $filters['nom_style'] . '%';
        }

        // Filtre par date de PO (podate)
        if (isset($filters['podateStart']) && isset($filters['podateTil'])) {
            $query .= ' AND podate BETWEEN ? AND ?';
            $bindings[] = $filters['podateStart'];
            $bindings[] = $filters['podateTil'];
        }

        // Filtre par ETD (etdfinal)
        if (isset($filters['etdStart']) && isset($filters['etdTil'])) {
            $query .= ' AND etdfinal BETWEEN ? AND ?';
            $bindings[] = $filters['etdStart'];
            $bindings[] = $filters['etdTil'];
        }

        // Exécution de la requête SQL avec les filtres appliqués
        $nbrTransfo = DB::select($query, $bindings);

        return self::hydrate($nbrTransfo);
    }
    public static function findNbrCond($filters = [])
    {
        // Début de la requête SQL
        $query = 'select count(id_stade_master_plan) as nb_cond from v_recap_master_plan where id_stade_master_plan = ?';
        $bindings = ['4'];

        // Filtre par id de la saison
        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $query .= ' AND id_saison = ?';
            $bindings[] = $filters['idSaison'];
        }

        // Filtre par demande_client_id
        if (isset($filters['demande_client_id']) && $filters['demande_client_id']) {
            $query .= ' AND demande_client_id ILIKE ?';
            $bindings[] = '%' . $filters['demande_client_id'] . '%';
        }

        // Filtre par type_valeur_ajoutee
        if (isset($filters['type_valeur_ajoutee']) && $filters['type_valeur_ajoutee']) {
            $query .= ' AND type_valeur_ajoutee ILIKE ?';
            $bindings[] = '%' . $filters['type_valeur_ajoutee'] . '%';
        }

        // Filtre par designation_stade_master_plan
        if (isset($filters['designation_stade_master_plan']) && $filters['designation_stade_master_plan']) {
            $query .= ' AND designation_stade_master_plan ILIKE ?';
            $bindings[] = '%' . $filters['designation_stade_master_plan'] . '%';
        }

        // Filtre par nom_style
        if (isset($filters['nom_style']) && $filters['nom_style']) {
            $query .= ' AND nom_style ILIKE ?';
            $bindings[] = '%' . $filters['nom_style'] . '%';
        }

        // Filtre par date de PO (podate)
        if (isset($filters['podateStart']) && isset($filters['podateTil'])) {
            $query .= ' AND podate BETWEEN ? AND ?';
            $bindings[] = $filters['podateStart'];
            $bindings[] = $filters['podateTil'];
        }

        // Filtre par ETD (etdfinal)
        if (isset($filters['etdStart']) && isset($filters['etdTil'])) {
            $query .= ' AND etdfinal BETWEEN ? AND ?';
            $bindings[] = $filters['etdStart'];
            $bindings[] = $filters['etdTil'];
        }

        // Exécution de la requête SQL avec les filtres appliqués
        $nbrocond = DB::select($query, $bindings);

        return self::hydrate($nbrocond);
    }
    public static function findNbrExpe($filters = [])
    {
        // Début de la requête SQL
        $query = 'select count(id_stade_master_plan) as nb_exp from v_recap_master_plan where id_stade_master_plan = ? and designation_stade_specifique=?';
        $bindings = ['4', 'expedition'];

        // Filtre par id de la saison
        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $query .= ' AND id_saison = ?';
            $bindings[] = $filters['idSaison'];
        }

        // Filtre par demande_client_id
        if (isset($filters['demande_client_id']) && $filters['demande_client_id']) {
            $query .= ' AND demande_client_id ILIKE ?';
            $bindings[] = '%' . $filters['demande_client_id'] . '%';
        }

        // Filtre par type_valeur_ajoutee
        if (isset($filters['type_valeur_ajoutee']) && $filters['type_valeur_ajoutee']) {
            $query .= ' AND type_valeur_ajoutee ILIKE ?';
            $bindings[] = '%' . $filters['type_valeur_ajoutee'] . '%';
        }

        // Filtre par designation_stade_master_plan
        if (isset($filters['designation_stade_master_plan']) && $filters['designation_stade_master_plan']) {
            $query .= ' AND designation_stade_master_plan ILIKE ?';
            $bindings[] = '%' . $filters['designation_stade_master_plan'] . '%';
        }

        // Filtre par nom_style
        if (isset($filters['nom_style']) && $filters['nom_style']) {
            $query .= ' AND nom_style ILIKE ?';
            $bindings[] = '%' . $filters['nom_style'] . '%';
        }

        // Filtre par date de PO (podate)
        if (isset($filters['podateStart']) && isset($filters['podateTil'])) {
            $query .= ' AND podate BETWEEN ? AND ?';
            $bindings[] = $filters['podateStart'];
            $bindings[] = $filters['podateTil'];
        }

        // Filtre par ETD (etdfinal)
        if (isset($filters['etdStart']) && isset($filters['etdTil'])) {
            $query .= ' AND etdfinal BETWEEN ? AND ?';
            $bindings[] = $filters['etdStart'];
            $bindings[] = $filters['etdTil'];
        }

        // Exécution de la requête SQL avec les filtres appliqués
        $nbrexp = DB::select($query, $bindings);

        return self::hydrate($nbrexp);
    }
    public static function findNbrFacturation($filters = [])
    {
        // Début de la requête SQL
        $query = 'select count(id_stade_master_plan) as nb_fact from v_recap_master_plan where id_stade_master_plan = ? and designation_stade_specifique=?';
        $bindings = ['4', 'facturation'];

        // Filtre par id de la saison
        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $query .= ' AND id_saison = ?';
            $bindings[] = $filters['idSaison'];
        }

        // Filtre par demande_client_id
        if (isset($filters['demande_client_id']) && $filters['demande_client_id']) {
            $query .= ' AND demande_client_id ILIKE ?';
            $bindings[] = '%' . $filters['demande_client_id'] . '%';
        }

        // Filtre par type_valeur_ajoutee
        if (isset($filters['type_valeur_ajoutee']) && $filters['type_valeur_ajoutee']) {
            $query .= ' AND type_valeur_ajoutee ILIKE ?';
            $bindings[] = '%' . $filters['type_valeur_ajoutee'] . '%';
        }

        // Filtre par designation_stade_master_plan
        if (isset($filters['designation_stade_master_plan']) && $filters['designation_stade_master_plan']) {
            $query .= ' AND designation_stade_master_plan ILIKE ?';
            $bindings[] = '%' . $filters['designation_stade_master_plan'] . '%';
        }

        // Filtre par nom_style
        if (isset($filters['nom_style']) && $filters['nom_style']) {
            $query .= ' AND nom_style ILIKE ?';
            $bindings[] = '%' . $filters['nom_style'] . '%';
        }

        // Filtre par date de PO (podate)
        if (isset($filters['podateStart']) && isset($filters['podateTil'])) {
            $query .= ' AND podate BETWEEN ? AND ?';
            $bindings[] = $filters['podateStart'];
            $bindings[] = $filters['podateTil'];
        }

        // Filtre par ETD (etdfinal)
        if (isset($filters['etdStart']) && isset($filters['etdTil'])) {
            $query .= ' AND etdfinal BETWEEN ? AND ?';
            $bindings[] = $filters['etdStart'];
            $bindings[] = $filters['etdTil'];
        }

        // Exécution de la requête SQL avec les filtres appliqués
        $nbrfact = DB::select($query, $bindings);

        return self::hydrate($nbrfact);
    }
}
