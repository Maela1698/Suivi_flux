<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlanAction extends Model
{
    use HasFactory;

    public  function insertPlanAction($numero, $constat_id, $moyens, $datedebut,$priorite,$responsable_id,$deadline,$commentaires)
    {
        DB::table('planaction')->insert([
            'numero' => $numero,
            'constat_id' => $constat_id,
            'datedebut' => $datedebut,
            'moyens' => $moyens,
            'priorite' => $priorite,
            'responsable_id' => $responsable_id,
            'deadline' => $deadline,
            'commentaires' => $commentaires
        ]);
    }

    public static function getLastConstat()
    {
        $select = DB::select('select * from constat order by id desc');
        return self::hydrate($select);
    }

    public static function getListeEmployeByNomPrenom($nom)
    {
        $select = DB::select("select * from  v_listeemploye where nom ILIKE '%".$nom."%' or prenom ILIKE '%".$nom."%' order by id desc");
        return self::hydrate($select);
    }

    public static function listePlanAction($condition)
    {
        $select = DB::select("select * from vue_plans_action where 1=1 and audit_id is null".$condition);
        return self::hydrate($select);
    }

    public static function listePlanActionByConstat($idConstat)
    {
        $select = DB::select('select * from vue_plans_action where constat_id='.$idConstat);
        return self::hydrate($select);
    }

    public static function listePlanActionById($id)
    {
        $select = DB::select('select * from vue_plans_action where planaction_id='.$id);
        return self::hydrate($select);
    }


    public  function insertPlanActionExterne($numero, $audit_id, $moyens, $datedebut,$priorite,$responsable_id,$deadline,$commentaires)
    {
        DB::table('planaction')->insert([
            'numero' => $numero,
            'audit_id' => $audit_id,
            'datedebut' => $datedebut,
            'moyens' => $moyens,
            'priorite' => $priorite,
            'responsable_id' => $responsable_id,
            'deadline' => $deadline,
            'commentaires' => $commentaires
        ]);
    }

    public static function listePlanActionExterne($condition)
    {
        $select = DB::select('select * from vue_plans_action where audit_id is not null '.$condition);
        return self::hydrate($select);
    }

    public static function listePlanActionByAudit($idAudit)
    {
        $select = DB::select('select * from vue_plans_action where audit_id='.$idAudit);
        return self::hydrate($select);
    }


}
