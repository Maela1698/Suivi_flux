<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DemandeClientSDCEtapeDev extends Model
{
    use HasFactory;

    protected $table = 'demandeclientsdcetapedev';
    protected $fillable = [
        'id_demande_client',
        'id_sdc',
        'id_etape_dev',
        'etat'
    ];


    public function insertDemandeCSDCEtapeSansSDC($idDC, $idEtapeDev, $dateEntree, $quantitesdc)
    {
        DB::table($this->table)->insert([
            'id_demande_client' => $idDC,
            'id_etape_dev' => $idEtapeDev,
            'date_entree_demande' => $dateEntree,
            'quantitesdc' => $quantitesdc,
            'etat' => 0
        ]);
    }

    public function insertDemandeCSDCEtapeAvecSDC($idDC, $idEtapeDev, $idSDC, $dateEntree, $quantitesdc)
    {
        DB::table($this->table)->insert([
            'id_demande_client' => $idDC,
            'id_sdc' => $idSDC,
            'id_etape_dev' => $idEtapeDev,
            'date_entree_demande' => $dateEntree,
            'quantitesdc' => $quantitesdc,
            'etat' => 0
        ]);
    }

    public static function getDemandeSDCEtapeDevByIdDemande($idDemande)
    {
        $select = DB::select('select * from demandeclientsdcetapedev where id_demande_client=' . $idDemande);
        return self::hydrate($select);
    }

    public static function getDemandeSDCEtapeDevById($id)
    {
        $select = DB::select('select * from demandeclientsdcetapedev where id=' . $id);
        return self::hydrate($select);
    }
    public static function modifIdSDC($idSDC, $id, $quantitesdc)
    {
        DB::select('update demandeclientsdcetapedev set id_sdc=? , quantitesdc=? where id=?', [$idSDC,$quantitesdc, $id]);
    }

    public static function updateDCSDCEtapeDev($idEtapeDEV, $idDCSdcEtape, $dateEntree){
        DB::select('update demandeclientsdcetapedev set id_etape_dev=?, date_entree_demande=? where id=?',[$idEtapeDEV,$dateEntree,$idDCSdcEtape]);

    }

    public static function changerEtat($etat, $idDCSdcEtape){
        DB::select('update demandeclientsdcetapedev set etat=?  where id=?',[$etat,$idDCSdcEtape]);
    }

    public static function getV_DemandeSDCEtapeDevById($id)
    {
        $select = DB::select('select * from v_demandeclientsdcetapedev where id=' . $id);
        return self::hydrate($select);
    }
}
