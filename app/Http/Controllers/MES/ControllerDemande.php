<?php

namespace App\Http\Controllers\MES;

use App\Http\Controllers\Controller;
use App\Models\MES\SuiviFluxMes;
use App\Models\MES\VDemande;
use App\Models\MES\VDestRecap;
use App\Models\MES\VGeneralFinalRecap;
use App\Models\MES\VListeOF;
use App\Models\Saison;
use App\Models\Tiers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControllerDemande extends Controller
{
    // 
    public function getDemandeConfirme(Request $request) {
        // on prend seulemnent les clients et non tous les tiers
        $tiers = Tiers::where('idacteur', 1)->get();

        $saisons = Saison::where('etat', 0)->get();

        // where = 2 puisque les demande dont l'etat = 2 
        // sont consideres comme confirmee
        $demandesConfirmes = VDemande::where('id_etat', 2)->where('etat',0)->orderBy('id');
        
        $selectedTier = null;
        if ($request->has('id_tier') && $request->id_tier != '') {
            $selectedTier = Tiers::where('id', $request->id_tier)->first();
            if ($selectedTier) {
                $demandesConfirmes = $demandesConfirmes->where('id_tiers', $selectedTier->id);
            }
        }

        $selectedModele = $request->nom_modele ?? '';
        if (!empty($selectedModele)) {
            $demandesConfirmes = $demandesConfirmes->where('nom_modele', 'ilike', '%' . $selectedModele . '%');
        }

        $selectedSaison = $request->id_saison ?? null;
        if (!empty($selectedSaison)) {
            $demandesConfirmes = $demandesConfirmes->where('id_saison', $selectedSaison);
        }

        $demandesConfirmes = $demandesConfirmes->get();
        return view('MES.demande.listeDemandeConfirme', compact('demandesConfirmes', 'tiers', 'selectedTier','selectedModele','saisons'));
    }

    public function getFicheDemandeConfirme($id){
        $demandeConfirme = VGeneralFinalRecap::find($id);
        // automatiquement, une commande validee va 
        // directement dans le view v_dest_recap.
        // il faut qu'au moins on repartie une taille 
        // d'une commande avec sa quantite_of pour
        // que son flu puisse etre suivi   
        $listeOF = VListeOF::where('iddemandeclient',$id)->whereNotNull('qteof')->get();
        return view('MES.demande.ficheDemandeConfirme',compact('demandeConfirme','listeOF'));
    }

    // recuperer tous les OF (num commande) d'une recap commande
    public function getDestinationByOF($recap_id,$numerocommande){
        $destinations = VDestRecap::where('recap_id',$recap_id)->where('numerocommande',$numerocommande)->get();
        return response()->json($destinations);
    }

    public function suivreFlux(Request $request){
        $numerocommande = $request->input('numerocommande');
        $couleur = $request->input('couleur');
        $uniteTaille = $request->input('uniteTaille');
        $qteof = $request->input('qteof');
        $iddemandeclient = $request->input('iddemandeclient');
        $id_destination = $request->input('id_destination');
        $date_livraison_confirme = $request->input('date_livraison_confirme');
        $dateOper = Carbon::now()->format('Y-m-d');
        $checkbox = $request->input('checkbox',[]);
        foreach ($checkbox as $id) {
            if (isset($numerocommande[$id], $uniteTaille[$id], $qteof[$id], $iddemandeclient[$id], $id_destination[$id], $date_livraison_confirme[$id])) {
                $suivi = new SuiviFluxMes();
                $suivi->insertSuiviFlux(
                    $dateOper,
                    $iddemandeclient[$id],
                    $numerocommande[$id],
                    $qteof[$id],
                    $couleur,
                    $uniteTaille[$id],
                    $id_destination[$id],
                    $date_livraison_confirme[$id]
                );
            }
        }
        return redirect()->back();
        // return redirect()->route('MES.suiviFlux');
    }
}
