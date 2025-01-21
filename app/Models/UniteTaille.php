<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniteTaille extends Model
{
    use HasFactory;
    protected $table = 'unitetaille';
    protected $fillable = [
        'unite_taille',
        'rang',
        'etat',
    ];
}
