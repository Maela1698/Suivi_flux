<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntreeTissu extends Model
{
    use HasFactory;

    protected $table = 'entreetissu';

    protected $fillable = [
        'idfamilletissus',
        'dateentree',
        'datefacturation',
        'idcategorietissus',
        'idclassematierepremiere',
        'idutilisationwms',
        'iddonnebc',
        'numerobc',
        'numerobl',
        'numerofacture',
        'idfournisseur',
        'idclient',
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
        'fret',
        'image',
        'commentaire',
        'idstocktissu',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'idfamilletissus' => 'required',
            'dateentree' => 'required',
            'datefacturation' => 'required',
            'idcategorietissus' => 'required',
            'idclassematierepremiere' => 'required',
            'idutilisationwms' => 'required',
            'numerobc' => 'required',
            'numerobl' => 'required',
            'numerofacture' => 'required',
            'idfournisseur' => 'required',
            'idclient' => 'required',
            'modele' => 'required',
            'saison' => 'required',
            'designation' => 'required',
            'reftissu' => 'required',
            'composition' => 'required',
            'couleur' => 'required',
            'laize' => 'required',
            'qtecommande' => 'required|min:1',
            'idunitemesurematierepremiere' => 'required',
            'qterecu' => 'required',
            'nbrouleau' => 'required',
            'nblot' => 'required',
            'prixunitaire' => 'required',
            'idunitemonetaire' => 'required',
            'fret' => 'required',
        ];
        $messages = [

        ];

        return compact('rules', 'messages');
    }
}
