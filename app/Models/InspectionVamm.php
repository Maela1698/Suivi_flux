<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InspectionVamm extends Model
{
    use HasFactory;
    protected $table = 'inspectionvamm';
    protected $fillable = [
        'id' , 'id_demande_client' , 'id_type_defaut' , 'nombre_defaut' , 'etat'
    ];

    public function insertInspectionVamm($idDC, $date_inspection, $nombre_inspecter)
    {
        DB::table('inspectionvamm')->insert([
            'id_demande_client' => $idDC,
            'date_inspection' => $date_inspection,
            'nombre_inspecter' => $nombre_inspecter,
            'etat' => 0
        ]);
    }

    public function insertDetailInspectionVamm($id_inspection_vamm, $id_type_defaut, $nombre_defaut)
    {
        DB::table('detailinspectionvamm')->insert([
            'id_inspection_vamm' => $id_inspection_vamm,
            'id_type_defaut' => $id_type_defaut,
            'nombre_defaut' => $nombre_defaut,
            'etat' => 0
        ]);
    }

    public static function getInspectionByDemande()
    {
        $select = DB::select("select *from inspectionvamm order by id desc limit 1");
        return self::hydrate($select);
    }

    public static function getAllTypeDefautByTypeVamm($typeVamm)
    {
        $select = DB::select("select *from typeDefautVamm where id_type_vamm=".$typeVamm." order by id asc");
        return self::hydrate($select);
    }

    public static function listeInspectionByTypeVamm($id_type_vamm,$condition)
    {
        $select = DB::select("select *from v_inspectionVamm where id_type_vamm=".$id_type_vamm." ".$condition);
        return self::hydrate($select);
    }

    public static function listeDetailInspectioByIdInspection($id)
    {
        $select = DB::select("select *from v_detailInspectionVamm where id_inspection_vamm=".$id." order by id desc limit 1");
        return self::hydrate($select);
    }

    public static function calculNombreInspectionByTypeVamm($typeVamm)
    {
        $select = DB::select("select *from calculNombreInspectionVamm where id_type_vamm=".$typeVamm." order by id_demande_client desc");
        return self::hydrate($select);
    }

    public static function sommeQteProduite($condition)
    {
        $select = DB::select("select sum(qte) as qtes from v_suivifluxbrodmain where type_flux=1 ".$condition);
        // dd("select sum(qte) as qtes from v_suivifluxbrodmain where type_flux=1 ".$condition);
        return self::hydrate($select);
    }

    public static function sommeQteInspecter($typeVamm,$condition)
    {
        $select = DB::select("select sum(nombre_inspecter) as nombre_inspecter from calculNombreInspectionVamm where id_type_vamm=".$typeVamm. " ".$condition);
        return self::hydrate($select);
    }

    public static function compteNbInspecter($typeVamm,$condition)
    {
        $select = DB::select("select count(*) as compte from calculNombreInspectionVamm where id_type_vamm=".$typeVamm. " ".$condition);
        return self::hydrate($select);
    }

    public static function sommeTauxRejet($typeVamm,$condition)
    {
        $select = DB::select("select sum(taux_retouche) as sommeTauxRetouche from v_inspectionVamm where id_type_vamm=".$typeVamm. " ".$condition);
        return self::hydrate($select);
    }

}
