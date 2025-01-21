<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ResultatCalculRetro extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'resultatcalcule';
    protected $fillable = [
        'id_etape',
        'id_demande_client',
        'date_depart',
        'date_fin_prevue',
        'date_fin_reelle',
        'semaine',
        'annee',
        'etat',
        'etatupdate',
        'commentaires',
    ];

    public static function CalculeAllDate($iddemande)
    {
        $select=DB::select('select recalculate_dates(?)', [$iddemande]);
        return self::hydrate($select);
    }
}
