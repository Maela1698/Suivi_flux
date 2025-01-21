<?php

namespace App\Models\DATA_MACRO;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacroDetail extends Model
{
    use HasFactory;
    protected $table = 'macrocharge_details';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable =
    [
        'macrocharge2_id',
        'effectif',
        'efficience',
        'besoin_effectif',
    ];
}
