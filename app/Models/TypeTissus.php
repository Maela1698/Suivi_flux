<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TypeTissus extends Model
{
    use HasFactory;


    protected $table = 'typetissus';
    protected $fillable = [
        'type_tissus',
        'etat',
    ];

    public static function getAllTypeTissu(){
        $select=DB::select('select * from typeTissus');
        return self::hydrate($select);
    }


}
