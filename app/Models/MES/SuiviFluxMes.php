<?php

namespace App\Models\MES;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SuiviFluxMes extends Model
{
    use HasFactory;

    protected $table = 'suivifluxmes';

    protected $fillable = [
        'date_operaton',
        'id_demande_client',
        'numero_commande',
        'id_taille',
        'qte_po',
        'couleur',
        'id_destination'
    ];

    public $timestamps = false;

    use HasFactory;

    public static function updateSuiviFluxMes($date_operaton, $qte_coupe, $qte_entree_chaine,$qte_transfere,$qte_pret_livrer,$qte_deja_livrer,$entree_repassage,$sortie_repassage,$commentaire,$rejetCoupe,$rejetChaine,$etat,$id){
        DB::select('update suivifluxmes set date_operaton=?, qte_coupe=?, qte_entree_chaine=?, qte_transfere=?, qte_pret_livrer=?, qte_deja_livrer=?, entree_repassage=?, sortie_repassage=?, commentaire=?, qte_rejet_coupe=?, qte_rejet_chaine=?, etat=? where id=?',[$date_operaton, $qte_coupe, $qte_entree_chaine,$qte_transfere,$qte_pret_livrer,$qte_deja_livrer,$entree_repassage,$sortie_repassage,$commentaire,$rejetCoupe,$rejetChaine,$etat,$id]);
    }

    public static function getAllSuiviFluxMes($condition)
    {
        $select = DB::select("select * from v_suiviFluxMes where 1=1 ".$condition);

        return self::hydrate($select);
    }

    public static function sommeQteCoupe($condition)
    {
        $select = DB::select("select sum(qte_coupe) as somme from v_suiviFluxMes where 1=1 ".$condition);
        return $select[0]->somme ?? 0;
    }

    public static function sommeQteEntreeChaine($condition)
    {
        $select = DB::select("select sum(qte_entree_chaine) as somme from v_suiviFluxMes where 1=1 ".$condition);
        return $select[0]->somme ?? 0;
    }

    public static function sommeQteTransferer($condition)
    {
        $select = DB::select("select sum(qte_transfere) as somme from v_suiviFluxMes where 1=1 ".$condition);
        return $select[0]->somme ?? 0;
    }

    public static function sommeQtePretLivrer($condition)
    {
        $select = DB::select("select sum(qte_pret_livrer) as somme from v_suiviFluxMes where 1=1 ".$condition);
        return $select[0]->somme ?? 0;
    }

    public static function sommeQteDejaLivrer($condition)
    {
        $select = DB::select("select sum(qte_deja_livrer) as somme from v_suiviFluxMes where 1=1 ".$condition);
        return $select[0]->somme ?? 0;
    }

    public static function sommeEntreeRepassage($condition)
    {
        $select = DB::select("select sum(entree_repassage) as somme from v_suiviFluxMes where 1=1 ".$condition);
        return $select[0]->somme ?? 0;
    }

    public static function sommeSortieRepassage($condition)
    {
        $select = DB::select("select sum(sortie_repassage) as somme from v_suiviFluxMes where 1=1 ".$condition);
        return $select[0]->somme ?? 0;
    }

    public static function sommeBalanceATransferer($condition)
    {
        $select = DB::select("select sum(balanceatransferer) as somme from v_suivifluxmes where 1=1 ".$condition);
        return $select[0]->somme ?? 0;
    }

    public static function sommeBalanceALivrer($condition)
    {
        $select = DB::select("select sum(balancealivrer) as somme from v_suivifluxmes  where 1=1 ".$condition);
        return $select[0]->somme ?? 0;
    }

    public static function sommeBalanceRepassage($condition)
    {
        $select = DB::select("select sum(balancerepassage) as somme from v_suivifluxmes where 1=1 ".$condition);
        return $select[0]->somme ?? 0;
    }

    public static function sommeQtePo($condition)
    {
        $select = DB::select("select sum(qte_po) as somme from v_suivifluxmes where 1=1 ".$condition);
        return $select[0]->somme ?? 0;
    }


    public function insertSuiviFlux($date_operaton,$id_demande_client,$numero_commande,$qte_po,$couleur,$id_taille,$id_destination)
    {
        try {
            // Met à jour la table `destination` pour marquer l'enregistrement comme suivi
            DB::update('UPDATE destination SET istracked = true WHERE id = ?', [$id_destination]);

            // Insère les données dans la table spécifiée
            DB::table($this->table)->insert([
                'date_operaton' => $date_operaton,
                'id_demande_client' => $id_demande_client,
                'numero_commande' => $numero_commande,
                'qte_po' => $qte_po,
                'couleur' => $couleur,
                'id_taille' => $id_taille,
                'id_destination' => $id_destination,
            ]);
        } catch (\Exception $e) {
            // Capture les exceptions et affiche un message ou effectue un traitement personnalisé
            Log::error('Erreur lors de l\'opération : ' . $e->getMessage());
            return response()->json(['message' => 'Une erreur s\'est produite lors de l\'opération.'], 500);
        }

    }


    public static function sommeRejetChaine($condition)
    {
        $select = DB::select("select sum(qte_rejet_chaine) as somme from v_suiviFluxMes where 1=1 ".$condition);
        return $select[0]->somme ?? 0;
    }

    public static function sommeRejetCoupe($condition)
    {
        $select = DB::select("select sum(qte_rejet_coupe) as somme from v_suiviFluxMes where 1=1 ".$condition);
        return $select[0]->somme ?? 0;
    }
}
