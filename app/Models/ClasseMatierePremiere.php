<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClasseMatierePremiere extends Model
{
    use HasFactory;


    protected $table = 'classeMatierePremiere';
    protected $fillable = [
        'classe',
        'etat',
    ];

    public static function getAllClasseMP(){
        $select=DB::select('select * from classeMatierePremiere');
        return self::hydrate($select);
    }
}
