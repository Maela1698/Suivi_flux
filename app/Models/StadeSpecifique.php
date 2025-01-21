<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StadeSpecifique extends Model
{
    use HasFactory;
    protected $table = 'stadespecifique';

    protected $fillable = [
        'idstademasterplan',
        'designation',
        'niveau',
        'etat'
    ];
}
