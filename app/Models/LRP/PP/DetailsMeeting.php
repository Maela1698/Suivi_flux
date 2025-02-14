<?php

namespace App\Models\LRP\PP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsMeeting extends Model{
    use HasFactory;

    protected $table = 'details_meeting';

    protected $fillable = [
        'id',
        'id_meeting',
        'heure_debut',
        'effectif_prevu',
        'effectif_reel',
        'id_demande',
        'commentaire',
        'etat',
        'id_chaine',
        'date_entree_chaine',
        'date_entree_coupe',
        'date_entree_finition'
    ];

    public $timestamps = false;
}