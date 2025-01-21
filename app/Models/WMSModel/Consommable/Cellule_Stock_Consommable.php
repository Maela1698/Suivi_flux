<?php

namespace App\Models\WMSModel\Consommable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cellule_Stock_Consommable extends Model
{
    use HasFactory;
    protected $table = 'cellule_stockconsommable';

    protected $fillable = [
        'idstockconsommable',
        'idcellule',
    ];

    // Disable auto-incrementing ID behavior
    public $incrementing = false;

    // Disable timestamps
    public $timestamps = false;

    // If your primary key is composite (combination of identreetissu and idcellule), you can set them like this:
    protected $primaryKey = null; // No primary key or composite key
}
