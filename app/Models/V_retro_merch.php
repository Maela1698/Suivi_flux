<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_retro_merch extends Model
{
    use HasFactory;
    protected $table = 'v_micro_merch';
    public $timestamps = false;

    protected $fillable = [
        'resultat_id',
        'id_etape',
        'id_demande_client',
        'datecalcul',
        'resultat_etat',
        'etape_designation',
        'etape_nbjour',
        'etape_stade',
        'etape_etat',
        'sdc_id',
        'sdc_date_entree',
        'sdc_date_envoie',
        'sdc_quantite',
        'sdc_etat',
        'demande_id',
        'demande_date_entree',
        'demande_date_livraison',
        'nom_modele',
        'theme',
        'qte_commande_provisoire',
        'taille_base',
        'requete_client',
        'commentaire_merch',
        'demande_etat',
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
        'total_qte_detailsdc',
        'micro_semaine',
        'micro_realisation',
        'micro_commentaires',
        'micro_etat',
    ];
}
