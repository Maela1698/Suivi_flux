<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retour_Tissu extends Model
{
    use HasFactory;

    protected $table = 'retour_tissu';

    protected $fillable = [
        'idsortietissu',
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
            'idsortietissu' => 'required|numeric',
            'qteretour' => 'required|numeric',
            'dateretour' => 'required',
        ];

        $messages = [];

        return compact('rules', 'messages');
    }
}
