<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntreeCT extends Model
{
    use HasFactory;

    protected $table = 'entreect';

    protected $fillable = [
        'dateentree',
        'datefacturation',
        'idcategorietissus',
        'idclassematierepremiere',
        'idutilisationwms',
        'iddonnebc',
        'numerobc',
        'numerobl',
        'numerofacture',
        'fournisseur',
        'client',
        'modele',
        'saison',
        'designation',
        'reftissu',
        'composition',
        'couleur',
        'laize',
        'qtecommande',
        'idunitemesurematierepremiere',
        'qterecu',
        'tauxecart',
        'nbrouleau',
        'nblot',
        'prixunitaire',
        'idunitemonetaire',
        'resterecevoir',
        'idcellule',
        'fret',
        'image',
        'commentaire',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'dateentree' => 'required',
            'datefacturation' => 'required',
            'idcategorietissus' => 'required',
            'idclassematierepremiere' => 'required',
            'idutilisationwms' => 'required',
            'numerobc' => 'required',
            'numerobl' => 'required',
            'numerofacture' => 'required',
            'fournisseur' => 'required',
            'client' => 'required',
            'modele' => 'required',
            'saison' => 'required',
            'designation' => 'required',
            'reftissu' => 'required',
            'composition' => 'required',
            'couleur' => 'required',
            'laize' => 'required',
            'qtecommande' => 'required',
            'idunitemesurematierepremiere' => 'required',
            'qterecu' => 'required',
            'nbrouleau' => 'required',
            'nblot' => 'required',
            'prixunitaire' => 'required',
            'idunitemonetaire' => 'required',
            'idcellule' => 'required',
            'fret' => 'required',
        ];
        $messages = [];

        return compact('rules', 'messages');
    }
}
