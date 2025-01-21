<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PieceMachine extends Model
{
    use HasFactory;
    protected $table = 'piecemachine';
    public $timestamps = false;
    protected $fillable = [
        'designation',
        'reference',
        'dureevie',
        'nombre',
        'photo',
        'etat',
        'date_ajout_piece',
    ];

    // KPI pièces
    // where etat=0 => pieces dispo
    public static function sumPiecesDispoByRef()
    {
        $select = DB::select('SELECT reference, SUM(nombre) AS total_pieces
                        FROM piecemachine where etat=0
                        GROUP BY reference;');
        return self::hydrate($select);
    }

    // where etat=0 => pieces dispo
    public static function sumPiecesIndispoByRef()
    {
        $select = DB::select('SELECT reference, SUM(nombre) AS total_pieces
                        FROM piecemachine where etat=10
                        GROUP BY reference;');
        return self::hydrate($select);
    }
    // KPI pièces

    // CRUD
    public static function affecterPieceMachine($idelement, $idpiece, $idmachine, $date_affect, $commentaire)
    {
        return DB::insert(
            'insert into jointure_machine_piece
            (idelement, idpiecemachine,idmachine,date_affectation_piece,commentaire)
            values (?,?,?,?,?)',
            [
                $idelement,
                $idpiece,
                $idmachine,
                $date_affect,
                $commentaire
            ]
        );
    }
    public static function findPieceMachine($idmachine)
    {
        $select = DB::select('select * from v_element_piece_machine where id_machine=? and etat_pm not in(300,400)', [$idmachine]);
        return self::hydrate($select);
    }

    public static function findAllPieceMachine()
    {
        $select = DB::select('select * from piecemachine');
        return self::hydrate($select);
    }
    // CRUD

}
