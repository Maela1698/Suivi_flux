<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTissu extends Model
{
    use HasFactory;

    protected $table = 'stocktissu';

    protected $fillable = [
        'idcategorietissus',
        'idclassematierepremiere',
        'idutilisationwms',
        'reference',
        'designation',
        'composition',
        'couleur',
        'idfournisseur',
        'saison',
        'laize',
        'qtestock',
        'prixunitaire',
        'idunitemesurematierepremiere',
        'idfamilletissus',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'idcategorietissus' => 'required|numeric',
            'idclassematierepremiere' => 'required|numeric',
            'idutilisationwms' => 'required|numeric',
            'reference' => 'required',
            'designation' => 'required',
            'composition' => 'required',
            'couleur' => 'required',
            'idfournisseur' => 'required|numeric',
            'saison' => 'required',
            'laize' => 'required|numeric',
            'qtestock' => 'required|numeric',
            'prixunitaire' => 'required|numeric',
            'idunitemesurematierepremiere' => 'required|numeric',
            'idfamilletissus' => 'required|numeric',
        ];

        $messages = [
        ];

        return compact('rules', 'messages');
    }
}
