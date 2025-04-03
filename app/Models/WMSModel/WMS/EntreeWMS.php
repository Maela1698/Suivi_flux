<?php

namespace App\Models\WMSModel\WMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class EntreeWMS extends Model
{
    use HasFactory;
    protected $table = 'entreewms';

    protected $fillable = [
        'dateentree',
        'code',
        'numbc',
        'numbl',
        'numerofacture',
        'idfournisseur',
        'idclient',
        'idstockwms',
        'saison',
        'designation',
        'reference',
        'couleur',
        'modele',
        'qtecommande',
        'idclassematierepremiere',
        'idfamillewms',
        'idunitemesurematierepremiere',
        'qteentree',
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
            'numerofacture' => 'nullable',
            'idfournisseur' => 'required|numeric',
            'idclient' => 'required|numeric',
            'idstockwms' => 'nullable|numeric',
            'saison' => 'required',
            'designation' => 'required',
            'reference' => 'required',
            'couleur' => 'required',
            'modele' => 'required',
            'qtecommande' => 'required|numeric',
            'idclassematierepremiere' => 'required|numeric',
            'idfamillewms' => 'required|numeric',
            'idunitemesurematierepremiere' => 'required',
            'qteentree' => 'required|numeric',
            'resterecevoir' => 'required|numeric',
            'prixunitaire' => 'required|numeric',
            'idunitemonetaire' => 'required',
            'fret' => 'nullable',
            'commentaire' => 'nullable',
            'code' => 'nullable',
            'image' => 'nullable',
            'datefacturation' => 'required',
        ];
        $messages = [];

        return compact('rules', 'messages');
    }

    public static function getEntreeWMSByStock($idstockwms)
    {
        $select = DB::select('select * from entreewms where idstockwms='.$idstockwms);
        return self::hydrate($select);
    }

}
