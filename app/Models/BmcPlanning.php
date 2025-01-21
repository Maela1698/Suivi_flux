<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BmcPlanning extends Model
{
    use HasFactory;
    // Table associated with the model
    protected $table = 'bmc_planning';
    public $timestamps = false;
    // Fillable fields for mass assignment
    protected $fillable = [
        'iddemandeclient',
        'id_data_bmc',
        'inlinechacun',
        'capacitetheorique',
        'capacitereel',
        'capacite_par_jour',
        'qtereel',
        'charge',
        'etat',
    ];
    public static function getLastDataBmc(){
        $results = DB::select('select id from databrodmachine ORDER BY id DESC LIMIT 1');
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->id;
        }
        return $tiers;
    }
    public static function getMinDateInlineBmc(){
        $results=DB::select('select min(inline) as debut_inline from databrodmachine where inline is not null');
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->debut_inline;
        }
        return $tiers;
    }
    public static function getBmcPlanning(){
        $select=DB::select('select * from v_kanban_bmc_planing order by inlinechacun,iddemandeclient');
        return self::hydrate($select);
    }
    public static function getChargeBmcPlaningByInline($inlinechac){
        $results=DB::select('select COALESCE(SUM(charge),0) as charge from bmc_planning where inlinechacun=?',[$inlinechac]);
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->charge;
        }
        return $tiers;
    }

}
