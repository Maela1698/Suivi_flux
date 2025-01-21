<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cellule extends Model
{
    use HasFactory;

    protected $table = 'cellule';

    protected $fillable = [
        'designation',
        'idrack',
        'largeur',
        'longueur',
        'hauteur',
        'idclassematierepremiere',
        'commentaire',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'idrack' => 'required|numeric',
            'designation' => 'required',
            'largeur' => 'required|numeric',
            'longueur' => 'required|numeric',
            'hauteur' => 'required|numeric',
            'idclassematierepremiere' => 'required|numeric',
        ];

        $messages = [
            'idrack' => 'S\'il vous plait remplissez ce champ',
            'designation' => 'S\'il vous plait remplissez ce champ',
            'largeur' => 'S\'il vous plait remplissez ce champ',
            'longueur' => 'S\'il vous plait remplissez ce champ',
            'hauteur' => 'S\'il vous plait remplissez ce champ',
            'idclassematierepremiere' => 'S\'il vous plait remplissez ce champ',
        ];

        return compact('rules', 'messages');
    }
}
