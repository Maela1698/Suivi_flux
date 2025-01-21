<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    use HasFactory;
    protected $table = 'style';
    protected $fillable = [
        'nom_style',
        'pointdev',
        'etat',
    ];

    public static function getStyleById($id)
    {
        $select = DB::select('select * from style where id=' . $id);
        return self::hydrate($select);
    }

}
