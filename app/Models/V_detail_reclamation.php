<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class V_detail_reclamation extends Model
{
    use HasFactory;
    protected $table = 'v_detail_reclamation';
    protected $fillable = [
        'donne_bc_id',
        'donne_bc_id_detail',
        'donne_bc_designation',
        'donne_bc_laize',
        'donne_bc_utilisation',
        'donne_bc_couleur',
        'donne_bc_quantite',
        'donne_bc_unite',
        'donne_bc_prix_unitaire',
        'donne_bc_devise',
        'tissus_id',
        'tissus_designation',
        'tissus_couleur',
        'tissus_quantite',
        'tissus_prix_unitaire',
        'tissus_laize_utile',
        'accessoire_id',
        'accessoire_designation',
        'accessoire_couleur',
        'accessoire_quantite',
        'accessoire_prix_unitaire',
        'tiers_id',
        'nomtier',
        'pays',
        'ville',
        'numero_bc',
        'date_bc',
        'echeance',
        'etat_bc',
        'detail_id',
        'id_bc',
        'id_demande_client',
        'etat_detail',
        'dateconfirmation',
        'dateenvoie',
        'daterelance',
        'raison',
        'reclamation_quantite',
        'remarque',
        'retour',
        'recompensation',
        'note',
        'reclamation_unite',
        'total_quantite',
        'total_recompensation',
        'total_valeurreclame',
        'total_valeurcompense',
        'total_reste',
        'date_entree',
        'date_livraison',
        'nom_modele',
        'theme',
        'qte_commande_provisoire',
        'taille_base',
        'requete_client',
        'commentaire_merch',
        'etat',
        'id_unite_taille_min',
        'id_unite_taille_max',
        'client_nomtier',
        'nom_style',
        'type_incontern',
        'type_phase',
        'type_saison',
        'tailleMin',
        'tailleMax',
        'type_stade',
        'type_etat',
        'periode',
    ];
    public static function getHistoriqueById($iddonnebc){
        $select=DB::select('select * from reclamation where id_donne_bc =?',[$iddonnebc]);
        return self::hydrate($select);
    }
}
