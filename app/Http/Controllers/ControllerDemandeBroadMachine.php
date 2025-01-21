<?php

namespace App\Http\Controllers;

use App\Models\BroadMachine;
use App\Models\DemandeClient;
use App\Models\EtatDemandeClient;
use App\Models\InspectionVamm;
use App\Models\Lavage;
use App\Models\Serigraphie;
use App\Models\Smv;
use App\Models\ValeurAjoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerDemandeBroadMachine extends Controller
{
    public function listeBroderieMachine(Request $request)
    {
        $nomSaison = $request->input('nomSaison');
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $nomTiers = $request->input('nomTiers');
        $idTiers = $request->input('idTiers');
        $nomStyle = $request->input('nomStyle');
        $idStyle = $request->input('idStyle');
        $etatDemande = $request->input('etatDemande');
        $nomStade = $request->input('nomStade');
        $idStade = $request->input('idStade');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $condition = "";
        if (empty($nomSaison)) {
            $idSaison = "";
        }
        if (empty($nomTiers)) {
            $idTiers = "";
        }
        if (empty($nomStyle)) {
            $idStyle = "";
        }
        if (empty($nomStade)) {
            $idStade = "";
        }
        if (!empty($idSaison)) {
            $condition = $condition . " and id_saison=" . $idSaison;
        }
        if (!empty($modele)) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition = $condition . " and id_style=" . $idStyle;
        }
        if (!empty($idStade)) {
            $condition = $condition . " and type_stade='" . $idStade."'";
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and date_entree between '" . $dateDebut . "' and '" . $dateFin."'";
        }
        if (!empty($etatDemande)) {
            $condition = $condition . " and type_etat='" . $etatDemande . "'";
        }

        $condition1 = $condition . " order by id desc";
        $demande = BroadMachine::getAllDemandeBroadMachine($condition1);
        $etat = EtatDemandeClient::all();

        $nombre = count($demande);
        $qte = BroadMachine::sommeQuantiteBroderieMachine($condition);
        $qte = $qte[0]->somme;
        $nego = BroadMachine::sommeNegoBroderieMachine($condition);
        $nego = $nego[0]->somme;
        $proto = BroadMachine::sommeProtoBroderieMachine($condition);
        $proto = $proto[0]->somme;
        $tds = BroadMachine::sommeTDSBroderieMachine($condition);
        $tds = $tds[0]->somme;
        $pps = BroadMachine::sommePPSBroderieMachine($condition);
        $pps = $pps[0]->somme;
        $prod = BroadMachine::sommePRODBroderieMachine($condition);
        $prod = $prod[0]->somme;
        $typeDefaut = InspectionVamm::getAllTypeDefautByTypeVamm(4);
        $nombreInspection = InspectionVamm::calculNombreInspectionByTypeVamm(4);
        return view('VAMM.BROAD_MACHINE.listeDemandeBroadMachine', compact('nombreInspection','typeDefaut','nombre','qte','nego','proto','tds','pps','prod','dateFin', 'dateDebut', 'idStade', 'nomStade', 'etatDemande', 'idStyle', 'nomStyle', 'idTiers', 'nomTiers', 'modele', 'idSaison', 'nomSaison', 'etat', 'demande'));
    }

    public function detailDemandeBroderieMachine(Request $request)
    {
        $idDemande = $request->input('idDemande');
        $request->session()->put('idDemandeBrodMachine', $idDemande);
        $demande = BroadMachine::getAllDemandeWithBroadMachine($idDemande);
        $dossiertech = DemandeClient::getDossierTechniqueById($idDemande);
        $lavage = Lavage::getAllLavageDemandeById($idDemande);
        $tailles = DemandeClient::getTailleByIdDemande($idDemande);
        $valeur = ValeurAjoute::getAllValeurDemandeById($idDemande);
        $results = DB::select(" select sum(quantite) as somme from detailtailledemandeclient where id_demande_client=" . $idDemande);
        $somme = $results[0]->somme ?? 0;
        return view('VAMM.BROAD_MACHINE.detailDemandeBrodMachine', compact('somme', 'demande', 'lavage', 'valeur', 'dossiertech', 'tailles', 'idDemande'));
    }

    public function planningBrodMachine(Request $request)
    {
        $nomSaison = $request->input('nomSaison');
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $nomTiers = $request->input('nomTiers');
        $idTiers = $request->input('idTiers');
        $nomStyle = $request->input('nomStyle');
        $idStyle = $request->input('idStyle');
        $etatDemande = $request->input('etatDemande');
        $nomStade = $request->input('nomStade');
        $idStade = $request->input('idStade');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $condition = "";
        if (empty($nomSaison)) {
            $idSaison = "";
        }
        if (empty($nomTiers)) {
            $idTiers = "";
        }
        if (empty($nomStyle)) {
            $idStyle = "";
        }
        if (empty($nomStade)) {
            $idStade = "";
        }
        if (!empty($idSaison)) {
            $condition = $condition . " and id_saison=" . $idSaison;
        }
        if (!empty($modele)) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition = $condition . " and id_style=" . $idStyle;
        }
        if (!empty($idStade)) {
            $condition = $condition . " and type_stade='" . $idStade."'";
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and date_entree between '" . $dateDebut . "' and '" . $dateFin."'";
        }
        if (!empty($etatDemande)) {
            $condition = $condition . " and type_etat='" . $etatDemande . "'";
        }

        $condition1 = $condition . " order by id desc";
        $demandePremier = BroadMachine::getDemandeBroadMachinePremier($condition);
        $demandeChangeStade = BroadMachine::getDemandeChangeEtatBroadMachine($condition);
        $demandeProd = BroadMachine::getDemandeProdBrodMachine($condition);
        $etat = EtatDemandeClient::all();
        return view('VAMM.BROAD_MACHINE.planningBroadMachine', compact('etat', 'dateFin', 'dateDebut', 'idStade', 'nomStade', 'etatDemande', 'idStyle', 'nomStyle', 'idTiers', 'nomTiers', 'modele', 'idSaison', 'nomSaison','demandeProd', 'demandeChangeStade', 'demandePremier'));
    }

    public function finEtapePlanningBrodMachine(Request $request)
    {
        $idDemandeBrodMachine = $request->input('idDemandeBrodMachine');
        $idEtape = $request->input('idEtape');
        $brodMachine = new BroadMachine();
        if ($idEtape == 1) {
            $brodMachine->updatePAOBrodMachine($idDemandeBrodMachine);
        } elseif ($idEtape == 2) {
            $brodMachine->updateEssaiPnxBrodMachine($idDemandeBrodMachine);
        } elseif ($idEtape == 3) {
            $brodMachine->updateCotationBrodMachine($idDemandeBrodMachine);
        } elseif ($idEtape == 4) {
            $brodMachine->updateDemandeAchatMpBrodMachine($idDemandeBrodMachine);
        } elseif ($idEtape == 5) {
            $brodMachine->updateBrodMachineBrodMachine($idDemandeBrodMachine);
        }
        return redirect()->route('BRODMACHINE.planningBrodMachine');
    }

    public function tacheFiniBrodMachine(Request $request)
    {
        $nomSaison = $request->input('nomSaison');
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $nomTiers = $request->input('nomTiers');
        $idTiers = $request->input('idTiers');
        $nomStyle = $request->input('nomStyle');
        $idStyle = $request->input('idStyle');
        $etatDemande = $request->input('etatDemande');
        $nomStade = $request->input('nomStade');
        $idStade = $request->input('idStade');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $condition = "";
        if (empty($nomSaison)) {
            $idSaison = "";
        }
        if (empty($nomTiers)) {
            $idTiers = "";
        }
        if (empty($nomStyle)) {
            $idStyle = "";
        }
        if (empty($nomStade)) {
            $idStade = "";
        }
        if (!empty($idSaison)) {
            $condition = $condition . " and id_saison=" . $idSaison;
        }
        if (!empty($modele)) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition = $condition . " and id_style=" . $idStyle;
        }
        if (!empty($idStade)) {
            $condition = $condition . " and type_stade='" . $idStade."'";
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and date_entree between '" . $dateDebut . "' and '" . $dateFin."'";
        }
        if (!empty($etatDemande)) {
            $condition = $condition . " and type_etat='" . $etatDemande . "'";
        }

        $demandePremier = BroadMachine::getDemandeBroadMachinePremier($condition);
        $demandeChangeStade = BroadMachine::getDemandeChangeEtatBroadMachine($condition);
        $demandeProd = BroadMachine::getDemandeProdBrodMachine($condition);
        $etat = EtatDemandeClient::all();
        return view('VAMM.BROAD_MACHINE.tacheFini', compact('etat', 'dateFin', 'dateDebut', 'idStade', 'nomStade', 'etatDemande', 'idStyle', 'nomStyle', 'idTiers', 'nomTiers', 'modele', 'idSaison', 'nomSaison','demandeProd', 'demandeChangeStade', 'demandePremier'));
    }

    public function listeNombrePointsBrodMachine(Request $request)
    {
        $idDCBrodMachine = $request->session()->get('idDemandeBrodMachine');
        $demande = BroadMachine::getAllDemandeWithBroadMachine($idDCBrodMachine);
        $tailles = DemandeClient::getTailleByIdDemande($idDCBrodMachine);
        $nombrePoints = BroadMachine::getNombrePointsByDemande($idDCBrodMachine);
        $dernierNbPoints = BroadMachine::getNombrePointsByDemande($idDCBrodMachine);
        $detailNbPoints=null;
        if(count($dernierNbPoints)!=0){
            $detailNbPoints = BroadMachine::getDetailNombrePointsByIdNbPoints($dernierNbPoints[0]->id);
        }
        return view('VAMM.BROAD_MACHINE.nombrePointsBrodMachine', compact('detailNbPoints','nombrePoints','tailles', 'demande'));
    }

    public function insertNombrePointsBrodMachine(Request $request)
    {
        $idDCBrodMachine = $request->session()->get('idDemandeBrodMachine');
        $demande = BroadMachine::getAllDemandeWithBroadMachine($idDCBrodMachine);
        $tailles = DemandeClient::getTailleByIdDemande($idDCBrodMachine);
        $tempsMachine = $request->input('tempsMachine');
        $tempsNettoyage = $request->input('tempsNettoyage');
        $tempsGarnissage = $request->input('tempsGarnissage');
        $taille = $request->input('taille');
        $nbPoints = $request->input('nbPoints');
        $quantite = $request->input('quantite');
        $smvDemande = Smv::getDernierSmvByIdDemande($idDCBrodMachine);
        BroadMachine::updateTempsGarnissage($tempsGarnissage);
        BroadMachine::updateTempsNettoyage($tempsNettoyage);
        BroadMachine::updateTempsMachine($tempsMachine);
        $smvBcm = BroadMachine::getSmvBmc();
        $countTaille = count($tailles);
        $tempsTotal = [];
        for($i=0; $i<count($smvBcm); $i++){
            $tempsTotal[]=$smvBcm[$i]->temps*$countTaille;
        }
        $tempsPiece =[];
        for($j=0; $j<count($smvBcm); $j++){
            $tempsPiece[]=$tempsTotal[$j]*$demande[0]->qte_commande_provisoire;
        }
        $sommeSmv = array_sum($tempsPiece);
        $listeNbPoints=[];
        for($n=0; $n<count($tailles); $n++){
            $listeNbPoints[] = $nbPoints[$n]*$quantite[$n];
        }
        $sommeNbPoints = array_sum($listeNbPoints);
        if($sommeNbPoints==0 && count($smvDemande)>0){
            $sommeNbPoints = $smvDemande[0]->nombre_points*$demande[0]->qte_commande_provisoire;
        }
        $nouveauNbPoints = new BroadMachine();
        $nouveauNbPoints->insertNombrePoints($idDCBrodMachine, $sommeSmv, $tempsMachine,$tempsNettoyage,$tempsGarnissage,$sommeNbPoints);
        $dernierNbPoints = BroadMachine::getNombrePointsByDemande($idDCBrodMachine);
        for($t=0; $t<count($tailles);$t++){
            $detailNbPoints = new BroadMachine();
            $detailNbPoints->insertDetailNombrePoints($dernierNbPoints[0]->id,$nbPoints[$t], $taille[$t],$quantite[$t]);
        }
        return redirect()->route('BRODMACHINE.listeNombrePointsBrodMachine');
    }

    public function updateNombrePointsBrodMachine(Request $request)
    {
        $idDCBrodMachine = $request->session()->get('idDemandeBrodMachine');
        $demande = BroadMachine::getAllDemandeWithBroadMachine($idDCBrodMachine);
        $tailles = DemandeClient::getTailleByIdDemande($idDCBrodMachine);
        $tempsMachine = $request->input('tempsMachine');
        $tempsNettoyage = $request->input('tempsNettoyage');
        $tempsGarnissage = $request->input('tempsGarnissage');
        $taille = $request->input('taille');
        $nbPoints = $request->input('nbPoints');
        $quantite = $request->input('quantite');
        $smvDemande = Smv::getDernierSmvByIdDemande($idDCBrodMachine);
        BroadMachine::updateTempsGarnissage($tempsGarnissage);
        BroadMachine::updateTempsNettoyage($tempsNettoyage);
        BroadMachine::updateTempsMachine($tempsMachine);
        $smvBcm = BroadMachine::getSmvBmc();
        $countTaille = count($tailles);
        $tempsTotal = [];
        for($i=0; $i<count($smvBcm); $i++){
            $tempsTotal[]=$smvBcm[$i]->temps*$countTaille;
        }
        $tempsPiece =[];
        for($j=0; $j<count($smvBcm); $j++){
            $tempsPiece[]=$tempsTotal[$j]*$demande[0]->qte_commande_provisoire;
        }
        $sommeSmv = array_sum($tempsPiece);
        $listeNbPoints=[];
        for($n=0; $n<count($tailles); $n++){
            $listeNbPoints[] = $nbPoints[$n]*$quantite[$n];
        }
        $sommeNbPoints = array_sum($listeNbPoints);
        if($sommeNbPoints==0 && count($smvDemande)>0){
            $sommeNbPoints = $smvDemande[0]->nombre_points*$demande[0]->qte_commande_provisoire;
        }
        $nouveauNbPoints = new BroadMachine();
        $nouveauNbPoints->updateNombrePoints($sommeSmv, $tempsMachine, $tempsNettoyage, $tempsGarnissage, $sommeNbPoints, $idDCBrodMachine);
        $dernierNbPoints = BroadMachine::getNombrePointsByDemande($idDCBrodMachine);
        for($t=0; $t<count($tailles);$t++){
            $detailNbPoints = new BroadMachine();
            $detailNbPoints->updateDetailNombrePoints($taille[$t],$quantite[$t],$nbPoints[$t],$dernierNbPoints[0]->id);
        }
        return redirect()->route('BRODMACHINE.listeNombrePointsBrodMachine');
    }

    public function listeConsommableBrodMachine(Request $request)
    {
        $idDCBrodMachine = $request->session()->get('idDemandeBrodMachine');
        $demande = BroadMachine::getAllDemandeWithBroadMachine($idDCBrodMachine);
        $tailles = DemandeClient::getTailleByIdDemande($idDCBrodMachine);
        $nombrePoints = BroadMachine::getNombrePointsByDemande($idDCBrodMachine);
        $dernierNbPoints = BroadMachine::getNombrePointsByDemande($idDCBrodMachine);
        $detailNbPoints=null;
        if(count($dernierNbPoints)!=0){
            $detailNbPoints = BroadMachine::getDetailNombrePointsByIdNbPoints($dernierNbPoints[0]->id);
        }
        return view('VAMM.BROAD_MACHINE.consommableBrodMachine', compact('detailNbPoints','nombrePoints','tailles', 'demande'));
    }

    public function listeSuiviFlux(Request $request)
    {
        $idDCBrodMachine = $request->session()->get('idDemandeBrodMachine');
        $suivi = BroadMachine::listeSuiviFluxMachine();
        return view('VAMM.BROAD_MACHINE.listeSuiviFluxBrodMachine', compact('suivi'));
    }

    public function insertSuiviFlux(Request $request)
    {
        $idDCBrodMachine = $request->session()->get('idDemandeBrodMachine');
        $dateOper = $request->input('dateOper');
        $type = $request->input('type');
        $qte = $request->input('qte');
        $recoupe = $request->input('recoupe');
       $suivi = new BroadMachine();
       $suivi->insertSuiviFluxBrodMachine($idDCBrodMachine,$dateOper,$qte,$recoupe,$type);
       return redirect()->route('BRODMACHINE.listeSuiviFlux');

    }


}
