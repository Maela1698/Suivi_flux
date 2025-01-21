<?php

namespace App\Models\WMSModel\WMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WMS_TISSU_RETOUR extends Model
{
    use HasFactory;
    protected $table = 'wms_tissu_retour';

    protected $fillable = [
        'identreetissu',
        'idtyperetour',
        'quantite',
        'commentaire',
        'idstocktissu',
        'prixunitaire',
        'date_retour',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'identreetissu' => 'nullable',
            'idtyperetour' => 'required',
            'quantite' => 'required',
            'commentaire' => 'nullable',
            'idstocktissu' => 'required',
            'prixunitaire' => 'nullable',
            'date_retour' => 'required',
        ];

        $messages = [];

        return compact('rules', 'messages');
    }
}
