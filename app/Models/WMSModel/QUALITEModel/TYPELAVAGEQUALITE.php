<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TYPELAVAGEQUALITE extends Model
{
    use HasFactory;
    protected $table = 'typelavagequalitewms';
    protected $fillable = [
        'type',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'type' => 'required',
        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
