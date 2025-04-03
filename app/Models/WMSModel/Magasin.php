<?php

namespace App\Models\WMSModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magasin extends Model
{
    use HasFactory;

    protected $table = 'magasin';

    protected $fillable = ['id_donne_bc', 'datearrivereelle', 'bl', 'quantite', 'reste', 'numero'];

    public $timestamps = false;

    public static function getValidationRules($id = null)
    {
        $rules = [
            'id_donne_bc' => 'required|numeric',
            'datearrivereelle' => 'required|date',
            'bl' => 'required',
            'quantite' => 'required|numeric',
            'reste' => 'required|numeric',
            'numero' => 'required',
        ];

        $messages = [];

        return compact('rules', 'messages');
    }
}
