<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QUALITEROULEAUTISSU_TESTNUANCE extends Model
{
    use HasFactory;
    protected $table = 'qualiterouleautissu_testnuance';

    protected $fillable = [
        'idqualiterouleautissu',
        'image',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'idqualiterouleautissu' => 'required|numeric',
            'image' => 'required',

        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
