<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BmPlanning extends Model
{
    use HasFactory;
    // Table associated with the model
    protected $table = 'bm_planning';
    public $timestamps = false;
    // Fillable fields for mass assignment
    protected $fillable = [
        'iddemandeclient',
        'id_data_bm',
        'inlinechacun',
        'capacitetheorique',
        'capacitereel',
        'effectif',
        'efficience',
        'heuretravail',
        'qtereel',
        'charge',
        'etat',
    ];
    public static function getLastDataBm(){
        $results = DB::select('select id from databrodmain ORDER BY id DESC LIMIT 1');
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->id;
        }
        return $tiers;
    }
    public static function getMinDateInlineBm(){
        $results=DB::select('select min(inline) as debut_inline from databrodmain    where inline is not null');
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->debut_inline;
        }
        return $tiers;
    }
    public static function getBmPlanning(){
        $select=DB::select('select * from v_kanban_bm_planing order by inlinechacun,iddemandeclient');
        return self::hydrate($select);
    }
    public static function getChargeBmPlaningByInline($inlinechac){
        $results=DB::select('select ROUND(CAST(COALESCE(SUM(charge),0) AS NUMERIC),2) as charge from bm_planning where inlinechacun=?',[$inlinechac]);
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->charge;
        }
        return $tiers;
    }

}
