<?php

namespace App\Models\WMSModel\WMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationWMS extends Model
{
    use HasFactory;
    protected $table = 'reservationwms';

    protected $fillable = [
        'datereservation',
        'idstockwms',
        'qtereserve',
        'commentaire',
    ];

    public $timestamps = false; //disable timestamps

    public static function getValidationRules($id = null)
    {
        $rules = [
            'datereservation' => 'required|date',
            'idstockwms' => 'required|numeric',
            'qtereserve' => 'required|numeric',
        ];
        // TODO: Custom validation messages
        $messages = [];

        return compact('rules', 'messages');
    }
}
