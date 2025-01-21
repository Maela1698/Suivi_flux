<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MicroMerchDev extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'micromerchdev';
    protected $fillable = [
        'id_etape',
        'id_demande',
        'realisation',
        'commentaires',
        'etat',
    ];

    public static function getCapacite($debut,$fin,$annee){
        $select = DB::select('
        SELECT SUM(objectif * effectif * ((8 * nbJour) + heureSupple)) AS capacite FROM parametremicromerchdev WHERE semaine >= ? AND semaine <= ? AND annee = ?',[$debut, $fin, $annee]);
        $pri = null;
        if (!empty($select)) {
            $pri = $select[0]->capacite;
        }
        return $pri;
    }
    public static function getIdDemandeByFiltre($debut,$fin,$annee){
        $select = DB::select('
        SELECT distinct id_demande_client  FROM v_filtre_micro WHERE semaine >= ? AND semaine <= ? AND annee = ? and id_etat=1',[$debut, $fin, $annee]);
        return self::hydrate($select);
    }
    public static function getPlanning($iddemande){
        $select = DB::select('
        SELECT SUM(total_qte_detailsdcc) AS total_sum
        FROM (
        SELECT DISTINCT total_qte_detailsdc,
        CASE WHEN total_qte_detailsdc is null THEN etape_quantite ELSE total_qte_detailsdc END AS total_qte_detailsdcc
        FROM v_filtre_micro
        WHERE id_demande_client = ?
          AND micro_realisation IS NULL
          AND etape_designation LIKE ?
        ) AS distinct_quantites
    ', [$iddemande, '%FIN MONTAGE%']);

        $pri = null;
        if (!empty($select)) {
            $pri = $select[0]->total_sum;
        }
        return $pri;
    }
    public static function getReelProduit($iddemande){
        $select = DB::select('
    SELECT SUM(total_qte_detailsdcc) AS total_sum
    FROM (
        SELECT DISTINCT total_qte_detailsdc,
        CASE WHEN total_qte_detailsdc is null THEN etape_quantite ELSE total_qte_detailsdc END AS total_qte_detailsdcc
        FROM v_filtre_micro
        WHERE id_demande_client = ?
          AND micro_realisation IS NOT NULL
          AND etape_designation LIKE ?
    ) AS distinct_quantites
', [$iddemande, '%FIN MONTAGE%']); // Remplacez $id_demande_client par votre variable


        $pri = null;
        if (!empty($select)) {
            $pri = $select[0]->total_sum;
        }
        return $pri;
    }

    public static function getAllParametre(){
        $select=DB::select('select * from parametremicromerchdev');
        return self::hydrate($select);
    }
    public static function getAnne(){
        $select=DB::select('select distinct annee from v_micro_merch');
        return self::hydrate($select);
    }
    public static function insertAnne($anne) {
        for ($i = 1; $i <= 52; $i++) {
            DB::table('parametremicromerchdev')->insert([
                'annee' => $anne,
                'semaine' => $i,
            ]);
        }
    }
    public static function getAllListeDemandeNego(){
        $select=DB::select('select * from v_demandeClient where etat=0 and id_etat=1 order by id desc');
        return self::hydrate($select);
    }
    public static function insertEtape($demande)
    {
        DB::insert("
            INSERT INTO resultatcalcule (id_etape, id_demande_client, date_depart, date_fin_prevue, semaine, annee)
            SELECT
                e.id,
                dc.id,
                CASE
                    WHEN e.id = 1 THEN dc.date_entree
                    ELSE NULL
                END AS date_depart,
                CASE
                    WHEN e.id = 1 THEN dc.date_entree + INTERVAL '1 day' * e.nbjour
                    ELSE NULL
                END AS date_fin_prevue,
                EXTRACT(WEEK FROM dc.date_entree) AS semaine,
                EXTRACT(YEAR FROM dc.date_entree) AS annee
            FROM
                demandeclient dc
            CROSS JOIN
                etaperetromerch e
            WHERE
                dc.id = ? AND dc.id_etat != 3 AND dc.etat = 0",
            [$demande]
        );
    }


}
