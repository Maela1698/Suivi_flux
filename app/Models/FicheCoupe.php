<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FicheCoupe extends Model
{
    use HasFactory;
    protected $table = 'fichecoupe';
    protected $fillable = [
        'nomfichier',
        'fichier',
        'id_demande_client',
        'etat'
    ];

    public function insertFicheCoupe($nomFichier, $fichier, $idDC)
    {
        DB::table($this->table)->insert([
            'nomfichier' => $nomFichier,
            'fichier' => $fichier,
            'id_demande_client' => $idDC,
            'etat' => 0
        ]);
    }

    public static function getFicheCoupeByDC($idDC){
        $select=DB::select('select * from fichecoupe where etat =0 and id_demande_client='.$idDC);
        return self::hydrate($select);
    }

    public static function getFicheCoupeById($id){
        $select=DB::select('select * from fichecoupe where id='.$id);
        return self::hydrate($select);
    }

}
