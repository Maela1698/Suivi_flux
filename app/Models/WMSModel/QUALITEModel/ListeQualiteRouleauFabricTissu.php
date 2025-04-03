<?php

namespace App\Models\WMSModel\QUALITEModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListeQualiteRouleauFabricTissu extends Model
{
    use HasFactory;
    protected $table = 'listerouleaufabrictissu';

    protected $fillable = [
        'idqualiterouleautissu',
        'laizeutilisable',
        'metragereel',
        'longueurinspect',
        'poidsreel',
    ];


    // Disable timestamps
    public $timestamps = false;

    public static function getValidationRules($id = null)
    {
        $rules = [
            'idqualiterouleautissu' => 'required',
            'laizeutilisable' => 'required',
            'metragereel' => 'required',
            'longueurinspect' => 'required',
            'poidsreel' => 'required',
        ];
        // TODO: Custom error
        $messages = [];

        return compact('rules', 'messages');
    }
}
