<?php

namespace App\Http\Controllers;

use App\Models\KpiCRM;
use Illuminate\Http\Request;

class ControllerKpiCRM extends Controller
{
    public function kpi(Request $request)
    {
        $t=round(32.5 / 5) * 5;
        $nbCommandeV = KpiCRM::getSumDemandeValide(2);
        $nbQteCommandeV = KpiCRM::getSumQteDemandeValide(2);
        $nbCommande = KpiCRM::getSumDemande();
        $tauxConversion=0;
        if($nbCommande!=0 && $nbCommandeV!=0){
            $tauxConversion = ($nbCommandeV*100)/$nbCommande;
        }

        $tauxConversionClient = KpiCRM::getKPI();
        $grandPourcentage = KpiCRM::getGrandPourcentage();
        $pourcentage = round($grandPourcentage/5)*5;
        $sommeObjectifSaison = KpiCRM::getSumQteObjectifSaison();
        $tauxConfirmeGeneral = ($nbQteCommandeV*100)/$sommeObjectifSaison;
        $tauxConfirmeClient = KpiCRM::getTauxConfimeClient();
        $pourcentageConfirmeClient= KpiCRM::getMaxPourcentageConfirmeClient();
        return view('CRM.KPI.kpi', compact('pourcentageConfirmeClient','tauxConfirmeClient','tauxConfirmeGeneral','nbCommandeV', 'nbQteCommandeV', 'nbCommande', 'tauxConversion','tauxConversionClient', 'pourcentage'));
    }
}
