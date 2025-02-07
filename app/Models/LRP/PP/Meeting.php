<?php

namespace App\Models\LRP\PP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $table = 'test_meeting';

    protected $fillable = [
        'titre',
        'date',
        'heure_debut',
        'nbr_prs',
        'id',
    ];

    public $timestamps = false;
}
