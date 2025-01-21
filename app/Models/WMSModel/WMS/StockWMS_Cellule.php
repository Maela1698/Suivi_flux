<?php

namespace App\Models\WMSModel\WMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockWMS_Cellule extends Model
{
    use HasFactory;
    protected $table = 'stockwms_cellule';

    protected $fillable = [
        'idstockwms',
        'idcellule',
    ];

    // Disable auto-incrementing ID behavior
    public $incrementing = false;

    // Disable timestamps
    public $timestamps = false;
}
