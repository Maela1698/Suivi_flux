<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Tracer extends Model
{
    use HasFactory;
    protected $table = 'dateprevisionfortrace'; // Nom de la table dans la BD
    public $timestamps = false;
    protected $fillable = [
        'id_demande_client',
        'datetrace',
        'etat'
    ];
    public static function insertPrevision($iddemande,$okprod,$tissu){
        $max = max(Carbon::parse($okprod), Carbon::parse($tissu));
        DB::insert('insert into dateprevisionfortrace (id_demande_client, datetrace) values (?, ?)', [$iddemande, $max]);
    }
    public static function updatePrevision($iddemande,$okprod,$tissu){
        $max = max(Carbon::parse($okprod), Carbon::parse($tissu));
        DB::update('UPDATE dateprevisionfortrace SET datetrace=? WHERE id_demande_client = ?',
        [$max, $iddemande]);
    }
    public static function updateOkProd($iddemande,$okprod,$tissu,$accy){
        DB::update('UPDATE okprodrecap SET okprod = ?, tissus = ?, accy = ? WHERE id_demande_client = ?',
        [$okprod, $tissu, $accy, $iddemande]);
    }

    public static function insertOkProdRecap($idrecap,$iddemande,$okprod,$tissu,$accy){
        DB::insert('insert into okprodrecap (id_recap,id_demande_client, okprod,tissus,accy) values (?,?, ?,?,?)', [$idrecap,$iddemande, $okprod,$tissu,$accy]);
    }
    public static function getPrevByIdDemande($iddemande){
        $select=DB::select('select * from okprodrecap where id_demande_client = ?', [$iddemande]);
        return self::hydrate($select);
    }

    public static function updateDatePrevisionTrace($datetrace, $etat, $id_demande_client)
    {
        DB::update('update dateprevisionfortrace set datetrace = ?, etat = ?  where id_demande_client = ?', [$datetrace, $etat, $id_demande_client]);
    }
}
