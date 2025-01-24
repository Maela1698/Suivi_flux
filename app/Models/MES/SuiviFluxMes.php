<?php

namespace App\Models\MES;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SuiviFluxMes extends Model
{
    use HasFactory;

    public static function updateSuiviFluxMes($date_operaton, $qte_coupe, $qte_entree_chaine,$qte_transfere,$qte_pret_livrer,$qte_deja_livrer,$id_taille,$qte_po,$id){
        DB::select('update suivifluxmes set date_operaton=?, qte_coupe=?, qte_entree_chaine=?, qte_transfere=?, qte_pret_livrer=?, qte_deja_livrer=?, id_taille=?, qte_po=? where id=?',[$date_operaton, $qte_coupe, $qte_entree_chaine,$qte_transfere,$qte_pret_livrer,$qte_deja_livrer,$id_taille,$qte_po,$id]);
    }
}
