<?php

namespace App\Models\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestConformiteTissu extends Model
{
    use HasFactory;

    protected $table = 'testconformitetissu';

    protected $fillable = [
        'identreetissu',
        'datedebut',
        'lab_dip',
        'swatch',
        'qtecde',
        'qterecupl',
        'laizecde',
        'observation',
        'qtecdekg',
        'qterecuplkg',
        'laizerecuepl',
        'passed',
        'conformite',

    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [

            'identreetissu' => 'required|numeric',
            'datedebut' => 'required',
            'lab_dip' => 'required',
            'swatch' => 'required',
            'qtecde' => 'required',
            'qterecupl' => 'required',
            'laizecde' => 'required',
            'qtecdekg' => 'required',
            'qterecuplkg' => 'required',
            'laizerecuepl' => 'required',
            'passed' => 'required',
            'conformite' => 'required',
        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
