<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Norme extends Model
{
    use HasFactory;

    public static function listeNorme()
    {
        $select = DB::select('select * from norme order by id desc');
        return self::hydrate($select);
    }
}
