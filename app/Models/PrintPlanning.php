<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PrintPlanning extends Model
{
    use HasFactory;
    // Table associated with the model
    protected $table = 'print_planning';
    public $timestamps = false;
    // Fillable fields for mass assignment
    protected $fillable = [
        'iddemandeclient',
        'id_data_print',
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
    public static function getLastDataPrint(){
        $results = DB::select('select id from dataprint ORDER BY id DESC LIMIT 1');
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->id;
        }
        return $tiers;
    }
    public static function getMinDateInlinePrint(){
        $results=DB::select('select min(inline) as debut_inline from dataprint where inline is not null');
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->debut_inline;
        }
        return $tiers;
    }
    public static function getPrintPlanning(){
        $select=DB::select('select * from v_kanban_print_planing order by inlinechacun,iddemandeclient');
        return self::hydrate($select);
    }
    public static function getChargePrintPlaningByInline($inlinechac){
        $results=DB::select('select ROUND(CAST(COALESCE(SUM(charge),0) AS NUMERIC),2) as charge from print_planning where inlinechacun=?',[$inlinechac]);
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->charge;
        }
        return $tiers;
    }
    // public static function getSmvPrintById($demande_client_id){
    //     $results=DB::select('select COALESCE(smv_print,0) from parametreser where id_demande_client=?',[$demande_client_id]);
    //     $tiers = null;
    //     if (!empty($results)) {
    //         $tiers = $results[0]->smv_print;
    //     }
    //     return $tiers;
    // }
}
