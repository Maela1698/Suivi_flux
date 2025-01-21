<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cellule_EntreeTissu extends Model
{
    use HasFactory;

    protected $table = 'cellule_entreetissu';

    protected $fillable = [
        'identreetissu',
        'idcellule',
    ];

    // Disable auto-incrementing ID behavior
    public $incrementing = false;

    // Disable timestamps
    public $timestamps = false;

    // If your primary key is composite (combination of identreetissu and idcellule), you can set them like this:
    protected $primaryKey = null; // No primary key or composite key
}
