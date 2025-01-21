<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QUALITEROULEAUTISSU_TESTRETRACTION extends Model
{
    use HasFactory;
    protected $table = 'qualiterouleautissu_testretraction';

    protected $fillable = [
        'idqualiterouleautissu',
        'longueurelong',
        'laizeelong',
        'longueurretrait',
        'laizeretrait',
        'ecartretrait',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'idqualiterouleautissu' => 'required',
            'longueurelong' => 'required|numeric',
            'laizeelong' => 'required|numeric',
            'longueurretrait' => 'required|numeric',
            'laizeretrait' => 'required|numeric',
            'ecartretrait' => 'required|numeric',

        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
