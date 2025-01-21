<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RetroMerch extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'v_retro_merch';
    protected $fillable = [
        'sdc_id',
        'sdc_date_entree',
        'sdc_date_envoie',
        'sdc_quantite',
        'sdc_etat',
        'demande_id',
        'demande_date_entree',
        'demande_date_livraison',
        'nom_modele',
        'theme',
        'qte_commande_provisoire',
        'taille_base',
        'requete_client',
        'commentaire_merch',
        'photo_commande',
        'demande_etat',
        'id_unite_taille_min',
        'id_unite_taille_max',
        'nomtier',
        'id_tiers',
        'nom_style',
        'id_style',
        'type_incontern',
        'id_incontern',
        'type_phase',
        'id_phase',
        'type_saison',
        'id_saison',
        'taillemin',
        'taillemax',
        'type_stade',
        'id_stade',
        'type_etat',
        'id_etat'
    ];
    public static function getDemandeRetro(){
        $select=DB::select('select * from v_retro_merch where demande_etat=0');
        return self::hydrate($select);
    }
    public static function getEtatRetroMerch(){
        $select=DB::select('select * from etatRetroMerch');
        return self::hydrate($select);
    }
    public static function getDemandeMicro(){
        $select=DB::select('WITH ranked_results AS (
                SELECT
                    vm.*,
                    ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) AS row_num,
                    (ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) - 1) / 5 AS group_number
                FROM v_micro_merch vm
            ),
            group_completion AS (
                SELECT
                    group_number,
                    id_demande_client,
                    COUNT(*) AS total_in_group,
                    COUNT(CASE WHEN micro_realisation IS NOT NULL THEN 1 END) AS completed_in_group
                FROM ranked_results
                GROUP BY group_number, id_demande_client
            ),
            filtered_results AS (
                SELECT r.*,
                    ROW_NUMBER() OVER (PARTITION BY r.id_demande_client ORDER BY r.group_number, r.row_num) AS client_row_num
                FROM ranked_results r
                JOIN group_completion gc
                ON r.group_number = gc.group_number
                AND r.id_demande_client = gc.id_demande_client
                WHERE gc.completed_in_group < 5
            )
            SELECT *
            FROM filtered_results
            WHERE client_row_num <= 5
            ORDER BY id_demande_client, group_number, row_num'
);
        return self::hydrate($select);
    }
    public static function getDonne($iddemande){
        $select=DB::select('select * from v_micro_merch where id_demande_client=? order by id_etape ',[$iddemande]);
        return self::hydrate($select);
    }

    public static function getMpNonDispoKpi(){
        $results = DB::select('select count(*) as nondispo from v_filtre_dispo where micro_realisation is null');
        $smv = null;
        if (!empty($results)) {
            $smv = $results[0]->nondispo;
        }
        return $smv;
    }
    public static function getEnvoiSdcKpi(){
        $results = DB::select('select count(*) as envoiesdc from v_filtre_envoie_sdc where micro_realisation is null');
        $smv = null;
        if (!empty($results)) {
            $smv = $results[0]->envoiesdc;
        }
        return $smv;
    }
    public static function getRetardKpi(){
        $results = DB::select('select count(*) as retard from v_filtre_retard');
        $smv = null;
        if (!empty($results)) {
            $smv = $results[0]->retard;
        }
        return $smv;
    }
    public static function getOkProdKpi(){
        $results = DB::select('select count(*) as okprod from v_filtre_ok_prod where micro_realisation is null');
        $smv = null;
        if (!empty($results)) {
            $smv = $results[0]->okprod;
        }
        return $smv;
    }
}
