<?php

namespace App\Http\Controllers;

use App\Models\Smv;
use Illuminate\Http\Request;
use App\Models\DemandeClient;
use App\Models\StadeDemandeClient;
use App\Models\UniteMonetaire;

class ControllerSmv extends Controller
{
    public function smv(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $stades = StadeDemandeClient::all();
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        return view('CRM.smv.smv',compact('demande','stades'));
    }
    public function smvApercue(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $detaildemande = DemandeClient::getAllListeDemandeById($idDemande);
        $smv = Smv::getSmvByIdDemande($idDemande);
        return view('CRM.smv.smvApercu',compact('smv','detaildemande'));
    }

    public function nouveauSmv(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $idStade = $request->input('stade');
        $unitemonetaire = UniteMonetaire::getAllUniteMonetaire();
        $stade = StadeDemandeClient::find($idStade);
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        $smv = Smv::getLastSmvByIdDemande($idDemande);
        return view('CRM.smv.ajoutSmv',compact('smv','stade','idStade','unitemonetaire','demande'));
    }
    public function insertSmv(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $smvProd = $request->input('smvprod'); // SMV Prod
        $smvFinition = $request->input('smvfinition'); // SMV Finition
        $broadMain = $request->input('broadMain'); // Heure Broad Main
        $nbPoints = $request->input('nbPoints'); // Nombre des Points
        $prixPrint = $request->input('prix'); // Prix Print
        $uniteMonetaire = $request->input('uniteMonetaire'); // Unité Monétaire
        $commentaire = $request->input('commentaire'); // Commentaire
        $idStade = $request->input('idStadeDemandeClient');
        Smv::insertSmv( $smvProd, $smvFinition, $prixPrint, $uniteMonetaire, $nbPoints, $broadMain, $idDemande, $idStade,$commentaire);
        return redirect()->route('CRM.smv');
    }

     //controllerSmv
     public function updateSmv(Request $request)
     {
         $idDemande = $request->session()->get('idDemande');
         $idStade = $request->input('stade');
         $stade = StadeDemandeClient::find($idStade);
         $demande = DemandeClient::getAllListeDemandeById($idDemande);
         $unitemonetaire = UniteMonetaire::getAllUniteMonetaire();

         $smv = Smv::getLastSmvByIdDemande($idDemande);
        //  dd(count($smv));

         return view('CRM.smv.updateSmv', compact('smv','demande', 'idStade', 'stade', 'unitemonetaire'));
     }

     public function modifSmv(Request $request)
     {

         $idDemande = $request->session()->get('idDemande');

         $idsmv = Smv::getIDLastSmvByIdDemande($idDemande);

         $smv_prod = $request->input('smvprod'); // SMV Prod
         $smv_finition = $request->input('smvfinition'); // SMV Finition
         $broadMain = $request->input('broadMain'); // Heure Broad Main
         $nbPoints = $request->input('nbPoints'); // Nombre des Points
         $prix_print = $request->input('prix'); // Prix Print
         $unite_monetaire = $request->input('uniteMonetaire'); // Unité Monétaire
         $commentaire = $request->input('commentaire'); // Commentaire

         // logger()->info('Valeur de idDemande avant updateSmv : ', ['idDemande' => $idDemande->idDemande]);


         Smv::updateSmv(
             $idDemande,
             $smv_prod,
             $smv_finition,
             $prix_print,
             $unite_monetaire,
             $nbPoints,
             $broadMain,
             $commentaire
         );
         return redirect()->route('CRM.smv');
     }
}
