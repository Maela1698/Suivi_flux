<?php

namespace App\Http\Controllers\QUALITECONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\CategorieTissus;
use App\Models\ClasseMatierePremiere;
use App\Models\FamilleTissus;
use App\Models\QUALITEModel\QualiteRouleauTissu;
use App\Models\QUALITEModel\TestConformiteTissu;
use App\Models\Tiers;
use App\Models\WMSMODEL\QUALITEModel\CHOIXQUALITE;
use App\Models\WMSMODEL\QUALITEModel\CodificationAccessoire;
use App\Models\WMSMODEL\QUALITEModel\CodificationAccessoire_FamilleWMS;
use App\Models\WMSMODEL\QUALITEModel\CODIFICATIONACCESSOIRE_INSPECTIONACCESSOIRE;
use App\Models\WMSMODEL\QUALITEModel\DEFAUTFABRICINSPECTION;
use App\Models\WMSMODEL\QUALITEModel\INSPECTIONACCESSOIRE;
use App\Models\WMSMODEL\QUALITEModel\QUALITEROULEAUTISSU_TESTDISCORGING;
use App\Models\WMSMODEL\QUALITEModel\QUALITEROULEAUTISSU_TESTNUANCE;
use App\Models\WMSMODEL\QUALITEModel\QUALITEROULEAUTISSU_TESTRETRACTION;
use App\Models\WMSMODEL\QUALITEModel\SPEEDMACHINE;
use App\Models\WMSMODEL\QUALITEModel\TESTDISCORGING;
use App\Models\WMSMODEL\QUALITEModel\TESTFABRICINSPECTION;
use App\Models\WMSMODEL\QUALITEModel\TESTNUANCE;
use App\Models\WMSMODEL\QUALITEModel\TESTRETRACTION;
use App\Models\WMSMODEL\QUALITEModel\TYPELAVAGEQUALITE;
use App\Models\WMSMODEL\QUALITEModel\WMSQUALITYCORRECTIVEACTION;
use App\Models\WMSModel\UtilisationWMS;
use App\Models\WMSModel\V_Entree_Tissu;
use App\Models\WMSMODEL\WMS\FamilleWMS;
use App\Models\WMSMODEL\WMS\Type_wms;
use App\Models\WMSMODEL\WMS\V_ENTREE_WMS;

class PageQualite extends Controller
{
    //!------------------------------------TISSU------------------------------------!//
    public function entreeQualiteTissu()
    {
        $familleTissu = FamilleTissus::where('etat', 0)->get();
        $historyEntree = V_Entree_Tissu::orderBy('dateentree', 'desc')
            ->take(100)
            ->get();
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
        $testConformite = TestConformiteTissu::where('identreetissu', $identreetissu)->first();
        $inspectionDefaut = DEFAUTFABRICINSPECTION::where('idqualiterouleautissu', $idqualiterouleautissu)->get();
        return view('WMS.QUALITE.Tissu.test-fabric-inspection-defaut', compact('testConformite', 'idqualiterouleautissu', 'inspectionDefaut'));
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
            $testRetraction = QUALITEROULEAUTISSU_TESTDISCORGING::where('idqualiterouleautissu', $rouleauTissus->id)->first();

            $rouleauTissus->image = $testRetraction ? $testRetraction->image : null;
            $rouleauTissus->typefrottement = $testRetraction ? $testRetraction->typefrottement : null;
            $rouleauTissus->echellegris = $testRetraction ? $testRetraction->echellegris : null;
            $rouleauTissus->duree = $testRetraction ? $testRetraction->duree : null;
            $rouleauTissus->validationtest = $testRetraction ? $testRetraction->validationtest : null;
            $rouleauTissus->remarque = $testRetraction ? $testRetraction->remarque : null;

            $rouleau[] = $rouleauTissus;
        }

        $historyEntree = V_Entree_Tissu::find($identreetissu);
        return view('WMS.QUALITE.Tissu.test-disgorging', compact('identreetissu', 'rouleau', 'historyEntree', 'inspectionData'));
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
