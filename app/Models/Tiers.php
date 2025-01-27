<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiers extends Model
{
    use HasFactory;
    protected $table = 'tiers';
    public $timestamps = false;

    protected $fillable = [

        'id','nomtier', 'idacteur', 'adresse', 'ville', 'codepostal',
        'idpays', 'numphone', 'emailtier', 'website', 'idunite',
        'idqualite', 'idetat', 'merchsenior', 'contactmerchsenior',
        'emailmerchsenior', 'merchjunior', 'contactmerchjunior',
        'emailmerchjunior', 'assistant', 'contactassistant',
        'emailassistant', 'idutilisateur', 'logo', 'dateentree',
        'etat'
    ];

    public static function getLastIdTier(){
            $results = DB::select('select id from tiers ORDER BY id DESC LIMIT 1');
            $tiers = null;
            if (!empty($results)) {
                $tiers = $results[0]->id;
            }
            return $tiers;
    }
    public static function insertIntelocateur($idtiers,$nomInterlocateur,$emailInterlocateur,$contactInterlocateur){
        DB::insert('insert into tiersInterlocateur values(default,?,?,?,?,?)',[$idtiers,$nomInterlocateur,$emailInterlocateur,$contactInterlocateur,0]);
    }
    public static function deleteById($id)
    {
        DB::delete('DELETE FROM tiersInterlocateur WHERE idtiers = ?', [$id]);
    }


    public static function getAllTiers(){
        $select=DB::select('select * from v_tiers where etat=0');
        return self::hydrate($select);
    }
    public static function getAllTiersById($id){
        $select=DB::select('select * from v_tiers where etat=0 and id=?',[$id]);
        return self::hydrate($select);
    }


    public static function getAllTierByIdTier($id){
        $select=DB::select('select * from tiers where etat=0 and id=?',[$id]);
        return self::hydrate($select);
    }




    public static function getCountTier($filters = [])
    {
    $query = DB::table('tiers')->where('etat', 0);
    $columns = ['nomtier', 'emailtier', 'adresse', 'ville', 'numphone', 'website'];

    if (isset($filters['idTiers']) && $filters['idTiers']) {
        $query->where('id', $filters['idTiers']);
    }

    if (isset($filters['idPays']) && $filters['idPays']) {
        $query->where('idpays', $filters['idPays']);
    }

    if (isset($filters['idEtat']) && $filters['idEtat']) {
        $query->where('idetat', $filters['idEtat']);
    }

    if (isset($filters['idActeur']) && $filters['idActeur']) {
        $query->where('idacteur', $filters['idActeur']);
    }

    if (isset($filters['autre']) && $filters['autre']) {
        $searchTerm = $filters['autre'];
        $query->where(function($query) use ($columns, $searchTerm) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
            }
        });
    }

    if (isset($filters['start']) && isset($filters['end']) && $filters['start'] && $filters['end']) {
        $query->whereBetween('dateentree', [$filters['start'], $filters['end']]);
    }

        $total = $query->count();
        return $total;
    }

    public static function getCountClient($filters = [])
    {
        $query = DB::table('tiers')->where('idacteur', 1)->where('etat', 0);
        $columns = ['nomtier', 'emailtier', 'adresse', 'ville', 'numphone', 'website'];

        if (isset($filters['idTiers']) && $filters['idTiers']) {
            $query->where('id', $filters['idTiers']);
        }

        if (isset($filters['idPays']) && $filters['idPays']) {
            $query->where('idpays', $filters['idPays']);
        }

        if (isset($filters['idEtat']) && $filters['idEtat']) {
            $query->where('idetat', $filters['idEtat']);
        }

        if (isset($filters['idActeur']) && $filters['idActeur']) {
            $query->where('idacteur', $filters['idActeur']);
        }

        if (isset($filters['autre']) && $filters['autre']) {
            $searchTerm = $filters['autre'];
            $query->where(function($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }

        if (isset($filters['start']) && isset($filters['end']) && $filters['start'] && $filters['end']) {
            $query->whereBetween('dateentree', [$filters['start'], $filters['end']]);
        }

        $total = $query->count();
        return $total;
    }

    public static function getCountFournisseur($filters = [])
    {
        $query = DB::table('tiers')->where('idacteur', 2)->where('etat', 0);
        $columns = ['nomtier', 'emailtier', 'adresse', 'ville', 'numphone', 'website'];

        if (isset($filters['idTiers']) && $filters['idTiers']) {
            $query->where('id', $filters['idTiers']);
        }

        if (isset($filters['idPays']) && $filters['idPays']) {
            $query->where('idpays', $filters['idPays']);
        }

        if (isset($filters['idEtat']) && $filters['idEtat']) {
            $query->where('idetat', $filters['idEtat']);
        }

        if (isset($filters['idActeur']) && $filters['idActeur']) {
            $query->where('idacteur', $filters['idActeur']);
        }

        if (isset($filters['autre']) && $filters['autre']) {
            $searchTerm = $filters['autre'];
            $query->where(function($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }

        if (isset($filters['start']) && isset($filters['end']) && $filters['start'] && $filters['end']) {
            $query->whereBetween('dateentree', [$filters['start'], $filters['end']]);
        }

        $total = $query->count();
        return $total;
    }

    public static function getCountProspect($filters = [])
    {
        $query = DB::table('tiers')->where('idacteur', 3)->where('etat', 0);
        $columns = ['nomtier', 'emailtier', 'adresse', 'ville', 'numphone', 'website'];

        if (isset($filters['idTiers']) && $filters['idTiers']) {
            $query->where('id', $filters['idTiers']);
        }

        if (isset($filters['idPays']) && $filters['idPays']) {
            $query->where('idpays', $filters['idPays']);
        }

        if (isset($filters['idEtat']) && $filters['idEtat']) {
            $query->where('idetat', $filters['idEtat']);
        }

        if (isset($filters['idActeur']) && $filters['idActeur']) {
            $query->where('idacteur', $filters['idActeur']);
        }

        if (isset($filters['autre']) && $filters['autre']) {
            $searchTerm = $filters['autre'];
            $query->where(function($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }

        if (isset($filters['start']) && isset($filters['end']) && $filters['start'] && $filters['end']) {
            $query->whereBetween('dateentree', [$filters['start'], $filters['end']]);
        }

        $total = $query->count();
        return $total;
    }




    public static function getDetailTierById($id){
        $select=DB::select('select * from v_detailTier where id =?',[$id]);
        return self::hydrate($select);
    }
    public static function getCahierChargeById($id) {
        $select = DB::select('SELECT * FROM tiersCahierCharge WHERE idtiers = ?', [$id]);
        return self::hydrate($select);
    }

    public static function getInterlocateurById($id) {
        $select = DB::select('SELECT * FROM tiersInterlocateur WHERE idTiers = ?', [$id]);
        return self::hydrate($select);
    }
    public static function deleteTier($idTier){
        DB::update('update tiers set etat=? where id=?',[1,$idTier]);
    }
    public static function updatePhoto($photo,$idTier){
        DB::update('update tiers set logo=? where id=?',[$photo,$idTier]);
    }


    public static function getAllTiersByIdActeur(){
        $select=DB::select('select * from tiers where etat=0 and idActeur=2');
        return self::hydrate($select);
    }


    // Sarobidy
    public static function getMerchSeniorName()
    {
        $select = DB::select('select merchsenior from tiers');
        return self::hydrate($select);
    }

    // Sarobidy



    public static function getAllClientTiersByIdActeur()
    {
        $select = DB::select('select * from tiers where etat=0 and idActeur=1');
        return self::hydrate($select);
    }


}
