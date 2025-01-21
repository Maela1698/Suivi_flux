<?php

namespace App\Models\WMSModel\WMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilleWMS extends Model
{
    use HasFactory;
    protected $table = 'famillewms';

    protected $fillable = [
        'idwms_type',
        'nom',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'idwms_type' => 'required',
            'nom' => 'required',
        ];

        $messages = [];

        return compact('rules', 'messages');
    }
}
