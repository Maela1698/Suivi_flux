<?php

namespace App\Models\QUALITETISSU;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShadeTestRouleau extends Model
{
    use HasFactory;

    public  function insertShadeTestRouleau($idqualiterouleau)
    {
        DB::table('shadetestrouleau')->insert([
            'idqualiterouleau' => $idqualiterouleau
        ]);
    }
    public static function updateShadeTestRouleau($idqualiterouleau,$photo_shade)
    {
        DB::table('shadetestrouleau')
        ->where('idqualiterouleau', $idqualiterouleau)
        ->update([
            'photo_shade' =>$photo_shade
        ]);
    }

    public static function deleteShadeTestRouleau($id_entree_tissu){
        DB::select('delete from shadetestrouleau where id_entree_tissu='.$id_entree_tissu);
    }

    public static function listeShadeTestRouleau($id_entree_tissu)
    {
        $select = DB::select("select *from v_shadeTestRouleau where identreetissu =".$id_entree_tissu." order by id asc");
        return self::hydrate($select);
    }
}
