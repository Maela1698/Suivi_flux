<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CompositionTissus extends Model
{
    use HasFactory;


    protected $table = 'compositiontissus';
    protected $fillable = [
        'composition_tissus',
        'etat',
    ];

    public static function getAllCompositionTissu(){
        $select=DB::select('select * from compositionTissus');
        return self::hydrate($select);
    }
}
