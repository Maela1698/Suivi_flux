<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RecapCommande extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'recapcommande';
    protected $fillable = [
        'iddemandeclient',
        'etdrevise',
        'etdpropose',
        'receptionbc',
        'bcclient',
        'date_bc_tissu',
        'date_bc_access',
        'etat',
        'podateprev',
    ];


    public static function getAllDestination(){
        $select=DB::select('select * from destStd');
        return self::hydrate($select);
    }
    public static function getDestinationRecapCommandeById($idrecap){
        $select=DB::select('select * from v_dest_recap where recap_id=?',[$idrecap]);
        return self::hydrate($select);
    }
    public static function getAllDonne(){
        $select=DB::select('select * from v_combined_full_info where etat=0 and id_etat=2');
        return self::hydrate($select);
    }
    public static function getCin($iddemande){
        $select=DB::select('select * from v_combined_full_info where etat=0 and id=?',[$iddemande]);
        return self::hydrate($select);
    }
    public static function gePoDaterecapCommande($idrecapcommande, $iddemandeclient)
    {
        // $select = DB::select('SELECT podate FROM recapcommande WHERE id=? and iddemandeclient=?', [$idrecapcommande, $iddemandeclient]);
        $select = DB::select('SELECT receptionbc FROM recapcommande WHERE id=? and iddemandeclient=?', [$idrecapcommande, $iddemandeclient]);

        return self::hydrate($select);
    }

    public static function getETDrecapCommande($idrecapcommande, $iddemandeclient)
    {
        $select = DB::select('SELECT
            CASE
                WHEN etdRevise IS NOT NULL AND etdPropose IS NULL THEN etdRevise
                WHEN etdRevise IS NOT NULL AND etdPropose IS NOT NULL THEN etdPropose
                ELSE NULL
            END AS etd
        FROM recapcommande
        WHERE id = ? AND idDemandeClient = ?', [$idrecapcommande, $iddemandeclient]);
        return self::hydrate($select);
    }
}
