<?php

namespace App\Models\WMSModel\Consommable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client_StockConsommable extends Model
{
    use HasFactory;
    protected $table = 'client_stockconsommable';

    protected $fillable = [
        'idstockconsommable',
        'idclient',
        'modele',
    ];

    // Disable auto-incrementing ID behavior
    public $incrementing = false;

    // Disable timestamps
    public $timestamps = false;

    // If your primary key is composite (combination of identreetissu and idcellule), you can set them like this:
    protected $primaryKey = null;

    public static function getValidationRules($id = null)
    {
        $rules = [
            'idstockconsommable' => 'required|numeric',
            'idclient' => 'required|numeric',
            'modele' => 'required',
        ];

        $messages = [];

        return compact('rules', 'messages');
    }
}
