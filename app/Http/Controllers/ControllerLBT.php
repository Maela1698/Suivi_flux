<?php
namespace App\Http\Controllers;

use App\Models\DemandeClient;
use App\Models\EtatDemandeClient;
use App\Models\InspectionVamm;
use App\Models\Lavage;
use App\Models\LBT;
use App\Models\ValeurAjoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 class ControllerLBT extends Controller
{
    public function listeLBT(Request $request)
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
            $condition = $condition . " and type_stade='" . $idStade . "'";
        }
        if (!empty($dateDebut) && !empty($dateFin)) {
            $condition = $condition . " and date_entree between '" . $dateDebut . "' and '" . $dateFin . "'";
        }
        if (!empty($etatDemande)) {
            $condition = $condition . " and type_etat='" . $etatDemande . "'";
        }

        $condition1 = $condition . " order by id_demande_client desc";
        $demande = LBT::getAllDemandeLBT($condition1);
        $etat = EtatDemandeClient::all();
        $typeDefaut = InspectionVamm::getAllTypeDefautByTypeVamm(2);
        $nombreInspection = InspectionVamm::calculNombreInspectionByTypeVamm(2);
        return view('VAMM.LBT.listeDemandeLBT', compact('nombreInspection','typeDefaut','dateFin', 'dateDebut', 'idStade', 'nomStade', 'etatDemande', 'idStyle', 'nomStyle', 'idTiers', 'nomTiers', 'modele', 'idSaison', 'nomSaison', 'etat', 'demande'));
    }

    public function detailDemandeLBT(Request $request)
    {
        $idDemande = $request->input('idDemande') ?? session('idDemande');
        $request->session()->put('idDemandeLBT', $idDemande);
        $tailles = DemandeClient::getTailleByIdDemande($idDemande);
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        $dossiertech = DemandeClient::getDossierTechniqueById($idDemande);
        $lavage = Lavage::getAllLavageDemandeById($idDemande);
        $valeur = ValeurAjoute::getAllValeurDemandeById($idDemande);
        $results = DB::select(" select sum(quantite) as somme from detailtailledemandeclient where id_demande_client=" . $idDemande);
        $somme = $results[0]->somme ?? 0;
        $demandeLBT = LBT::getDemandeLBTByDemande($idDemande);
        return view('VAMM.LBT.detailDemandeLBT', compact('demandeLBT', 'somme', 'demande', 'lavage', 'valeur', 'dossiertech', 'tailles', 'idDemande'));
    }

    public function listeParametreLavage(Request $request)
    {
        $idDemande = $request->session()->get('idDemandeLBT');
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        $parametre = LBT::getParametreLavageByDemande($idDemande);
        $fichier = [];
        if (count($parametre) != 0) {
            $fichier = LBT::getFichierParametreLavageByDemande($parametre[0]->id);
        }
        $demandeLBT = LBT::getDemandeLBTByDemande($idDemande);
        return view('VAMM.LBT.listeParametreLavage', compact('demandeLBT', 'fichier', 'parametre', 'demande'));
    }

    public function insertParametreLavage(Request $request)
    {
        $idDemande = $request->session()->get('idDemandeLBT');
        $data = [
            'id_demande_client' => $idDemande,
            'date_parametre' => $request->input('date_parametre'),
            'poids_unitaire' => $request->input('poidsUnitaire'),
            'poids_passe' => $request->input('poidsPasse'),
            'temps_passe_estime' => $request->input('tempsPasseEstime'),
            'temps_passe_reel' => $request->input('tempsPasseReel'),
            'conso_total_eau' => $request->input('consoTotalEau'),
            'commentaire' => $request->input('commentaire'),
            'prix_lavage' => $request->input('prixLavage')
        ];
        $parametre = new LBT();
        $parametre->insertParametreLavage($data);

        $p = LBT::getParametreLavageByDemande($idDemande);
        $nom = $request->input('nom');
        $fichier = $request->file('fichier');
        if (!empty($fichier[0])) {
            for ($i = 0; $i < count($fichier); $i++) {
                $request->validate([
                    'fichier'[$i] => 'mimes:pdf|max:10000',
                ]);

                $pdfPath[] = "";
                if ($request->hasFile('fichier')) {
                    $uploadedPDF = $request->file('fichier'[$i]);
                    $pdfPath = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
                }
                $fiche = new LBT();
                $fiche->insertFichierParametreLavage($p[0]->id, $nom[$i], $pdfPath);
            }
        }
        return redirect()->route('LBT.listeParametreLavage');
    }


    public function listeParametreBlanchissement(Request $request)
    {
        $idDemande = $request->session()->get('idDemandeLBT');
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        $parametre = LBT::getParametreBlanchissementByDemande($idDemande);
        $fichier = [];
        if (count($parametre) != 0) {
            $fichier = LBT::getFichierParametreLavageByDemande($parametre[0]->id);
        }
        $demandeLBT = LBT::getDemandeLBTByDemande($idDemande);
        return view('VAMM.LBT.listeParametreBlanchissement', compact('demandeLBT', 'fichier', 'parametre', 'demande'));
    }

    public function insertParametreBlanchissement(Request $request)
    {
        $idDemande = $request->session()->get('idDemandeLBT');
        $option = 0;
        if (!empty($request->input('rouge'))) {
            $option = 0;
        }

        if (!empty($request->input('bleu'))) {
            $option = 1;
        }
        $data = [
            'id_demande_client' => $idDemande,
            'nb_panneaux' => $request->input('nbPanneaux'),
            'date_parametre' => $request->input('date_parametre'),
            'poids_unitaire' => $request->input('poidsUnitaire'),
            'option_valeur' => $option,
            'poids_passe' => $request->input('poidPasse'),
            'prix_blanchissement' => $request->input('prixBlanchissement'),
            'commentaire' => $request->input('commentaire')
        ];

        $parametre = new LBT();
        $parametre->insertParametreBlanchissement($data);

        $p = LBT::getParametreBlanchissementByDemande($idDemande);
        $nom = $request->input('nom');
        $fichier = $request->file('fichier');
        if (!empty($fichier[0])) {
            for ($i = 0; $i < count($fichier); $i++) {
                $request->validate([
                    'fichier'[$i] => 'mimes:pdf|max:10000',
                ]);

                $pdfPath[] = "";
                if ($request->hasFile('fichier')) {
                    $uploadedPDF = $request->file('fichier'[$i]);
                    $pdfPath = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
                }
                $fiche = new LBT();
                $fiche->insertFichierParametreBlanchissement($p[0]->id, $nom[$i], $pdfPath);
            }
        }
        return redirect()->route('LBT.listeParametreBlanchissement');
    }

    public function listeParametreTeinture(Request $request)
    {
        $idDemande = $request->session()->get('idDemandeLBT');
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        $parametre = LBT::getParametreTeintureByDemande($idDemande);
        $fichier = [];
        if (count($parametre) != 0) {
            $fichier = LBT::getFichierParametreLavageByDemande($parametre[0]->id);
        }
        $demandeLBT = LBT::getDemandeLBTByDemande($idDemande);
        return view('VAMM.LBT.listeParametreTeinture', compact('demandeLBT', 'fichier', 'parametre', 'demande'));
    }

    public function insertParametreTeinture(Request $request)
    {
        $idDemande = $request->session()->get('idDemandeLBT');
        $option = 0;

        $data = [
            'id_demande_client' => $idDemande,
            'date_parametre' => $request->input('date_parametre'),
            'couleur' => $request->input('couleur'),
            'nb_panneaux' => $request->input('nbPanneaux'),
            'poids_unitaire' => $request->input('poidsUnitaire'),
            'poids_passe' => $request->input('poidsPasse'),
            'prix_teinture' => $request->input('prixTeinture'),
            'commentaire' => $request->input('commentaire')
        ];

        $parametre = new LBT();
        $parametre->insertParametreTeinture($data);

        $p = LBT::getParametreTeintureByDemande($idDemande);
        $nom = $request->input('nom');
        $fichier = $request->file('fichier');
        if (!empty($fichier[0])) {
            for ($i = 0; $i < count($fichier); $i++) {
                $request->validate([
                    'fichier'[$i] => 'mimes:pdf|max:10000',
                ]);

                $pdfPath[] = "";
                if ($request->hasFile('fichier')) {
                    $uploadedPDF = $request->file('fichier'[$i]);
                    $pdfPath = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
                }
                $fiche = new LBT();
                $fiche->insertFichierParametreTeinture($p[0]->id, $nom[$i], $pdfPath);
            }
        }
        return redirect()->route('LBT.listeParametreTeinture');
    }


    public function insertSuiviFluxLBT(Request $request)
    {
        $idDemande = $request->session()->get('idDemandeLBT');

        $data = [
            'id_demande_client' => $idDemande,
            'date_operation' => $request->input('dateOper'),
            'type_piece' => $request->input('typePiece'),
            'type_action' => $request->input('typeFlux'),
            'quantite' => $request->input('qte'),
            'type_lbt' => $request->input('typeLBT'),
            'recoupe' => $request->input('recoupe')
        ];

        $suivi = new LBT();
        $suivi->insertSuiviFluxLBT($data);
        return redirect()->route('LBT.listeSuiviLBT');
    }

    public function listeSuiviLBT(Request $request)
    {
        $suivi = LBT::getSuiviFluxLBT();
        return view('VAMM.LBT.listeSuiviLBT', compact('suivi'));
    }

    public function listeRapportJournalierLBT(Request $request)
    {
        $rapportTeintureProd = LBT::getRapportJournalierTeinture();
        $rapportTeintureDev = LBT::getRapportJournalierTeintureDev();
        $rapportLavage = LBT::getRapportJournalierLavage();
        //    $rapport = LBT::getRapportJournalierLBT();
        return view('VAMM.LBT.listeRapportJournalierLBT', compact('rapportLavage', 'rapportTeintureDev', 'rapportTeintureProd'));
    }

    public function insertRapportJournalierTeintureProd(Request $request)
    {
        $data = [
            'daterapport' => $request->input('dateProd'),
            'teinte' => $request->input('nbTeinte'),
            'nombre_panneau' => $request->input('nbPanneau'),
            'nb_rejet_panneau' => $request->input('nbRejetPanneau'),
            'nb_retouche_panneau' => $request->input('nbRetouchePanneau'),
            'conso_gasoil' => $request->input('consoGasoil'),
            'prix_unitaire_gasoil' => $request->input('prixUnitaireGasoil'),
            'conso_produit_chimique' => $request->input('consoProduitChimique'),
            'prix_unitaire_produit_chimique' => $request->input('prixProduitChimique'),
            'conso_electrique' => $request->input('consoElectrique'),
            'prix_kwh' => $request->input('prixKWh'),
            'commentaire' => $request->input('commentaire')
        ];

        $rapport = new LBT();
        $rapport->insertRapportJournalierTeintureProd($data);
        return redirect()->route('LBT.listeRapportJournalierLBT');
    }

    public function insertRapportJournalierTeintureDev(Request $request)
    {
        $data = [
            'daterapport' => $request->input('dateProd'),
            'nb_couleur_recherche' => $request->input('nbCouleurRecherche'),
            'nb_couleur_realise' => $request->input('nbCouleurRealise'),
            'nb_tentative' => $request->input('nbTentative'),
            'conso_produit_chimique' => $request->input('consoProduitChimique'),
            'valeur_produit_chimique' => $request->input('valeurProduitChimique'),
            'taux_rejet' => $request->input('tauxRejet'),
            'taux_retouche' => $request->input('tauxRetouche'),
            'commentaire' => $request->input('commentaire')
        ];

        $rapport = new LBT();
        $rapport->insertRapportJournalierTeintureDev($data);
        return redirect()->route('LBT.listeRapportJournalierLBT');
    }


    public function insertRapportJournalierLavage(Request $request)
    {
        $data = [
            'date_rapport' => $request->input('dateProd'),
            'prix_unitaire_gasoil' => $request->input('prixGasoil'),
            'conso_gasoil' => $request->input('consoGasoil'),
            'conso_produit_chimique' => $request->input('consoProduitChimique'),
            'valeur_produit_chimique' => $request->input('valeurProduitChimique'),
            'conso_electrique' => $request->input('consoElectrique'),
            'prix_kwh' => $request->input('prixKwh'),
            'taux_retouche' => $request->input('tauxRetouche'),
            'nc_traites' => $request->input('ncTraite'),
            'absenteisme' => $request->input('absenteisme'),
            'commentaire' => $request->input('commentaire'),
            'nb_piece_lave' => $request->input('nbPieceLave'),
            'type_lavage' => $request->input('type'),
            'taux_rejet' => $request->input('tauxRejet')
        ];

        $rapport = new LBT();
        $rapport->insertRapportJournalierLavage($data);
        return redirect()->route('LBT.listeRapportJournalierLBT');
    }

    public function listePlanningLBT(Request $request)
    {
        $demandePremier = LBT::getDemandeLBTPremier();
        $demandeP = collect();

        if (count($demandePremier) != 0) {
            foreach ($demandePremier as $item) {
                if (!empty($item->id_sdc)) {
                    $demandeP = $demandeP->merge(LBT::getDemandeLBTPremierByDemandeSdc($item->id_demande_client, $item->id_sdc));
                } else {
                    $demandeP = $demandeP->merge(LBT::getDemandeLBTPremierByDemande($item->id_demande_client));
                }
            }
        }

        $demandeChange = LBT::getDemandeLBTChangeStade();
        $demandeProd = LBT::getDemandeLBTProd();
        return view('VAMM.LBT.planningLBT', compact('demandeProd','demandeP','demandeChange'));
    }

    public function listePlanningFiniLBT(Request $request)
    {
        $demandePremier = LBT::getDemandeLBTPremier();
        $demandeP = collect();

        if (count($demandePremier) != 0) {
            foreach ($demandePremier as $item) {
                if (!empty($item->id_sdc)) {
                    $demandeP = $demandeP->merge(LBT::getDemandeLBTPremierByDemandeSdc($item->id_demande_client, $item->id_sdc));
                } else {
                    $demandeP = $demandeP->merge(LBT::getDemandeLBTPremierByDemande($item->id_demande_client));
                }
            }
        }

        $demandeChange = LBT::getDemandeLBTChangeStade();
        $demandeProd = LBT::getDemandeLBTProd();
        return view('VAMM.LBT.planningFiniLBT', compact('demandeProd','demandeP','demandeChange'));
    }

    public function finEtapePlanningLBT(Request $request)
    {
        $idDemandeLBT = $request->input('idDemandeLBT');
        $idEtape = $request->input('idEtape');
        if($idEtape==1){
           LBT::updateApproProduitChimique($idDemandeLBT);
        }
        elseif($idEtape==2){
           LBT::updatePesage($idDemandeLBT);
        }elseif($idEtape==3){
            LBT::updateLavageBlancTeint($idDemandeLBT);
        }elseif($idEtape==4){
            LBT::updateTestShrinkage($idDemandeLBT);
        }elseif($idEtape==5){
            LBT::updatePri($idDemandeLBT);
        }
        // $dateFin = Carbon::now()->format('Y-m-d H:i:s');
        // $planningBrod = new BroadMain();
        // $planningBrod->insertPlanningBrodMain($idDemandeBrodMain,$deadlineBrod,$dateFin, $idEtape);
        return redirect()->route('LBT.listePlanningLBT');
    }

    public function listeModal(Request $request)
    {
       $modal = LBT::getModal();
        return view('VAMM.LBT.modal', compact('modal'));
    }
}
