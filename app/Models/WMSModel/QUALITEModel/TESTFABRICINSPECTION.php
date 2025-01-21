<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TESTFABRICINSPECTION extends Model
{
    use HasFactory;
    protected $table = 'testfabricinspection';

    protected $fillable = [
        'identreetissu',
        'datedebut',
        'idlisteemploye',
        'sens',
        'numtissu',
        'idspeedmachine',
        'idchoixqualite',
        'longueur',
        'passed',
        'grammage',
        'tolerance',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'identreetissu' => 'required',
            'datedebut' => 'required',
            'idlisteemploye' => 'nullable',
            'sens' => 'required',
            'numtissu' => 'required',
            'idspeedmachine' => 'required',
            'idchoixqualite' => 'required',
            'longueur' => 'required',
            'passed' => 'required',
            'grammage' => 'required',
            'tolerance' => 'required',

        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
