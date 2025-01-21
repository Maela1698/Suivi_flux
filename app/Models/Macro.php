<?php

namespace App\Models\DATA_MACRO;

use App\Models\VMacro;
use Illuminate\Support\Facades\DB;
// use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Macro extends Model
{
    use HasFactory;
    protected $table = 'macrocharge2';
    public $incrementing = false;
    public $timestamps = false;
    // protected $fillable =
    // [
    //     'id',
    //     'mois',
    //     'annee',
    //     'jourouvrable',
    //     'effectif_macro',
    //     'absence',
    //     'heuretravail',
    //     'efficience_macro',
    //     'heuresup',
    //     'etat',
    // ];

    protected $fillable =
    [
        'id_type_macro',
        'mois',
        'annee',
        'jourouvrable',
        'absence',
        'heuretravail',
        'heuresup',
        'etat',
    ];

    public static function insertMacro($data)
    {
        return self::create([
            'mois' => $data['mois'],
            'annee' => $data['annee'],
            'jourouvrable' => $data['jourouvrable'],
            'effectif_macro' => $data['effectif_macro'],
            'absence' => $data['absence'],
            'heuretravail' => $data['heuret'],
            'efficience_macro' => $data['efficience'],
            'heuresup' => $data['heuresup'],
            'etat' => 0,
        ]);
    }


    public static function countJourOuvrable($mois_requete, $annee_requete)
    {
        // Définir le premier et le dernier jour du mois
        $debut_mois = \Carbon\Carbon::createFromDate($annee_requete, $mois_requete, 1);
        $fin_mois = $debut_mois->copy()->endOfMonth();

        // Récupérer tous les jours fériés du mois et de l'année donnés
        $joursFeries = DB::table('jours_feries')
            ->where('mois', $mois_requete)
            ->where('annee', $annee_requete)
            ->pluck('jour');

        // Convertir les jours fériés en objets Carbon pour comparaison facile
        $joursFeries = $joursFeries->map(function ($date) {
            return \Carbon\Carbon::parse($date);
        });

        // Boucle 1 : Si aucun jour férié n'est trouvé pour le mois et l'année demandés
        if ($joursFeries->isEmpty()) {
            $joursOuvrables = 0;
            for ($date = $debut_mois; $date->lte($fin_mois); $date->addDay()) {
                // Ne pas compter les dimanches
                if (!$date->isSunday()) {
                    $joursOuvrables++;
                }
            }
            return $joursOuvrables;
        }

        // Boucle 2 : Sinon, compter les jours ouvrables en excluant à la fois les dimanches et les jours fériés trouvés
        $joursOuvrables = 0;
        for ($date = $debut_mois; $date->lte($fin_mois); $date->addDay()) {
            // Ne pas compter les dimanches
            if ($date->isSunday()) {
                continue; // Passer au jour suivant
            }

            // Vérifier si le jour est un jour férié
            if ($joursFeries->contains(function ($jourFerie) use ($date) {
                return $jourFerie->isSameDay($date);
            })) {
                continue; // Passer au jour suivant
            }

            // Si ce n'est pas un dimanche et pas un jour férié, c'est un jour ouvrable
            $joursOuvrables++;
        }

        return $joursOuvrables;
    }

    public static function findJourOuvrable($mois_requete, $annee_requete)
    {
        try {
            $result = DB::select('SELECT jours_ouvrables FROM v_macrocharge_combine WHERE mois = ? AND annee = ? LIMIT 1', [$mois_requete, $annee_requete]);

            // Vérifiez si un résultat est trouvé
            if (!empty($result) && isset($result[0]->jours_ouvrables)) {
                return (int) $result[0]->jours_ouvrables;
            }

            // Si aucun résultat, retourner 0
            return 0;
        } catch (\Exception $e) {
            Log::error('Erreur dans findJourOuvrable : ' . $e->getMessage());
            return 0;
        }
    }

    // public static function findJourOuvrable($mois_requete, $annee_requete)
    // {
    //     $joursOuvrables = DB::select('SELECT jours_ouvrables FROM v_macrocharge_combine WHERE mois = ? AND annee = ? LIMIT 1', [$mois_requete, $annee_requete]);
    //     return $joursOuvrables[0]->jours_ouvrables;
    // }
    // try {
    //     // Exécute la requête SQL
    //     $joursOuvrables = DB::select('SELECT jours_ouvrables FROM v_macrocharge_combine WHERE mois = ? AND annee = ? LIMIT 1', [$mois_requete, $annee_requete]);

    //     // Vérifiez si un résultat est retourné et si la colonne existe
    //     if (!empty($joursOuvrables) && isset($joursOuvrables[0]->jours_ouvrables)) {
    //         return (int) $joursOuvrables[0]->jours_ouvrables;
    //     }

    //     // Si aucun résultat trouvé, retournez 0
    //     return 0;
    // } catch (\Exception $e) {
    //     // Enregistrez l'erreur dans les logs pour déboguer
    //     Log::error('Erreur dans findJourOuvrable : ' . $e->getMessage());
    //     return 0;
    // }




    public static function getAllTypeMacro()
    {
        $select = DB::select('select * from type_macrocharge');
        return self::hydrate($select);
    }

    public static function percentage_disp($mois, $annee)
    {
        $select = DB::select(
            'SELECT * FROM v_pourcentage_estdispo WHERE estdispo = 1 AND mois_disponibilite = ? AND annee_disponibilite = ?',
            [$mois, $annee]
        );
        return self::hydrate($select);
    }

    
}
