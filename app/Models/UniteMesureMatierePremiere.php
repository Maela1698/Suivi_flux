<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UniteMesureMatierePremiere extends Model
{
    use HasFactory;

    protected $table = 'uniteMesureMatierePremiere';
    protected $fillable = [
        'unite_mesure',
        'etat',
    ];

    public static function getAllUniteMesureMP(){
        $select=DB::select('select * from uniteMesureMatierePremiere');
        return self::hydrate($select);
    }
}
