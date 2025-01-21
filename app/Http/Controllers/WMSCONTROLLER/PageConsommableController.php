<?php

namespace App\Http\Controllers\WMSCONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\ClasseMatierePremiere;
use App\Models\Tiers;
use App\Models\UniteMesureMatierePremiere;
use App\Models\UniteMonetaire;
use App\Models\WMSModel\Consommable\EntreeConsommable;
use App\Models\WMSModel\Consommable\V_Entree_Consommable;
use App\Models\WMSModel\Consommable\V_Sortie_Consommable;
use App\Models\WMSModel\Consommable\V_Stock_Consommable;
use Illuminate\Http\Request;

class PageConsommableController extends Controller
{
    function page_accueil_entree_consommable()
    {
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $entreeConsommable = V_Entree_Consommable::where('etat', 0)->get();
        return view('WMS.Tissu.Consommable.accueilEntreeConso', compact('entreeConsommable', 'client', 'fournisseur'));
    }
    function page_entree_consommable()
    {
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $uniteCommande = UniteMesureMatierePremiere::where('etat', 0)->get();
        $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
        return view('WMS.Tissu.Consommable.entreeConso', compact('classeMatiere', 'client', 'fournisseur', 'uniteCommande', 'uniteMonetaire'));
    }
    function page_stock_consommable()
    {
        $stockConsommable = [];
        $stock = V_Stock_Consommable::where('etat', 0)->get();
        foreach ($stock as $key => $stocks) {
            $stocks->idunitemonetaire = EntreeConsommable::where('idstockconsommable', $stocks->id)->first()->value('idunitemonetaire');
            $stocks->numbc = EntreeConsommable::where('idstockconsommable', $stocks->id)->first()->value('numbc');
            $stocks->qtecommande = EntreeConsommable::where('idstockconsommable', $stocks->id)->first()->value('qtecommande');
            $stockConsommable[] = $stocks;
        }
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
        return view('WMS.Tissu.Consommable.stockConso', compact('stockConsommable', 'client', 'fournisseur', 'uniteMonetaire'));
    }

    function page_sortie_consommable()
    {
        $sortieConsommable = V_Sortie_Consommable::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        return view('WMS.Tissu.Consommable.accueilSortieConso', compact('sortieConsommable', 'client', 'fournisseur'));
    }
}
