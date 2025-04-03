<?php

namespace App\Http\Controllers\QUALITECONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\CategorieTissus;
use App\Models\ClasseMatierePremiere;
use App\Models\FamilleTissus;
use App\Models\QUALITEModel\QualiteRouleauTissu;
use App\Models\QUALITEModel\TestConformiteTissu;
use App\Models\Tiers;
use App\Models\WMSModel\QUALITEModel\CHOIXQUALITE;
use App\Models\WMSModel\QUALITEModel\CodificationAccessoire;
use App\Models\WMSModel\QUALITEModel\CodificationAccessoire_FamilleWMS;
use App\Models\WMSModel\QUALITEModel\CODIFICATIONACCESSOIRE_INSPECTIONACCESSOIRE;
use App\Models\WMSModel\QUALITEModel\DEFAUTFABRICINSPECTION;
use App\Models\WMSModel\QUALITEModel\DefectFabricType;
use App\Models\WMSModel\QUALITEModel\INSPECTIONACCESSOIRE;
use App\Models\WMSModel\QUALITEModel\ListeQualiteRouleauFabricTissu;
use App\Models\WMSModel\QUALITEModel\QUALITEROULEAUTISSU_TESTDISCORGING;
use App\Models\WMSModel\QUALITEModel\QUALITEROULEAUTISSU_TESTNUANCE;
use App\Models\WMSModel\QUALITEModel\QUALITEROULEAUTISSU_TESTRETRACTION;
use App\Models\WMSModel\QUALITEModel\SPEEDMACHINE;
use App\Models\WMSModel\QUALITEModel\TESTDISCORGING;
use App\Models\WMSModel\QUALITEModel\TESTFABRICINSPECTION;
use App\Models\WMSModel\QUALITEModel\TESTNUANCE;
use App\Models\WMSModel\QUALITEModel\TESTRETRACTION;
use App\Models\WMSModel\QUALITEModel\TYPELAVAGEQUALITE;
use App\Models\WMSModel\QUALITEModel\V_DETAIL_METRAGE_LAIZE_RAPPORT;
use App\Models\WMSModel\QUALITEModel\V_DETAIL_METRAGE_LOT_RAPPORT;
use App\Models\WMSModel\QUALITEModel\V_GRAMMAGE_TISSU_RAPPORT;
use App\Models\WMSModel\QUALITEModel\V_INSPECTION_100_RAPPORT;
use App\Models\WMSModel\QUALITEModel\V_TOTAL_INSPECTION_100_RAPPORT;
use App\Models\WMSModel\QUALITEModel\V_inspection_tissu_rapport;
use App\Models\WMSModel\QUALITEModel\V_RESULTAT_INSPECTION_TISSU_RAPPORT;
use App\Models\WMSModel\QUALITEModel\V_TOTALE_DETAIL_METRAGE_LAIZE_RAPPORT;
use App\Models\WMSModel\QUALITEModel\V_TOTALE_DETAIL_METRAGE_LOT_RAPPORT;
use App\Models\WMSModel\QUALITEModel\WMSQUALITYCORRECTIVEACTION;
use App\Models\WMSModel\UtilisationWMS;
use App\Models\WMSModel\V_Entree_Tissu;
use App\Models\WMSModel\WMS\FamilleWMS;
use App\Models\WMSModel\WMS\Type_wms;
use App\Models\WMSModel\WMS\V_ENTREE_WMS;

class PageQualite extends Controller
{
    //!------------------------------------TISSU------------------------------------!//
    public function entreeQualiteTissu()
    {
        $familleTissu = FamilleTissus::where('etat', 0)->get();
        $historyEntree = V_Entree_Tissu::where('qterecu', '>=', 0)->orderBy('dateentree', 'desc')
            ->paginate(100);
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        return view('WMS.QUALITE.Tissu.EntreeTissu', compact('historyEntree', 'familleTissu', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur'));
    }

    public function page_ajout_rouleau_qualite($identreetissu)
    {
        $conformite = TestConformiteTissu::where('identreetissu', $identreetissu)->where('etat', 0)->first();
        $rouleau = QualiteRouleauTissu::where('identreetissu', $identreetissu)->where('etat', 0)->get();
        $historyEntree = V_Entree_Tissu::find($identreetissu);
        return view('WMS.QUALITE.Tissu.rouleauTissu', compact('rouleau', 'identreetissu', 'conformite', 'historyEntree'));
    }

    public function page_test_conformite_tissu($identreetissu)
    {
        $conformite = TestConformiteTissu::where('etat', 0)
            ->where('identreetissu', $identreetissu)
            ->get();
        $historyEntree = V_Entree_Tissu::find($identreetissu);
        return view('WMS.QUALITE.Tissu.test-conformite', compact('identreetissu', 'conformite', 'historyEntree'));
    }

    public function page_test_fabric_inspection($identreetissu)
    {
        $rouleau = QualiteRouleauTissu::where('etat', 0)->where('identreetissu', $identreetissu)->get();
        $historyEntree = V_Entree_Tissu::find($identreetissu);
        $speedMachine = SPEEDMACHINE::where('etat', 0)->get();
        $choix = CHOIXQUALITE::where('etat', 0)->get();
        $inspectionData = TESTFABRICINSPECTION::where('identreetissu', $identreetissu)->first();
        return view('WMS.QUALITE.Tissu.test-fabric-inspection', compact('identreetissu', 'rouleau', 'historyEntree', 'speedMachine', 'choix', 'inspectionData'));
    }

    public function page_test_fabric_inspection_default($idqualiterouleautissu, $identreetissu)
    {
        $rouleau = QualiteRouleauTissu::find($idqualiterouleautissu);
        $inspectionDefaut = DEFAUTFABRICINSPECTION::where('idqualiterouleautissu', $idqualiterouleautissu)->get();
        $rouleaufabrictissu = ListeQualiteRouleauFabricTissu::where('idqualiterouleautissu', $idqualiterouleautissu)->first();
        $defectFabricType = DefectFabricType::where('etat', 0)->get();
        return view('WMS.QUALITE.Tissu.test-fabric-inspection-defaut', compact('defectFabricType', 'rouleau', 'rouleaufabrictissu', 'idqualiterouleautissu', 'inspectionDefaut'));
    }

    public function page_test_elongation_retraction($identreetissu)
    {
        $rouleauTissu = QualiteRouleauTissu::where('etat', 0)->where('identreetissu', $identreetissu)->get();
        $rouleau = [];
        foreach ($rouleauTissu as $rouleauTissus) {
            $testRetraction = QUALITEROULEAUTISSU_TESTRETRACTION::where('idqualiterouleautissu', $rouleauTissus->id)->first();

            $rouleauTissus->longueurelong = $testRetraction ? $testRetraction->longueurelong : 0;
            $rouleauTissus->laizeelong = $testRetraction ? $testRetraction->laizeelong : 0;
            $rouleauTissus->longueurretrait = $testRetraction ? $testRetraction->longueurretrait : 0;
            $rouleauTissus->laizeretrait = $testRetraction ? $testRetraction->laizeretrait : 0;
            $rouleauTissus->ecartretrait = $testRetraction ? $testRetraction->ecartretrait : 0;

            $rouleau[] = $rouleauTissus;
        }
        $historyEntree = V_Entree_Tissu::find($identreetissu);
        $typeLavage = TYPELAVAGEQUALITE::where('etat', 0)->get();
        $inspectionData = TESTRETRACTION::where('identreetissu', $identreetissu)->first();
        return view('WMS.QUALITE.Tissu.test-elongation-retraction', compact('identreetissu', 'rouleau', 'historyEntree', 'inspectionData', 'typeLavage'));
    }

    public function page_test_nuance($identreetissu)
    {
        $rouleau = [];
        $rouleauTissu = QualiteRouleauTissu::where('etat', 0)->where('identreetissu', $identreetissu)->get();
        foreach ($rouleauTissu as $rouleauTissus) {
            $testRetraction = QUALITEROULEAUTISSU_TESTNUANCE::where('idqualiterouleautissu', $rouleauTissus->id)->first();
            $rouleauTissus->image = $testRetraction ? $testRetraction->image : 0;
            $rouleau[] = $rouleauTissus;
        }
        $historyEntree = V_Entree_Tissu::find($identreetissu);
        $inspectionData = TESTNUANCE::where('identreetissu', $identreetissu)->first();
        return view('WMS.QUALITE.Tissu.test-nuance', compact('identreetissu', 'rouleau', 'historyEntree', 'inspectionData'));
    }

    public function page_test_disgorging($identreetissu)
    {
        $inspectionData = TESTDISCORGING::where('identreetissu', $identreetissu)->first();
        $rouleau = [];
        $rouleauTissu = QualiteRouleauTissu::where('etat', 0)->where('identreetissu', $identreetissu)->get();
        foreach ($rouleauTissu as $rouleauTissus) {
            $testRetractions = QUALITEROULEAUTISSU_TESTDISCORGING::where('idqualiterouleautissu', $rouleauTissus->id)->get();
            foreach ($testRetractions as $testRetraction) {
                $testRetraction->image = $testRetraction->image;
                $testRetraction->typefrottement = $testRetraction->typefrottement;
                $testRetraction->echellegris = $testRetraction->echellegris;
                $testRetraction->duree = $testRetraction->duree;
                $testRetraction->validationtest = $testRetraction->validationtest;
                $testRetraction->remarque = $testRetraction->remarque;

                $rouleau[] = $testRetraction;
            }
        }

        $historyEntree = V_Entree_Tissu::find($identreetissu);
        return view('WMS.QUALITE.Tissu.test-disgorging', compact('rouleauTissu', 'identreetissu', 'rouleau', 'historyEntree', 'inspectionData'));
    }
    function rapportInspectionTissu($identreetissu)
    {
        $historyEntree = V_Entree_Tissu::find($identreetissu);
        $inspectionTissuRapport = V_inspection_tissu_rapport::where('identreetissu', $identreetissu)->first();
        $grammageTissuRapport = V_GRAMMAGE_TISSU_RAPPORT::where('identreetissu', $identreetissu)->get();
        $inspection100Rapport = V_INSPECTION_100_RAPPORT::where('identreetissu', $identreetissu)->get();
        $totalInspection100 = V_TOTAL_INSPECTION_100_RAPPORT::where('identreetissu', $identreetissu)->first();
        $detailmetrageaizeRapport = V_DETAIL_METRAGE_LAIZE_RAPPORT::where('identreetissu', $identreetissu)->get();
        $totaleDetailMetrageLaizeRapport = V_TOTALE_DETAIL_METRAGE_LAIZE_RAPPORT::where('identreetissu', $identreetissu)->first();
        $detailmetrageLotRapport = V_DETAIL_METRAGE_LOT_RAPPORT::where('identreetissu', $identreetissu)->get();
        $totaleDetailMetrageLotRapport = V_TOTALE_DETAIL_METRAGE_LOT_RAPPORT::where('identreetissu', $identreetissu)->first();
        $fabricInspection = TESTFABRICINSPECTION::where('identreetissu', $identreetissu)->first();
        $resultatInspection = V_RESULTAT_INSPECTION_TISSU_RAPPORT::where('identreetissu', $identreetissu)->first();
        return view('WMS.QUALITE.Tissu.rapport-inspection', compact('resultatInspection', 'totalInspection100', 'historyEntree', 'inspectionTissuRapport', 'grammageTissuRapport', 'inspection100Rapport', 'detailmetrageaizeRapport', 'totaleDetailMetrageLaizeRapport', 'detailmetrageLotRapport', 'totaleDetailMetrageLotRapport', 'fabricInspection'));
    }
    //!------------------------------------ACCESSOIRE------------------------------------!//
    public function entreeQualiteAccesoire()
    {
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $familleWMS = FamilleWMS::where('idwms_type', 1)->where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $historyEntree = V_ENTREE_WMS::where('idwms_type', 1)->get();

        return view('WMS.QUALITE.Accessoire.EntreeAccessoire', compact('historyEntree', 'familleWMS', 'classeMatiere', 'client', 'fournisseur'));
    }
    public function inspectionQualiteAccesoire($idfamillewms, $identreewms)
    {
        $historyEntree = V_ENTREE_WMS::find($identreewms);
        $correctiveAction = WMSQUALITYCORRECTIVEACTION::where('etat', 0)->get();
        $codificationFamille = CodificationAccessoire_FamilleWMS::where('idfamillewms', $idfamillewms)->get();

        $codification = [];
        $inspectionData = INSPECTIONACCESSOIRE::where('identreewms', $identreewms)->first();
        $defaut = CODIFICATIONACCESSOIRE_INSPECTIONACCESSOIRE::where('idinspectionaccessoire', $inspectionData->id)->get();
        foreach ($codificationFamille as $codificationFamilles) {
            $codification[] = CodificationAccessoire::where('id', $codificationFamilles->idcodificationaccessoire)->first();
        }
        return view('WMS.QUALITE.Accessoire.inspection-accessoire', compact('inspectionData', 'codification', 'historyEntree', 'correctiveAction', 'defaut'));
    }
}
