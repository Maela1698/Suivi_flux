<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encre extends Model
{
    use HasFactory;
    protected $table = 'encre';
    protected $fillable = [
        'encre',
        'etat'
    ];
}
