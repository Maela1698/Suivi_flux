<?php

namespace App\Http\Controllers\MES;

use App\Http\Controllers\Controller;
use App\Models\MES\SuiviFluxMes;
use App\Models\MES\VDemande;
use App\Models\MES\VDestRecap;
use App\Models\MES\VListeOF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControllerDemande extends Controller
{
    //
    public function getDemandeConfirme(){
        $demandesConfirmes = VDemande::where('id_etat',2)->orderBy('id')->get();
        return view('MES.demande.listeDemandeConfirme',compact('demandesConfirmes'));
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
       $dateOper = Carbon::now()->format('Y-m-d');
       for($i=0; $i<count($numerocommande);$i++){
            $suivi = new SuiviFluxMes();
            $suivi->insertSuiviFlux($dateOper,$iddemandeclient[$i],$numerocommande[$i],$qteof[$i],$couleur,$uniteTaille[$i]);
       }
       return redirect()->route('MES.suiviFlux');
    }
}
