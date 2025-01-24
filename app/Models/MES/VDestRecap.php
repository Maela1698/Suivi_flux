<?php

namespace App\Models\MES;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VDestRecap extends Model
{
    use HasFactory;
    protected $table = 'v_dest_recap';
    public $timestamps = false;
    protected $fillable = [
        'recap_id',
        'iddemandeclient',
        'etdrevise',
        'etdpropose',
        'receptionbc',
        'bcclient',
        'date_bc_tissu',
        'date_bc_access',
        'recap_etat',
        'destination_id',
        'numerocommande',
        'etdinitial',
        'datelivraisonexacte',
        'dateinspection',
        'qteof',
        'destination_etat',
        'deststd_id',
        'deststd_designation',
        'unite_taille',
        'unitetailleid',
        'nomtier',
        'id_tiers',
        'nom_modele',
        'nom_style',
        'id_style'
    ];
}