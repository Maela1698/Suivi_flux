<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FamilleTissus extends Model
{
    use HasFactory;


    protected $table = 'familletissus';
    protected $fillable = [
        'famille_tissus',
        'etat',
    ];

    public static function getAllFamilleTissu(){
        $select=DB::select('select * from familleTissus');
        return self::hydrate($select);
    }
}
