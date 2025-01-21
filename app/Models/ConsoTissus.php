<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConsoTissus extends Model
{
    use HasFactory;

    protected $table = 'consotissus';
    protected $fillable = [
        'id' , 'id_tissus' , 'conso_tissus' , 'efficience_tissus' , 'etat', 'id_demande_client'
    ];

    public static function getAllConsoTissuByTissu(){
        $select=DB::select('select * from consotissus where etat=0 order by id desc');
        return self::hydrate($select);
    }

    public static function getAllConsoTissuByDC($idDC){
        $select=DB::select('select * from consotissus where etat=0 and id_demande_client='.$idDC);
        return self::hydrate($select);
    }

    public function insertConsoTissu($id_tissus,$conso,$eff,$idDC)
    {
        DB::table($this->table)->insert([
            'id_tissus' => $id_tissus,
            'conso_tissus' => $conso,
            'efficience_tissus' => $eff,
            'id_demande_client' => $idDC,
            'etat' => 0
        ]);
    }


    public static function modifConsoTissu($conso, $eff, $id){
        DB::select('update consotissus set conso_tissus=?, efficience_tissus=?  where id_tissus=?',[$conso, $eff, $id]);
    }


}
