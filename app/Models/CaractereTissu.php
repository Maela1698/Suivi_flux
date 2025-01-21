<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CaractereTissu extends Model
{
    use HasFactory;
    protected $table = 'caracteretissu';
    protected $fillable = [
        'id_caracteristique_tissu',
        'id_tissu'
    ];

    public static function getAllCaractereTissu(){
        $select=DB::select('select * from caracteretissu');
        return self::hydrate($select);
    }

    public function insertCaractereTissu($id_caracteristique_tissu, $id_tissu)
    {
        DB::table('caracteretissu')->insert([
            'id_caracteristique_tissu' => $id_caracteristique_tissu,
            'id_tissu' => $id_tissu
        ]);
    }

    public static function deleteCaractereTissuByTissu($id)
    {
        DB::delete('DELETE FROM caracteretissu WHERE id_tissu = ?', [$id]);
    }

}
