<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class V_Rack_Cellule extends Model
{
    use HasFactory;

    protected $table = 'v_rack_cellule';

    public static function listeV_Rack_Cellule()
    {
        $select = DB::select('select * from v_rack_cellule');
        return self::hydrate($select);
    }
}
