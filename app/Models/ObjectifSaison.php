<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ObjectifSaison extends Model
{
    use HasFactory;

    protected $table = 'objectifsaison';

    // Autoriser l'assignation en masse pour ces colonnes
    protected $fillable = [
        'idtiers',
        'idsaison',
        'targetsaison',
        'tauxconfirmation',
        'etat'
    ];

    // Désactiver les timestamps si la table ne les contient pas
    public $timestamps = false;

    public static function findAllObjectifSaison()
    {
        $select = DB::select('select * from objectifsaison');
        return self::hydrate($select);
    }

    public static function findAllv_ObjectifSaison()
    {
        $select = DB::select('select * from v_recap_objectif_saison');
        return self::hydrate($select);
    }

    public static function findDetailv_ObjectifSaison($id_tier, $idsaison)
    {
        $select = DB::select('select * from v_recap_objectif_saison where
        id_tier=? and idsaison=?', [$id_tier, $idsaison]);
        return self::hydrate($select);
    }


    public static function findSumNbCommande($filters = [])
    {
        // Début de la requête SQL
        $query = 'SELECT SUM(nb_commandes) AS sum_nb_commande FROM v_recap_objectif_saison WHERE 1=1';

        // Paramètres pour les filtres
        $bindings = [];

        // Filtre par id de la saison
        if (isset($filters['idsaison']) && $filters['idsaison']) {
            $query .= ' AND idsaison = ?';
            $bindings[] = $filters['idsaison'];
        }

        // Filtre par id du client (tiers)
        if (isset($filters['id_tier']) && $filters['id_tier']) {
            $query .= ' AND id_tier = ?';
            $bindings[] = $filters['id_tier'];
        }

        // Filtre par merchsenior
        if (isset($filters['merchsenior']) && $filters['merchsenior']) {
            $query .= ' AND merchsenior ILIKE ?';
            $bindings[] = '%' . $filters['merchsenior'] . '%';
        }

        // Filtre par état (atteint ou non atteint)
        if (isset($filters['etat']) && $filters['etat']) {
            if ($filters['etat'] == 'Atteint') {
                $query .= ' AND tauxconfirmation >= 100'; // Objectif atteint
            } else if ($filters['etat'] == 'Non Atteint') {
                $query .= ' AND tauxconfirmation < 100'; // Objectif non atteint
            }
        }

        // Exécution de la requête SQL avec les filtres appliqués
        $select = DB::select($query, $bindings);

        return self::hydrate($select);
        // $select = DB::select('select sum(nb_commandes) AS sum_nb_commande from v_recap_objectif_saison');
        // return self::hydrate($select);

        // Le WHERE 1=1 permet d'ajouter dynamiquement des conditions sans avoir à vérifier si c'est le premier filtre ou non.
    }

    public static function findSumTarget($filters = [])
    {
        // Initialisation de la requête avec la table 'objectifsaison'
        // $query = DB::table('objectifsaison')
        //     ->select(DB::raw('SUM(targetsaison) AS sum_target_saison'));
        $query = 'SELECT sum(targetsaison) as total_target_saison from v_recap_objectif_saison WHERE 1=1';

        $bindings = [];

        // Filtre par id de la saison
        if (isset($filters['idsaison']) && $filters['idsaison']) {
            $query .= ' AND idsaison = ?';
            $bindings[] = $filters['idsaison'];
        }

        // Filtre par id du client (tiers)
        if (isset($filters['id_tier']) && $filters['id_tier']) {
            $query .= ' AND id_tier = ?';
            $bindings[] = $filters['id_tier'];
        }

        // Filtre par merchsenior
        if (isset($filters['merchsenior']) && $filters['merchsenior']) {
            $query .= ' AND merchsenior ILIKE ?';
            $bindings[] = '%' . $filters['merchsenior'] . '%';
        }

        // Filtre par état (atteint ou non atteint)
        if (isset($filters['etat']) && $filters['etat']) {
            if ($filters['etat'] == 'Atteint') {
                $query .= ' AND tauxconfirmation >= 100'; // Objectif atteint
            } else if ($filters['etat'] == 'Non Atteint') {
                $query .= ' AND tauxconfirmation < 100'; // Objectif non atteint
            }
        }
        $select = DB::select($query, $bindings);

        return self::hydrate($select);
    }

    public static function findSumConfirmee($filters = [])
    {
        // Début de la requête SQL
        $query = 'select sum(total_qte_confirmee) as total_confirmee from v_recap_objectif_saison WHERE 1=1';

        // Paramètres pour les filtres
        $bindings = [];

        // Filtre par id de la saison
        if (isset($filters['idsaison']) && $filters['idsaison']) {
            $query .= ' AND idsaison = ?';
            $bindings[] = $filters['idsaison'];
        }

        // Filtre par id du client (tiers)
        if (isset($filters['id_tier']) && $filters['id_tier']) {
            $query .= ' AND id_tier = ?';
            $bindings[] = $filters['id_tier'];
        }

        // Filtre par merchsenior
        if (isset($filters['merchsenior']) && $filters['merchsenior']) {
            $query .= ' AND merchsenior ILIKE ?';
            $bindings[] = '%' . $filters['merchsenior'] . '%';
        }

        // Filtre par état (atteint ou non atteint)
        if (isset($filters['etat']) && $filters['etat']) {
            if ($filters['etat'] == 'Atteint') {
                $query .= ' AND tauxconfirmation >= 100'; // Objectif atteint
            } else if ($filters['etat'] == 'Non Atteint') {
                $query .= ' AND tauxconfirmation < 100'; // Objectif non atteint
            }
        }

        // Exécution de la requête SQL avec les filtres appliqués
        $select = DB::select($query, $bindings);

        return $select;
    }

    public static function moyenneTauxConfirmed($filters = [])
    {
        $queryConf = 'SELECT SUM(total_qte_confirmee) as total_confirmee FROM v_recap_objectif_saison WHERE 1=1';
        $queryTarget = 'SELECT SUM(targetsaison) as total_target_saison FROM v_recap_objectif_saison WHERE 1=1';

        $bindings = [];

        // Filtre par id de la saison
        if (isset($filters['idsaison']) && $filters['idsaison']) {
            $queryConf .= ' AND idsaison = ?';
            $queryTarget .= ' AND idsaison = ?';
            $bindings[] = $filters['idsaison'];
        }

        // Filtre par id du client (tiers)
        if (isset($filters['id_tier']) && $filters['id_tier']) {
            $queryConf .= ' AND id_tier = ?';
            $queryTarget .= ' AND id_tier = ?';
            $bindings[] = $filters['id_tier'];
        }

        // Filtre par merchsenior
        if (isset($filters['merchsenior']) && $filters['merchsenior']) {
            $queryConf .= ' AND merchsenior ILIKE ?';
            $queryTarget .= ' AND merchsenior ILIKE ?';
            $bindings[] = '%' . $filters['merchsenior'] . '%';
        }

        // Filtre par état (atteint ou non atteint)
        if (isset($filters['etat']) && $filters['etat']) {
            if ($filters['etat'] == 'Atteint') {
                $queryConf .= ' AND tauxconfirmation >= 100';
                $queryTarget .= ' AND tauxconfirmation >= 100';
            } else if ($filters['etat'] == 'Non Atteint') {
                $queryConf .= ' AND tauxconfirmation < 100';
                $queryTarget .= ' AND tauxconfirmation < 100';
            }
        }

        $sumtauxconf = DB::select($queryConf, $bindings);
        $sumtarget = DB::select($queryTarget, $bindings);

        if (
            empty($sumtauxconf) || $sumtauxconf[0]->total_confirmee == 0
            || empty($sumtarget) || $sumtarget[0]->total_target_saison == 0
        ) {
            return 0;
        }

        $total_qte_provisoire = $sumtauxconf[0]->total_confirmee;
        $total_target = $sumtarget[0]->total_target_saison;
        $moyenne = ($total_qte_provisoire / $total_target) * 100;

        return $moyenne;
    }


    // public static function moyenneTauxConfirmed()
    // {
    //     $sumtauxconf = ObjectifSaison::findsumConfirmee();
    //     $sumtarget = ObjectifSaison::findSumTarget();

    //     // Vérification que les deux sommes existent et ne sont pas vides
    //     if (
    //         empty($sumtauxconf) || $sumtauxconf[0]->total_confirmee == 0
    //         || empty($sumtarget) || $sumtarget[0]->total_target_saison == 0
    //     ) {
    //         return 0;
    //     }

    //     // Extraction des valeurs numériques depuis les tableaux
    //     $total_qte_provisoire = $sumtauxconf[0]->total_confirmee;
    //     $total_target = $sumtarget[0]->total_target_saison;

    //     // Calcul de la moyenne des taux de confirmation en pourcentage
    //     $moyenne = ($total_qte_provisoire / $total_target) * 100;

    //     return $moyenne;
    // }

    // 1 vrai
    // public static function moyenneTauxConfirmed()
    // {
    //     // Récupération de la somme des quantités confirmées
    //     $sumtauxconf = DemandeClient::findsumConfirmee();

    //     // Récupération de la somme des objectifs de saison
    //     $sumtarget = ObjectifSaison::findSumTarget();

    //     // Vérification que les deux sommes existent et ne sont pas vides
    //     if (
    //         // ici
    //         $sumtauxconf->isEmpty() || $sumtauxconf[0]->total_confirmee == 0
    //         || $sumtarget->isEmpty() || $sumtarget[0]->sum == 0
    //     ) {
    //         return 0; // Si l'une des deux sommes est vide ou nulle, la moyenne est 0
    //     }

    //     // Extraction des valeurs numériques depuis les collections
    //     $total_qte_provisoire = $sumtauxconf[0]->total_qte_provisoire;
    //     $total_target = $sumtarget[0]->sum;

    //     // Calcul de la moyenne des taux de confirmation en pourcentage
    //     $moyenne = ($total_qte_provisoire / $total_target) * 100;

    //     return $moyenne;
    // }

    // public static function moyenneTauxConfirmed()
    // {
    //     // Récupération de la somme des quantités confirmées
    //     $sumtauxconf = DemandeClient::findsumConfirmee();

    //     // Récupération de la somme des objectifs de saison
    //     $sumtarget = ObjectifSaison::findSumTarget();

    //     // Vérification que les deux sommes existent et ne sont pas vides
    //     if (
    //         empty($sumtauxconf) || $sumtauxconf[0]->total_confirmee == 0
    //         || empty($sumtarget) || $sumtarget[0]->sum_target_saison == 0
    //     ) {
    //         return 0; // Si l'une des deux sommes est vide ou nulle, la moyenne est 0
    //     }

    //     // Extraction des valeurs numériques depuis les tableaux
    //     $total_qte_confed = $sumtauxconf[0]->total_confirmee;
    //     $total_target = $sumtarget[0]->sum_target_saison;

    //     // Calcul de la moyenne des taux de confirmation en pourcentage
    //     $moyenne = ($total_qte_confed / $total_target) * 100;

    //     return $moyenne;
    // }


    // Mise à jour : modifier 21 09 2024; 12:34
    public static function modifierObjectifTarget($id_obj, $id_tiers, $id_saison, $newtarget)
    {
        // $objectif = self::find($id_obj);
        $quantiteConfirmee = DB::select('SELECT SUM(total_qte_confirmee) as total_confirmee FROM v_recap_objectif_saison WHERE 1=1');

        // $quantiteConfirmee = DemandeClient::qteconfirme($id_saison, $id_tiers);

        // Vérification de la quantité confirmée : si null ou vide, on attribue 0
        if ($quantiteConfirmee === null || empty($quantiteConfirmee)) {
            // $quantiteConfirmee)->isEmpty()
            $quantiteConfirmee = collect([(object) ['total_confirmee' => 0]]);
        }

        // Calcul du taux de confirmation
        $tauxconfirmation = 0;
        if ($quantiteConfirmee[0]->total_confirmee > 0 && $newtarget > 0) {
            $tauxconfirmation = ($quantiteConfirmee[0]->total_confirmee / $newtarget) * 100;
        }


        // Mise à jour de l'objectif et du taux de confirmation
        DB::update('UPDATE objectifsaison SET targetsaison=?, tauxconfirmation=? WHERE id=?', [$newtarget, $tauxconfirmation, $id_obj]);
    }

    public static function deleteObjectifSaison($idobj)
    {
        $delete = DB::delete('delete from objectifsaison where id=?', [$idobj]);
    }

    public static function qteconfirme($idsaison, $id_tiers)
    {
        $select = DB::select('SELECT
                                SUM(qte_commande_provisoire) AS total_qte_confirmee
                            FROM
                                demandeclient
                            WHERE
                                id_etat = 2
                            AND
                                id_saison = ?
                            AND
                                id_client = ?
                            GROUP BY
                                id_saison,
                                id_client', [$idsaison, $id_tiers]);

        return self::hydrate($select);
    }
    // public static function moyenneTauxConfirmed()
    // {
    //     // Récupération de la somme des quantités confirmées
    //     $sumtauxconf = DemandeClient::findsumConfirmee();
    //     // Récupération de la somme des objectifs de saison
    //     $sumtarget = ObjectifSaison::findSumTarget();

    //     // Vérification que les deux sommes existent et ne sont pas vides
    //     if (
    //         $sumtauxconf->isEmpty() || $sumtauxconf[0]->total_qte_provisoire == 0
    //         || $sumtarget->isEmpty() || $sumtarget[0]->sum == 0
    //     ) {
    //         return 0; // Si l'une des deux sommes est vide ou nulle, la moyenne est 0
    //     }

    //     // Extraction des valeurs numériques depuis les collections
    //     $total_qte_provisoire = $sumtauxconf[0]->total_qte_provisoire;
    //     $total_target = $sumtarget[0]->sum;

    //     // Calcul de la moyenne des taux de confirmation
    //     $moyenne = $total_qte_provisoire / $total_target;

    //     return $moyenne;
    // }


}
