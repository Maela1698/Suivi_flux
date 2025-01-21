<?php

namespace App\Models\WMSModel\WMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntreeWMS_Cellule extends Model
{
    use HasFactory;
    protected $table = 'entreewms_cellule';

    protected $fillable = [
        'identreewms',
        'idcellule',
    ];

    // Disable auto-incrementing ID behavior
    public $incrementing = false;

    // Disable timestamps
    public $timestamps = false;

    // If your primary key is composite (combination of identreetissu and idcellule), you can set them like this:
    protected $primaryKey = null; // No primary key or composite key
}
