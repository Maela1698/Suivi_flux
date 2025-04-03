<?php

namespace App\Models\QUALITETISSU;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TestConformite extends Model
{
    use HasFactory;


    public function insertTestConformite($id_entree_tissu,$photo_conformite,$passed)
    {
        DB::table('testconformite')->insert([
            'id_entree_tissu' => $id_entree_tissu,
            'photo_conformite' => $photo_conformite,
            'passed' => $passed
        ]);
    }

    public static function updateConformite($photo_conformite, $passed, $date_conformite,$id_entree_tissu){
        DB::select('update testconformite set photo_conformite=?, passed=?, date_conformite=?  where id_entree_tissu=?',[$photo_conformite, $passed, $date_conformite,$id_entree_tissu]);
    }


    public static function deleteTestConformite($id_entree_tissu){
        DB::select('delete from testconformite where id_entree_tissu='.$id_entree_tissu);
    }

    public static function listeTestConformite($id_entree_tissu)
    {
        $select = DB::select("select *from testconformite where id_entree_tissu =".$id_entree_tissu);
        return self::hydrate($select);
    }

    public static function nbTestConformite($id_entree_tissu)
    {
        $select = DB::select('select * from testconformite where id_entree_tissu=? ', [$id_entree_tissu]);
        return count($select);
    }
}
