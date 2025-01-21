<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incontern extends Model
{
    use HasFactory;
    protected $table = 'incontern';
    protected $fillable = [
        'type_incontern',
        'etat',
    ];

    public static function getAllIncontern(){
        $select=DB::select('select * from incontern where etat =0');
        return self::hydrate($select);
    }
}
