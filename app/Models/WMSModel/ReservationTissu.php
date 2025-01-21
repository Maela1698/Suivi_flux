<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationTissu extends Model
{
    use HasFactory;

    protected $table = 'reservationtissu';

    protected $fillable = [
        'datereservation',
        'idstocktissu',
        'qtereserve',
        'commentaire',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'datereservation' => 'required|date',
            'idstocktissu' => 'required|numeric',
            'qtereserve' => 'required|numeric',
        ];
        // TODO: Custom validation messages
        $messages = [];

        return compact('rules', 'messages');
    }
}
