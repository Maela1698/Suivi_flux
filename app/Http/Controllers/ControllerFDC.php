<?php

namespace App\Http\Controllers;

use App\Models\Accessoire;
use App\Models\CaractereTissu;
use App\Models\CaracteristiqueTissu;
use App\Models\ConsoAccessoire;
use App\Models\ConsoTissus;
use App\Models\DemandeClient;
use App\Models\DispositionMatierePremiere;
use App\Models\Tiers;
use App\Models\Tissus;
use App\Models\V_accessoire;
use App\Models\V_tissus;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;

class ControllerFDC extends Controller
{
    public function fdc(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        return view('CRM.fdc.fdc', compact('demande'));
    }

    public function formAjoutFDC(Request $request)
    {
        $idDC =  $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $tissu = V_tissus::getAllV_tissu($idDC);
        $dispo = DispositionMatierePremiere::getAllDispoMP();
        $accessoire = V_accessoire::getAllV_accessoireByDC($idDC);
        $consoTissu = ConsoTissus::getAllConsoTissuByTissu();
        $detailTaille = DemandeClient::getTailleByIdDemande($idDC);
        $consoAccy = ConsoAccessoire::getAllConsoAccyByDC($idDC);
        $caracteristique = CaracteristiqueTissu::getAllCaracteristiqueTissu();
        return view('CRM.fdc.insertFDC', compact('idDC','caracteristique','consoAccy', 'accessoire', 'detailTaille', 'demande', 'tissu', 'dispo', 'consoTissu'));
    }

    public function modifConsoTissu(Request $request)
    {
        $idtissus = $request->input('idtissus');
        $conso = $request->input('conso');
        $efficience = $request->input('efficience');
        $idDC = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $qteAvant = $demande[0]->qte_commande_provisoire;
        $nouveauQte = $qteAvant * $conso;
        $consoTissu = new ConsoTissus();
        $consoTissu->modifConsoTissu($conso, $efficience, $idtissus);
        $tissu = new Tissus();
        $tissu->modifQuantiteTissu($nouveauQte, $idtissus);
        return redirect()->route('CRM.formAjoutFDC');
    }

    public function formUpdateConsoAccessoire(Request $request)
    {
        $idDC =  $request->session()->get('idDemande');
        $idAccessoire = $request->input('idAccessoire');
        $accessoire = V_accessoire::getAllV_accessoireById($idAccessoire);
        $detailTaille = DemandeClient::getTailleByIdDemande($idDC);
        return view('CRM.fdc.updateFDCAccessoire', compact('detailTaille', 'accessoire'));
    }

    public function modifConsoAccy(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $detail = DemandeClient::getTailleByIdDemande($idDC);
        $data = $request->all();
        $sommeConso = 0;
        for($j=0; $j<count($detail); $j++){
            for ($i = 0; $i < count($data['taille']); $i++) {
                $isExiste = ConsoAccessoire::isExisteConsoAccy($data['idAccessoire'], $data['taille'][$i]);
                $conso = new ConsoAccessoire();
                $qte = 0;
                if ($isExiste == 0) {
                    if ($detail[$j]->id_unite_taille == $data['taille'][$i]) {
                        $qte = $detail[$j]->quantite;
                        $conso->insertConsoAccy($data, $idDC, $qte, $data['taille'][$i]);
                    }
                } else {
                    if ($detail[$j]->id_unite_taille == $data['taille'][$i]) {
                        $qte = $detail[$j]->quantite;
                        $conso->updateConsoAccy($data, $data['taille'][$i], $qte);
                    }
                }
            }
        }

        $sommeConso = ConsoAccessoire::sumConsoAccessoire($data['idAccessoire']);
        $accessoire = new Accessoire();
        $accessoire->modifQteAccy($sommeConso, $data['idAccessoire']);
        return redirect()->route('CRM.formAjoutFDC');
    }

    public function fdcApercu(Request $request)
    {
        $idDC =  $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $tissu = V_tissus::getAllV_tissu($idDC);
        $dispo = DispositionMatierePremiere::getAllDispoMP();
        $accessoire = V_accessoire::getAllV_accessoireByDC($idDC);
        $consoTissu = ConsoTissus::getAllConsoTissuByTissu();
        $detailTaille = DemandeClient::getTailleByIdDemande($idDC);
        $consoAccy = ConsoAccessoire::getAllConsoAccyByDC($idDC);
        $caracteristique = CaracteristiqueTissu::getAllCaracteristiqueTissu();
        $tier = Tiers::getAllTierByIdTier($demande[0]->id_tiers);
        return view('CRM.fdc.fdcApercu', compact('tier','idDC','caracteristique','consoAccy', 'accessoire', 'detailTaille', 'demande', 'tissu', 'dispo', 'consoTissu'));
    }

    public function ajoutCaractereTissu(Request $request)
    {
        $tissu = $request->input('tissu');

        if (is_array($tissu)) {
            for ($i = 0; $i < count($tissu); $i++) {
                CaractereTissu::deleteCaractereTissuByTissu($tissu[$i]);
                $car = new CaractereTissu();
                $caractereTissu = $request->input('caractere' . $tissu[$i]);

                if (is_array($caractereTissu)) {
                    $d = count($caractereTissu);
                    for ($j = 0; $j < $d; $j++) {
                        $car->insertCaractereTissu($caractereTissu[$j], $tissu[$i]);
                    }
                } else {
                    continue;
                }
            }
        } else {
            return redirect()->back()->with('error', 'Les tissus doivent être un tableau.');
        }

        return redirect()->route('CRM.fdc');
    }

}
