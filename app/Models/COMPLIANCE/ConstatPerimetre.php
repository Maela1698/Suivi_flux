<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConstatPerimetre extends Model
{
    use HasFactory;
    public function insertConstatPerimetre($dateconstat, $section_id, $priorite, $description,$typeaudit_id,$question)
    {
        DB::table('constat')->insert([
            'dateconstat' => $dateconstat,
            'section_id' => $section_id,
            'priorite' => $priorite,
            'description' => $description,
            'typeaudit_id' => $typeaudit_id,
            'question_id' => $question
        ]);
    }
    public function insertFichierConstatPerimetre($chemin, $constat_id,$question_id)
    {
        DB::table('fichier')->insert([
            'chemin' => $chemin,
            'constat_id' => $constat_id,
            'questionnaire_id' => $question_id
        ]);
    }
    public static function getAllConstatById($constat_id)
    {
        $select = DB::select('select * from vue_constats where constat_id=?',[$constat_id]);
        return self::hydrate($select);
    }
}
