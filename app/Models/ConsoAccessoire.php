<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConsoAccessoire extends Model
{
    use HasFactory;
    protected $table = 'consoaccessoire';
    protected $fillable = [
        'id_accessoire',
        'conso_accessoire',
        'id_demande_client',
        'id_unite_taille',
        'qte',
        'etat'
    ];

    public static function getAllConsoAccyByDC($idDC)
    {
        $select = DB::select('select * from consoaccessoire where etat=0 and id_demande_client=' . $idDC);
        return self::hydrate($select);
    }

    public static function getAllConsoAccyById($id)
    {
        $select = DB::select('select * from consoaccessoire where etat=0 and id_accessoire=' . $id);
        return self::hydrate($select);
    }

    public static function isExisteConsoAccy($idAccessoire, $idUniteTaille)
    {
        $select = DB::table('consoaccessoire')
            ->where('id_accessoire', $idAccessoire)
            ->where('id_unite_taille', $idUniteTaille)
            ->count();
        return $select;
    }

    public function insertConsoAccy($data, $idDC, $qte, $taille)
    {
        DB::table($this->table)->insert([
            'id_accessoire' => $data['idAccessoire'],
            'conso_accessoire' => $data['conso'],
            'id_demande_client' => $idDC,
            'id_unite_taille' => $taille,
            'qte' => $qte,
            'etat' => 0
        ]);
    }

    public  function updateConsoAccy($data, $taille, $qte)
    {
        DB::table($this->table)
            ->where('id_accessoire', $data['idAccessoire'])
            ->where('id_unite_taille', $taille)
            ->update([
                'conso_accessoire' => $data['conso'],
                'qte' => $qte
            ]);
    }

    public static function sumConsoAccessoire($idAccessoire)
    {
        $nombre = DB::table('consoaccessoire')
            ->where('etat', 0)
            ->where('id_accessoire', $idAccessoire)
            ->sum(DB::raw('qte * conso_accessoire'));

        return $nombre;
    }

    public static function getIdConsoAccyDistinct()
    {
        $select = DB::select('select id_accessoire from consoaccessoire GROUP BY id_accessoire  HAVING COUNT(DISTINCT conso_accessoire) > 1');
        return self::hydrate($select);
    }

    public static function getIdConsoAccyPareil()
    {
        $select = DB::select('select id_accessoire from consoaccessoire GROUP BY id_accessoire  HAVING COUNT(DISTINCT conso_accessoire) = 1');
        return self::hydrate($select);
    }


    public static function isExisteConsoAccyDemande($idDC, $idUniteTaille)
    {
        $select = DB::table('consoaccessoire')
            ->where('id_demande_client', $idDC)
            ->where('id_unite_taille', $idUniteTaille)
            ->count();
        return $select;
    }

    public  function updateQteConsoAccy($idDC, $taille, $qte)
    {
        DB::table($this->table)
            ->where('id_demande_client', $idDC)
            ->where('id_unite_taille', $taille)
            ->update([
                'qte' => $qte
            ]);
    }

    public static function getIdConsoAccyByDCByTaille($idDC, $idTaille)
    {
        $select = DB::select('select * from consoaccessoire where etat=0 and id_demande_client=' . $idDC.' and id_unite_taille='.$idTaille);
        return self::hydrate($select);
    }

}
