<?php

namespace App\Models\WMSModel\Consommable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntreeConsommable extends Model
{
    use HasFactory;
    protected $table = 'entreeconsommable';

    protected $fillable = [
        'dateentree',
        'numbc',
        'numbl',
        'idfournisseur',
        'idclient',
        'saison',
        'designation',
        'reference',
        'couleur',
        'modele',
        'qtecommande',
        'idunitemesurematierepremiere',
        'qterecu',
        'resterecevoir',
        'prixunitaire',
        'idunitemonetaire',
        'fret',
        'commentaire',
        'image',
        'idstockconsommable',
        'datefacturation',

    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'dateentree' => 'required',
            'numbc' => 'required',
            'numbl' => 'required',
            'idfournisseur' => 'required|numeric',
            'idclient' => 'required|numeric',
            'saison' => 'required',
            'designation' => 'required',
            'reference' => 'required',
            'couleur' => 'required',
            'modele' => 'required',
            'qtecommande' => 'required|numeric',
            'idunitemesurematierepremiere' => 'required',
            'qterecu' => 'required|numeric',
            'resterecevoir' => 'required|numeric',
            'prixunitaire' => 'required|numeric',
            'idunitemonetaire' => 'required',
            'fret' => 'nullable',
            'commentaire' => 'nullable',
            'image' => 'nullable',
            'idstockconsommable' => 'nullable',
            'datefacturation' => 'required',
        ];
        $messages = [];

        return compact('rules', 'messages');
    }
}
