<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeClient;
use App\Models\Echantillon;
use App\Models\StadeDemandeClient;
use App\Models\Tiers;

class ControllerEchantillon extends Controller
{
    public function echantillon(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        return view('CRM.echantillon.echantillon', compact('demande'));
    }
    public function echantillonApercu(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $detaildemande = DemandeClient::getAllListeDemandeById($idDemande);
        $echantillon = Echantillon::getEchantillonByIdDemande($idDemande);
        $tier = Tiers::getAllTierByIdTier($detaildemande[0]->id_tiers);
        return view('CRM.echantillon.echantillonApercu', compact('tier','echantillon', 'detaildemande'));
    }
    public function nouveauEchantillon(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $idStade = $request->input('stade');
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        $echantillon = Echantillon::getLastEchantillonByIdDemande($idDemande);
        return view('CRM.echantillon.ajoutEchantillon', compact('echantillon','idStade',  'demande'));
    }
    public function insertEchantillon(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $date_envoie = $request->input('dateEnvoie');
        $awb = $request->input('awb');
        $idStade = $request->input('idStadeDemandeClient'); // Stade Demande Client
        $quantite = $request->input('quantite'); // Quantité
        $lieuDestination = $request->input('lieu'); // Lieu de destination
        $modeEnvoie = $request->input('modeEnvoie'); // Mode d'envoi
        $commentaire = $request->input('commentaire'); // Commentaire
        Echantillon::insertEchantillon($idDemande, $idStade,$date_envoie, $quantite, $lieuDestination,$modeEnvoie,$commentaire,$awb);
        return redirect()->route('CRM.echantillon');
    }

    public function updateEchantillon(Request $request)
    {

        $idDemande = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDemande);

        $idStade = $request->input('idStadeDemandeClient'); // Stade Demande Client
        $stade = StadeDemandeClient::find($idStade);

        $echantillon = Echantillon::getLastEchantillonByIdDemande($idDemande);

        return view('CRM.echantillon.updateEchantillon', compact('echantillon', 'demande', 'idStade', 'stade'));
    }

    public function modifEchantillon(Request $request)
    {

        $idDemande = $request->session()->get('idDemande');

        $idDemande = $request->session()->get('idDemande');
        $date_envoie = $request->input('dateEnvoie');
        $awb = $request->input('awb');
        $quantite = $request->input('quantite'); // Quantité
        $lieuDestination = $request->input('lieu'); // Lieu de destination
        $modeEnvoie = $request->input('modeEnvoie'); // Mode d'envoi
        $commentaire = $request->input('commentaire'); // Commentaire


        Echantillon::updateEchantillon(
            $idDemande,
            $date_envoie,
            $quantite,
            $lieuDestination,
            $modeEnvoie,
            $commentaire,
            $awb
        );
        return redirect()->route('CRM.echantillon');
    }

}
