<?php

namespace App\Models\WMSModel\WMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WMS_WMS_RETOUR extends Model
{
    use HasFactory;
    protected $table = 'wms_wms_retour';

    protected $fillable = [
        'identreewms',
        'idtyperetour',
        'quantite',
        'commentaire',
        'idstockwms',
        'prixunitaire',
        'date_retour',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'identreewms' => 'nullable',
            'idtyperetour' => 'required',
            'quantite' => 'required',
            'commentaire' => 'nullable',
            'idstockwms' => 'required',
            'prixunitaire' => 'nullable',
            'date_retour' => 'required',
        ];

        $messages = [];

        return compact('rules', 'messages');
    }
}
