<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategorieTissus extends Model
{
    use HasFactory;

    protected $table = 'categorietissus';
    protected $fillable = [
        'categorie',
        'etat',
    ];

    public static function getAllCategorieTissu(){
        $select=DB::select('select * from categorieTissus');
        return self::hydrate($select);
    }
}
