<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocalisationMachine extends Model
{
    use HasFactory;
    protected $table = 'localisationmachine';
    public $timestamps = false;
    protected $fillable = [
        'localisation',
        'etat'
    ];

    // dans LocalisationMachine
    public static function findAllLocalisation()
    {
        $select = DB::select('select * from localisationmachine where etat=0');
        return self::hydrate($select);
    }
    public static function insertLocalisation($localisation)
    {
        return DB::insert('insert into localisationmachine (localisation) values (?)', [$localisation]);
    }

    public static function affecterSecteurMachine($idsecteurmachine, $idlistemachine, $date_affectation_machine, $commentaire)
    {
        return DB::insert(
            'insert into join_secteur_machine
            (idsecteurmachine,idlistemachine,date_affectation_machine,commentaire)
            values (?,?,?,?)',
            [
                $idsecteurmachine,
                $idlistemachine,
                $date_affectation_machine,
                $commentaire
            ]
        );
    }
}
