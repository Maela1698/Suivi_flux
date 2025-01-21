<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtatTiers extends Model
{
    use HasFactory;
    protected $table = 'etatTiers';
    protected $fillable = [
        'etatTiers',
        'etat',
    ];

    public static function getAllEtatTiers(){
        $select=DB::select('select * from etatTiers where etat=0');
        return self::hydrate($select);
    }
}
