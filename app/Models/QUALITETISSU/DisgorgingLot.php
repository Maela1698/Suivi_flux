<?php

namespace App\Models\QUALITETISSU;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DisgorgingLot extends Model
{
    use HasFactory;

    public static function updateDisgorgingLot($id_entree_tissu,$lot,$image_disgorging,$type_frottement,$echelle_gris,$duree,$validation_test,$remarque)
    {
        DB::table('disgorginglot')
        ->where('id_entree_tissu', $id_entree_tissu)
        ->where('lot', $lot)
        ->update([
            'image_disgorging' => $image_disgorging,
            'type_frottement' => $type_frottement,
            'echelle_gris' => $echelle_gris,
            'duree' => $duree,
            'validation_test' => $validation_test,
            'remarque' => $remarque
        ]);
    }
    public function insertDisgorgingLot($id_entree_tissu,$lot)
    {
        DB::table('disgorginglot')->insert([
            'id_entree_tissu' => $id_entree_tissu,
            'lot' =>$lot
        ]);
    }



    public static function deleteDisgorgingLot($id_entree_tissu){
        DB::select('delete from disgorginglot where id_entree_tissu='.$id_entree_tissu);
    }

    public static function listeDisgorgingLot($id_entree_tissu)
    {
        $select = DB::select("select *from disgorginglot where id_entree_tissu =".$id_entree_tissu." order by id asc");
        return self::hydrate($select);
    }

    public static function nbDisgorgingLot($id_entree_tissu)
    {
        $select = DB::select('select * from disgorginglot where id_entree_tissu=? ', [$id_entree_tissu]);
        return count($select);
    }
}
