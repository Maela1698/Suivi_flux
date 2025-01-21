<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VMacro extends Model
{
    use HasFactory;
    protected $table = 'v_macrocharge_combine';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable =
    [
        'id',
        'id_type_macro',
        'type_macro',
        'macrocharge2_id',
        'mois',
        'annee',
        'jourouvrable',
        'absence',
        'heuretravail',
        'heuresup',
        'effectif_macro',
        'efficience_macro',
        'besoin_effectif',
        'etat',
    ];
}
