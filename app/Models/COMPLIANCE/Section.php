<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Section extends Model
{
    use HasFactory;

    public static function getAllSection()
    {
        $select = DB::select('select * from section where etat=0 ');
        return self::hydrate($select);
    }

}
