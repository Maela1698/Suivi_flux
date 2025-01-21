<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class INSPECTIONACCESSOIRE extends Model
{
    use HasFactory;
    protected $table = 'inspectionaccessoire';

    protected $fillable = [
        'identreewms',
        'datedebut',
        'datefin',
        'packtotal',
        'aql',
        'pourcentageinspect',
        'packtotalselect',
        'totaldefect',
        'majordefect',
        'minordefect',
        'pourcentagedefect',
        'image',
        'passed',
        'idwmsqualitycorrectiveaction',
        'commentaire',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'identreewms' => 'required',
            'datedebut' => 'required',
            'datefin' => 'nullable',
            'packtotal' => 'required',
            'aql' => 'required',
            'pourcentageinspect' => 'required',
            'packtotalselect' => 'required',
            'totaldefect' => 'required',
            'majordefect' => 'required',
            'minordefect' => 'required',
            'pourcentagedefect' => 'required',
            'image' => 'required',
            'passed' => 'required',
            'idwmsqualitycorrectiveaction' => 'required',
            'commentaire' => 'nullable',

        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
