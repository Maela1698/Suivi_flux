<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LeadTime extends Model
{
    use HasFactory;

    protected $table = 'leadtime';
    protected $fillable = [
        'id',
        'designation',
        'leadtime',
        'etat'
    ];

    public static function getMatierePremiereValeur()
    {
        $mp = DB::select('select leadtime from leadtime where id=1');
        return self::hydrate($mp);
    }

    public static function getEchantillonValeur()
    {
        $echantillon = DB::select('select leadtime from leadtime where id=2');
        return self::hydrate($echantillon);
    }

    public static function getProductionValeur()
    {
        $prod = DB::select('select leadtime from leadtime where id=3');
        return self::hydrate($prod);
    }
}
