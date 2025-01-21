<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DispositionMatierePremiere extends Model
{
    use HasFactory;
    protected $table = 'dispositionMatierePremiere';
    protected $fillable = [
        'disposition',
        'etat',
    ];

    public static function getAllDispoMP(){
        $select=DB::select('select * from dispositionMatierePremiere where etat=0');
        return self::hydrate($select);
    }
}
