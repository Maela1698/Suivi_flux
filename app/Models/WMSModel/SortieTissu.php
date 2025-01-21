<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SortieTissu extends Model
{
    use HasFactory;

    protected $table = 'sortietissu';

    protected $fillable = [
        'datesortie',
        'numbci',
        'idfamilletissus',
        'qtesortie',
        'designation',
        'reference',
        'modele',
        'saison',
        'receveur',
        'destinataire',
        'idcategorietissus',
        'idclassematierepremiere',
        'idunitemesurematierepremiere',
        'idutilisationwms',
        'idfournisseur',
        'idclient',
        'composition',
        'couleur',
        'laize',
        'prixunitaire',
        'commentaire',
        'idstocktissu',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'datesortie' => 'required|date',
            'numbci' => 'required',
            'idfamilletissus' => 'required|numeric',
            'qtesortie' => 'required|numeric',
            'designation' => 'required',
            'reference' => 'required',
            'modele' => 'required',
            'saison' => 'required',
            'receveur' => 'required',
            'destinataire' => 'required',
            'idcategorietissus' => 'required|numeric',
            'idclassematierepremiere' => 'required|numeric',
            'idutilisationwms' => 'required|numeric',
            'idfournisseur' => 'required|numeric',
            'idclient' => 'required|numeric',
            'composition' => 'required',
            'couleur' => 'required',
            'laize' => 'required',
            'idunitemesurematierepremiere' => 'required|numeric',
            'prixunitaire' => 'required|numeric',
            'idstocktissu' => 'required|numeric',
        ];
        $messages = [

        ];

        return compact('rules', 'messages');
    }
}
