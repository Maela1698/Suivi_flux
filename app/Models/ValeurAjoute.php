<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValeurAjoute extends Model
{
    use HasFactory;
    protected $table = 'valeurajoutee';
    protected $fillable = [
        'type_valeur_ajoutee',
        'etat',
    ];

    public static function getAllValeurAjoute(){
        $select=DB::select('select * from valeurAjoutee where etat =0');
        return self::hydrate($select);
    }
    public static function insertValeurAjoute($idDemande,$idValeur){
        DB::insert('insert into valeurAjouteeDemande values(default,?,?,?)',[$idDemande,$idValeur,0]);
    }
    public static function getAllValeurDemandeById($idDemande){
        $select=DB::select('select * from v_valeurAjouteeDemande where etat=0 and id_demande_client=?',[$idDemande]);
        return self::hydrate($select);
    }
    public static function deleteValeurAjouteByDemande($id)
    {
        DB::delete('DELETE FROM valeurajouteedemande WHERE id_demande_client = ?', [$id]);
    }


}
