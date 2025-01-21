<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    use HasFactory;

    protected $table = 'rack';

    protected $fillable = [
        'idsectionwms',
        'designation',
        'largeur',
        'longueur',
        'hauteur',
        'commentaire',
        'idcategorietissu',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'idsectionwms' => 'required|numeric',
            'designation' => 'required',
            'largeur' => 'required|numeric',
            'longueur' => 'required|numeric',
            'hauteur' => 'required|numeric',
            'idcategorietissu' => 'required|numeric',
        ];

        $messages = [
            'idsectionwms' => 'S\'il vous plait remplissez ce champ',
            'designation' => 'S\'il vous plait remplissez ce champ',
            'largeur' => 'S\'il vous plait remplissez ce champ',
            'longueur' => 'S\'il vous plait remplissez ce champ',
            'hauteur' => 'S\'il vous plait remplissez ce champ',
            'idcategorietissus' => 'S\'il vous plait remplissez ce champ',
        ];

        return compact('rules', 'messages');
    }
}
