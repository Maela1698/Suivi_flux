<?php

namespace App\Models\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualiteRouleauTissu extends Model
{
    use HasFactory;

    protected $table = 'qualiterouleautissu';

    protected $fillable = [
        'identreetissu',
        'reference',
        'lot',
        'laize',
        'metrage',
        'poids',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [

            'identreetissu' => 'required|numeric',
            'reference' => 'required',
            'lot' => 'required|numeric',
            'laize' => 'required|numeric',
            'metrage' => 'required|numeric',
            'poids' => 'required|numeric',
        ];
        // TODO: Custom error
        $messages = [

        ];

        return compact('rules', 'messages');
    }
}
