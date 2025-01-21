<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActeurTier extends Model
{
    use HasFactory;
    protected $table = 'acteurTiers';
    protected $fillable = [
        'acteur',
        'etat',
    ];

    public static function getAllActeurTier(){
        $select=DB::select('select * from acteurTiers where etat =0');
        return self::hydrate($select);
    }
}
