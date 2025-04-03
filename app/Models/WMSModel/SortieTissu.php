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
        'receveur',
        'destinataire',
        'prixunitaire',
        'commentaire',
        'idstocktissu',
        'obsolete',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'datesortie' => 'required|date',
            'numbci' => 'required',
            'idfamilletissus' => 'required|numeric',
            'qtesortie' => 'required|numeric',
            'receveur' => 'required',
            'destinataire' => 'required',
            'prixunitaire' => 'required|numeric',
            'idstocktissu' => 'required|numeric',
            'obsolete' => 'required|numeric',
        ];
        $messages = [];

        return compact('rules', 'messages');
    }
}
