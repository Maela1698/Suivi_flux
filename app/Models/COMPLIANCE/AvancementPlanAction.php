<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AvancementPlanAction extends Model
{
    use HasFactory;

    public  function insertAvancementPlanAction($planaction_id, $dateavancement, $designation, $avancement)
    {
        DB::table('avancementplanaction')->insert([
            'planaction_id' => $planaction_id,
            'dateavancement' => $dateavancement,
            'designation' => $designation,
            'avancement' => $avancement
        ]);
    }


    public static function getLastAvancement($idPlanAction)
    {
        $select = DB::select("select * from avancementplanaction where planaction_id=".$idPlanAction." order by id desc");
        return self::hydrate($select);
    }

}
