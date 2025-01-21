<?php

namespace App\Models\WMSModel\WMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_wms extends Model
{
    use HasFactory;
    protected $table = 'wms_type';

    protected $fillable = [
        'type',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'type' => 'required',
        ];

        $messages = [
            'type.required' => 'S\'il vous plait remplissez ce champ',
        ];

        return compact('rules', 'messages');
    }
}
