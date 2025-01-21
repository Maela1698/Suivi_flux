<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiltreDemande extends Model
{
    use HasFactory;
    protected $table = 'v_demandeclient';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'date_entree',
        'date_livraison',
        'nom_modele',
        'theme',
        'qte_commande_provisoire',
        'taille_base',
        'requete_client',
        'commentaire_merch',
        'photo_commande',
        'etat',
        'id_unite_taille_min',
        'id_unite_taille_max',
        'nomtier',
        'id_tiers',
        'nom_style',
        'id_style',
        'type_incontern',
        'id_incontern',
        'type_phase',
        'id_phase',
        'type_saison',
        'id_saison',
        'tailleMin',
        'tailleMax',
        'type_stade',
        'id_stade',
        'type_etat',
        'id_etat',
    ];
}
