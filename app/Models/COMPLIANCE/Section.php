<?php

namespace App\Models\COMPLIANCE;

use GuzzleHttp\Promise\Create;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Section extends Model{
    use HasFactory;

    protected $table = 'section';

    public $timestamps = false;

    public static function getAllSection()
    {
        $select = DB::select('select * from section where etat=0 ');
        return self::hydrate($select);
    }

    public function addSection($nom_section) {
        $this->designation = $nom_section;
        $this->save();
    }
}
