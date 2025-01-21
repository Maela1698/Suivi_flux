<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualiteTiers extends Model
{
    use HasFactory;
    protected $table = 'qualiteTiers';
    protected $fillable = [
        'qualite',
        'etat',
    ];

    public static function getAllQualiteTiers(){
        $select=DB::select('select * from qualiteTiers where etat=0');
        return self::hydrate($select);
    }
}
