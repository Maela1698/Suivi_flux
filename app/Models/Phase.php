<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;
    protected $table = 'phase';
    protected $fillable = [
        'type_phase',
        'etat',
    ];

    public static function getAllPhase(){
        $select=DB::select('select * from phase where etat =0');
        return self::hydrate($select);
    }
}
