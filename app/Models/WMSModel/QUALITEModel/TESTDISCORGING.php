<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TESTDISCORGING extends Model
{
    use HasFactory;
    protected $table = 'testdiscorging';

    protected $fillable = [
        'identreetissu',
        'datedebut',
        'datepreparation',
        'dateevaluation',
        'passed',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'identreetissu' => 'required|numeric',
            'datedebut' => 'required|date',
            'datepreparation' => 'required|date',
            'dateevaluation' => 'required|date',
            'passed' => 'required|numeric',

        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
