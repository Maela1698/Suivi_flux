<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_donne_bc extends Model
{
    use HasFactory;
    protected $table = 'v_donne_bc';
    protected $fillable = [
        'id_donne_bc',
        'designation',
        'laize',
        'utilisation',
        'couleur',
        'quantite',
        'unite',
        'prix_unitaire',
        'prix_total',
        'devise',
        'etat',
        'numerobc',
        'categorie',
        'des_tissus',
        'ref_tissus',
        'composition_tissus',
        'famille_accessoire',
        'des_accessoire',
        'ref_accessoire',
        'nom_modele',
        'theme',
        'date_livraison',
        'type_saison',
        'client',
        'fournisseur',
        'id_tiers',
        'idPays',
        'pays',
        'bcid',
        'date_bc',
        'echeance',
        'type_bc',
        'idtypebc',
        'dateex',
        'deadline',
        'transport',
        'dateemmission',
        'numerofacture',
        'montant',
        'detailfacture',
        'commentaire',
        'transit',
        'transittime',
        'datedepart',
        'datearrive',
        'awb',
        'datearrivereelle',
        'bl',
        'magasin_quantite',
        'reste',
        'numero',
        'dateenvoie',
        'daterelance',
        'raison',
        'reclamation_quantite',
        'remarque',
        'retour',
        'recompensation',
        'note',
        'swift',
        'deposit',
        'pri',
        'payer'
    ];

}
