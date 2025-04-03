<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'grammage',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'idfamilletissus' => 'required',
            'dateentree' => 'required|date',
            'datefacturation' => 'required|date',
            'idcategorietissus' => 'required',
            'idclassematierepremiere' => 'required',
            'idutilisationwms' => 'required',
            'numerobc' => 'required',
            'numerobl' => 'required',
            'numerofacture' => 'required',
            'idfournisseur' => 'required|numeric',
            'idclient' => 'required|numeric',
            'modele' => 'required',
            'saison' => 'required',
            'designation' => 'required',
            'composition' => 'required',
            'couleur' => 'required',
            'laize' => 'required',
            'qtecommande' => 'required|numeric|min:1',
            'idunitemesurematierepremiere' => 'required|numeric',
            'qterecu' => 'required|numeric',
            'nbrouleau' => 'required|numeric',
            'nblot' => 'required|numeric',
            'prixunitaire' => 'required|numeric',
            'idunitemonetaire' => 'required|numeric',
            'grammage' => 'nullable',
        ];
        $messages = [];

        return compact('rules', 'messages');
    }

    public static function insertCelluleEntree($identreetissu,$idcellule)
    {
        return DB::table('cellule_entreetissu')->insert([
            'identreetissu' => $identreetissu,
            'idcellule' => $idcellule
        ]);
    }

    public static function getEntreeTissuByStock($idstocktissu)
    {
        $select = DB::select("select id from entreetissu e where idstocktissu =".$idstocktissu);
        return self::hydrate($select);
    }
}
