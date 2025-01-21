<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeClient;
use App\Models\Pri;
use App\Models\StadeDemandeClient;
use App\Models\UniteMonetaire;
class ControllerPri extends Controller
{
    public function pri(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        return view('CRM.pri.pri',compact('demande'));
    }
    public function priApercue(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $detaildemande = DemandeClient::getAllListeDemandeById($idDemande);
        $pri = Pri::getPriByIdDemande($idDemande);
        return view('CRM.pri.priApercu',compact('pri','detaildemande'));
    }
    public function nouveauPri(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $idStade = $request->input('stade');
        $unitemonetaire = UniteMonetaire::getAllUniteMonetaire();
        //$stade = StadeDemandeClient::find($idStade);
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        $pri = Pri::getLastPriByIdDemande($idDemande);
        return view('CRM.pri.ajoutPri',compact('pri','idStade','unitemonetaire','demande'));
    }

    public function insertPri(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $prix = $request->input('prix'); // Prix
        $uniteMonetaire = $request->input('uniteMonetaire'); // Unité Monétaire
        $commentaire = $request->input('commentaire');
        $idStade = $request->input('idStadeDemandeClient');
        Pri::insertPri( $prix, $uniteMonetaire, $idDemande, $commentaire);
        return redirect()->route('CRM.pri');
    }
    public function updatePri(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDemande);

        $idStade = $request->input('idStadeDemandeClient');
        $stade = StadeDemandeClient::find($idStade);

        $prix = $request->input('prix'); // Prix
        $uniteMonetaire = $request->input('uniteMonetaire'); // Unité Monétaire
        $unitemonetaire = UniteMonetaire::getAllUniteMonetaire();

        $pri = Pri::getLastPriByIdDemande($idDemande);

        return view('CRM.pri.updatePri', compact('pri', 'demande', 'idStade', 'stade', 'unitemonetaire'));
    }

    public function modifPri(Request $request)
    {

        $idDemande = $request->session()->get('idDemande');

        // $idpri = Pri::getIDLastPriByIdDemande($idDemande);

        $prix = $request->input('prix'); // Prix Print
        $commentaire = $request->input('commentaire'); // Commentaire

        // logger()->info('Valeur de idDemande avant updateSmv : ', ['idDemande' => $idDemande->idDemande]);


        Pri::updatePri(
            $idDemande,
            $prix,
            $commentaire
        );
        return redirect()->route('CRM.pri');
    }
}
