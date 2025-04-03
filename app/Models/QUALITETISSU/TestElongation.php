<?php

namespace App\Models\QUALITETISSU;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TestElongation extends Model
{
    use HasFactory;

    public static function insertTestElongation($id_entree_tissu)
    {
        DB::table('testelongation')->insert([
            'id_entree_tissu' => $id_entree_tissu
        ]);
    }
    public static function updateTestElongation($id_entree_tissu,$date_elongation,$date_preparation,$date_evaluation,$id_employe,$id_type_lavage,$temps_relaxation,$observation,$passed)
    {
        DB::table('testelongation')
        ->where('id_entree_tissu', $id_entree_tissu)
        ->update([
            'date_elongation' =>$date_elongation,
            'date_preparation' => $date_preparation,
            'date_evaluation' => $date_evaluation,
            'id_employe' => $id_employe,
            'id_type_lavage' => $id_type_lavage,
            'temps_relaxation' => $temps_relaxation,
            'observation' => $observation,
            'passed' => $passed
        ]);
    }

    public static function nbTestElongation($id_entree_tissu)
    {
        $select = DB::select('select * from testelongation where id_entree_tissu=? ', [$id_entree_tissu]);
        return count($select);
    }

    public static function deleteTestElongation($id_entree_tissu){
        DB::select('delete from testelongation where id_entree_tissu='.$id_entree_tissu);
    }

    public static function listeTestElongation($id_entree_tissu)
    {
        $select = DB::select("select *from v_testelongation where id_entree_tissu =".$id_entree_tissu);
        return self::hydrate($select);
    }
}
