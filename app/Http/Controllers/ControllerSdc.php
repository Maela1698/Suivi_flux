<?php

namespace App\Http\Controllers;

use App\Models\StadeDemandeClient;
use App\Models\Sdc;
use App\Models\V_accessoire;
use App\Models\V_tissus;
use Illuminate\Http\Request;
use App\Models\DemandeClient;
use App\Models\DemandeClientSDCEtapeDev;
use App\Models\Tiers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class ControllerSdc extends Controller
{
    public function sdc(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $stades = StadeDemandeClient::all();

        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        return view('CRM.sdc.sdc', compact('demande', 'stades'));
    }
    public function sdcApercue(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $detaildemande = DemandeClient::getAllListeDemandeById($idDemande);
        $sdc = Sdc::where('id_demande_client', $idDemande)->first();
        $idsdc = Sdc::getLastIdSdcByIdDemande($idDemande);
        $detailsdc = Sdc::getDetailSdcById($idsdc);
        $dispomat = Sdc::getDispoMatierePremiere();
        $tissus = V_tissus::getAllV_tissu($idDemande);
        $accessoire = V_accessoire::getAllV_accessoireSansFinition($idDemande);
        $lavage = DemandeClient::getLavageByIdDemande($idDemande);
        $valeur = DemandeClient::getValeurAjoutByIdDemande($idDemande);
        // dd($detaildemande[0]->id_tiers);

        $tier = Tiers::getAllTierByIdTier($detaildemande[0]->id_tiers);

        return view('CRM.sdc.sdcApercu', compact('tier', 'detaildemande', 'sdc', 'detailsdc', 'dispomat', 'tissus', 'accessoire', 'valeur', 'lavage'));
    }
    // public function nouveauSdc(Request $request)
    // {
    //     $idDemande = $request->session()->get('idDemande');
    //     $idStade = $request->input('stade');
    //     $stade = StadeDemandeClient::find($idStade);
    //     $demande = DemandeClient::getAllListeDemandeById($idDemande);
    //     $tailles = DemandeClient::getTailleByIdDemande($idDemande);
    //     $donne = Sdc::getDetailById($idDemande);
    //     return view('CRM.sdc.ajoutSdc',compact('stade','tailles','idStade','donne'));
    // }

    public function nouveauSdc(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $idStade = $request->input('stade');
        $stade = StadeDemandeClient::find($idStade);
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        $tailles = DemandeClient::getTailleByIdDemande($idDemande);
        return view('CRM.sdc.ajoutSdc', compact('stade', 'tailles', 'idStade'));
    }
    public function insertSdc(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $dateenvoie = $request->input('dateEnvoie');
        $quantiteclients = $request->input('quantiteclient');
        $keeps = $request->input('keep');
        $idUniteTailles = $request->input('id_unite_taille_dc');
        $idStade = $request->input('idStade');
        $demande= DemandeClient::getAllListeDemandeById($idDemande);

        Sdc::insertSdc($dateenvoie, $idDemande, $idStade);

        $idSdc = Sdc::getLastIdSdcByIdDemande($idDemande);
        foreach ($idUniteTailles as $index => $unite) {
            $s = new Sdc();
            $s->insertDetailSdc($idSdc, $unite, ($quantiteclients[$index] + $keeps[$index]), $quantiteclients[$index], $keeps[$index]);
        }
        $qteTotal = DB::table('detailsdc')
            ->where('id_sdc', $idSdc)
            ->where('etat', 0)
            ->sum('qte_total');

        $nbDemandeClientSDCEtapeDEV = SDC::nbDemandeSDCByDemande($idDemande);
        // dd($nbDemandeClientSDCEtapeDEV);
        if ( $demande[0]->id_stade==1) {
            $idSDCDemande = DemandeClientSDCEtapeDev::getDemandeSDCEtapeDevByIdDemande($idDemande);
            $demandeSDCEtape = new DemandeClientSDCEtapeDev();
            $demandeSDCEtape->modifIdSDC($idSdc, $idSDCDemande[0]->id, $qteTotal);
        } else {
            $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
            //ajout demandeSDCEtapeSansEtapeDev
            $d = new DemandeClientSDCEtapeDev();
            $d->insertDemandeCSDCEtapeAvecSDC($idDemande, 1, $idSdc, $dateActuelle,$qteTotal);
        }
        DemandeClient::updateStadeDemande($idStade, $idDemande);
        return redirect()->route('CRM.sdc');
    }
    public function updateSdc(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $lastsdc = Sdc::getLastSdcById($idDemande);
        $detail = Sdc::getDetailById($idDemande);
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        $tailles = DemandeClient::getTailleByIdDemande($idDemande);
        return view('CRM.sdc.updateSdc', compact('lastsdc', 'detail', 'demande', 'tailles'));
    }

    public function modifSdc(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $dateenvoie = $request->input('dateEnvoie');
        $quantiteclients = $request->input('quantiteclient');
        $keeps = $request->input('keep');
        $idUniteTailles = $request->input('id_unite_taille_dc');
        Sdc::updateSdc($dateenvoie, $idDemande);
        foreach ($idUniteTailles as $index => $unite) {
            Sdc::updateDetailSdc($quantiteclients[$index] + $keeps[$index], $quantiteclients[$index], $keeps[$index], $idDemande, $unite);
        }
        return redirect()->route('CRM.sdc');
    }
}
