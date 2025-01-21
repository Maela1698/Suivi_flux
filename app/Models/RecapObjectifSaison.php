<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecapObjectifSaison extends Model
{
    use HasFactory;
    protected $table = 'v_recap_objectif_saison';
    protected $fillable = [
        'id_obj',
        'id_tier',
        'nomTier',
        'idActeur',
        'merchSenior',
        'emailMerchSenior',
        'merchJunior',
        'dateentree',
        'idsaison',
        'type_saison',
        'nb_commandes',
        'targetsaison',
        'total_qte_confirmee',
        'total_qte_encours_nego',
        'tauxconfirmation',
        'etat_objectif'
    ];

    public static function findFilteredObjectifs($filters)
    {
        $query = self::query();

        if (!empty($filters['idsaison'])) {
            $query->where('idsaison', $filters['idsaison']);
        }

        if (!empty($filters['idclient'])) {
            $query->where('idtiers', $filters['idclient']);
        }

        if (!empty($filters['merch'])) {
            $query->where('merchSenior', 'like', '%' . $filters['merch'] . '%');
                //   ->orWhere('emailMerchSenior', 'like', '%' . $filters['merch'] . '%');
        }

        if (!empty($filters['merch'])) {
            $query->where('merchSenior', 'like', '%' . $filters['merch'] . '%');
        }

        if (!empty($filters['etat'])) {
            $etatValue = $filters['etat'] === 'Atteint' ? '>= 1' : '< 1';
            $query->whereRaw('tauxconfirmation ' . $etatValue);
        }

        return $query->get();
    }
}
