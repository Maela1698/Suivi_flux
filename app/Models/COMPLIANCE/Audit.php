<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Audit extends Model
{
    use HasFactory;

    public function insertAudit($dateaudit, $section_id, $reference_nc, $description, $typeaudit_id,$norme_id)
    {
        DB::table('audit')->insert([
            'dateaudit' => $dateaudit,
            'section_id' => $section_id,
            'reference_nc' => $reference_nc,
            'description' => $description,
            'typeaudit_id' => $typeaudit_id,
            'norme_id' => $norme_id
        ]);
    }

    public static function getListeAudit($condition)
    {
        $select = DB::select('select * from vue_audits where 1=1 '.$condition);
        return self::hydrate($select);
    }

    public static function getListeAuditById($idAudit)
    {
        $select = DB::select('select * from vue_audits where audit_id='.$idAudit);
        return self::hydrate($select);
    }

    public static function getLastAudit()
    {
        $select = DB::select('select * from audit order by id desc limit 1');
        return self::hydrate($select);
    }

}
