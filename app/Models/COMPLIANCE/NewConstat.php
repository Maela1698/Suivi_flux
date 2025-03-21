<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewConstat extends Model
{
    use HasFactory;

    protected $table = 'constat';

    public $timestamps = false;

    protected $fillable = [
        'dateconstat',
        'section_id',
        'priorite',
        'description',
        'typeaudit_id',
        'action',
        'deadline',
        'avancement',
        'numero',
    ];
}
