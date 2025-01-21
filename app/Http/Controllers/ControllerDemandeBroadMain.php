<?php

namespace App\Http\Controllers;

use App\Models\BroadMain;
use App\Models\DemandeClient;
use App\Models\EtatDemandeClient;
use App\Models\InspectionVamm;
use App\Models\Lavage;
use App\Models\Smv;
use App\Models\UniteMonetaire;
use App\Models\ValeurAjoute;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerDemandeBroadMain extends Controller
{
    public function listeBroderieMain(Request $request)
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
        $conditionNbCommande="";
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
            $conditionNbCommande = $conditionNbCommande. " and id_saison=". $idSaison;
        }
        if (!empty($modele)) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
            $conditionNbCommande = $conditionNbCommande. " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and id_tiers=" . $idTiers;
            $conditionNbCommande = $conditionNbCommande. " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition = $condition . " and id_style=" . $idStyle;
            $conditionNbCommande = $conditionNbCommande. " and id_style=" . $idStyle;
        }
        if (!empty($idStade)) {
            $condition = $condition . " and type_stade='" . $idStade."'";
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and date_entree between '" . $dateDebut . "' and '" . $dateFin."'";
            $conditionNbCommande = $conditionNbCommande. " and date_entree between '" . $dateDebut . "' and '" . $dateFin."'";
        }
        if (!empty($etatDemande)) {
            $condition = $condition . " and type_etat='" . $etatDemande . "'";
            $conditionNbCommande = $conditionNbCommande. " and type_etat='" . $etatDemande . "'";
        }

        $condition1 = $condition . " order by id desc";
        $demande = BroadMain::getDemandeWithBroadMainAndSmock($condition1);

        $nbDemande =count($demande);
        $nbDemandeDev=BroadMain::getNbCommandeDevBrodMainAndSmock($condition);
        $nbDemandeDev = $nbDemandeDev[0]->compte;
        $nbDemandeProd=BroadMain::getNbCommandeProdBrodMainAndSmock($condition);
        $nbDemandeProd = $nbDemandeProd[0]->compte;
        $etat = EtatDemandeClient::all();
        $typeDefaut = InspectionVamm::getAllTypeDefautByTypeVamm(3);
        $nombreInspection = InspectionVamm::calculNombreInspectionByTypeVamm(3);
        return view('VAMM.BROAD_MAIN.listeDemandeBroadMain', compact('nombreInspection','typeDefaut','nbDemandeProd','nbDemandeDev','nbDemande','dateFin', 'dateDebut', 'idStade', 'nomStade', 'etatDemande', 'idStyle', 'nomStyle', 'idTiers', 'nomTiers', 'modele', 'idSaison', 'nomSaison', 'etat', 'demande'));
    }

    public function detailDemandeBrodMain(Request $request)
    {
        $idDemande = $request->input('idDemande') ?? session('idDemande');
        $request->session()->put('idDemandeBrodMain', $idDemande);
        $tailles = DemandeClient::getTailleByIdDemande($idDemande);
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        $dossiertech = DemandeClient::getDossierTechniqueById($idDemande);
        // $demandeMain = BroadMain::getAllDemandeBroadMainById($id);
        $lavage = Lavage::getAllLavageDemandeById($idDemande);
        $valeur = ValeurAjoute::getAllValeurDemandeById($idDemande);
        $results = DB::select(" select sum(quantite) as somme from detailtailledemandeclient where id_demande_client=" . $idDemande);
        $somme = $results[0]->somme ?? 0;
        return view('VAMM.BROAD_MAIN.detailDemandeBrodMain', compact('somme', 'demande', 'lavage', 'valeur', 'dossiertech', 'tailles', 'idDemande'));
    }

    public function formAjoutConsoFil(Request $request)
    {
        $idDCBrodMain = $request->session()->get('idDemandeBrodMain');
        $demandeBrodMain = BroadMain::getAllDemandeBroadMainById($idDCBrodMain);
        $uniteMonetaire = UniteMonetaire::getAllUniteMonetaire();
        $smv = Smv::getDernierSmvByIdDemande($demandeBrodMain[0]->id_demande_client);

        return view('VAMM.BROAD_MAIN.consoFil', compact('smv','uniteMonetaire'));
    }

    public function ajoutConsoFil(Request $request)
    {
        $nbHeure = $request->input('nbHeure');
        $prix = $request->input('prix');
        $unite = $request->input('unite');
        $couleur = $request->input('couleur');
        $conso = $request->input('conso');
        $idDCBrodMain = $request->session()->get('idDemandeBrodMain');

        $consoFil = new BroadMain();
        $consoFil->insertConsoFilBrodMain($idDCBrodMain,$nbHeure,$prix,$unite);

        $dernierConsoFil = BroadMain::getDernierConsoFil();
        for($i=0; $i<count($couleur); $i++){
            $detailConso = new BroadMain();
            $detailConso->insertDetailConsoFilBrodMain($dernierConsoFil[0]->id, $couleur[$i], $conso[$i]);
        }
        return redirect()->route('BRODMAIN.listeConsoFil');
    }


    public function listeConsoFil(Request $request)
    {
        $idDCBrodMain = $request->session()->get('idDemandeBrodMain');
        $conso = BroadMain::getConsoFilByDemande($idDCBrodMain);
        $demande = BroadMain::getAllDemandeBroadMainById($idDCBrodMain);
        return view('VAMM.BROAD_MAIN.listeConsoFil', compact('demande','conso'));
    }

    public function formModifConsoFil(Request $request)
    {
        $idDCBrodMain = $request->session()->get('idDemandeBrodMain');
        $conso = BroadMain::getConsoFilByDemande($idDCBrodMain);
        $uniteMonetaire = UniteMonetaire::getAllUniteMonetaire();
        return view('VAMM.BROAD_MAIN.modifConsoFil', compact('conso','uniteMonetaire'));
    }

    public function modifConsoFil(Request $request)
    {
        $nbHeure = $request->input('nbHeure');
        $id = $request->input('id');
        $prix = $request->input('prix');
        $unite = $request->input('unite');
        $couleur = $request->input('couleur');
        $conso = $request->input('conso');
        $idDCBrodMain = $request->session()->get('idDemandeBrodMain');

        BroadMain::updateConsoFilBroadMain($id,$nbHeure,$unite,$prix);

        BroadMain::deleteDetailConsoFilByIdConso($id);
        for($i=0; $i<count($couleur); $i++){
            $detailConso = new BroadMain();
            $detailConso->insertDetailConsoFilBrodMain($id, $couleur[$i], $conso[$i]);
        }
        return redirect()->route('BRODMAIN.listeConsoFil');
    }


    public function ajoutSuiviFluxBrodMain(Request $request)
    {
        $iddemandeBrodMain = $request->session()->get('idDemandeBrodMain');
        $idDemande= $request->input('idDemande');

        $id='';
        if(!empty($idDemande)){
            $id= $idDemande;
        }else{
            $id= $iddemandeBrodMain;
        }
        $type = $request->input('type');
        $qte = $request->input('qte');
        $recoupe = $request->input('recoupe');
        $dateOper = $request->input('dateOper');
        $suivi = new BroadMain();
        $suivi->insertSuiviFluxBrodMain($id, $dateOper, $type, $qte, $recoupe);
        return redirect()->route('BRODMAIN.listeSuiviFluxBrodMain');
    }

    public function listeSuiviFluxBrodMain(Request $request)
    {
        $suivi = BroadMain::getSuiviFluxBrodMain();
        return view('VAMM.BROAD_MAIN.listeSuiviFluxBrodMain', compact('suivi'));
    }

    public function planningBrodMain(Request $request)
    {
        $demandeBrod = BroadMain::getAllDemandeBroderieMainPlanning();
        $demandeSmock = BroadMain::getAllDemandeSmockMainPlanning();
        $demandeBrodProd = BroadMain::getAllDemandeBroderieMainProdPlanning();
        $demandeSmockProd = BroadMain::getAllDemandeSmockMainProdPlanning();
        $demandeDistinct = BroadMain::getAllDemandeBroderieSmockMainPlanning();
        return view('VAMM.BROAD_MAIN.planningBrodMain', compact('demandeSmockProd','demandeBrodProd','demandeDistinct','demandeBrod','demandeSmock'));
    }

    public function finEtapePlanningBrodMachine(Request $request)
    {
        $idDemandeBrodMain = $request->input('iddemandeBrod');
        $idEtape = $request->input('idEtape');
        $deadlineBrod = $request->input('deadlineBrod');
        if($idEtape==1){
            BroadMain::updateApproMpBrodMain($idDemandeBrodMain);
        }
        elseif($idEtape==2){
            BroadMain::updatePliTissuBrodMain($idDemandeBrodMain);
        }elseif($idEtape==3){
            BroadMain::updateDessinBrodMain($idDemandeBrodMain);
        }elseif($idEtape==4){
            BroadMain::updatePoncageBrodMain($idDemandeBrodMain);
        }elseif($idEtape==5){
            BroadMain::updateDeveloppementBrodMain($idDemandeBrodMain);
        }
        $dateFin = Carbon::now()->format('Y-m-d H:i:s');
        $planningBrod = new BroadMain();
        $planningBrod->insertPlanningBrodMain($idDemandeBrodMain,$deadlineBrod,$dateFin, $idEtape);
        return redirect()->route('BRODMAIN.planningBrodMain');
    }

    public function planningFiniBrodMain(Request $request)
    {

        $demandeBrod = BroadMain::getAllDemandeBroderieMainPlanning();
        $demandeSmock = BroadMain::getAllDemandeSmockMainPlanning();
        $demandeBrodProd = BroadMain::getAllDemandeBroderieMainProdPlanning();
        $demandeSmockProd = BroadMain::getAllDemandeSmockMainProdPlanning();
        $demandeDistinct = BroadMain::getAllDemandeBroderieSmockMainPlanning();
        return view('VAMM.BROAD_MAIN.planningFiniBrodMain', compact('demandeSmockProd','demandeBrodProd','demandeDistinct','demandeBrod','demandeSmock'));
    }

    public function ajoutRapportJournalierBrodMain(Request $request)
    {
        $iddemandeBrodMain = $request->session()->get('idDemandeBrodMain');

        $data = [
            'id_demande_client' => $iddemandeBrodMain,
            'date_rapport' => $request->input('dateProd'),
            'conso_electricite' => $request->input('consoElectricite'),
            'valeur_electricite' => $request->input('valeurElectricite'),
            'nb_lancement' => $request->input('nbLancement'),
            'nc_traite' => $request->input('ncTraite'),
            'taux_rejet' => $request->input('rejet'),
            'taux_retouche' => $request->input('retouche'),
            'absenteisme' => $request->input('absenteisme'),
            'commentaire' => $request->input('commentaire'),
            'nb_operateur' => $request->input('nbOperateur')
        ];

        $rapport = new BroadMain();
        $rapport->insertRapportJournalierBrodMain($data);

        $dernierRapportJournalier = BroadMain::rapportJournalierBrodMainDernier();

        $heure = $request->input('heure');
        $qte = $request->input('qte');
        for($i=0; $i<count($qte); $i++){
            $detailRapport = new BroadMain();
            $detailRapport->insertDetailRapportJournalierBrodMain($dernierRapportJournalier[0]->id,$heure[$i], $qte[$i]);
        }

        return redirect()->route('BRODMAIN.listeRapportJournalierBrodMain');
    }

    public function listeRapportJournalierBrodMain(Request $request)
    {
        $rapport = BroadMain::getRapportJournalierBrodMain();
        return view('VAMM.BROAD_MAIN.listeRapportJournalierBrodMain', compact('rapport'));
    }


}
