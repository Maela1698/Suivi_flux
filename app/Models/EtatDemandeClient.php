<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtatDemandeClient extends Model
{
    use HasFactory;

    protected $table = 'etatdemandeclient';
    protected $fillable = [
        'type_etat',
        'etat',
    ];
}
