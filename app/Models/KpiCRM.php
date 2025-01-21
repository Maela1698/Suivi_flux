<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KpiCRM extends Model
{
    use HasFactory;
    public static function getSumQteDemandeValide($etat)
    {
        $result = DB::select('SELECT SUM(qte_commande_provisoire) as total FROM demandeclient WHERE id_etat ='.$etat);

        return $result[0]->total ?? 0;
    }

    public static function getSumDemandeValide($etat)
    {
        $result = DB::select('SELECT count(*) as compte FROM demandeclient WHERE id_etat ='.$etat);

        return $result[0]->compte ?? 0;
    }

    public static function getSumDemande()
    {
        $result = DB::select('SELECT count(*) as compte FROM demandeclient');

        return $result[0]->compte ?? 0;
    }

    public static function getKPI(){
        $select=DB::select(' select *from v_kpi order by pourcentage desc');
        return self::hydrate($select);
    }

    public static function getGrandPourcentage()
    {
        $result = DB::select('select pourcentage from v_kpi order by pourcentage desc limit 1');

        return $result[0]->pourcentage ?? 0;
    }

    public static function getSumQteObjectifSaison()
    {
        $result = DB::select('SELECT SUM(targetsaison) as total FROM objectifsaison');

        return $result[0]->total ?? 0;
    }
    public static function getTauxConfimeClient()
    {
        $result = DB::select('select sum(quantitetotal*100)/targetsaison as pourcentage, id_tiers,nomtier from v_tauxConfirmeClient group by id_tiers,nomtier,targetsaison order by pourcentage desc');

        return self::hydrate($result);
    }

    public static function getMaxPourcentageConfirmeClient()
    {
        $result = DB::select(' select sum(quantitetotal*100)/targetsaison as pourcentage from v_tauxConfirmeClient group by id_tiers,targetsaison order by pourcentage desc limit 1');

        return $result[0]->pourcentage ?? 0;
    }
}
