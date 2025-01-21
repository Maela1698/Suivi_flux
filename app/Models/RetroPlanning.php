<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RetroPlanning extends Model
{
    use HasFactory;
    // Table associated with the model
    protected $table = 'retro_planing';
    public $timestamps = false;
    // Fillable fields for mass assignment
    protected $fillable = [
        'iddemandeclient',
        'id_data_prod',
        'id_chaine',
        'inlinechacun',
        'heuretravail',
        'efficience',
        'efficiencereel',
        'effectif',
        'capacitereel',
        'qtereel',
        'commentaire',
        'etat',
        'charge'
    ];
    public static function getAllChaine(){
        $select=DB::select('select * from chaine order by id_chaine');
        return self::hydrate($select);
    }
    public static function getRetroPlanning(){
        $select=DB::select('select * from v_kanban_retro_planing order by id_chaine,inlinechacun,iddemandeclient');
        return self::hydrate($select);
    }
    public static function getLastDataProd(){
        $results = DB::select('select id from dataprod ORDER BY id DESC LIMIT 1');
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->id;
        }
        return $tiers;
    }
    public static function getMinDateInline(){
        $results=DB::select('select min(inline) as debut_inline from v_kanban_retro_planing where inline is not null');
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->debut_inline;
        }
        return $tiers;
    }
    public static function compareDate($date){
        $results=DB::select('select MAKE_DATE(annee, mois, jour) AS full_date from jours_feries where MAKE_DATE(annee, mois, jour)=?',[$date]);
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->full_date;
        }
        return $tiers;
    }
    public static function getLasteDateByIdDemande($iddemande){
        $results=DB::select('select inlinechacun from retro_planing  where iddemandeclient=? order by inlinechacun desc limit 1',[$iddemande]);
        if (!empty($results)) {
            $tiers = $results[0]->inlinechacun;
        }
        return $tiers;
    }
    public static function getLastQuantiteByIdDemande($iddemande){
        $results=DB::select('select qtereel from retro_planing  where iddemandeclient=? order by inlinechacun desc limit 1',[$iddemande]);
        if (!empty($results)) {
            $tiers = $results[0]->qtereel;
        }
        return $tiers;
    }
    public static function getLastCapaciteByIdDemande($iddemande){
        $results=DB::select('select capacitereel from retro_planing  where iddemandeclient=? order by inlinechacun desc limit 1',[$iddemande]);
        if (!empty($results)) {
            $tiers = $results[0]->capacitereel;
        }
        return $tiers;
    }
    public static function getFirstDateByIdDemande($iddemande){
        $results=DB::select('select inlinechacun from retro_planing  where iddemandeclient=? order by inlinechacun asc limit 1',[$iddemande]);
        if (!empty($results)) {
            $tiers = $results[0]->inlinechacun;
        }
        return $tiers;
    }
    public static function getRetroPlanningByIdDemande($idDemande){
        $select=DB::select('select * from retro_planing where iddemandeclient='.$idDemande);
        return self::hydrate($select);
    }
    public static function getRetroByDate($date,$id_chaine){
        $select=DB::select('select * from retro_planing where inlinechacun>=? and id_chaine=?',[$date,$id_chaine]);
        return self::hydrate($select);
    }
    public static function getRetroByDateStrict($date,$id_chaine){
        $select=DB::select('select * from retro_planing where inlinechacun>? and id_chaine=? order by id',[$date,$id_chaine]);
        return self::hydrate($select);
    }

    public static function getRetroPlaningByIdChaine($id_chaine){
        $select=DB::select('select * from retro_planing where id_chaine=? order by id',[$id_chaine]);
        return self::hydrate($select);
    }
    public static function getEntreDeuxDate($debut,$fin,$chaine){
        $select=DB::select('select * from retro_planing where inlinechacun>=? and inlinechacun<=? and id_chaine=? order by id asc',[$debut,$fin,$chaine]);
        return self::hydrate($select);
    }

    public static function compareDateMinForId($date1,$date2){
        // Comparer les dates
        if ($date1 < $date2) {
            return $date1;  // ID si la première date est antérieure
        }if ($date1 > $date2) {
            return $date2;  // ID si la première date est postérieure
        }
    }
    public static function compareDateMaxForId($date1,$date2){
        // Comparer les dates
        if ($date1 > $date2) {
            return $date1;  // ID si la première date est antérieure
        }if ($date1 < $date2) {
            return $date2;  // ID si la première date est postérieure
        }
    }

    public static function getIdByIdChaineAndIdDate($date,$id_chaine){
        $select=DB::select('select * from retro_planing where inlinechacun=? and id_chaine=? order by id asc',[$date,$id_chaine]);
        return self::hydrate($select);
    }

    public static function getEntreDeuxDateStrict($debut,$fin,$chaine){
        $select=DB::select('select * from retro_planing where inlinechacun>? and inlinechacun<? and id_chaine=? order by id asc',[$debut,$fin,$chaine]);
        return self::hydrate($select);
    }
    public static function getCountId($iddemande,$chaine){
        $results=DB::select('select count(*) as nombre from retro_planing  where iddemandeclient=? and id_chaine=?',[$iddemande,$chaine]);
        if (!empty($results)) {
            $tiers = $results[0]->nombre;
        }
        return $tiers;
    }
    public static function getRetroPlanningByIdDemandeByChaine($idDemande, $id_chaine){
        $select=DB::select('select * from retro_planing where iddemandeclient=? and id_chaine=?',[$idDemande,$id_chaine]);
        return self::hydrate($select);
    }
    public static function getIdChaineByDesignation($chaine){
        $select=DB::select('select id_chaine from chaine  where designation=?',[$chaine]);
        if (!empty($select)) {
            $tiers = $select[0]->id_chaine;
        }
        return $tiers;
    }

    public function insertNonTravail($date_changement, $date_non_travail, $id_chaine)
    {
        DB::table('datenontravail')->insert([
            'date_changement' => $date_changement,
            'date_non_travail' => $date_non_travail,
            'id_chaine' => $id_chaine
        ]);
    }

    public static function listeDateNonTravail()
    {
        $select=DB::select('select * from datenontravail ');
        return self::hydrate($select);
    }
    public static function deleteDateNonTravailByChaineDate($date_non_travail)
    {
        DB::select('delete from datenontravail where date_non_travail=? ' , [$date_non_travail]);
        // dd('delete from datenontravail where date_non_travail=? and id_chaine=?' , [$date_non_travail,$id_chaine]);
    }
    public static function listeRetroPlanningByDateChaine($inlinechacun,$id_chaine)
    {
        $select=DB::select('select * from retro_planing  where inlinechacun=? and id_chaine=? order by id asc', [$inlinechacun,$id_chaine]);
        return self::hydrate($select);
    }

    public static function updateInlineRetro($inlinechacun,$id)
    {
        DB::select('update retro_planing set inlinechacun=?  where id=?', [$inlinechacun,$id]);
    }
    public static function checkIfNotNull($inlinechac)
    {
        $select=DB::select('select qtereel from v_kanban_retro_planing  where inlinechacun=? ',[$inlinechac]);
        return self::hydrate($select);
    }
    public static function getChargeRetroPlaningByInline($inlinechac){
        $results=DB::select('select ROUND(CAST(COALESCE(SUM(charge),0) AS NUMERIC),2) as charge from retro_planing where inlinechacun=?',[$inlinechac]);
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->charge;
        }
        return $tiers;
    }
}

































