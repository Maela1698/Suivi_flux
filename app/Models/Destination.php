<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Destination extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'destination';

    protected $fillable = [
        'idrecapcommande',
        'numerocommande',
        'etdinitial',
        'datelivraisonexacte',
        'dateinspection',
        'qteof',
        'iddeststd',
        'etat',
    ];
    public static function getETDdestination($iddestination, $idrecapcommande)
    {
        $select = DB::select('SELECT etdinitial FROM destination WHERE id=? and idrecapcommande=?', [$iddestination, $idrecapcommande]);
        return self::hydrate($select);
    }
}
