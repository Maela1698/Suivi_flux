<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Echantillon extends Model
{
    use HasFactory;
    protected $table = 'envoieechantillon';

    protected $fillable = [
        'id_demande_client',
        'id_stade_demande_client',
        'date_creation',
        'date_envoie',
        'quantite',
        'lieu_destination',
        'mode_envoie',
        'commentaire',
        'awb',
        'etat',
    ];
    public static function insertEchantillon($id_demande_client, $id_stade_demande_client, $date_envoie,$quantite, $lieu_destination, $mode_envoie, $commentaire, $awb)
{
    DB::insert('insert into envoieEchantillon values (default,?, ?, ?, ?, ?, ?, ?, ?, ?,?)', [$id_demande_client,$id_stade_demande_client,now()->toDateString(),$date_envoie,$quantite,$lieu_destination,$mode_envoie,$commentaire,$awb,0]);
}

    public static function getEchantillonByIdDemande($idDemande){
        $select=DB::select('select * from v_echantillon where id_demande_client=? order by id desc',[$idDemande]);
        return self::hydrate($select);
    }

    public static function getIDLastEchantillonByIdDemande($idDemande)
    {
        $results = DB::select('select id from envoieechantillon where id_demande_client=? ORDER BY id DESC LIMIT 1', [$idDemande]);
        $echantillon = null;
        if (!empty($results)) {
            $echantillon = $results[0]->id;
        }
        return $echantillon;
    }
     // ligne du last echantillon
     public static function getLastEchantillonByIdDemande($idDemande)
     {
         $idlastEchantillon = Echantillon::getIDLastEchantillonByIdDemande($idDemande);
         $results = DB::select('select * from v_echantillon where id=?', [$idlastEchantillon]);
         return self::hydrate($results);
     }

     public static function updateEchantillon(
         $idDemande,
         $date_envoie,
         $quantite,
         $lieu_destination,
         $mode_envoie,
         $commentaire,
         $awb
     ) {


         $idechantillon = Echantillon::getIDLastEchantillonByIdDemande($idDemande);

         // dd($idechantillon);
         DB::update('UPDATE envoieechantillon SET
         date_envoie=?, quantite=?, lieu_destination=?,mode_envoie=?,commentaire=?,awb=?  WHERE id=?', [
             $date_envoie,
             $quantite,
             $lieu_destination,
             $mode_envoie,
             $commentaire,
             $awb,
             $idechantillon,
         ]);
     }
}
