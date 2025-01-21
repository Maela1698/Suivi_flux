<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QUALITEROULEAUTISSU_TESTDISCORGING extends Model
{
    use HasFactory;
    protected $table = 'qualiterouleautissu_testdiscorging';

    protected $fillable = [
        'idqualiterouleautissu',
        'typefrottement',
        'echellegris',
        'duree',
        'validationtest',
        'remarque',
        'image',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'idqualiterouleautissu' => 'required|numeric',
            'typefrottement' => 'required',
            'echellegris' => 'required|numeric',
            'duree' => 'required|numeric',
            'validationtest' => 'required|numeric',
            'remarque' => 'nullable',
            'image' => 'required',
        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
