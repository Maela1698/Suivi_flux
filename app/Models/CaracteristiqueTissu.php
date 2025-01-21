<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CaracteristiqueTissu extends Model
{
    use HasFactory;
    protected $table = 'caracteristiquetissu';
    protected $fillable = [
        'caracteristique',
        'pointDev',
        'etat',
    ];

    public static function getAllCaracteristiqueTissu(){
        $select=DB::select('select * from caracteristiquetissu where etat=0');
        return self::hydrate($select);
    }
}
