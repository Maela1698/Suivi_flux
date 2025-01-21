<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilisationWMS extends Model
{
    use HasFactory;

    protected $table = 'utilisationwms';

    protected $fillable = [
        'utilisation',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'utilisation' => 'required',
        ];

        $messages = [
            'utilisation' => 'S\'il vous plait remplissez ce champ',
        ];

        return compact('rules', 'messages');
    }
}
