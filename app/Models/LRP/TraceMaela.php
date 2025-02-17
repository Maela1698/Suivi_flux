<?php

namespace App\Models\LRP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraceMaela extends Model
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