<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saison extends Model
{
    use HasFactory;
    protected $table = 'saison';
    protected $fillable = [
        'type_saison',
        'etat',
    ];

}
