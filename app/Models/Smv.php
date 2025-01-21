<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Smv extends Model
{
    use HasFactory;
    protected $table = 'smv';
    protected $fillable = [
        'date_smv',
        'smv_prod',
        'smv_finition',
        'prix_print',
        'id_unite_monetaire',
        'nombre_points',
        'smv_brod_main',
        'id_demande_client',
        'id_stade_demande_client',
        'commentaire',
        'etat'
    ];
    public static function insertSmv($smv_prod,$smv_finition,$prix_print,$id_unite_monetaire,$nombre_points,$smv_brod_main,$id_demande_client,$id_stade_demande_client,$commentaire){
        DB::insert('insert into smv values(default,?,?,?,?,?,?,?,?,?,?,?)',[now()->toDateString(),$smv_prod,$smv_finition,$prix_print,$id_unite_monetaire,$nombre_points,$smv_brod_main,$id_demande_client,$id_stade_demande_client,$commentaire,0]);
    }

    public static function getSmvByIdDemande($idDemande){
        $select=DB::select('select * from v_smv where id_demande_client=?',[$idDemande]);
        return self::hydrate($select);
    }

    public static function getIDLastSmvByIdDemande($idDemande)
    {
        $results = DB::select('select id from smv where id_demande_client=? ORDER BY id DESC LIMIT 1', [$idDemande]);
        $smv = null;
        if (!empty($results)) {
            $smv = $results[0]->id;
        }
        return $smv;
    }

      // ligne du last smv
      public static function getLastSmvByIdDemande($idDemande)
      {
          $idlastsmv = Smv::getIDLastSmvByIdDemande($idDemande);
          $results = DB::select('select * from v_smv where id=?', [$idlastsmv]);
          return self::hydrate($results);
      }

      public static function updateSmv(
          $idDemande,
          $smv_prod,
          $smv_finition,
          $prix_print,
          $id_unite_monetaire,
          $nombre_points,
          $smv_brod_main,
          $commentaire
      ) {


          $idsmv = Smv::getIDLastSmvByIdDemande($idDemande);

          // dd($idsmv);
          DB::update('UPDATE smv SET smv_prod=?, smv_finition=?, prix_print=?,id_unite_monetaire=?, nombre_points=?, smv_brod_main=?,
          commentaire=? WHERE id=?', [
              $smv_prod,
              $smv_finition,
              $prix_print,
              $id_unite_monetaire,
              $nombre_points,
              $smv_brod_main,
              $commentaire,
              $idsmv,
          ]);
      }

      public static function getDernierSmvByIdDemande($idDemande)
      {
          $results = DB::select('select * from smv where id_demande_client=? ORDER BY id DESC LIMIT 1', [$idDemande]);
          return self::hydrate($results);
      }
}
