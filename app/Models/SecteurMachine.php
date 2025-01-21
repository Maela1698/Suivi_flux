<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SecteurMachine extends Model
{
    use HasFactory;
    protected $table = 'secteurmachine';
    public $timestamps = false;
    protected $fillable = [
        'idlocalisationmachine',
        'secteur',
        'etat'
    ];

    // dans SecteurMachine
    public static function findAllSecteur()
    {
        $select = DB::select('select * from secteurmachine');
        return self::hydrate($select);
    }
    public static function findMachineSecteurJointure($idmachine)
    {
        $details_jointure_secteur = DB::select('select * from v_localisation_secteur_machine where id_machine=? ORDER BY date_affectation_machine DESC LIMIT 1', [$idmachine]);
        return self::hydrate($details_jointure_secteur);
    }
}
