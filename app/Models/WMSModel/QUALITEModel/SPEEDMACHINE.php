<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPEEDMACHINE extends Model
{
    use HasFactory;
    protected $table = 'speedmachine';

    protected $fillable = [
        'speed',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'speed' => 'required',
        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
