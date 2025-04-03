<?php

namespace App\Models\QUALITETISSU;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Disgorging extends Model
{
    use HasFactory;

    public static function updateDisgorging($id_entree_tissu,$date_disgorging,$date_preparation,$date_evaluation,$passed)
    {
        DB::table('disgorging')
        ->where('id_entree_tissu', $id_entree_tissu)
        ->update([
            'date_disgorging' =>$date_disgorging,
            'date_preparation' => $date_preparation,
            'date_evaluation' => $date_evaluation,
            'passed' => $passed
        ]);
    }
    public function insertDisgorging($id_entree_tissu)
    {
        DB::table('disgorging')->insert([
            'id_entree_tissu' => $id_entree_tissu
        ]);
    }

    public static function nbDisgorging($id_entree_tissu)
    {
        $select = DB::select('select * from disgorging where id_entree_tissu=? ', [$id_entree_tissu]);
        return count($select);
    }
    public static function deleteDisgorging($id_entree_tissu){
        DB::select('delete from disgorging where id_entree_tissu='.$id_entree_tissu);
    }

    public static function listeDisgorging($id_entree_tissu)
    {
        $select = DB::select("select *from disgorging where id_entree_tissu =".$id_entree_tissu);
        return self::hydrate($select);
    }
}
