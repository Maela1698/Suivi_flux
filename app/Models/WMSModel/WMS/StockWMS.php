<?php

namespace App\Models\WMSModel\WMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockWMS extends Model
{
    use HasFactory;
    protected $table = 'stockwms';
    protected $fillable = [
        'designation',
        'reference',
        'couleur',
        'idfournisseur',
        'saison',
        'idclassematierepremiere',
        'idfamillewms',
        'qtestock',
        'prixunitaire',
        'idunitemesurematierepremiere',
        'commentaire',
        'image',
        'etat',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'designation' => 'required',
            'reference' => 'required',
            'couleur' => 'required',
            'idfournisseur' => 'required',
            'saison' => 'required',
            'idclassematierepremiere' => 'required|numeric',
            'idfamillewms' => 'required|numeric',
            'qtestock' => 'required',
            'prixunitaire' => 'required',
            'idunitemesurematierepremiere' => 'required',
            'commentaire' => 'nullable',
            'image' => 'nullable',
        ];

        $messages = [];

        return compact('rules', 'messages');
    }
}
