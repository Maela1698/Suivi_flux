<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTissu_Tiers_Modele extends Model
{
    use HasFactory;

    protected $table = 'stocktissu_tiers_modele';

    protected $fillable = [
        'idstocktissu',
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
            'idstocktissu' => 'required|numeric',
            'idclient' => 'required|numeric',
            'modele' => 'required',
        ];

        $messages = [];

        return compact('rules', 'messages');
    }
}
