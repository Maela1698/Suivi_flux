<?php

namespace App\Models\MES;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VListeOF extends Model
{
    use HasFactory;
    protected $table = 'v_liste_of';
    public $timestamps = false;
    protected $fillable = [
        'recap_id',
        'iddemandeclient',
        'numerocommande',
        'nomtier',
        'nom_style',
        'nom_modele',
        'qteof'
    ];
}
