<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Objet extends Model
{
    use HasFactory;


    public static $prefixe;
    public static $nomSequence;

    protected $fillable = [
        'prefixe',
        'nomSequence'
    ];

    public function generateId(){
        $nextVal = DB::select("SELECT nextval(?)", [static::$nomSequence])[0]->nextval;
        return static::$prefixe . str_pad($nextVal, 7, '0', STR_PAD_LEFT);
    }
}