<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TESTNUANCE extends Model
{
    use HasFactory;
    protected $table = 'testnuance';

    protected $fillable = [
        'datedebut',
        'dateexecution',
        'identreetissu',
        'endroit',
        'commentaire',
        'passed',
        'nuance',
        'envers',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'datedebut' => 'required|date',
            'dateexecution' => 'required|date',
            'identreetissu' => 'required|numeric',
            'endroit' => 'required',
            'commentaire' => 'nullable',
            'passed' => 'required|numeric',
            'nuance' => 'required|numeric',
            'envers' => 'required',

        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
