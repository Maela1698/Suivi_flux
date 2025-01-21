<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sdc extends Model
{
    use HasFactory;
    protected $table = 'sdc';
    protected $fillable = [
        'date_entree',
        'date_envoie',
        'id_demande_client',
        'id_stade_demande_client',
        'etat',
    ];

    public static function insertSdc($date_envoie,$idDemande,$id_stade_demande_client){
        DB::insert('insert into sdc values(default,?,?,?,?,?)',[now()->toDateString(),$date_envoie,$idDemande,$id_stade_demande_client,0]);
    }
    // public static function insertDetailSdc($id_sdc,$id_unite_taille_dc,$qte_total,$paquet,$qte_client,$keep){
    //     DB::insert('insert into detailSdc(id_sdc,id_unite_taille_dc) values ',[$id_sdc,$id_unite_taille_dc,$qte_total,$paquet,$qte_client,$keep,0]);
    // }

    public static function insertDetailSdc($id_sdc,$id_unite_taille_dc,$qte_total, $qte_client,$keep)
    {
        DB::table('detailsdc')->insert([
            'id_sdc' => $id_sdc,
            'id_unite_taille_dc' => $id_unite_taille_dc,
            'qte_total' => $qte_total,
            'qte_client' => $qte_client,
            'keep' => $keep
        ]);
    }
    public static function getLastIdSdcByIdDemande($idDemande){
        $results = DB::select('select id from sdc where id_demande_client=? ORDER BY id DESC LIMIT 1',[$idDemande]);
        $sdc = null;
        if (!empty($results)) {
            $sdc = $results[0]->id;
        }
        return $sdc;
    }
    public static function getDetailSdcById($idSdc){
        $select=DB::select('select * from v_detailSdc where id_sdc=? and (qte_total>0 or paquet>0 or qte_client>0 or keep>0)',[$idSdc]);
        return self::hydrate($select);
    }
    public static function getDispoMatierePremiere(){
        $select=DB::select('select * from dispositionMatierePremiere');
        return self::hydrate($select);
    }
    public static function getLastSdcById($idDemande){
        $idlast = Sdc::getLastIdSdcByIdDemande($idDemande);
        $select=DB::select('select * from sdc where id=?',[$idlast]);
        return self::hydrate($select);
    }
    public static function getDetailById($idDemande){
        $idlast = Sdc::getLastIdSdcByIdDemande($idDemande);
        $select=DB::select('select * from v_detailsdc where id_sdc=?',[$idlast]);
        return self::hydrate($select);
    }
    public static function updateSdc($date_envoie,$idDemande){
        $idlast = Sdc::getLastIdSdcByIdDemande($idDemande);
        DB::update('update sdc set date_envoie=?  where id=?',[$date_envoie,$idlast]);
    }
    public static function updateDetailSdc($qte_total,$qte_client,$keep,$idDemande,$id_unite_taille_dc){
        $idlast = Sdc::getLastIdSdcByIdDemande($idDemande);
        DB::update('update detailSdc set qte_total=?,qte_client=?,keep=?  where id_sdc=? and id_unite_taille_dc=?',[$qte_total,$qte_client,$keep,$idlast,$id_unite_taille_dc]);
    }

    public static function nbDemandeSDCByDemande($demandeClient)
    {
        $select = DB::table('sdc')
            ->where('id_demande_client', $demandeClient)
            ->where('etat', 0)
            ->count();
        return $select;
    }

    public static function getSDCById($idDC){
        $select=DB::select('select * from sdc where id_demande_client='.$idDC);
        return self::hydrate($select);
    }

}
