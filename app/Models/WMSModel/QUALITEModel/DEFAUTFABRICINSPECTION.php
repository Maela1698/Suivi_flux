<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DEFAUTFABRICINSPECTION extends Model
{
    use HasFactory;
    protected $table = 'defautfabricinspection';

    protected $fillable = [
        'idqualiterouleautissu',
        'image',
        'metrage',
        'iddefectfabrictype',
        'defectpoint',
        'demeritpoint',
        'sonnette',
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
            'idqualiterouleautissu' => 'required',
            'image' => 'required',
            'metrage' => 'required',
            'iddefectfabrictype' => 'required',
            'defectpoint' => 'required',
            'demeritpoint' => 'required',
            'sonnette' => 'required',
        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
