<?php

namespace App\Http\Controllers;

use App\Models\BureauEtude;
use App\Models\DemandeClient;
use App\Models\DemandeClientSDCEtapeDev;
use App\Models\Echantillon;
use App\Models\ListeEmploye;
use App\Models\Planning;
use App\Models\Sdc;
use App\Models\Smv;
use App\Models\SpecificiteMontageDEV;
use App\Models\Style;
use App\Models\V_tissus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ControllerPlanningDev extends Controller
{
    public function planningDEV(Request $request)
    {
        $demande = Planning::getAllDemandeClientSDCEtapeDevLimit();
        $now = Carbon::now();
        $etapeDev = Planning::getAllEtapeDEV();
        $typeOccurence = BureauEtude::getAllTypeOccurencePatronage();
        $placeur = ListeEmploye::getAllListeEmployePlaceur();
        $employeMontage = ListeEmploye::getAllListeEmployeMontage();
        $employeDev = ListeEmploye::getAllListeEmployeDeveloppement();
        $retouche = BureauEtude::getAllRetouche();
        $idSaison = '';
        $modele = '';
        $idTiers = '';
        $idStyle = '';
        $patronier = '';
        $dateDebut = '';
        $dateFin = '';
        $nomSaison = '';
        $nomTiers = '';
        $nomStyle = '';
        $nomEmploye = '';
        $nomStade='';
        $idStade='';
        return view('DEV.PLANNING.planning', compact('idStade','nomStade','retouche','employeDev','employeMontage','placeur','typeOccurence','etapeDev','now','idSaison','modele','idTiers','idStyle','patronier','dateDebut','dateFin','nomSaison','nomTiers','nomStyle','nomEmploye', 'demande'));
    }

    public function recherchePlanning(Request $request)
    {
        $now = Carbon::now();
        $etapeDev = Planning::getAllEtapeDEV();
        $typeOccurence = BureauEtude::getAllTypeOccurencePatronage();
        $placeur = ListeEmploye::getAllListeEmployePlaceur();
        $employeMontage = ListeEmploye::getAllListeEmployeMontage();
        $employeDev = ListeEmploye::getAllListeEmployeDeveloppement();
        $retouche = BureauEtude::getAllRetouche();
        $idSaison = $request->input('idSaison');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $patronier = $request->input('patronier');
        $dateDebut = $request->input('dateDebut');
        $dateFin = $request->input('dateFin');
        $nomSaison = $request->input('nomSaison');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');
        $nomEmploye = $request->input('nomEmploye');
        $nomStade = $request->input('nomStade');
        $idStade = $request->input('idStade');
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

        if (empty($nomEmploye)) {
            $patronier = "";
        }

        if (empty($nomStade)) {
            $idStade = "";
        }

        if (!empty($idSaison)) {
            $condition = " and id_saison=" . $idSaison;
        }
        if (!empty($idStade)) {
            $condition = " and stadesdc='" . $idStade. "'";
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
        if (!empty($patronier)) {
            $condition = $condition . " and idlisteemploye=" . $patronier;
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and DATE(deadlinedemandeclient) between '" . $dateDebut . "' and '" . $dateFin . "'";
        }

        if (!empty($dateDebut) && empty($dateFin)) {
            $condition = $condition . " and DATE(deadlinedemandeclient) between '" . $dateDebut . "' and '" . $dateDebut . "'";
        }
        $condition = $condition." order by id asc limit 100";
        $demande =Planning::getAllDemandeClientSDCEtapeDevRecherche($condition);
        return view('DEV.PLANNING.planning', compact('nomStade','idStade','retouche','employeDev','employeMontage','placeur','typeOccurence','etapeDev','now','idSaison','modele','idTiers','idStyle','patronier','dateDebut','dateFin','nomSaison','nomTiers','nomStyle','nomEmploye', 'demande'));
    }


    public function formAjoutBureauEtude(Request $request)
    {
        $idDCSDCEtapeDev = $request->input('idDCSDCEtapeDev');
        $deadline = $request->input('deadline');
        $typePatronage = BureauEtude::getAllTypePatronage();
        $patronier = ListeEmploye::getAllListeEmployePatronier();
        return view('DEV.PLANNING.ajoutBureauEtude', compact('deadline', 'idDCSDCEtapeDev', 'typePatronage', 'patronier'));
    }

    public function ajoutBureauEtude(Request $request)
    {
        $preRunDemande = $request->input('preRunDemande');
        $demandeLapdip = $request->input('demandeLapdip');
        $demandeTauxRetrait = $request->input('demandeTauxRetrait');
        $tauxMesure = $request->input('tauxMesure');
        $conformiteDossier  = $request->input('conformiteDossier');
        if ($preRunDemande != 1) {
            $preRunDemande = 0;
        }
        if ($demandeLapdip != 1) {
            $demandeLapdip = 0;
        }
        if ($demandeTauxRetrait != 1) {
            $demandeTauxRetrait = 0;
        }
        if ($tauxMesure != 1) {
            $tauxMesure = 0;
        }
        if ($conformiteDossier != 1) {
            $conformiteDossier = 0;
        }
        $data = [
            'datedebut' => $request->input('dateDebut'),
            'idtypepatronage' => $request->input('idtypepatronage'),
            'idlisteemploye' => $request->input('idlisteemploye'),
            'iddclientsdcetapedev' => $request->input('iddclientsdcetapedev'),
            'datefin' => $request->input('dateDebut'),
            'commentaire' => '',
            'deadline' => $request->input('deadline')
        ];

        $data1 = [
            'iddclientsdcetapedev' => $request->input('iddclientsdcetapedev'),
            'valeurcouture' => $request->input('valeurCouture'),
            'pointcm' => $request->input('pointcm'),
            'montagedevant' => $request->input('montagedevant'),
            'montageenvers' => $request->input('montageenvers'),
            'glissementcouture' => $request->input('glissementcouture'),
            'maille' => $request->input('maille'),
            'autres' => $request->input('autres'),
            'preRunDemande' => $preRunDemande,
            'demandeLapdip' => $demandeLapdip,
            'demandeTauxRetrait' => $demandeTauxRetrait,
            'tauxMesure' => $tauxMesure,
            'conformiteDossier' => $conformiteDossier
        ];
        $bureau = new BureauEtude();
        $bureau->insertBureauEtude($data);

        $specificite = new SpecificiteMontageDEV();
        $specificite->insertSpecificiteMontage($data1);

        $demandeSDCEtape = new DemandeClientSDCEtapeDev();
        $demandeSDCEtape->changerEtat(1, $request->input('iddclientsdcetapedev'));
        return redirect()->route('DEV.planningDEV');
    }

    public function formUpdateBureauEtude(Request $request)
    {
        $idDCSDCEtapeDev = $request->input('idDCSDCEtapeDev');
        $typePatronage = BureauEtude::getAllTypePatronage();
        $patronier = ListeEmploye::getAllListeEmployePatronier();
        $bureau = BureauEtude::getBureauEtudeByIdDcDSCEtape($idDCSDCEtapeDev);
        $specificite = SpecificiteMontageDEV::getAllSpecificiteMontage($idDCSDCEtapeDev);
        return view('DEV.PLANNING.updateBureauEtude', compact('specificite', 'bureau', 'idDCSDCEtapeDev', 'typePatronage', 'patronier'));
    }

    public function updateBureauEtude(Request $request)
    {
        $preRunDemande = $request->input('preRunDemande');
        $demandeLapdip = $request->input('demandeLapdip');
        $demandeTauxRetrait = $request->input('demandeTauxRetrait');
        $tauxMesure = $request->input('tauxMesure');
        $conformiteDossier  = $request->input('conformiteDossier');

        if ($preRunDemande != 1) {
            $preRunDemande = 0;
        }
        if ($demandeLapdip != 1) {
            $demandeLapdip = 0;
        }
        if ($demandeTauxRetrait != 1) {
            $demandeTauxRetrait = 0;
        }
        if ($tauxMesure != 1) {
            $tauxMesure = 0;
        }
        if ($conformiteDossier != 1) {
            $conformiteDossier = 0;
        }
        $data = [
            'datedebut' => $request->input('dateDebut'),
            'idtypepatronage' => $request->input('idtypepatronage'),
            'idlisteemploye' => $request->input('idlisteemploye'),
            'iddclientsdcetapedev' => $request->input('iddclientsdcetapedev'),
            'datefin' => $request->input('dateDebut'),
            'commentaire' => '',
            'deadline' => $request->input('dateDebut')
        ];

        $data1 = [
            'iddclientsdcetapedev' => $request->input('iddclientsdcetapedev'),
            'valeurcouture' => $request->input('valeurCouture'),
            'pointcm' => $request->input('pointcm'),
            'montagedevant' => $request->input('montagedevant'),
            'montageenvers' => $request->input('montageenvers'),
            'glissementcouture' => $request->input('glissementcouture'),
            'maille' => $request->input('maille'),
            'autres' => $request->input('autres'),
            'preRunDemande' => $preRunDemande,
            'demandeLapdip' => $demandeLapdip,
            'demandeTauxRetrait' => $demandeTauxRetrait,
            'tauxMesure' => $tauxMesure,
            'conformiteDossier' => $conformiteDossier
        ];
        $bureau = new BureauEtude();
        $bureau->updateBureauEtude($data);

        $specificite = new SpecificiteMontageDEV();
        $specificite->updateSpecificiteMontage($data1);
        return redirect()->route('DEV.planningDEV');
    }


    public function acheverBureauEtude(Request $request)
    {
        $etapeDEV = $request->input('etapeDEV');
        // dd($etapeDEV);
        $commentaire = $request->input('commentaire');
        $idDCSdcEtapeDev = $request->input('idDCSdcEtapeDev');
        $bureau = new BureauEtude();
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $bureau->updateBEAchever($commentaire, $dateActuelle, $idDCSdcEtapeDev);
        $demandeCSdcEtape = new DemandeClientSDCEtapeDev();
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $demandeCSdcEtape->updateDCSDCEtapeDev($etapeDEV, $idDCSdcEtapeDev, $dateActuelle);
        $demandeCSdcEtape->changerEtat(0, $idDCSdcEtapeDev);
        return redirect()->route('DEV.planningDEV');
    }

    public function debutPatronage(Request $request)
    {
        $idDCSdcEtapeDev = $request->input('idDCSdcEtapeDev');
        $dateEntreePatronage = $request->input('dateEntreePatronage');
        $deadlinePatronage = $request->input('deadlinePatronage');
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $demandeSDCEtapeDev = DemandeClientSDCEtapeDev::getDemandeSDCEtapeDevById($idDCSdcEtapeDev);
        $demandeClient = DemandeClient::getAllDemandeById($demandeSDCEtapeDev[0]->id_demande_client);
        $style = Style::getStyleById($demandeClient[0]->id_style);
        $data = [
            'datedebut' => $dateActuelle,
            'daterecepetion' => $dateEntreePatronage,
            'iddclientsdcetapedev' => $idDCSdcEtapeDev,
            'datefin' => $deadlinePatronage,
            'pointpatronage' => $style[0]->pointdev,
            'commentaire' => '',
            'deadline' => $deadlinePatronage
        ];
        $suiviPatronage = new BureauEtude();
        $suiviPatronage->insertSuiviPatronage($data);
        $demandeSDCEtape = new DemandeClientSDCEtapeDev();
        $demandeSDCEtape->changerEtat(1, $idDCSdcEtapeDev);
        return redirect()->route('DEV.planningDEV');
    }

    public function acheverSuiviPatronage(Request $request)
    {
        $etapeDEV = $request->input('etapeDEVPatronage');
        $commentaire = $request->input('commentairePatronage');
        $idDCSdcEtapeDev = $request->input('idDCSdcEtapeDevPatronage');

        $demandeCSdcEtape = new DemandeClientSDCEtapeDev();
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $demandeCSdcEtape->updateDCSDCEtapeDev($etapeDEV, $idDCSdcEtapeDev, $dateActuelle);
        $demandeCSdcEtape->changerEtat(0, $idDCSdcEtapeDev);

        $bureau = new BureauEtude();
        $bureau->updateSuiviPatronage($idDCSdcEtapeDev, $dateActuelle, $commentaire);
        return redirect()->route('DEV.planningDEV');
    }


    public function debutControlePatronage(Request $request)
    {
        $idDCSdcEtapeDev = $request->input('idDCSdcEtapeDevPatronage');
        $dateEntreePatronage = $request->input('dateEntreeControlePatronage');
        $deadlinePatronage = $request->input('deadlineControlePatronage');

        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $data = [
            'daterecepetion' => $dateEntreePatronage,
            'datedebut' => $dateActuelle,
            'deadline' => $deadlinePatronage,
            'datefin' => $deadlinePatronage,
            'iddclientsdcetapedev' => $idDCSdcEtapeDev,
            'commentaire' => ''
        ];
        $bureau = new BureauEtude();
        $bureau->insertControlePatronage($data);
        $demandeSDCEtape = new DemandeClientSDCEtapeDev();
        $demandeSDCEtape->changerEtat(1, $idDCSdcEtapeDev);
        return redirect()->route('DEV.planningDEV');
    }

    public function acheverControlePatronage(Request $request)
    {
        $etapeDEV = $request->input('etapeDEVControlePatronage');
        $commentaire = $request->input('commentaireControlePatronage');
        $idDCSdcEtapeDev = $request->input('idDCSdcEtapeDevControlePatronage');
        $demandeCSdcEtape = new DemandeClientSDCEtapeDev();
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $demandeCSdcEtape->updateDCSDCEtapeDev($etapeDEV, $idDCSdcEtapeDev, $dateActuelle);
        $demandeCSdcEtape->changerEtat(0, $idDCSdcEtapeDev);
        $occurence = $request->input('occurence');
        if ($occurence != 1) {
            $occurence = 0;
        }
        $typeOccurence = $request->input('typeOccurence');
        $controlePatronage = new BureauEtude();
        $controlePatronage->updateControlePatronage($idDCSdcEtapeDev, $dateActuelle, $commentaire,$typeOccurence,$occurence);
        return redirect()->route('DEV.planningDEV');
    }


    public function debutPlacement(Request $request)
    {
        $idDCSdcEtapeDev = $request->input('idDCDSCEtapeDevPlacement');
        $idDemandeClientPlacement = $request->input('idDemandeClientPlacement');
        $dateEntree = $request->input('dateEntreePlacement');
        $deadline = $request->input('deadlinePlacement');
        $placeur = $request->input('placeur');
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $data = [
            'daterecepetion' => $dateEntree,
            'datedebut' => $dateActuelle,
            'datefin' => $deadline,
            'deadline' => $deadline,
            'iddclientsdcetapedev' => $idDCSdcEtapeDev,
            'idlisteemploye' => $placeur
        ];

        $data1 = [
            'daterecepetion' => $dateEntree,
            'datedebut' => $dateActuelle,
            'datefin' => $deadline,
            'deadline' => $deadline,
            'iddclientsdcetapedev' => $idDCSdcEtapeDev
        ];
        $isExisteSuiviConso = BureauEtude::isExisteSuiviConso($idDemandeClientPlacement);
        if ($isExisteSuiviConso == 0) {
            $suiviConso = new BureauEtude();
            $suiviConso->insertSuiviConso($data1);
        } else {
            $suiviC = BureauEtude::getSuiviConsoByIdDemandeClient($idDemandeClientPlacement);
            $data2 = [
                'daterecepetion' => $dateEntree,
                'datedebut' => $dateActuelle,
                'datefin' => $deadline,
                'deadline' => $deadline,
                'iddclientsdcetapedev' => $suiviC[0]->iddclientsdcetapedev
            ];
            $suiviConso = new BureauEtude();
            $suiviConso->updateSuiviConso($data2);
        }

        $suiviPlaceur = new BureauEtude();
        $suiviPlaceur->insertSuiviPlaceur($data);


        $demandeSDCEtape = new DemandeClientSDCEtapeDev();
        $demandeSDCEtape->changerEtat(1, $idDCSdcEtapeDev);
        return redirect()->route('DEV.planningDEV');
    }

    public function formFinPlacement(Request $request)
    {
        $idDemande = $request->input('idDemande');
        $idDCSDCEtapeDevRecent = $request->input('idDCSDCEtapeDev');
        $suiviC = BureauEtude::getSuiviConsoByIdDemandeClient($idDemande);
        $idDCSDCEtapeDev = $suiviC[0]->iddclientsdcetapedev;
        $tissus = V_tissus::getAllV_tissu($idDemande);
        $typePlacement = BureauEtude::getAllTypePlacement();
        $suiviConso = BureauEtude::getSuiviConsoByIdDCSDCEtapedev($idDCSDCEtapeDev);
        $idSuiviConso = $suiviConso[0]->id;
        $suiviPlaceur = BureauEtude::getSuiviPlaceurByIdDCSDCEtapeDev($idDCSDCEtapeDev);
        $idSuiviPlaceur = $suiviPlaceur[0]->id;
        $etapeDev = Planning::getAllEtapeDEV();
        return view('DEV.PLANNING.finPlacement', compact('idDCSDCEtapeDevRecent', 'idDemande', 'idDCSDCEtapeDev', 'etapeDev', 'idSuiviPlaceur', 'idSuiviConso', 'tissus', 'typePlacement'));
    }

    public function acheverPlacement(Request $request)
    {
        $placement = $request->input('placement');
        $etapeDEV = $request->input('etapeDEV');
        $idDCSdcEtapeDev = $request->input('idDCSDCEtapeDev');
        $idDCSDCEtapeDevRecent = $request->input('idDCSDCEtapeDevRecent');
        $demandeClientSDC = DemandeClientSDCEtapeDev::getV_DemandeSDCEtapeDevById($idDCSDCEtapeDevRecent);
        $string = $demandeClientSDC[0]->type_stade;
        $mot = "prod";
        $lowercaseString = Str::lower($string);
        $idSuiviConso = $request->input('idSuiviConso');
        $nombreLigne = $request->input('nombreLigne');
        $idTypePlacement = $request->input('idTypePlacement');
        $idDemande = $request->input('idDemande');
        $typePlacement = BureauEtude::getAllTypePlacementById($idTypePlacement);
        $idSuiviPlaceur = $request->input('idSuiviPlaceur');
        $isExisteSuiviConso = BureauEtude::isExisteDetailSuiviConso($idSuiviConso);

        if ($isExisteSuiviConso == 0) {
            for ($i = 0; $i < $nombreLigne; $i++) {
                $detailSuiviConso = new BureauEtude();
                $data = [
                    'idsuiviconso' => $idSuiviConso,
                    'idtissus' => $request->input('tissu' . $i),
                    'laizeutile' => $request->input('laize' . $i),
                    'consocommande' => $request->input('conso' . $i),
                    'efficiencecommande' => $request->input('efficience' . $i),
                    'varience' => 0,
                    'tauxrecoupe' => $request->input('tauxRecoupe' . $i),
                    'pointplacement' => $typePlacement[0]->pointplacement,
                    'id_type_placement' => $idTypePlacement,
                    'commentaire' => $request->input('commentaire' . $i)
                ];
                $dataP = [
                    'idsuiviconso' => $idSuiviConso,
                    'idtissus' => $request->input('tissu' . $i),
                    'laizeutile' => $request->input('laize' . $i),
                    'consorecu' => $request->input('conso' . $i),
                    'efficiencerecu' => $request->input('efficience' . $i),
                    'varience' => 0,
                    'tauxrecoupe' => $request->input('tauxRecoupe' . $i),
                    'pointplacement' => $typePlacement[0]->pointplacement,
                    'id_type_placement' => $idTypePlacement,
                    'commentaire' => $request->input('commentaire' . $i)
                ];
                if (Str::contains($lowercaseString, $mot)) {
                    $detailSuiviConso->insertDetailSuiviConsoProd($dataP);
                } else {
                    $detailSuiviConso->insertDetailSuiviConso($data);
                }
            }
        } else {
            for ($i = 0; $i < $nombreLigne; $i++) {
                $detailSuiviConso = new BureauEtude();
                $data2 = [
                    'idsuiviconso' => $idSuiviConso,
                    'idtissus' => $request->input('tissu' . $i),
                    'laizeutile' => $request->input('laize' . $i),
                    'consocommande' => $request->input('conso' . $i),
                    'efficiencecommande' => $request->input('efficience' . $i),
                    'varience' => 0,
                    'tauxrecoupe' => $request->input('tauxRecoupe' . $i),
                    'id_type_placement' => $idTypePlacement,
                    'pointplacement' => $typePlacement[0]->pointplacement,
                    'commentaire' => $request->input('commentaire' . $i)
                ];
                $dataP2 = [
                    'idsuiviconso' => $idSuiviConso,
                    'idtissus' => $request->input('tissu' . $i),
                    'laizeutile' => $request->input('laize' . $i),
                    'consorecu' => $request->input('conso' . $i),
                    'efficiencerecu' => $request->input('efficience' . $i),
                    'varience' => 0,
                    'tauxrecoupe' => $request->input('tauxRecoupe' . $i),
                    'id_type_placement' => $idTypePlacement,
                    'pointplacement' => $typePlacement[0]->pointplacement,
                    'commentaire' => $request->input('commentaire' . $i)
                ];
                if (Str::contains($lowercaseString, $mot)) {
                    $detailSuiviConso->updateDetailSuiviConsoProd($dataP2);
                } else {
                    $detailSuiviConso->updateDetailSuiviConso($data2);
                }
            }
        }


        if (!empty($placement)) {
            for ($j = 0; $j < count($placement); $j++) {
                $detailPlaceur = new BureauEtude();
                $data1 = [
                    'id_suivi_placeur' => $idSuiviPlaceur,
                    'idtissus' => $request->input('tissu' . $placement[$j]),
                    'nbmarkeur' => $request->input('nbMarker' . $placement[$j]),
                    'pointplacement' => $typePlacement[0]->pointplacement,
                    'id_type_placement' => $idTypePlacement,
                    'commentaire' =>  $request->input('commentaire' . $placement[$j]),
                ];
                $detailPlaceur->insertDetailSuiviPlaceur($data1);
            }
        }


        $demandeCSdcEtape = new DemandeClientSDCEtapeDev();
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $demandeCSdcEtape->updateDCSDCEtapeDev($etapeDEV, $idDCSDCEtapeDevRecent, $dateActuelle);
        $demandeCSdcEtape->changerEtat(0, $idDCSDCEtapeDevRecent);
        return redirect()->route('DEV.planningDEV');
    }

    public function debutIntermediaire(Request $request)
    {
        $idDCSdcEtapeDev = $request->input('idDCSdcEtapeDevInter');
        $dateEntree = $request->input('dateEntreeInter');
        $deadline = $request->input('deadlineInter');
        $etapeDevInter = $request->input('etapeDevInter');
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $demandeSDCEtapeDev = DemandeClientSDCEtapeDev::getDemandeSDCEtapeDevById($idDCSdcEtapeDev);
        $demandeClient = DemandeClient::getAllDemandeById($demandeSDCEtapeDev[0]->id_demande_client);
        $style = Style::getStyleById($demandeClient[0]->id_style);
        $data = [
            'datedebut' => $dateActuelle,
            'daterecepetion' => $dateEntree,
            'datefin' => $deadline,
            'commentaire' => '',
            'iddclientsdcetapedev' => $idDCSdcEtapeDev,
            'deadline' => $deadline,
            'idetapedev' => $etapeDevInter
        ];
        $inter = new BureauEtude();
        $inter->insertEtapeIntermediaire($data);
        $demandeSDCEtape = new DemandeClientSDCEtapeDev();
        $demandeSDCEtape->changerEtat(1, $idDCSdcEtapeDev);
        return redirect()->route('DEV.planningDEV');
    }

    public function acheverIntermediaire(Request $request)
    {
        $etapeDEV = $request->input('etapeDEV');
        $commentaire = $request->input('commentaire');
        $idDCSdcEtapeDev = $request->input('idDCSdcEtapeDev');
        $bureau = new BureauEtude();
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $bureau->updateInterAchever($commentaire, $dateActuelle, $idDCSdcEtapeDev);
        $demandeCSdcEtape = new DemandeClientSDCEtapeDev();
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $demandeCSdcEtape->updateDCSDCEtapeDev($etapeDEV, $idDCSdcEtapeDev, $dateActuelle);
        $demandeCSdcEtape->changerEtat(0, $idDCSdcEtapeDev);
        return redirect()->route('DEV.planningDEV');
    }

    public function debutMontage(Request $request)
    {
        $idDCSdcEtapeDev = $request->input('etapeIdMontage');
        $dateEntree = $request->input('dateEntreeMontage');
        $deadline = $request->input('deadlineMontage');
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $data = [
            'daterecepetion' => $dateEntree,
            'datedebut' => $dateActuelle,
            'deadline' => $deadline,
            'multiplicateur' => 0,
            'iddclientsdcetapedev' => $idDCSdcEtapeDev
        ];
        $rapportMontage = new BureauEtude();
        $rapportMontage->insertRapportMontage($data);
        $demandeSDCEtape = new DemandeClientSDCEtapeDev();
        $demandeSDCEtape->changerEtat(1, $idDCSdcEtapeDev);
        return redirect()->route('DEV.planningDEV');
    }

    public function acheverMontage(Request $request)
    {
        $idDCSdcEtapeDev = $request->input('idDCSdcEtapeDev');
        $etapeDEV = $request->input('etapeDEV');
        $demandeSDCEtape = DemandeClientSDCEtapeDev::getDemandeSDCEtapeDevById($idDCSdcEtapeDev);
        $smv = Smv::getDernierSmvByIdDemande($demandeSDCEtape[0]->id_demande_client);
        $multiplicateur = $request->input('multiplicateur');
        $qteProduites = $request->input('qteProduite');
        $commentaire = $request->input('commentaire');
        $dateFin = $request->input('dateFin');
        $dateOnly = Carbon::parse($dateFin)->format('Y-m-d');

        $employe = $request->input('employe');
        $idRapport = BureauEtude::getRapportMontageByIdDcSDCEtape($idDCSdcEtapeDev);
        $dateActuelle = Carbon::now();
        for ($i = 0; $i < count($employe); $i++) {
            $minute = ListeEmploye::getHeureTravailByDateEntreeEmploye($dateOnly, $employe[$i]);
            $minuteProd = $smv[0]->smv_prod * $multiplicateur * $qteProduites;
            $minutePresence = count($employe) * $minute;
            $data = [
                'idrapportmontagedev' => $idRapport[0]->id,
                'datefin' => $dateFin,
                'qteproduite' => $qteProduites,
                'idlisteemploye' => $employe[$i],
                'commentaire' => $commentaire,
                'minuteproduite' => $minuteProd,
                'minutepresence' => $minutePresence,
                'multiplicateur' => $multiplicateur,
                'efficiencedev' => ($minuteProd / $minutePresence) * 100
            ];
            $detailRapport = new BureauEtude();
            $detailRapport->insertDetailRapportMontageDev($data);
        }

        $demandeClientSDCEtape = DemandeClientSDCEtapeDev::getDemandeSDCEtapeDevById($idDCSdcEtapeDev);

        $results = DB::select("
        SELECT SUM(qteproduite) AS total_quantite
        FROM (
            SELECT DISTINCT ON (datefin) idrapportmontagedev, qteproduite
            FROM detailrapportmontagedev
            WHERE etat = 0
        ) AS subquery
        WHERE idrapportmontagedev =
    " . $idRapport[0]->id);
        $qteTotal = $results[0]->total_quantite ?? 0;
        // dd($qteTotal.'hey'.$demandeClientSDCEtape[0]->quantitesdc);
        if ($qteTotal >= $demandeClientSDCEtape[0]->quantitesdc) {
            $isExiste = BureauEtude::isExisteControleFinal($idDCSdcEtapeDev);
            if ($isExiste == 0) {
                $demandeSDCEtape = new DemandeClientSDCEtapeDev();
                $demandeSDCEtape->updateDCSDCEtapeDev(12, $idDCSdcEtapeDev, $dateFin);
                $demandeSDCEtape->changerEtat(0, $idDCSdcEtapeDev);
            } else {
                $demandeSDCEtape = new DemandeClientSDCEtapeDev();
                $demandeSDCEtape->updateDCSDCEtapeDev(12, $idDCSdcEtapeDev, $dateFin);
            }
        }
        return redirect()->route('DEV.planningDEV');
    }


    public function acheverControleFinal(Request $request)
    {

        $idDCSdcEtapeDev = $request->input('idDCSdcEtapeDev');
        $dateFin = $request->input('dateFin');
        $retouche = $request->input('retouche');
        $typeRetouche = $request->input('typeRetouche');
        $qteControle = $request->input('qteControle');
        $qteRetouche = $request->input('qteRetouche');
        $qteRejet = $request->input('qteRejet');
        $commentaire = $request->input('commentaire');
        $isExiste = BureauEtude::isExisteControleFinal($idDCSdcEtapeDev);
        if ($isExiste == 0) {
            $data = [
                'daterecepetion' => $dateFin,
                'datedebut' => $dateFin,
                'deadline' => $dateFin,
                'iddclientsdcetapedev' => $idDCSdcEtapeDev
            ];
            $controlFinal = new BureauEtude();
            $controlFinal->insertControleFinalDev($data);
        }

        if (empty($retouche)) {
            $retouche = 0;
        }

        $listeContrFinal = BureauEtude::getControleFinalByIdDCSDC($idDCSdcEtapeDev);
        $data1 = [
            'idrapportmontagedev' => $listeContrFinal[0]->id,
            'datefin' => $dateFin,
            'retouche' => $retouche,
            'qtecontrole' => $qteControle,
            'qteretouche' => $qteRetouche,
            'qterejet' => $qteRejet,
            'idtyperetouche' => $typeRetouche,
            'commentaire' => $commentaire,
            'tauxretouche' => ($qteRetouche * 100) / $qteControle,
            'tauxrejet' => ($qteRejet * 100) / $qteControle
        ];

        $detailControl = new BureauEtude();
        $detailControl->insertDetailControleFinalDev($data1);

        $demandeClientSDCEtape = DemandeClientSDCEtapeDev::getDemandeSDCEtapeDevById($idDCSdcEtapeDev);

        $results = DB::select("
        SELECT SUM(qtecontrole) as total_quantite from detailcontrolefinaldev WHERE idrapportmontagedev =" . $listeContrFinal[0]->id);
        $qteTotal = $results[0]->total_quantite ?? 0;
        if ($qteTotal == $demandeClientSDCEtape[0]->quantitesdc) {
            $isExiste = BureauEtude::isExisteRapportFinition($idDCSdcEtapeDev);
            if ($isExiste == 0) {
                $demandeSDCEtape = new DemandeClientSDCEtapeDev();
                $demandeSDCEtape->updateDCSDCEtapeDev(14, $idDCSdcEtapeDev, $dateFin);
                $demandeSDCEtape->changerEtat(0, $idDCSdcEtapeDev);
            } else {
                $demandeSDCEtape = new DemandeClientSDCEtapeDev();
                $demandeSDCEtape->updateDCSDCEtapeDev(14, $idDCSdcEtapeDev, $dateFin);
            }
        }
        return redirect()->route('DEV.planningDEV');
    }



    public function debutControleFinal(Request $request)
    {
        $idDCSdcEtapeDev = $request->input('etapeIdFinal');
        $dateEntree = $request->input('dateEntreeFinal');
        $deadline = $request->input('deadlineFinal');
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $data = [
            'daterecepetion' => $dateEntree,
            'datedebut' => $dateActuelle,
            'deadline' => $deadline,
            'iddclientsdcetapedev' => $idDCSdcEtapeDev
        ];
        $final = new BureauEtude();
        $final->insertControleFinalDev($data);
        $demandeSDCEtape = new DemandeClientSDCEtapeDev();
        $demandeSDCEtape->changerEtat(1, $idDCSdcEtapeDev);
        return redirect()->route('DEV.planningDEV');
    }

    public function acheverFinition(Request $request)
    {
        $idDCSdcEtapeDev = $request->input('idDCSdcEtapeDev');
        $qte = $request->input('qte');
        $finisseur = $request->input('finisseur');
        $commentaire = $request->input('commentaire');
        $dateFin = $request->input('dateFin');
        $isExiste = BureauEtude::isExisteRapportFinition($idDCSdcEtapeDev);
        $demandeSDCEtape = DemandeClientSDCEtapeDev::getDemandeSDCEtapeDevById($idDCSdcEtapeDev);
        $smv = Smv::getDernierSmvByIdDemande($demandeSDCEtape[0]->id_demande_client);
        $minute = ListeEmploye::getHeureTravailByDateEntreeEmploye($dateFin, $finisseur);
        if ($isExiste == 0) {
            $data = [
                'daterecepetion' => $dateFin,
                'datedebut' => $dateFin,
                'deadline' => $dateFin,
                'iddclientsdcetapedev' => $idDCSdcEtapeDev,
            ];
            $rapportFinition = new BureauEtude();
            $rapportFinition->insertFinitionDev($data);
        }

        $finition = BureauEtude::getRapportFinitionByIdDCSDC($idDCSdcEtapeDev);
        $data1 = [
            'idrapportfinitiondev' => $finition[0]->id,
            'datefin' => $dateFin,
            'qtefini' => $qte,
            'idlisteemploye' => $finisseur,
            'commentaire' => $commentaire,
            'minuteproduite' => $smv[0]->smv_finition * $qte,
            'minutepresence' => $minute * $qte,
            'efficiencedev' => (($smv[0]->smv_finition * $qte) / ($minute * $qte)) * 100
        ];

        $detailFinition = new BureauEtude();
        $detailFinition->insertDetailFinitionDev($data1);
        $results = DB::select("
        SELECT SUM(qtefini) as total_quantite from detailrapportfinitiondev WHERE idrapportfinitiondev =" . $finition[0]->id);
        $qteTotal = $results[0]->total_quantite ?? 0;
        if ($qteTotal == $demandeSDCEtape[0]->quantitesdc) {
            $demandeSDCEtape = new DemandeClientSDCEtapeDev();
            $demandeSDCEtape->updateDCSDCEtapeDev(13, $idDCSdcEtapeDev, $dateFin);
            $demandeSDCEtape->changerEtat(0, $idDCSdcEtapeDev);
        }
        return redirect()->route('DEV.planningDEV');
    }

    public function debutRapportFinition(Request $request)
    {
        $idDCSdcEtapeDev = $request->input('etapeIdFinal');
        $dateEntree = $request->input('dateEntreeFinal');
        $deadline = $request->input('deadlineFinal');
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $data = [
            'daterecepetion' => $dateEntree,
            'datedebut' => $dateActuelle,
            'deadline' => $deadline,
            'iddclientsdcetapedev' => $idDCSdcEtapeDev
        ];
        $rapportFinition = new BureauEtude();
        $rapportFinition->insertFinitionDev($data);
        $demandeSDCEtape = new DemandeClientSDCEtapeDev();
        $demandeSDCEtape->changerEtat(1, $idDCSdcEtapeDev);
        return redirect()->route('DEV.planningDEV');
    }

    public function transmission(Request $request)
    {
        $idDCSdcEtapeDev = $request->input('idDCSdcEtapeDev');
        $dateEnvoie = $request->input('dateEnvoie');
        $qte = $request->input('qte');
        $commentaire = $request->input('commentaire');
        $data = [
            'dateenvoie' => $dateEnvoie,
            'qteenvoie' => $qte,
            'commentaire' => $commentaire,
            'iddclientsdcetapedev' => $idDCSdcEtapeDev,
        ];
        $trans = new BureauEtude();
        $trans->insertTransmission($data);
        $demandeSDCEtape = new DemandeClientSDCEtapeDev();
        $demandeSDCEtape->updateDCSDCEtapeDev(15, $idDCSdcEtapeDev, $dateEnvoie);
        $demandeSDCEtape->changerEtat(0, $idDCSdcEtapeDev);
        return redirect()->route('DEV.planningDEV');
    }

    public function transmissionClient(Request $request)
    {
        $idDCSdcEtapeDev = $request->input('idDCSdcEtapeDev');
        $dateEnvoie = $request->input('dateEnvoie');
        $qte = $request->input('qte');
        $lieu = $request->input('lieu');
        $modeEnvoie = $request->input('modeEnvoie');
        $awb = $request->input('awb');
        $commentaire = $request->input('commentaire');
        $echantillon = new Echantillon();
        $demandeSDCEtape = DemandeClientSDCEtapeDev::getDemandeSDCEtapeDevById($idDCSdcEtapeDev);
        $sdc = Sdc::getSDCById($demandeSDCEtape[0]->id_demande_client);
        $stade = $sdc[0]->id_stade_demande_client;
        $echantillon->insertEchantillon($demandeSDCEtape[0]->id_demande_client, $stade, $dateEnvoie, $qte, $lieu, $modeEnvoie, $commentaire, $awb);
        $demandeSDCEtape = new DemandeClientSDCEtapeDev();
        $demandeSDCEtape->updateDCSDCEtapeDev(16, $idDCSdcEtapeDev, $dateEnvoie);
        $demandeSDCEtape->changerEtat(0, $idDCSdcEtapeDev);
        return redirect()->route('DEV.planningDEV');
    }

    public function acheverAttente(Request $request)
    {
        $etapeDEV = $request->input('etapeDEVControlePatronage');
        $idDCSdcEtapeDev = $request->input('idDCSdcEtapeDevAttente');
        $demandeCSdcEtape = new DemandeClientSDCEtapeDev();
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        $demandeCSdcEtape->updateDCSDCEtapeDev($etapeDEV, $idDCSdcEtapeDev, $dateActuelle);
        $demandeCSdcEtape->changerEtat(0, $idDCSdcEtapeDev);

        return redirect()->route('DEV.planningDEV');
    }

}
