<?php

namespace App\Models\WMSModel\WMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetourWMS extends Model
{
    use HasFactory;
    protected $table = 'retour_wms';

    protected $fillable = [
        'idsortiewms',
        'qteretour',
        'dateretour',
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
            'idsortiewms' => 'required|numeric',
            'qteretour' => 'required|numeric',
            'dateretour' => 'required',
        ];

        $messages = [];

        return compact('rules', 'messages');
    }
}
