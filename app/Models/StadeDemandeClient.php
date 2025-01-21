<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StadeDemandeClient extends Model
{
    use HasFactory;
    protected $table = 'stadedemandeclient';
    protected $fillable = [
        'type_stade',
        'etat',
    ];

    

}
