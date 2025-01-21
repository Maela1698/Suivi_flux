<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Periode extends Model
{
    use HasFactory;
    protected $table = 'periode';
    protected $fillable = [
        'periode',
        'etat',
    ];

    public static function getAllPeriode(){
        $select=DB::select('select * from periode where etat=0');
        return self::hydrate($select);
    }
}
