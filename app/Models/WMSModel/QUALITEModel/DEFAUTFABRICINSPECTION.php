<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DEFAUTFABRICINSPECTION extends Model
{
    use HasFactory;
    protected $table = 'defautfabricinspection';

    protected $fillable = [
        'idqualiterouleautissu',
        'image',
        'metrage',
        'defaut',
        'defectpoint',
        'demeritpoint',
        'sonnette',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'idqualiterouleautissu' => 'required',
            'image' => 'required',
            'metrage' => 'required',
            'defaut' => 'required',
            'defectpoint' => 'required',
            'demeritpoint' => 'required',
            'sonnette' => 'required',
        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
