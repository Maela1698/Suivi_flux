<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pri extends Model
{
    use HasFactory;
    protected $table = 'pri';
    protected $fillable = [
        'date_pri',
        'prix',
        'id_unite_monetaire',
        'id_demande_client',
        'commentaire',
        'etat',
    ];
    public static function insertPri($prix_print,$id_unite_monetaire,$id_demande_client,$commentaire){
        DB::insert('insert into pri values(default,?,?,?,?,?,?)',[now()->toDateString(),$prix_print,$id_unite_monetaire,$id_demande_client,$commentaire,0]);
    }
    public static function insertPriNouveau($date,$prix_print,$id_unite_monetaire,$id_demande_client,$commentaire){
        DB::insert('insert into pri values(default,?,?,?,?,?,?)',[$date,$prix_print,$id_unite_monetaire,$id_demande_client,$commentaire,0]);
    }

    public static function getPriByIdDemande($idDemande){
        $select=DB::select('select * from v_pri where id_demande_client=?',[$idDemande]);
        return self::hydrate($select);
    }

    //id du smv
    public static function getIDLastPriByIdDemande($idDemande)
    {
        $results = DB::select('select id from pri where id_demande_client=? ORDER BY id DESC LIMIT 1', [$idDemande]);
        $pri = null;
        if (!empty($results)) {
            $pri = $results[0]->id;
        }
        return $pri;
    }

    // ligne du last pri
    public static function getLastPriByIdDemande($idDemande)
    {
        $idlastpri = Pri::getIDLastPriByIdDemande($idDemande);
        $results = DB::select('select * from v_pri where id=?', [$idlastpri]);
        return self::hydrate($results);
    }

    public static function updatePri(
        $idDemande,
        $prix,
        $commentaire
    ) {


        $idprix = Pri::getIDLastPriByIdDemande($idDemande);

        // dd($idprix);
        DB::update('UPDATE pri SET prix=?,commentaire=? WHERE id=?', [
            $prix,
            $commentaire,
            $idprix,
        ]);
    }

}
