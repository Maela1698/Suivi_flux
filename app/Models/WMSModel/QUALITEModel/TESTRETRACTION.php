<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TESTRETRACTION extends Model
{
    use HasFactory;
    protected $table = 'testretraction';

    protected $fillable = [
        'identreetissu',
        'datedebut',
        'datepreparation',
        'dateevaluation',
        'idlisteemploye',
        'idtypelavage',
        'tempsrelaxation',
        'observation',
        'passed',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'identreetissu' => 'required',
            'datedebut' => 'required|date',
            'datepreparation' => 'required|date',
            'dateevaluation' => 'required|date',
            'idlisteemploye' => 'nullable',
            'idtypelavage' => 'required',
            'tempsrelaxation' => 'required',
            'observation' => 'nullable',
            'passed' => 'required',

        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
