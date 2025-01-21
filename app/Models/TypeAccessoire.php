<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TypeAccessoire extends Model
{
    use HasFactory;
    protected $table = 'typeaccessoire';
    protected $fillable = [
        'type_accessoire',
        'etat',
    ];

    public static function getAllTypeAccessoire(){
        $select=DB::select('select * from typeaccessoire');
        return self::hydrate($select);
    }
}
