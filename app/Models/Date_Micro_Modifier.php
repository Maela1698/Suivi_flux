<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date_Micro_Modifier extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'datemodifiermicro';
    protected $fillable = [
        'id_etape',
        'id_demande_client',
        'date_depart',
    ];
}
