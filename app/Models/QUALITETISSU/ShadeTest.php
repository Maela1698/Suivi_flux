<?php

namespace App\Models\QUALITETISSU;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShadeTest extends Model
{
    use HasFactory;

    public static function updateShadeTest($id_entree_tissu,$date_shade,$date_execution,$endroit,$passed,$nuance,$observation)
    {
        DB::table('shadetest')
        ->where('id_entree_tissu', $id_entree_tissu)
        ->update([
            'date_shade' =>$date_shade,
            'date_execution' => $date_execution,
            'endroit' => $endroit,
            'passed' => $passed,
            'nuance' => $nuance,
            'observation' => $observation
        ]);
    }

    public static function insertShadeTest($id_entree_tissu)
    {
        DB::table('shadetest')
        ->insert([
            'id_entree_tissu' =>$id_entree_tissu
        ]);
    }

    public static function nbShadeTest($id_entree_tissu)
    {
        $select = DB::select('select * from shadetest where id_entree_tissu=? ', [$id_entree_tissu]);
        return count($select);
    }

    public static function deleteShadeTest($id_entree_tissu){
        DB::select('delete from shadetest where id_entree_tissu='.$id_entree_tissu);
    }

    public static function listeShadeTest($id_entree_tissu)
    {
        $select = DB::select("select *from shadetest where id_entree_tissu =".$id_entree_tissu);
        return self::hydrate($select);
    }
}
