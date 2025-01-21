<?php

namespace App\Models\WMSModel\Consommable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockConsommable extends Model
{
    use HasFactory;
    protected $table = 'stockconsommable';
    protected $fillable = [
        'designation',
        'reference',
        'couleur',
        'idfournisseur',
        'saison',
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
