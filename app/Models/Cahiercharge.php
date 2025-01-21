<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cahiercharge extends Model
{
    use HasFactory;
    protected $table = 'tierscahiercharge';
    public $timestamps = false;
    protected $fillable = [
        'idtiers',
        'cahiercharge',
        'etat',
    ];
}
