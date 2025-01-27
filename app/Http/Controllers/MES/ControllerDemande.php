<?php

namespace App\Http\Controllers\MES;

use App\Http\Controllers\Controller;
use App\Models\MES\SuiviFluxMes;
use App\Models\MES\VDemande;
use App\Models\MES\VDestRecap;
use App\Models\MES\VListeOF;
use App\Models\Tiers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControllerDemande extends Controller
{
    //
    public function getDemandeConfirme(){
        $tiers = Tiers::all();
        $demandesConfirmes = VDemande::where('id_etat',2)->orderBy('id')->get();
        return view('MES.demande.listeDemandeConfirme',compact('demandesConfirmes','tiers'));
    }

    public function getFicheDemandeConfirme($id){
        $demandeConfirme = VDemande::find($id);
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
        $dateOper = Carbon::now()->format('Y-m-d');
        $checkbox = $request->input('checkbox',[]);
        foreach ($checkbox as $id) {
            if (isset($numerocommande[$id], $uniteTaille[$id], $qteof[$id], $iddemandeclient[$id], $id_destination[$id])) {
                $suivi = new SuiviFluxMes();
                $suivi->insertSuiviFlux(
                    $dateOper,
                    $iddemandeclient[$id],
                    $numerocommande[$id],
                    $qteof[$id],
                    $couleur,
                    $uniteTaille[$id],
                    $id_destination[$id]
                );
            }
        }
       return redirect()->route('MES.suiviFlux');
    }
}
