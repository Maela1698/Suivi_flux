<?php

namespace App\Http\Controllers;

use App\Models\DemandeClient;
use App\Models\Echantillon;
use App\Models\Encre;
use App\Models\EtatDemandeClient;
use App\Models\InspectionVamm;
use App\Models\Lavage;
use App\Models\Sdc;
use App\Models\Serigraphie;
use App\Models\Smv;
use App\Models\Tiers;
use App\Models\V_accessoire;
use App\Models\V_tissus;
use App\Models\ValeurAjoute;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControllerListeDemandeSer extends Controller
{
    public function listeSerigraphie(Request $request)
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
            $condition = $condition .  " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and id_tiers=" . $idTiers;
        }
        if (!empty($idStyle)) {
            $condition = $condition . " and id_style=" . $idStyle;
        }
        if (!empty($idStade)) {
            $condition = $condition . " and type_stade='" . $idStade . "'";
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and date_entree between '" . $dateDebut . "' and '" . $dateFin . "'";
        }
        if (!empty($etatDemande)) {
            $condition = $condition . " and type_etat='" . $etatDemande . "'";
        }

        $condition1 = $condition . " order by id desc";
        $demande = Serigraphie::getAllDemandeClientWithSerigraphie($condition1);

        $nombre = count($demande);
        $qte = Serigraphie::sommeQuantiteSerigraphie($condition);
        $qte = $qte[0]->somme;
        $nego = Serigraphie::sommeNegoSerigraphie($condition);
        $nego = $nego[0]->somme;
        $proto = Serigraphie::sommeProtoSerigraphie($condition);
        $proto = $proto[0]->somme;
        $tds = Serigraphie::sommeTDSSerigraphie($condition);
        $tds = $tds[0]->somme;
        $pps = Serigraphie::sommePPSSerigraphie($condition);
        $pps = $pps[0]->somme;
        $prod = Serigraphie::sommePRODSerigraphie($condition);
        $prod = $prod[0]->somme;

        $etat = EtatDemandeClient::all();
        $typeDefaut = InspectionVamm::getAllTypeDefautByTypeVamm(1);
        $nombreInspection = InspectionVamm::calculNombreInspectionByTypeVamm(1);
        return view('VAMM.SERIGRAPHIE.listeDemandeSer', compact('nombreInspection','typeDefaut','prod', 'pps', 'tds', 'proto', 'nego', 'qte', 'nombre', 'dateFin', 'dateDebut', 'idStade', 'nomStade', 'etatDemande', 'idStyle', 'nomStyle', 'idTiers', 'nomTiers', 'modele', 'idSaison', 'nomSaison', 'etat', 'demande'));
    }

    public function detailDemandeSerigraphie(Request $request)
    {
        $idDemande = $request->input('idDemande') ?? session('idDemande');
        $request->session()->put('idDemandeSer', $idDemande);
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        $lavage = Lavage::getAllLavageDemandeById($idDemande);
        $valeur = ValeurAjoute::getAllValeurDemandeById($idDemande);
        $tailles = DemandeClient::getTailleByIdDemande($idDemande);
        $dossiertech = DemandeClient::getDossierTechniqueById($idDemande);
        return view('VAMM.SERIGRAPHIE.detailDemandeSer', compact('dossiertech', 'tailles', 'valeur', 'demande', 'lavage'));
    }

    public function listeMpSer(Request $request)
    {
        $idDC = $request->session()->get('idDemandeSer');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $listeTissu = V_tissus::getAllV_tissu($idDC);
        $listeAcc = V_accessoire::getAllV_accessoireByDC($idDC);
        return view('VAMM.SERIGRAPHIE.listeMpSer', compact('listeTissu', 'listeAcc', 'idDC', 'demande'));
    }

    public function detailTissuSer(Request $request)
    {
        $id = $request->input('idTissus') ?? session('idTissus');
        $listeTissu = V_tissus::getAllV_tissuById($id);
        return view('VAMM.SERIGRAPHIE.detailTissuSer', compact('listeTissu'));
    }

    public function detailAccessoireSer(Request $request)
    {
        $id = $request->input('idAcc') ?? session('idAcc');
        $listeAcc = V_accessoire::getAllV_accessoireById($id);
        return view('VAMM.SERIGRAPHIE.detailAccesoireSer', compact('listeAcc'));
    }

    public function sdcApercueSer(Request $request)
    {
        $idDemande = $request->session()->get('idDemandeSer');
        $detaildemande = DemandeClient::getAllListeDemandeById($idDemande);
        $sdc = Sdc::where('id_demande_client', $idDemande)->first();
        $idsdc = Sdc::getLastIdSdcByIdDemande($idDemande);
        $detailsdc = Sdc::getDetailSdcById($idDemande);
        $dispomat = Sdc::getDispoMatierePremiere();
        $tissus = V_tissus::getAllV_tissu($idDemande);
        $accessoire = V_accessoire::getAllV_accessoireSansFinition($idDemande);
        $lavage = DemandeClient::getLavageByIdDemande($idDemande);
        $valeur = DemandeClient::getValeurAjoutByIdDemande($idDemande);
        $tier = Tiers::getAllTierByIdTier($detaildemande[0]->id_tiers);
        return view('VAMM.SERIGRAPHIE.sdcApercuSer', compact('tier', 'detaildemande', 'sdc', 'detailsdc', 'dispomat', 'tissus', 'accessoire', 'valeur', 'lavage'));
    }

    public function smvApercue(Request $request)
    {
        $idDemande = $request->session()->get('idDemandeSer');
        $detaildemande = DemandeClient::getAllListeDemandeById($idDemande);
        $smv = Smv::getSmvByIdDemande($idDemande);
        return view('VAMM.SERIGRAPHIE.smvApercuSer', compact('smv', 'detaildemande'));
    }

    public function echantillonApercuSer(Request $request)
    {
        $idDemande = $request->session()->get('idDemandeSer');
        $detaildemande = DemandeClient::getAllListeDemandeById($idDemande);
        $echantillon = Echantillon::getEchantillonByIdDemande($idDemande);
        $tier = Tiers::getAllTierByIdTier($detaildemande[0]->id_tiers);
        return view('VAMM.SERIGRAPHIE.echantillonApercuSer', compact('tier', 'echantillon', 'detaildemande'));
    }

    public function rechercheEncre(Request $request)
    {
        $query = $request->get('encre');

        $encre = Encre::where('encre', 'ILIKE', '%' . $query . '%')->get();

        return response()->json($encre);
    }
    public function formAjoutParametreSer(Request $request)
    {
        $type = Serigraphie::getAllTypeEncre();
        return view('VAMM.SERIGRAPHIE.ajoutParametreSer', compact('type'));
    }

    public function ajoutParametreSer(Request $request)
    {
        $smvPrint = $request->input('smvPrint');
        $qteCoupe = $request->input('qteCoupe');
        $prix = $request->input('prix');
        $typeEncre = $request->input('typeEncre');
        $idEncre = $request->input('idEncre');
        $grammage = $request->input('grammage');
        $couche = $request->input('couche');
        $idDC = $request->session()->get('idDemandeSer');
        $param = new Serigraphie();
        $param->insertParametreSer($smvPrint, $qteCoupe, $idDC, $prix);

        $dernierParam = Serigraphie::getDernierParametreSer();
        for ($i = 0; $i < count($typeEncre); $i++) {
            $detail = new Serigraphie();
            $detail->insertDetailParametreSer($dernierParam[0]->id, $typeEncre[$i], $idEncre[$i], $grammage[$i], $couche[$i]);
        }
        return redirect()->route('SERIGRAPHIE.listeParametreSer');
    }


    public function updateParametreSer(Request $request)
    {
        $smvPrint = $request->input('smvPrint');
        $qteCoupe = $request->input('qteCoupe');
        $prix = $request->input('prix');
        $idDC = $request->session()->get('idDemandeSer');
        Serigraphie::updateParametreSer($smvPrint, $qteCoupe, $idDC, $prix);

        return redirect()->route('SERIGRAPHIE.listeParametreSer');
    }

    public function updateDetailParametreSer(Request $request)
    {

        $typeEncre = $request->input('typeEncre');
        $idEncre = $request->input('idEncre');
        $grammage = $request->input('grammage');
        $couche = $request->input('couche');
        $idDC = $request->session()->get('idDemandeSer');

        $dernierParam = Serigraphie::getParametreSerByDemande($idDC);
        $detail = new Serigraphie();
        $detail->insertDetailParametreSer($dernierParam[0]->id, $typeEncre, $idEncre, $grammage, $couche);

        return redirect()->route('SERIGRAPHIE.listeParametreSer');
    }


    public function deteleDetailParametre(Request $request)
    {

        $idDetail = $request->input('idDetail');
        Serigraphie::deleteDetailParametreSer($idDetail);
        return redirect()->route('SERIGRAPHIE.listeParametreSer');
    }

    public function listeParametreSer(Request $request)
    {
        $idDC = $request->session()->get('idDemandeSer');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $param = Serigraphie::getAllDetailrapport($idDC);
        $type = Serigraphie::getAllTypeEncre();
        return view('VAMM.SERIGRAPHIE.listeParametreSer', compact('type', 'demande', 'param'));
    }

    public function planningSerigraphie(Request $request)
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
            $condition = $condition . " and stadesdc='" . $idStade . "'";
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and date_entree between '" . $dateDebut . "' and '" . $dateFin . "'";
        }
        if (!empty($etatDemande)) {
            $condition = $condition . " and type_etat='" . $etatDemande . "'";
        }


        $etapeSer = Serigraphie::getAllEtapeSerigrahie();
        $demandeSer = Serigraphie::getDemandePremierPlanningSerigraphie($condition);
        $demandeChangeStade = Serigraphie::getDemandeChangeStadePlanningSerigraphie($condition);
        $demandeProd = Serigraphie::getDemandeProdlanningSerigraphie($condition);
        $now = Carbon::now();
        $etat = EtatDemandeClient::all();
        return view('VAMM.SERIGRAPHIE.planningSerigraphie', compact('etat', 'dateFin', 'dateDebut', 'idStade', 'nomStade', 'etatDemande', 'idStyle', 'nomStyle', 'idTiers', 'nomTiers', 'modele', 'idSaison', 'nomSaison', 'demandeProd', 'demandeChangeStade', 'now', 'demandeSer', 'etapeSer'));
    }

    public function insertFluxSerigraphie(Request $request)
    {
        $iddemandeSer = $request->input('iddemandeSer');
        $type = $request->input('type');
        $qte = $request->input('qte');
        $recoupe = $request->input('recoupe');
        $dateOper = $request->input('dateOper');
        $unite = $request->input('unite');
        $suivi = new Serigraphie();
        $suivi->insertSuiviFluxSerigraphie($iddemandeSer, $dateOper, $type);

        $dernierSuivi = Serigraphie::getSuiviFluxSerByDemande($iddemandeSer);
        for($i=0; $i<count($unite); $i++){
            $detailSuivi = new Serigraphie();
            $detailSuivi -> insertDetailSuiviFluxSerigraphie($dernierSuivi[0]->id,$unite[$i], $qte[$i], $recoupe[$i]);
        }
        return redirect()->route('SERIGRAPHIE.listeSuiviFlux');
    }

    public function insertDetailFluxSerigraphie(Request $request)
    {
        $iddemandeSer = $request->input('iddemandeSer');
        $qte = $request->input('qte');
        $recoupe = $request->input('recoupe');
        $unite = $request->input('unite');
        $id = $request->input('id');
        Serigraphie::deleteDetailSuiviFlux($id);
        $dernierSuivi = Serigraphie::getSuiviFluxSerByDemande($iddemandeSer);
        for($i=0; $i<count($unite); $i++){
            $detailSuivi = new Serigraphie();
            $detailSuivi -> insertDetailSuiviFluxSerigraphie($dernierSuivi[0]->id,$unite[$i], $qte[$i], $recoupe[$i]);
        }
        return redirect()->route('SERIGRAPHIE.detailSuiviFlux', parameters: ['id' => $id]);
    }


    public function finEtapePlanning(Request $request)
    {
        $idDemandeSer = $request->input('idDemandeSer');

        $idEtape = $request->input('idEtape');
        $deadline = $request->input('deadlineSer');
        $dateFin = Carbon::now()->format('Y-m-d H:i:s');
        $ser = new Serigraphie();
        if ($idEtape == 1) {
            $ser->updateEtatAchatEncreEchan($idDemandeSer);
        } elseif ($idEtape == 2) {
            $ser->updateEtatPao($idDemandeSer);
        } elseif ($idEtape == 3) {
            $ser->updateEtatPri($idDemandeSer);
        } elseif ($idEtape == 4) {
            $ser->updateEtatImpressionDessin($idDemandeSer);
        } elseif ($idEtape == 5) {
            $ser->updateEtatRecherchColorisValida($idDemandeSer);
        } elseif ($idEtape == 6) {
            $ser->updateEtatInsolaCadre($idDemandeSer);
        } elseif ($idEtape == 7) {
            $ser->updateEtatRaclage($idDemandeSer);
        } elseif ($idEtape == 8) {
            $ser->updateEtatAchatEncreProd($idDemandeSer);
        } elseif ($idEtape == 9) {
            $ser->updateEtatGabarits($idDemandeSer);
        } elseif ($idEtape == 10) {
            $ser->updateEtatPrepaTable($idDemandeSer);
        } elseif ($idEtape == 11) {
            $ser->updateEtatPrepaEncreProd($idDemandeSer);
        }
        $planning = new Serigraphie();
        $planning->insertPlanningSerigraphie($idDemandeSer, $deadline, $dateFin, $idEtape);
        return redirect()->route('SERIGRAPHIE.planningSerigraphie');
    }

    public function tacheFiniSerigraphie(Request $request)
    {
        $etapeSer = Serigraphie::getAllEtapeSerigrahie();
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
            $condition = $condition . " and stadesdc='" . $idStade . "'";
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and date_entree between '" . $dateDebut . "' and '" . $dateFin . "'";
        }
        if (!empty($etatDemande)) {
            $condition = $condition . " and type_etat='" . $etatDemande . "'";
        }

        $demandeSer = Serigraphie::getDemandePremierPlanningSerigraphie($condition);
        $demandeChangeStade = Serigraphie::getDemandeChangeStadePlanningSerigraphie($condition);
        $demandeProd = Serigraphie::getDemandeProdlanningSerigraphie($condition);
        $now = Carbon::now();
        $etat = EtatDemandeClient::all();
        return view('VAMM.SERIGRAPHIE.tacheFiniSerigraphie', compact('etat', 'dateFin', 'dateDebut', 'idStade', 'nomStade', 'etatDemande', 'idStyle', 'nomStyle', 'idTiers', 'nomTiers', 'modele', 'idSaison', 'nomSaison', 'demandeProd', 'demandeChangeStade', 'now', 'demandeSer', 'etapeSer'));
    }

    public function listeSuiviFlux(Request $request)
    {
        $nomSaison = $request->input('nomSaison');
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $nomTiers = $request->input('nomTiers');
        $idTiers = $request->input('idTiers');
        $type = $request->input('type');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        if (empty($nomSaison)) {
            $idSaison = "";
        }
        if (empty($nomTiers)) {
            $idTiers = "";
        }
        $condition = "";
        if (!empty($idSaison)) {
            $condition = $condition . " and id_saison=" . $idSaison;
        }
        if (!empty($modele)) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and id_tiers=" . $idTiers;
        }
        if (!empty($type)) {
            $condition = $condition . " and type_flux=" . $type;
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and DATE(date_operation) between '" . $dateDebut . "' and '" . $dateFin . "'";
        }

        $nomType = "";
        if ($type == 1) {
            $nomType = "Réception";
        } elseif ($type == 2) {
            $nomType = "Livraison";
        }

        $qteCoupe = Serigraphie::sommeQuantiteCoupeSuiviFlux($condition);
        $qteCoupe = $qteCoupe[0]->recoupe;
        $qteRecu = Serigraphie::sommeQuantiteRecuSuiviFlux($condition);
        $qteRecu = $qteRecu[0]->qte;
        $qteLivre = Serigraphie::sommeQuantiteLivreSuiviFlux($condition);
        $qteLivre = $qteLivre[0]->qte;

        $suivi = Serigraphie::getSuiviFluxSerigraphie($condition);
        return view('VAMM.SERIGRAPHIE.listeSuiviFlux', compact('qteLivre', 'qteRecu', 'qteCoupe', 'nomType', 'suivi', 'nomSaison', 'idSaison', 'modele', 'nomTiers', 'idTiers', 'type', 'dateDebut', 'dateFin'));
    }

    public function detailSuiviFlux(Request $request)
    {
        $id = $request->input('id') ?? session('id');;
       $suivi = Serigraphie::getSuiviFluxSerigraphieById($id);
       $detailSuivi = Serigraphie::getDetailSuiviFluxSerByIdSuivi($id);
        return view('VAMM.SERIGRAPHIE.detailSuiviFluxSerigraphie', compact('suivi', 'detailSuivi'));
    }

    public function listeRapportJournalier(Request $request)
    {
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $modele = $request->input('modele');
        $nomSaison = $request->input('nomSaison');
        $idSaison = $request->input('idSaison');
        $nomTiers = $request->input('nomTiers');
        $idTiers = $request->input('idTiers');
        $condition = "";

        if (empty($nomSaison)) {
            $idSaison = "";
        }
        if (empty($nomTiers)) {
            $idTiers = "";
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = " and date_pro between '" . $dateDebut . "' and '" . $dateFin . "'";
        }
        if (!empty($modele)) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if (!empty($idSaison)) {
            $condition = $condition . " and type_saison='" . $idSaison . "'";
        }
        if (!empty($idTiers)) {
            $condition = $condition . " and nomtier='" . $idTiers . "'";
        }

        $qte = Serigraphie::sommeQteRapportSerigraphie($condition);
        $qte = $qte[0]->somme;
        $efficience = Serigraphie::sommeEfficienceRapportSerigraphie($condition);
        $efficience = $efficience[0]->somme;
        $chiffreAffaire = Serigraphie::sommeCARapportSerigraphie($condition);
        $chiffreAffaire = $chiffreAffaire[0]->somme;
        $retouche = Serigraphie::sommeRetoucheRapportSerigraphie($condition);
        $retouche = $retouche[0]->somme;
        $electricite = Serigraphie::sommeElectriciteRapportSerigraphie($condition);
        $electricite = $electricite[0]->somme;
        $valeur = Serigraphie::sommeValeurRapportSerigraphie($condition);
        $valeur = $valeur[0]->somme;
        $ncTraite = Serigraphie::sommeNcTraiteRapportSerigraphie($condition);
        $ncTraite = $ncTraite[0]->somme;
        $absenteisme = Serigraphie::sommeAbsenteismeRapportSerigraphie($condition);
        $absenteisme = $absenteisme[0]->somme;
        $rapport = Serigraphie::getAllRapportJournalier($condition);
        return view('VAMM.SERIGRAPHIE.listeRapportJournalierSer', compact('absenteisme', 'ncTraite', 'valeur', 'electricite', 'retouche', 'chiffreAffaire', 'efficience', 'qte', 'idTiers', 'nomTiers', 'idSaison', 'nomSaison', 'modele', 'dateFin', 'dateDebut', 'rapport'));
    }

    public function ajoutRapportJournalier(Request $request)
    {
        $idDC = $request->session()->get('idDemandeSer');
        $dateProd = $request->input('dateProd');
        $date = Carbon::parse($dateProd)->toDateString();
        $rapportExiste = Serigraphie::isRapportProdSerExiste($date);
        $electricite = $request->input('electricite');
        $ncTratite = $request->input('ncTraite');
        $absenteisme = $request->input('absenteisme');
        if (count($rapportExiste) != 0) {
            $electricite = $rapportExiste[0]->electricite;
            $ncTratite = $rapportExiste[0]->nc_traite;
            $absenteisme = $rapportExiste[0]->absenteisme;
        }
        $data = [
            'date_pro' => $request->input('dateProd'),
            'taux_retouche' => $request->input('retouche'),
            'taux_rejet' => $request->input('rejet'),
            'produit_chmique' => $request->input('chimique'),
            'valeur' => $request->input('valeur'),
            'electricite' => $electricite,
            'reclam_loading' => $request->input('reclam'),
            'nc_traite' => $ncTratite,
            'absenteisme' => $absenteisme,
            'commentaire' => $request->input('commentaire'),
            'nb_operateur' => $request->input('nbOperateur'),
            'id_demande_ser' => $idDC
        ];

        $rapportJour = new Serigraphie();
        $rapportJour->insertRapportJournalier($data);

        $dernierRapport = Serigraphie::rapportJournalierDernier();
        // dd($dernierRapport[0]->id);
        $heure = $request->input('heure');
        $qte = $request->input('qte');

        for ($i = 0; $i < count($qte); $i++) {
            $detailRapport = new Serigraphie();
            $detailRapport->insertDetailRapportJournalier($dernierRapport[0]->id, $heure[$i], $qte[$i]);
        }
        return redirect()->route('SERIGRAPHIE.listeRapportJournalier');
    }

    public function formModifRapportJournalierSer(Request $request)
    {
        $idRapport = $request->input('idRapport');
        $rapport = Serigraphie::rapportJournalierById($idRapport);
        $detailRapport = Serigraphie::rapportDetailJournalierById($idRapport);
        return view('VAMM.SERIGRAPHIE.modifRaportJournalier', compact('detailRapport', 'rapport'));
    }

    public function updateRapportJournalier(Request $request)
    {
        $data = [
            'id' => $request->input('id'),
            'taux_retouche' => $request->input('retouche'),
            'taux_rejet' => $request->input('rejet'),
            'produit_chmique' => $request->input('chimique'),
            'valeur' => $request->input('valeur'),
            'electricite' => $request->input('electricite'),
            'reclam_loading' => $request->input('reclam'),
            'nc_traite' => $request->input('ncTraite'),
            'absenteisme' => $request->input('absenteisme'),
            'commentaire' => $request->input('commentaire'),
            'nb_operateur' => $request->input('nbOperateur')
        ];

        $rapportJour = new Serigraphie();
        $rapportJour->updateRapportJournalier($data);

        Serigraphie::deleteDetailRapportById($request->input('id'));

        $heure = $request->input('heure');
        $qte = $request->input('qte');
        $somme = array_sum($qte);
        if ($somme != 0) {
            for ($i = 0; $i < count($qte); $i++) {
                $detailRapport = new Serigraphie();
                $detailRapport->insertDetailRapportJournalier($request->input('id'), $heure[$i], $qte[$i]);
            }
        }


        $heures = $request->input('heures');
        $qtes = $request->input('qtes');
        for ($j = 0; $j < count($qtes); $j++) {
            $detailRapport = new Serigraphie();
            $detailRapport->insertDetailRapportJournalier($request->input('id'), $heures[$j], $qtes[$j]);
        }
        return redirect()->route('SERIGRAPHIE.listeRapportJournalier');
    }
}
