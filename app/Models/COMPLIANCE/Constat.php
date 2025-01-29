<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Constat extends Model
{
    use HasFactory;

    public function insertConstat($dateconstat, $section_id, $priorite, $description, $typeaudit_id)
    {
        DB::table('constat')->insert([
            'dateconstat' => $dateconstat,
            'section_id' => $section_id,
            'priorite' => $priorite,
            'description' => $description,
            'typeaudit_id' => $typeaudit_id
        ]);
    }

    public static function updateConstat($dateconstat,$priorite,$description,$id)
    {
        DB::select('update constat set dateconstat=? , priorite=?, description=?  where id=?', [$dateconstat,$priorite,$description,$id]);
    }
    public static function getLastConstat()
    {
        $select = DB::select('select * from constat order by id desc limit 1');
        return self::hydrate($select);
    }

    public function insertFichierConstat($chemin, $constat_id)
    {
        DB::table('fichier')->insert([
            'chemin' => $chemin,
            'constat_id' => $constat_id
        ]);
    }

    public function insertFichierAudit($chemin, $audit_id)
    {
        DB::table('fichier')->insert([
            'chemin' => $chemin,
            'audit_id' => $audit_id
        ]);
    }
    public static function updateFichierConstat($chemin,$constat_id)
    {
        DB::select('update fichier set chemin=?  where constat_id=?', [$chemin,$constat_id]);
    }

    public static function listeFichierByConstat($constat_id)
    {
        $select = DB::select('select * from fichier where constat_id=' . $constat_id);
        return self::hydrate($select);
    }

    public static function listeFichierByAudit($audit_id)
    {
        $select = DB::select('select * from fichier where audit_id=' . $audit_id);
        return self::hydrate($select);
    }


    public static function getConstatByTypeAudit($typeAudit,$condition)
    {
        $select = DB::select("select * from vue_constats where typeaudit_id =" . $typeAudit." ".$condition);
        return self::hydrate($select);
    }

    public static function getConstatById($id)
    {
        $select = DB::select('select * from vue_constats where constat_id =' . $id);
        return self::hydrate($select);
    }

    public static function getAllFichier()
    {
        $select = DB::select('select * from fichier');
        return self::hydrate($select);
    }
}
