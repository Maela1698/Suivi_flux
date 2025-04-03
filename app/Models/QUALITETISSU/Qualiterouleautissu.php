<?php

namespace App\Models\QUALITETISSU;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Qualiterouleautissu extends Model
{
    use HasFactory;

    public static function getQualiteRouleauTissuByEntreeTissu($identreetissu)
    {
        $select = DB::select('select * from qualiterouleautissu where identreetissu='.$identreetissu." order by id asc");
        return self::hydrate($select);
    }

    public static function listeEmployeQualiteMagasin()
    {
        $select = DB::select("select *from v_listeemploye l where designationfonction ilike '%qualite magasin%'");
        return self::hydrate($select);
    }

    public static function listeLavage()
    {
        $select = DB::select("select *from lavage");
        return self::hydrate($select);
    }

    public static function listeLotRouleau($identreetissu)
    {
        $select = DB::select("select distinct (lot) as lot from qualiterouleautissu  where identreetissu =".$identreetissu);
        return self::hydrate($select);
    }

    public static function nbQualiteRouleau($id_entree_tissu)
    {
        $select = DB::select('select * from qualiterouleautissu where identreetissu=? ', [$id_entree_tissu]);
        return count($select);
    }




}
