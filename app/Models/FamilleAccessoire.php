<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FamilleAccessoire extends Model
{
    use HasFactory;
    protected $table = 'familleaccessoire';
    protected $fillable = [
        'famille_accessoire',
        'etat',
    ];

    public static function getAllFamilleAccessoire(){
        $select=DB::select('select * from familleaccessoire where etat=0');
        return self::hydrate($select);
    }
}
