<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpruntMachine extends Model
{
    use HasFactory;
    protected $table = 'empruntmachine';
    public $timestamps = false;
    protected $fillable = [
        'idmachine',
        'datefincontrat',
        'cout_prestation',
        // 'idunitemonetaire',
    ];
}
