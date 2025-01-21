<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkProdInitial extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'okprodinitial';
    protected $fillable = [
        'id_demande_client',
        'date_initial',
    ];
}
