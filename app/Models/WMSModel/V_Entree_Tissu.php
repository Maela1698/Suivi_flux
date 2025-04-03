<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class V_Entree_Tissu extends Model
{
    use HasFactory;

    protected $table = 'v_entree_tissu';

    public static function listeEntreeTissuById($id_entree_tissu)
    {
        $select = DB::select("select *from v_entree_tissu where id =".$id_entree_tissu);
        return self::hydrate($select);
    }
}
