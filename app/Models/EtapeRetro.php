<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtapeRetro extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'etaperetromerch';

    protected $fillable = [
        'designation',
        'nbJour',
        'etat',
    ];
}
