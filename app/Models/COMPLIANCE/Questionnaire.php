<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Questionnaire extends Model
{
    use HasFactory;
    protected $table = 'questionnaire';
    public $timestamps = false;
    protected $fillable = [
        'audit_id',
        'typeaudit_id',
        'question',
        'statut',
        'criticite',
        'procede_id',
        'axe_id',
        'observation',
        'score',
        'typeperimetre_id',
        'numero',
        'datequestion',
    ];
    public static function getAllSection()
    {
        $select = DB::select('select * from section ');
        return self::hydrate($select);
    }
    public static function getAllAxe()
    {
        $select = DB::select('select * from axe ');
        return self::hydrate($select);
    }
    public static function getAllTypePerimetre()
    {
        $select = DB::select('select * from typeperimetre ');
        return self::hydrate($select);
    }
    public static function getAllQuestionnaire()
    {
        $select = DB::select('select * from vue_questionnaires order by datequestion desc');
        return self::hydrate($select);
    }
    public static function getAllDepartement()
    {
        $select = DB::select('select * from departments order by departement_name asc');
        return self::hydrate($select);
    }
    public static function getAllQuestionnaireById($idquestion)
    {
        $select = DB::select('select * from vue_questionnaires where questionnaire_id=?',[$idquestion]);
        return self::hydrate($select);
    }
    public static function getAllConstatByIdConstats($idquestion)
    {
        $select = DB::select('select * from vue_constats where questionnaire_id=?',[$idquestion]);
        return self::hydrate($select);
    }
    public static function getAllTypePerimetreByIdDepartement($iddepartement)
    {
        $select = DB::select('select * from procede where departement_id=?',[$iddepartement]);
        return self::hydrate($select);
    }
}
