<?php

namespace App\Models\WMSModel\WMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SortieWMS extends Model
{
    use HasFactory;
    protected $table = 'sortiewms';

    protected $fillable = [
        'datesortie',
        'numbci',
        'idfamillewms',
        'qtesortie',
        'receveur',
        'destinataire',
        'prixunitaire',
        'commentaire',
        'idstockwms',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'datesortie' => 'required|date',
            'numbci' => 'required',
            'idfamillewms' => 'required|numeric',
            'qtesortie' => 'required|numeric',
            'receveur' => 'required',
            'destinataire' => 'required',
            'prixunitaire' => 'required|numeric',
            'idstockwms' => 'required|numeric',
        ];
        $messages = [];

        return compact('rules', 'messages');
    }
}
