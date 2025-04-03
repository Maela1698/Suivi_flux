<?php

namespace App\Models\QUALITETISSU;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ElongationRouleau extends Model
{
    use HasFactory;

    public static function insertElongationRouleau($id_rouleau)
    {
        DB::table('elongationrouleau')->insert([
            'id_rouleau' => $id_rouleau
        ]);
    }
    public static function updateElongationRouleau($id_rouleau,$elongation_long,$elongation_laize,$retrait_long,$retrait_laize,$retrait_angulaire)
    {
        DB::table('elongationrouleau')
        ->where('id_rouleau', $id_rouleau)
        ->update([
            'elongation_long' => $elongation_long,
            'elongation_laize' => $elongation_laize,
            'retrait_long' => $retrait_long,
            'retrait_laize' => $retrait_laize,
            'retrait_angulaire' => $retrait_angulaire
        ]);
    }

    public static function deleteElongationRouleau($id_entree_tissu){
        DB::select('delete from elongationrouleau where id_entree_tissu='.$id_entree_tissu);
    }

    public static function listeElongationRouleau($id_entree_tissu)
    {
        $select = DB::select("select *from v_elongationrouleau where identreetissu =".$id_entree_tissu);
        return self::hydrate($select);
    }

    public static function nbElongation($id_entree_tissu)
    {
        $select = DB::select('select * from elongationrouleau where id_entree_tissu=? ', [$id_entree_tissu]);
        return count($select);
    }

}
