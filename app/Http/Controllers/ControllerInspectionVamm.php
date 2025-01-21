<?php

namespace App\Http\Controllers;

use App\Models\InspectionVamm;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControllerInspectionVamm extends Controller
{
    public function listeInspectionSerigraphie(Request $request)
    {
        $nomSaison = $request->input('nomSaison');
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $nomTiers = $request->input('nomTiers');
        $idTiers = $request->input('idTiers');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');

        if (empty($nomSaison)) {
            $idSaison = "";
        }
        if (empty($nomTiers)) {
            $idTiers = "";
        }

        $condition="";
        if(!empty($dateDebut) && !empty($dateFin)){
            $condition = $condition . " and date_inspection between '".$dateDebut."' and '".$dateFin."'";
        }
        if(!empty($idSaison)){
            $condition = $condition . " and id_saison=". $idSaison;
        }
        if(!empty($idTiers)){
            $condition = $condition . " and id_tiers=". $idTiers;
        }
        if(!empty($modele)){
            $condition = $condition . " and nom_modele ILIKE '%". $modele."%'";
        }
        $condition = $condition ." order by id desc";
        $inspection = InspectionVamm::listeInspectionByTypeVamm(1,$condition);
        $typeDefaut = InspectionVamm::getAllTypeDefautByTypeVamm(1);

        return view('VAMM.SERIGRAPHIE.inspectionSer', compact('dateFin','dateDebut','idTiers','nomTiers','modele','idSaison','nomSaison','typeDefaut','inspection'));
    }

    public function insertInspection(Request $request)
    {
        $nombre = $request->input('nombre');
        $typeDefaut = $request->input('typeDefaut');
        $nombreInspection = $request->input('nombreInspection');
        $iddemande = $request->input('iddemande');
        $dateInspection = Carbon::now()->format('Y-m-d H:i:s');
        $inspection = new InspectionVamm();
        $inspection->insertInspectionVamm($iddemande,$dateInspection,$nombreInspection);

        $dernierInspection = InspectionVamm::getInspectionByDemande();
        for($i=0; $i<count($typeDefaut); $i++){
            if($nombre[$i]!=0){
                $detail = new InspectionVamm();
                $detail->insertDetailInspectionVamm($dernierInspection[0]->id,$typeDefaut[$i], $nombre[$i]);
            }

        }

        $detailInspection = InspectionVamm::listeDetailInspectioByIdInspection($dernierInspection[0]->id);
        if($detailInspection[0]->id_type_vamm==1){
            return redirect()->route('SERIGRAPHIE.listeInspectionSerigraphie');
        }elseif($detailInspection[0]->id_type_vamm==2){
            return redirect()->route(route: 'LBT.listeInspectionLBT');
        }
        elseif($detailInspection[0]->id_type_vamm==3){
            return redirect()->route(route: 'BRODMAIN.listeInspectionBroderieMain');
        }
        elseif($detailInspection[0]->id_type_vamm==4){
            return redirect()->route(route: 'BRODMACHINE.listeInspectionBroderieMachine');
        }

    }

    public function listeInspectionLBT(Request $request)
    {
        $nomSaison = $request->input('nomSaison');
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $nomTiers = $request->input('nomTiers');
        $idTiers = $request->input('idTiers');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');

        if (empty($nomSaison)) {
            $idSaison = "";
        }
        if (empty($nomTiers)) {
            $idTiers = "";
        }

        $condition="";
        if(!empty($dateDebut) && !empty($dateFin)){
            $condition = $condition . " and date_inspection between '".$dateDebut."' and '".$dateFin."'";
        }
        if(!empty($idSaison)){
            $condition = $condition . " and id_saison=". $idSaison;
        }
        if(!empty($idTiers)){
            $condition = $condition . " and id_tiers=". $idTiers;
        }
        if(!empty($modele)){
            $condition = $condition . " and nom_modele ILIKE '%". $modele."%'";
        }
        $condition = $condition ." order by id desc";
        $inspection = InspectionVamm::listeInspectionByTypeVamm(2,$condition);
        $typeDefaut = InspectionVamm::getAllTypeDefautByTypeVamm(2);
        return view('VAMM.LBT.inspectionLBT', compact('dateFin','dateDebut','modele','nomTiers','idTiers','idSaison','nomSaison','typeDefaut','inspection'));
    }

    public function listeInspectionBroderieMain(Request $request)
    {
        $nomSaison = $request->input('nomSaison');
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $nomTiers = $request->input('nomTiers');
        $idTiers = $request->input('idTiers');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');

        if (empty($nomSaison)) {
            $idSaison = "";
        }
        if (empty($nomTiers)) {
            $idTiers = "";
        }

        $condition="";
        if(!empty($dateDebut) && !empty($dateFin)){
            $condition = $condition . " and date_inspection between '".$dateDebut."' and '".$dateFin."'";
        }
        if(!empty($idSaison)){
            $condition = $condition . " and id_saison=". $idSaison;
        }
        if(!empty($idTiers)){
            $condition = $condition . " and id_tiers=". $idTiers;
        }
        if(!empty($modele)){
            $condition = $condition . " and nom_modele ILIKE '%". $modele."%'";
        }

        $pieceProduite=0;
        $sommeInspecter=0;
        $nbrInspecter=0;
        $sommeTauxRejet=0;
        $pourcentageDefaut=0;
        if(!empty($condition)){
            $pieceProduite = InspectionVamm::sommeQteProduite($condition);
            $sommeInspecter = InspectionVamm::sommeQteInspecter(3,$condition);
            $nbrInspecter = InspectionVamm::compteNbInspecter(3, $condition);
            $sommeTauxRejet = InspectionVamm::sommeTauxRejet(3,$condition);
            $pourcentageDefaut = $sommeTauxRejet[0]->sommeTauxRetouche/$nbrInspecter[0]->compte;
        }
        // dd($pieceProduite);
        $condition = $condition ." order by id desc";
        $inspection = InspectionVamm::listeInspectionByTypeVamm(3,$condition);
        $typeDefaut = InspectionVamm::getAllTypeDefautByTypeVamm(3);

        return view('VAMM.BROAD_MAIN.inspectionBrodMain', compact('pourcentageDefaut','sommeTauxRejet','nbrInspecter','sommeInspecter','pieceProduite','nomTiers','idTiers','dateFin','dateDebut','modele','idSaison','nomSaison','typeDefaut','inspection'));
    }

    public function listeInspectionBroderieMachine(Request $request)
    {
        $nomSaison = $request->input('nomSaison');
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $nomTiers = $request->input('nomTiers');
        $idTiers = $request->input('idTiers');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');

        if (empty($nomSaison)) {
            $idSaison = "";
        }
        if (empty($nomTiers)) {
            $idTiers = "";
        }

        $condition="";
        if(!empty($dateDebut) && !empty($dateFin)){
            $condition = $condition . " and date_inspection between '".$dateDebut."' and '".$dateFin."'";
        }
        if(!empty($idSaison)){
            $condition = $condition . " and id_saison=". $idSaison;
        }
        if(!empty($idTiers)){
            $condition = $condition . " and id_tiers=". $idTiers;
        }
        if(!empty($modele)){
            $condition = $condition . " and nom_modele ILIKE '%". $modele."%'";
        }
        $condition = $condition ." order by id desc";
        $inspection = InspectionVamm::listeInspectionByTypeVamm(4,$condition);
        $typeDefaut = InspectionVamm::getAllTypeDefautByTypeVamm(4);
        return view('VAMM.BROAD_MACHINE.inspectionBrodMachine', compact('nomSaison','idSaison','modele','nomTiers','idTiers','dateDebut','dateFin','typeDefaut','inspection'));
    }

}
