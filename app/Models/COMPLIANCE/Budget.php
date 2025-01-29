<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Budget extends Model
{
    use HasFactory;

    public  function insertBudget($id_norme, $annee, $date_entree, $montant, $budget_previsionnel)
    {
        DB::table('budget')->insert([
            'id_norme' => $id_norme,
            'annee' => $annee,
            'date_entree' => $date_entree,
            'montant' => $montant,
            'budget_previsionnel' => $budget_previsionnel,
            'etat' => 0
        ]);
    }

    public static function updateBudget($budgetreel, $planaction_id){
        DB::select('update budget set budgetreel=? where planaction_id=?',[$budgetreel, $planaction_id]);
    }

    public static function listeBudgetCompliance()
    {
        $select = DB::select('select * from v_budget_reel_compliance order by annee desc');
        return self::hydrate($select);
    }

    public static function dernierBudgetNorme($norme, $annee)
    {
        $select = DB::select('select sum(montant) as montant from budget where id_norme=? and annee=? ', [$norme, $annee]);
        return self::hydrate($select);
    }

    public static function detailBudgetByNorme($id_norme, $annee)
    {
        $select = DB::select('select * from v_historique_budget_compliance where id_norme=? and annee=? order by item desc', [$id_norme, $annee]);
        return self::hydrate($select);
    }

    public static function listeBudgetComplianceByNormeAnnee($id_norme, $annee)
    {
        $select = DB::select('select * from v_budget_reel_compliance where id_norme=? and annee=? ', [$id_norme, $annee]);
        return self::hydrate($select);
    }

    public static function isBudgetAnneeExiste($annee, $norme)
    {
        $select = DB::select('select * from budget where annee=? and id_norme=?', [$annee, $norme]);
        return count($select);
    }


}
