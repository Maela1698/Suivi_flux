<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\DemandeClient;
use App\Models\LeadTime;
use App\Models\RecapCommande;
use App\Models\Destination;
use App\Models\VRecapMasterPlan;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class MasterPlan extends Model
{
    use HasFactory;

    protected $table = 'masterplan';
    protected $fillable = [
        'id',
        'iddemandeClient',
        'date_mp_initial',
        'date_mp_reel',
        'date_e_init',
        'date_e_reel',
        'date_prod_initial',
        'date_prod_reel',
        'leadtimereel',
        'nbrjprod',
        'statutcommande',
        'idstadespecifique',
        'etat',
    ];

    public static function getRecapForMasterPlan()
    {
        $select = DB::select('SELECT rc.id, rc.iddemandeclient, vdc.nomtier, vdc.nom_modele
                          FROM recapcommande rc
                          JOIN v_demandeclient vdc ON rc.iddemandeclient = vdc.id
                          WHERE rc.iddemandeclient NOT IN (
                              SELECT mp.iddemandeclient
                              FROM masterplan mp
                          )');
        return $select;
    }

    public static function getDemandeForMasterPlan($idrecapcommande)
    {
        $select = DB::select('SELECT d.id
                            FROM destination d
                            WHERE d.idrecapcommande = ?', [$idrecapcommande]);
        return self::hydrate($select);
    }


    public static function insertMasterPlan($idRecapCommande, $idDemandeClient, $idDestination, $idStadeSpecifique, $statutcommande, $etat)
    {
        // Récupérer les dates et valeurs nécessaires
        $podate = RecapCommande::gePoDaterecapCommande($idRecapCommande, $idDemandeClient)->first()->receptionbc;



        // $etdFinal = Destination::getETDDemande($idDemandeClient)->first()->date_livraison;
        $etdFinal = DemandeClient::getDate_Livraion($idDemandeClient)->first()->date_livraison;

        // Conversion en objets Carbon
        $etdFinal = Carbon::parse($etdFinal);
        $podate = Carbon::parse($podate);

        // Calcul du leadTimeReel
        $leadTimeReel = $etdFinal->diffInDays($podate);

        // Calculs des dates
        // Clone l'objet Carbon avant chaque manipulation
        $date_p_initial = $etdFinal->copy()->subDays(40);
        $date_prod_reel = $date_p_initial->copy();

        $date_mp_initial = $date_prod_reel->copy()->subDays(20);
        $date_mp_reel = $date_mp_initial->copy();

        $date_e_init = $date_mp_reel->copy()->addDays(14);
        $date_e_reel = $date_e_init->copy();

        // Calcul du nombre de jours de production
        $nbrJProd = $etdFinal->diffInDays($date_prod_reel) - 7;

        // Insertion dans la table masterPlan
        return DB::table('masterplan')->insert([
            'iddemandeclient' => $idDemandeClient,
            'date_mp_initial' => $date_mp_initial,
            'date_mp_reel' => $date_mp_reel,
            'date_e_init' => $date_e_init,
            'date_e_reel' => $date_e_reel,
            'date_prod_initial' => $date_p_initial,
            'date_prod_reel' => $date_prod_reel,
            'leadtimereel' => $leadTimeReel,
            'nbrjprod' => $nbrJProd,
            'statutcommande' => $statutcommande,
            'idstadespecifique' => $idStadeSpecifique,
            'etat' => $etat
        ]);
    }

    public static function findAllStade()
    {
        $select = DB::select('SELECT * FROM stadeMasterPlan');
        return self::hydrate($select);
    }

    public static function calculerRetard($idRecapCommande)
    {
        // Initialisation des variables de retard
        $retardTissu = 0;
        $retardAccessoire = 0;

        // Récupération des données depuis la table recapcommande
        $recapCommande = DB::table('recapcommande')->where('id', $idRecapCommande)->first();

        if (!$recapCommande) {
            throw new Exception("RecapCommande avec l'ID $idRecapCommande non trouvé.");
        }

        // Vérification de la date_bc_tissu
        if (!$recapCommande->date_bc_tissu) {
            // Si la date_bc_tissu est absente, attribuer un retard de 30
            $retardTissu = 30;
        } else {

            // Si la date_bc_tissu est présente, calculer le retard
            $idrecapcommande = $recapCommande->id;
            $verifpodate = VRecapMasterPlan::check_and_insert_podate($idrecapcommande);
            if ($verifpodate == 10) {
                $podate = $recapCommande->podateprev;
                $dateEcheanceTissu = \Carbon\Carbon::parse($podate)->addDays(2);
            } else if ($verifpodate == 20) {
                $podate = $recapCommande->receptionbc;
                $dateEcheanceTissu = \Carbon\Carbon::parse($podate)->addDays(2);
            }
            // $podate = $recapCommande->reception;


            if (\Carbon\Carbon::parse($recapCommande->date_bc_tissu)->greaterThan($dateEcheanceTissu)) {
                $retardTissu = 10;
            } else {
                $retardTissu = 20;
            }
        }

        // Vérification de la date_bc_access
        if (!$recapCommande->date_bc_access) {
            // Si la date_bc_access est absente, attribuer un retard de 30
            $retardAccessoire = 30;
        } else {
            // Si la date_bc_access est présente, calculer le retard

            $idrecapcommande = $recapCommande->id;
            $verifpodate = VRecapMasterPlan::check_and_insert_podate($idrecapcommande);
            if ($verifpodate == 10) {
                $podate = $recapCommande->podateprev;
                $dateEcheanceAccessoire = \Carbon\Carbon::parse($podate)->addDays(7);
            } else if ($verifpodate == 20) {
                $podate = $recapCommande->receptionbc;
                $dateEcheanceAccessoire = \Carbon\Carbon::parse($podate)->addDays(7);
            }

            // $podate = $recapCommande->receptionbc;
            // $dateEcheanceAccessoire = \Carbon\Carbon::parse($podate)->addDays(7);

            if (\Carbon\Carbon::parse($recapCommande->date_bc_access)->greaterThan($dateEcheanceAccessoire)) {
                $retardAccessoire = 10;
            } else {
                $retardAccessoire = 20;
            }
        }

        // Retourner les valeurs de retard
        return [
            'retardTissu' => $retardTissu,
            'retardAccessoire' => $retardAccessoire
        ];
    }
}
