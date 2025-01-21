<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObjectifSaison;
use App\Models\DemandeClient;
use App\Models\Saison;
use App\Models\RecapObjectifSaison;
use App\Models\Tiers;
use Illuminate\Support\Facades\DB;

class ControllerObjectifSaison extends Controller
{

    public function objectifSaison(Request $request)
    {
        $filters = [
            'idsaison' => $request->input('idsaison'),
            'id_tier' => $request->input('id_tier'),
            'merchsenior' => $request->input('merchsenior'),
            'etat' => $request->input('etat'),
        ];

        $objectifs = RecapObjectifSaison::query();

        $columns = ['type_saison', 'nomtier', 'merchsenior'];

        // $objectifFilter = RecapObjectifSaison::query();

        // Filtrage par id de la saison : pas pri en compte par la recherche masi devrait l'être
        $nomsaison = null;
        if ($request->idsaison) {
            $objectifs->where('idsaison', $request->input('idsaison'));
            $type_saison = Saison::where('id', $request->idsaison)->pluck('type_saison')->first();
        }

        // Filtrage par id du client : pas pri en compte par la recherche masi devrait l'être
        $nomTiers = null;
        if ($request->id_tier) {
            $objectifs->where('id_tier', $request->input('id_tier'));
            $nomTiers = Tiers::where('id', $request->id_tier)->pluck('nomtier')->first();
        }

        // Filtrage par merch : pas pri en compte par la recherche masi devrait l'être
        $merchsenior = null;
        if ($request->merchsenior) {
            $objectifs->where('merchsenior', 'ILIKE', '%' . $request->input('merchsenior') . '%');
            $merchsenior = Tiers::where('merchsenior', $request->merchsenior)->pluck('merchsenior')->first();
        }

        // Filtrage par état (atteint ou non atteint) : seul pris en compte
        if ($request->etat) {
            if ($request->etat == 'Atteint') {
                $objectifs->where('tauxconfirmation', '>=', 100); // Si atteint
            } else if ($request->etat == 'Non Atteint') {
                $objectifs->where('tauxconfirmation', '<', 100); // Si non atteint
            }
        }

        // Récupération des résultats filtrés
        $objectif = $objectifs->get();

        // $quantiteConfirmee = DemandeClient::qteconfirme($request->idsaison, $request->idtiers);

        $sumnbcommande = ObjectifSaison::findSumNbCommande($filters);
        // $sumnbcommande = ObjectifSaison::findSumNbCommande();
        $sumobjectif = ObjectifSaison::findSumTarget($filters);
        $sumConfirmed = ObjectifSaison::findsumConfirmee($filters);
        $moyenne = ObjectifSaison::moyenneTauxConfirmed($filters);
        return view('Planning.RAD.listeObjectifSaison', compact(
            'objectif',
            'nomsaison',
            'nomTiers',
            'merchsenior',
            'sumnbcommande',
            'sumobjectif',
            'sumConfirmed',
            'moyenne'
        ));
    }

    public static function rechercheMerchSenior(Request $request)
    {
        $query = $request->get('merchsenior');
        $merch = Tiers::where('merchsenior', 'ILIKE', '%' . $query . '%')->get();
        return response()->json($merch);
    }
    public function showajouterobjectifSaison()
    {
        $tiers = Tiers::getAllClientTiersByIdActeur();
        $saisons = DB::select('select * from saison');
        return view('Planning.RAD.ajouterObjectifSaison', compact('tiers', 'saisons'));
    }

    public function ajouterObjectifSaison(Request $request)
    {
        // Validation des données de la requête
        $request->validate([
            'idtiers' => 'required|integer',
            'idsaison' => 'required|integer',
            'targetsaison' => 'required|integer',
        ]);

        // Vérification d'existence de l'objectif pour le même tiers et saison
        $existingObjectif = ObjectifSaison::where('idtiers', $request->idtiers)
            ->where('idsaison', $request->idsaison)
            ->first();

        if ($existingObjectif) {
            return redirect()->back()->with('error', 'Cet objectif existe déjà pour ce tiers et cette saison.');
        }

        // Récupération de la quantité confirmée
        $quantiteConfirmee = ObjectifSaison::qteconfirme($request->idsaison, $request->idtiers);

        // Si aucune quantité confirmée n'existe, assigner une valeur par défaut
        $totalQteConfirmee = 0;
        if ($quantiteConfirmee && !$quantiteConfirmee->isEmpty()) {
            $totalQteConfirmee = $quantiteConfirmee[0]->total_qte_confirmee ?? 0;
        }

        // Calcul du taux de confirmation
        $tauxconfirmation = 0;
        if ($totalQteConfirmee > 0 && $request->targetsaison > 0) {
            $tauxconfirmation = ($totalQteConfirmee / $request->targetsaison) * 100;
        }

        // Insertion de l'objectif
        ObjectifSaison::create([
            'idtiers' => $request->idtiers,
            'idsaison' => $request->idsaison,
            'targetsaison' => $request->targetsaison,
            'tauxconfirmation' => $tauxconfirmation,
            'etat' => 0, // Par défaut, l'état est 0
        ]);

        return redirect()->back()->with('success', 'Objectif ajouté avec succès.');
    }


    // public function ajouterObjectifSaison(Request $request)
    // {
    //     // Validation des données de la requête
    //     $request->validate([
    //         'idtiers' => 'required|integer',
    //         'idsaison' => 'required|integer',
    //         'targetsaison' => 'required|integer',
    //     ]);

    //     // Vérification d'existence de l'objectif pour le même tiers et saison
    //     $existingObjectif = ObjectifSaison::where('idtiers', $request->idtiers)
    //         ->where('idsaison', $request->idsaison)
    //         ->first();

    //     if ($existingObjectif) {
    //         return redirect()->back()->with('error', 'Cet objectif existe déjà pour ce tiers et cette saison.');
    //     }

    //     // Récupération de la quantité confirmée
    //     $quantiteConfirmee = DemandeClient::qteconfirme($request->idsaison, $request->idtiers);

    //     // Si aucune quantité confirmée n'existe, assigner une valeur par défaut
    //     $totalQteConfirmee = 0;
    //     if ($quantiteConfirmee && !$quantiteConfirmee->isEmpty()) {
    //         // Vérifier si la quantité confirmée est définie et non null
    //         $totalQteConfirmee = $quantiteConfirmee[0]->total_qte_confirmee ?? 0;
    //     }

    //     // Calcul du taux de confirmation
    //     $tauxconfirmation = 0;
    //     if ($totalQteConfirmee == 0) {
    //         $tauxconfirmation = 0; // Si la quantité confirmée est nulle
    //     } else if ($request->targetsaison > 0) {
    //         // Calcul du taux en fonction de la cible de saison
    //         $tauxconfirmation = ($totalQteConfirmee / $request->targetsaison) * 100;

    //         // Limiter le taux à 100% si la quantité confirmée dépasse la cible
    //         // if ($tauxconfirmation > 100) {
    //         //     $tauxconfirmation = 100;
    //         // }
    //     }


    //     // Insertion de l'objectif
    //     ObjectifSaison::create([
    //         'idtiers' => $request->idtiers,
    //         'idsaison' => $request->idsaison,
    //         'targetsaison' => $request->targetsaison,
    //         'tauxconfirmation' => $tauxconfirmation,
    //         'etat' => 0, // Par défaut, l'état est 0
    //     ]);

    //     return redirect()->back()->with('success', 'Objectif ajouté avec succès.');
    // }


    public static function getDetailObjectifSaison($id_tier, $idsaison)
    {
        $detailObjectif = ObjectifSaison::findDetailv_ObjectifSaison($id_tier, $idsaison);
        return view('Planning.RAD.detailObjectifSaison', compact('detailObjectif'));
    }

    public function updateObjectifSaison(Request $request)
    {
        $request->validate([
            'id_obj' => 'required|integer|exists:objectifsaison,id',
            'targetsaison' => 'required|integer|min:0',
        ]);

        $id_obj = $request->input('id_obj');
        $newtarget = $request->input('targetsaison');
        $id_tiers = $request->input('id_tiers');
        $id_saison = $request->input('id_saison');

        ObjectifSaison::modifierObjectifTarget($id_obj, $id_tiers, $id_saison, $newtarget);

        return redirect()->back()->with('success', 'Objectif mis à jour avec succès');
    }

    public static function deleteObjectifSaison(Request $request)
    {
        $idobj = $request->input('id_obj');
        $delete = ObjectifSaison::deleteObjectifSaison($idobj);
        return redirect()->route('LRP.objectifSaison');
    }

    // TEST/////
    // public function ajouterObjectifSaison(Request $request)
    // {
    //     $request->validate([
    //         'idtiers' => 'required|integer',
    //         'idsaison' => 'required|integer',
    //         'targetsaison' => 'required|integer',
    //     ]);

    //     $existingObjectif = ObjectifSaison::where('idtiers', $request->idtiers)
    //         ->where('idsaison', $request->idsaison)
    //         ->first();

    //     if ($existingObjectif) {
    //         return redirect()->back()->with('error', 'Cet objectif existe déjà pour ce tiers et cette saison.');
    //     }

    //     $quantiteConfirmee = DemandeClient::qteconfirme($request->idsaison, $request->idtiers);

    //     if ($quantiteConfirmee === null || $quantiteConfirmee->isEmpty()) {
    //         $quantiteConfirmee = collect([(object) ['total_qte_confirmee' => 0]]);
    //     }

    //     // ceci ne semble pas fonctionner
    //     $tauxconfirmation = 0;
    //     if ($quantiteConfirmee[0]->total_qte_confirmee == 0) {
    //         $tauxconfirmation = 0;
    //     } else if ($request->targetsaison > 0) {
    //         $tauxconfirmation = ($quantiteConfirmee[0]->total_qte_confirmee / $request->targetsaison) * 100;
    //     }

    //     // Insertion de l'objectif
    //     ObjectifSaison::create([
    //         'idtiers' => $request->idtiers,
    //         'idsaison' => $request->idsaison,
    //         'targetsaison' => $request->targetsaison,
    //         'tauxconfirmation' => $tauxconfirmation,
    //         'etat' => 0, // Par défaut, l'état est 0
    //     ]);

    //     return redirect()->back()->with('success', 'Objectif ajouté avec succès.');
    // }

}
