<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lavage extends Model
{
    use HasFactory;
    protected $table = 'lavage';
    protected $fillable = [
        'type_lavage',
        'etat',
    ];

    public static function getAllLavage(){
        $select=DB::select('select * from lavage where etat =0');
        return self::hydrate($select);
    }
    public static function insertLavageDemande($idDemande,$idLavage){
        DB::insert('insert into lavageDemandeClient values(default,?,?,?)',[$idDemande,$idLavage,0]);
    }
    public static function getAllLavageDemandeById($idDemande){
        $select=DB::select('select * from v_lavageDemandeClient where etat=0 and id_demande_client=?',[$idDemande]);
        return self::hydrate($select);
    }
    public static function deleteLavageByDemande($id)
    {
        DB::delete('DELETE FROM lavagedemandeclient WHERE id_demande_client = ?', [$id]);
    }


}
