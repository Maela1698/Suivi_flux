<?php

namespace App\Models\LRP\TRACE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trace extends Model
{
    use HasFactory;

    protected $table = 'dateprevisionfortrace';

    protected $fillable = [
        'id',
        'id_demande_client',
        'datetrace',
        'etat'
       
    ];

    public $timestamps = false;
}
