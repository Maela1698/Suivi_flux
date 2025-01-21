<?php

namespace App\Http\Controllers;

use App\Models\Accessoire;
use App\Models\CertificationClient;
use App\Models\ConsoAccessoire;
use App\Models\ConsoTissus;
use App\Models\FiltreDemande;
use App\Models\Incontern;
use App\Models\Lavage;
use App\Models\MicroMerchDev;
use App\Models\Phase;
use App\Models\Saison;
use App\Models\Style;
use App\Models\Tiers;
use App\Models\Tissus;
use App\Models\UniteTaille;
use App\Models\ValeurAjoute;
use App\Models\StadeDemandeClient;
use App\Models\EtatDemandeClient;
use App\Models\DemandeClient;
use App\Models\DemandeClientSDCEtapeDev;
use App\Models\Destination;
use App\Models\Periode;
use App\Models\Pri;
use App\Models\RecapCommande;
use App\Models\Smv;
use App\Models\V_accessoire;
use App\Models\V_tissus;
use App\Models\VRecapMasterPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class controllerDemande extends Controller
{

    public function listeDemande(Request $request)
    {
        $filters = [
            'theme' => $request->input('theme'),
            'modele' => $request->input('modele'),
            'idTiers' => $request->input('idTiers'),
            'stade' => $request->input('stade'),
            'etat' => $request->input('etat'),
            'idSaison' => $request->input('idSaison'),
            'autre' => $request->input('autre'),
            'startEntree' => $request->input('startEntree'),
            'endEntree' => $request->input('endEntree'),
            'startLivre' => $request->input('startLivre'),
            'endLivre' => $request->input('endLivre'),
        ];

        $demande = FiltreDemande::query()
            ->where('etat', 0)
            ->orderBy('id', 'desc');
        // Vérifier s'il y a des filtres appliqués
        $hasFilters = false;

        $columns = ['taille_base', 'type_incontern', 'type_phase', 'taillemin', 'taillemax', 'nomtier'];

        if ($request->theme) {
            $demande->where('theme', 'ILIKE', '%' . $request->input('theme') . '%');
            $hasFilters = true;
        }

        if ($request->modele) {
            $demande->where('nom_modele', 'ILIKE', '%' . $request->input('modele') . '%');
            $hasFilters = true;
        }

        $nomTiers = null;
        if ($request->idTiers) {
            $demande->where('id_tiers', operator: $request->input('idTiers'));
            $nomTiers = FiltreDemande::where('id_tiers', $request->idTiers)->pluck('nomtier')->first();
            $hasFilters = true;
        }
        if ($request->stade) {
            $demande->where('id_stade', $request->input('stade'));
            $hasFilters = true;
        }
        if ($request->etat) {
            $demande->where('id_etat', $request->input('etat'));
            $hasFilters = true;
        }
        $nomSaison = null;
        if ($request->idSaison) {
            $demande->where('id_saison', $request->input('idSaison'));
            $nomSaison = Saison::where('id', $request->idSaison)->pluck('type_saison')->first();
            $hasFilters = true;
        }

        if ($request->autre) {
            $searchTerm = $request->input('autre');
            $demande->where(function ($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
            $hasFilters = true;
        }

        if ($request->startEntree && $request->endEntree) {
            $demande->whereBetween('date_entree', [$request->startEntree, $request->endEntree]);
            $hasFilters = true;
        }
        if ($request->startLivre && $request->endLivre) {
            $demande->whereBetween('date_livraison', [$request->startLivre, $request->endLivre]);
            $hasFilters = true;
        }

        // Si aucun filtre n'est appliqué, appliquer la limite de 10
        if (!$hasFilters) {
            $demande->limit(100);
        }
        // Récupérer les résultats après application de tous les filtres
        $demandes = $demande->get();

        $nbrcommande = DemandeClient::getCountNbrCommande($filters);
        $nego = DemandeClient::getCountEnCourNego($filters);
        $valide = DemandeClient::getCountValide($filters);
        $refus = DemandeClient::getCountRefus($filters);
        $proto = DemandeClient::getCountProto($filters);
        $tds = DemandeClient::getCountTds($filters);
        $pps = DemandeClient::getCountPps($filters);
        $prod = DemandeClient::getCountProd($filters);
        $etat = EtatDemandeClient::all();
        $stade = StadeDemandeClient::all();


        return view('CRM.commande.listeDemande', compact('demandes', 'nbrcommande', 'nego', 'valide', 'refus', 'stade', 'etat', 'nomTiers', 'nomSaison', 'proto', 'tds', 'pps', 'prod'));
    }

    public function ajoutDemande()
    {
        $lavage = Lavage::getAllLavage();
        $valeurajoute = ValeurAjoute::getAllValeurAjoute();
        $phase = Phase::getAllPhase();
        $incontern = Incontern::getAllIncontern();
        $periode = Periode::getAllPeriode();
        $certification = CertificationClient::getAllCertification();
        return view('CRM.commande.ajoutDemande', compact('certification','periode', 'phase', 'incontern', 'lavage', 'valeurajoute'));
    }
    public function detailDemande(Request $request)
    {
        $idDemande = $request->input('idDemande') ?? session('idDemande');
        $request->session()->put('idDemande', $idDemande);
        //RECAP COMMANDE
        $destination = RecapCommande::getAllDestination();

        //RECAP COMMANDE
        $tailles = DemandeClient::getTailleByIdDemande($idDemande);
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        $dossiertech = DemandeClient::getDossierTechniqueById($idDemande);
        $lavage = Lavage::getAllLavageDemandeById($idDemande);
        $valeur = ValeurAjoute::getAllValeurDemandeById($idDemande);
        $results = DB::select(" select sum(quantite) as somme from detailtailledemandeclient where id_demande_client=" . $idDemande);
        $somme = $results[0]->somme ?? 0;
        return view('CRM.commande.detailDemande', compact('somme','destination', 'demande', 'lavage', 'valeur', 'dossiertech', 'tailles', 'idDemande'));
    }




    /*-------ajout---------------*/


    public function nouveauDemande(Request $request)
    {
        $request->validate([
            'photo_commande' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageBase64 = "";
        if ($request->hasFile('photo_commande')) {
            $photo = $request->file('photo_commande');
            $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
        }

        $request->validate([
            'ficheDT' => 'mimes:pdf|max:10000',
        ]);

        $pdfPath1 = "";
        if ($request->hasFile('ficheDT')) {
            $uploadedPDF = $request->file('ficheDT');
            $pdfPath1 = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
        }


        // Récupérer les premières valeurs par défaut pour id_stade et id_etat
        $defaultStade = StadeDemandeClient::first()->id;
        $defaultEtat = EtatDemandeClient::first()->id;

        // Gérer le fichier photo
        $photoPath = null;
        if ($request->hasFile('photo_commande')) {
            // Récupérer le fichier
            $file = $request->file('photo_commande');

            // Récupérer le nom d'origine du fichier
            $originalFileName = $file->getClientOriginalName();

            // Stocker le fichier avec son nom d'origine et récupérer le chemin
            $file->storeAs('photos_commandes', $originalFileName, 'public');
            $photoPath = $originalFileName;
        }
        // Créer une nouvelle demande client
        $demandeClient = new DemandeClient([
            'date_entree' => $request->input('date_entree'),
            'date_livraison' => $request->input('date_livraison'),
            'id_client' => $request->input('nomClient'),
            'id_style' => $request->input('idStyle', ''),
            'nom_modele' => $request->input('nom_modele', ''),
            'id_incontern' => $request->input('incontern'),
            'theme' => $request->input('theme'),
            'id_phase' => $request->input('phase'),
            'id_periode' => $request->input('periode'),
            'id_saison' => $request->input('idSaison'),
            'qte_commande_provisoire' => $request->input('qteProvisoire'),
            'taille_min' => $request->input('uniteTailleMin'),
            'id_unite_taille_min' => $request->input('uniteTailleMin'),
            'id_unite_taille_max' => $request->input('uniteTailleMax'),
            'taille_base' => $request->input('tailleBase'),
            'requete_client' => $request->input('requeteClient', ''),
            'commentaire_merch' => $request->input('commentaireMerch', ''),
            'id_stade' => $defaultStade, // Valeur par défaut
            'id_etat' => $defaultEtat, // Valeur par défaut
            'photo_commande' => $imageBase64, // Stocke le chemin du fichier
            'etat' => $request->input('etat', 0) // Défaut à 0 si non spécifié
        ]);
        // Sauvegarder dans la base de données
        $demandeClient->save();
        $idDemande = $demandeClient->id;
        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        // demandeSDCEtapeDEV
        $demandeSDCEtapeDev = new DemandeClientSDCEtapeDev();
        $demandeSDCEtapeDev->insertDemandeCSDCEtapeSansSDC($idDemande, 1, $dateActuelle, $request->input('qteProvisoire'));
        // session(['idDemande' => $idDemande]);

        $min = DemandeClient::getRangTailleMinById($request->input('uniteTailleMin'));
        $max = DemandeClient::getRangTailleMaxById($request->input('uniteTailleMax'));
        $taille = DemandeClient::getTailleByRang($min, $max);

        foreach ($taille as $t) {
            DemandeClient::insertTailles($idDemande, $t->id, 0);
        }

        // Gérer le fichier PDF
        $pdfPath = null;
        if ($request->hasFile('ficheDT')) {
            // Récupérer le fichier
            $file1 = $request->file('ficheDT');

            // Récupérer le nom d'origine du fichier
            $originalFileName1 = $file1->getClientOriginalName();



            $nomDossier = $request->input('nomDT');
            if (empty($nomDossier)) {
                $nomDossier = $originalFileName1;
            }

            // Insertion du chemin du fichier dans la base de données
            DemandeClient::insertDossierTechnique($idDemande, $pdfPath1, $nomDossier);
        }

        // Gestion des lavages associés
        $lavages = $request->input('lavages', []); // Récupère les ID des lavages cochés, sinon un tableau vide
        if (!empty($lavages)) {
            foreach ($lavages as $lavageId) {
                Lavage::insertLavageDemande($idDemande, $lavageId);
            }
        }

        // Gestion des valeurs ajoutées associées
        $valeurs = $request->input('valeurAjoutes', []); // Récupère les ID des valeurs ajoutées cochées, sinon un tableau vide
        if (!empty($valeurs)) {
            foreach ($valeurs as $valeurId) {
                ValeurAjoute::insertValeurAjoute($idDemande, $valeurId);
            }
        }

        MicroMerchDev::insertEtape($idDemande);
        return redirect()->route('CRM.detailDemande', ['idDemande' => $idDemande]);
    }

    public function ajoutDossierTech(Request $request)
    {
        $request->validate([
            'ficheDT' => 'mimes:pdf|max:15360',
        ]);

        $pdfPath = "";
        if ($request->hasFile('ficheDT')) {
            $uploadedPDF = $request->file('ficheDT');
            $pdfPath = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
        }

        $nomDossier2 = $request->input('nomDT');
        $idDemande = $request->input('idDemande');
        // Gérer le fichier PDF
        $pdfPath2 = null;
        if ($request->hasFile('ficheDT')) {
            // Récupérer le fichier
            $file2 = $request->file('ficheDT');

            // Récupérer le nom d'origine du fichier
            $originalFileName2 = $file2->getClientOriginalName();

            if (empty($nomDossier2)) {
                $nomDossier2 = $originalFileName2;
            }

            // Insertion du chemin du fichier dans la base de données
            DemandeClient::insertDossierTechnique($idDemande, $pdfPath, $nomDossier2);
            return redirect()->route('CRM.detailDemande', ['idDemande' => $idDemande]);
        }
    }

    public function annuleDemande(Request $request)
    {
        $idDemande = $request->input('idDemande');
        DemandeClient::annuleDemandeClient($idDemande);
        return redirect()->route('CRM.listeDemande', ['idDemande' => $idDemande]);
    }
    public function valideDemande(Request $request)
    {
        $idDemande = $request->input('idDemande');
        //RECAP COMMANDE
        $datereception = $request->input('datereception');
        $request->validate([
            'bcclient' => 'mimes:pdf|max:10000',
        ]);
        $bcclient = "";
        if ($request->hasFile('bcclient')) {
            $uploadedPDF = $request->file('bcclient');
            $bcclient = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
        }
        $demande = DemandeClient::find($idDemande);
        if ($demande) {
            $date_entree = $demande->date_entree;
            echo "La date d'entrée est : " . $date_entree;
            // Ajouter 67 jours à la date d'entrée
            $podateprev = Carbon::parse($date_entree)->addDays(67);
        } else {
            echo "Aucune demande trouvée avec cet ID.";
        }
        $recap = RecapCommande::create([
            'iddemandeclient' => $idDemande,
            'etdrevise' => null,
            'etdpropose' => null,
            'receptionbc' => $datereception,
            'bcclient' => $bcclient,
            'podateprev' => $podateprev
        ]);
        $idrecap = $recap->id;
        $champ1 = $request->input('champ1'); // Tableau de 'num cmd'
        $champ2 = $request->input('champ2'); // Tableau de 'etd'
        $champ3 = $request->input('champ3'); // Tableau de 'quantite'
        $champ4 = $request->input('champ4'); // Tableau de 'destination'
        foreach ($champ1 as $index => $value) {
            Destination::create([
                'idrecapcommande' => $idrecap,
                'numerocommande' => $champ1[$index] ?: '',
                'etdinitial' => $champ2[$index] ?: null,
                'datelivraisonexacte' => null,
                'dateinspection' => null,
                'qteof' => $champ3[$index] ?: 0,
                'iddeststd' => $champ4[$index]
            ]);
        }

        //RECAP COMMANDE
        DemandeClient::valideDemandeClient($idDemande);
        return redirect()->route('CRM.detailDemande', ['idDemande' => $idDemande]);
    }

    /*-------ajout---------------*/




    /*------------------------------------------------------auto complete------------------------------------------------------ */
    public function rechercheSaison(Request $request)
    {
        $query = $request->get('nomSaison');

        $saison = Saison::where('type_saison', 'ILIKE', '%' . $query . '%')->get();

        return response()->json($saison);
    }
    public function rechercheClientDemandeBc(Request $request)
    {
        $query = $request->get('nomClient');

        $clients = DemandeClient::where('nom_modele', 'ILIKE', '%' . $query . '%')->where('etat', 0)->get();

        return response()->json($clients);
    }
    public function rechercheClientDemande(Request $request)
    {
        $query = $request->get('nomClient');

        $clients = Tiers::where('nomtier', 'ILIKE', '%' . $query . '%')->where('etat', 0)->where('idacteur', 1)->get();

        return response()->json($clients);
    }
    public function rechercheClient(Request $request)
    {
        $query = $request->get('nomClient');

        $clients = Tiers::where('nomtier', 'ILIKE', '%' . $query . '%')->where('etat', 0)->get();

        return response()->json($clients);
    }

    public function rechercheStyle(Request $request)
    {
        $query = $request->get('nomStyle');

        $style = Style::where('nom_style', 'ILIKE', '%' . $query . '%')->get();

        return response()->json($style);
    }
    public function rechercheTailleMin(Request $request)
    {
        $query = $request->get('nomUnite');

        $unites = UniteTaille::where('unite_taille', 'ILIKE', '%' . $query . '%')->get();

        return response()->json($unites);
    }
    public function rechercheTailleMax(Request $request)
    {
        $query = $request->get('nomUnite');

        $unites = UniteTaille::where('unite_taille', 'ILIKE', '%' . $query . '%')->get();

        return response()->json($unites);
    }
    public function rechercheTailleBase(Request $request)
    {
        $query = $request->get('nomUnite');

        $unites = UniteTaille::where('unite_taille', 'ILIKE', '%' . $query . '%')->get();

        return response()->json($unites);
    }
    /*------------------------------------------------------auto complete------------------------------------------------------ */

    /*------------------------------------------------------delete update------------------------------------------------------ */
    public function deleteUnTaille(Request $request)
    {
        $idDemande = $request->input('idDemande');
        $idTaille = $request->input('idTaille');
        DemandeClient::deleteTaille($idTaille, $idDemande);
        return redirect()->route('CRM.detailDemande', ['idDemande' => $idDemande]);
    }
    public function deleteDossierTech(Request $request)
    {
        $idDemande = $request->input('idDemande');
        $idDt = $request->input('idDT');
        DemandeClient::deleteDossierTech($idDemande, $idDt);
        return redirect()->route('CRM.detailDemande', ['idDemande' => $idDemande]);
    }
    public function updateTaille(Request $request)
    {
        $idDemande = $request->input('idDemande');
        $idTaille = $request->input('idTaille');
        $quantite = $request->input('quantite');
        DemandeClient::updateTailleDemande($quantite, $idTaille, $idDemande);
        $isExisteConso = ConsoAccessoire::isExisteConsoAccyDemande($idDemande, $idTaille);
        $conso = ConsoAccessoire::getIdConsoAccyByDCByTaille($idDemande, $idTaille);
        if ($isExisteConso != 0) {
            $consoAccy = new ConsoAccessoire();
            $consoAccy->updateQteConsoAccy($idDemande, $idTaille, $quantite);
            for ($i = 0; $i < count($conso); $i++) {
                $sommeConso = ConsoAccessoire::sumConsoAccessoire($conso[$i]->id_accessoire);
                $accessoire = new Accessoire();
                $accessoire->modifQteAccy($sommeConso, $conso[$i]->id_accessoire);
            }
        }
        return redirect()->route('CRM.detailDemande', ['idDemande' => $idDemande]);
    }
    public function updateQuantites(Request $request)
    {
        $idTailles = $request->input('idTaille');
        $idDemande = $request->input('idDemande');
        $quantites = $request->input('quantite');

        for ($i = 0; $i < count($idTailles); $i++) {

            DemandeClient::updateTailleDemande($quantites[$i], $idTailles[$i], $idDemande);
            $isExisteConso = ConsoAccessoire::isExisteConsoAccyDemande($idDemande, $idTailles[$i]);
            if ($isExisteConso != 0) {
                $consoAccy = new ConsoAccessoire();
                $consoAccy->updateQteConsoAccy($idDemande, $idTailles[$i], $quantites[$i]);
            }
        }

        return redirect()->route('CRM.detailDemande', ['idDemande' => $idDemande]);
    }
    public function deleteDemande(Request $request)
    {
        $idDemande = $request->input('idDemande');
        DemandeClient::deleteDemandeById($idDemande);
        return redirect()->route('CRM.listeDemande');
    }

    public function updateDemande(Request $request)
    {
        $idDemande = $request->session()->get('idDemande');
        $lavage = Lavage::getAllLavage();
        $valeurajoute = ValeurAjoute::getAllValeurAjoute();
        $phase = Phase::getAllPhase();
        $periode = Periode::getAllPeriode();
        $incontern = Incontern::getAllIncontern();
        $lavageid = Lavage::getAllLavageDemandeById($idDemande)->pluck('id_lavage')->toArray();
        $valeurajouteid = VAleurAjoute::getAllValeurDemandeById($idDemande)->pluck('id_valeur_ajoutee')->toArray();
        $dossiertech = DemandeClient::getDossierTechniqueById($idDemande);
        $demande = DemandeClient::getAllListeDemandeById($idDemande);
        return view('CRM.commande.updateDemande', compact('periode', 'phase', 'incontern', 'lavage', 'valeurajoute', 'lavageid', 'valeurajouteid', 'dossiertech', 'demande'));
    }

    public function modifDemande(Request $request)
    {
        try {
            $idDemande = $request->session()->get('idDemande');

            $consoTissus = ConsoTissus::getAllConsoTissuByDC($idDemande);

            $demandeClient = DemandeClient::findOrFail($idDemande);

            $request->validate([
                'photo_commande' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            ]);
            $imageBase64 = "";
            if ($request->hasFile('photo_commande')) {
                $photo = $request->file('photo_commande');
                $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
                $demandeClient->photo_commande = $imageBase64;
            } else {
                $demandeClient->photo_commande = $request->input('photoRecent');
            }


            $nomDossier = $request->input('nomDT');

            // Mise à jour des champs de la demande client
            $demandeClient->date_entree = $request->input('date_entree');
            $demandeClient->date_livraison = $request->input('date_livraison');
            $demandeClient->id_client = $request->input('nomClient');
            $demandeClient->id_style = $request->input('idStyle', '');
            $demandeClient->nom_modele = $request->input('nom_modele', '');
            $demandeClient->id_incontern = $request->input('incontern');
            $demandeClient->theme = $request->input('theme');
            $demandeClient->id_phase = $request->input('phase');
            $demandeClient->id_saison = $request->input('idSaison');
            $demandeClient->id_periode = $request->input('periode');
            $demandeClient->qte_commande_provisoire = $request->input('qteProvisoire');
            $demandeClient->taille_base = $request->input('tailleBase');
            $demandeClient->requete_client = $request->input('requeteClient', '');
            $demandeClient->commentaire_merch = $request->input('commentaireMerch', '');
            $demandeClient->etat = $request->input('etat', 0);

            // Sauvegarder les changements dans la base de données
            $demandeClient->save();

            for ($j = 0; $j < count($consoTissus); $j++) {
                $tissu = new Tissus();
                $tissu->modifQuantiteTissu($consoTissus[$j]->conso_tissus * $request->input('qteProvisoire'), $consoTissus[$j]->id_tissus);
            }

            $dossierTechnique = DemandeClient::getDossierTechniqueById($idDemande);
            $pdfPath = null;
            if ($request->hasFile('ficheDT')) {
                // Récupérer le fichier
                $file1 = $request->file('ficheDT');

                // Récupérer le nom d'origine du fichier
                $originalFileName1 = $file1->getClientOriginalName();

                if (empty($nomDossier)) {
                    // Stocker le fichier avec son nom d'origine et récupérer le chemin
                    $file1->storeAs('dossier_techniques', $originalFileName1, 'public');
                    $pdfPath = $originalFileName1;
                } else {
                    $file1->storeAs('dossier_techniques', $nomDossier . '.pdf', 'public');
                    $pdfPath = $nomDossier;
                }
                if ($dossierTechnique->isEmpty()) {
                    DemandeClient::insertDossierTechnique($idDemande, $pdfPath, $originalFileName1);
                }
                if (!$dossierTechnique->isEmpty()) {
                    DemandeClient::updateDossierTechnique($pdfPath, $originalFileName1, $idDemande);
                }
            }
            DemandeClient::updateTailleDemandeDetail($request->input('uniteTailleMin'), $request->input('uniteTailleMax'), $idDemande);
            // Gestion des lavages associés
            Lavage::deleteLavageByDemande($idDemande); // Supprimer les anciens lavages
            $lavages = $request->input('lavages', []);
            foreach ($lavages as $lavageId) {
                Lavage::insertLavageDemande($idDemande, $lavageId);
            }

            // Gestion des valeurs ajoutées associées
            ValeurAjoute::deleteValeurAjouteByDemande($idDemande); // Supprimer les anciennes valeurs ajoutées
            $valeurs = $request->input('valeurAjoutes', []);
            foreach ($valeurs as $valeurId) {
                ValeurAjoute::insertValeurAjoute($idDemande, $valeurId);
            }

            return redirect()->route('CRM.detailDemande', ['idDemande' => $idDemande]);
        } catch (\Exception $errors) {
            return redirect()->back()->withErrors(['msg' => 'Erreur lors de la mis aa jour ' . $errors->getMessage()]);
        }
    }

    /*------------------------------------------------------delete update------------------------------------------------------ */

    /*------------------------------------------------------duplicata------------------------------------------------------ */
    public function duplicata(Request $request)
    {
        $idDemandeClients = $request->input('idDemande');
        return view('CRM.commande.duplicataCommande', compact('idDemandeClients'));
    }

    public function ajoutDuplicata(Request $request)
    {


        $idDemandeClient = $request->input('idDemandeClient');
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageBase64 = "";
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
        }

        $request->validate([
            'ficheDT' => 'mimes:pdf|max:18360',
        ]);
        $pdfPath = "";


        $mp = $request->input('mp');
        $fdc = $request->input('fdc');
        $smv = $request->input('smv');
        $pri = $request->input('pri');
        $nomDT = $request->input('nomDT');
        $nomModele = $request->input('nomModele');
        $saison = $request->input('idSaison');
        $dateEntree = $request->input('dateEntree');
        $demandeAvant = DemandeClient::getAllDemandeById($idDemandeClient);
        $demandeNouveau = new DemandeClient([
            'date_entree' => $dateEntree,
            'date_livraison' => $demandeAvant[0]->date_livraison,
            'id_client' => $demandeAvant[0]->id_client,
            'id_style' => $demandeAvant[0]->id_style,
            'nom_modele' => $nomModele,
            'id_incontern' => $demandeAvant[0]->id_incontern,
            'theme' => $demandeAvant[0]->theme,
            'id_phase' => $demandeAvant[0]->id_phase,
            'id_saison' => $saison,
            'qte_commande_provisoire' => $demandeAvant[0]->qte_commande_provisoire,
            'taille_min' => $demandeAvant[0]->taille_min,
            'id_unite_taille_min' => $demandeAvant[0]->id_unite_taille_min,
            'id_unite_taille_max' => $demandeAvant[0]->id_unite_taille_max,
            'taille_base' => $demandeAvant[0]->taille_base,
            'requete_client' => $demandeAvant[0]->requete_client,
            'commentaire_merch' => $demandeAvant[0]->commentaire_merch,
            'id_stade' => 1,
            'id_etat' => 1,
            'id_periode' => $demandeAvant[0]->id_periode,
            'photo_commande' => $imageBase64,
            'etat' => 0
        ]);
        $demandeNouveau->save();
        $idDemandeNouveau = $demandeNouveau->id;

        $dateActuelle = Carbon::now()->format('Y-m-d H:i:s');
        //ajout demandeSDCEtapeSansEtapeDev
        $demandeSDCEtapeDev = new DemandeClientSDCEtapeDev();
        $demandeSDCEtapeDev->insertDemandeCSDCEtapeSansSDC($idDemandeNouveau, 1, $dateActuelle, $demandeAvant[0]->qte_commande_provisoire);

        $tailleAvant = DemandeClient::getTailleByIdDemande($idDemandeClient);
        if (count($tailleAvant) != 0) {
            for ($m = 0; $m < count($tailleAvant); $m++) {
                $tailleNouveau = new DemandeClient();
                $tailleNouveau->insertTailles($idDemandeNouveau, $tailleAvant[$m]->id_unite_taille, $tailleAvant[$m]->quantite);
            }
        }

        $lavageAvant = Lavage::getAllLavageDemandeById($idDemandeClient);
        if (count($lavageAvant) != 0) {
            for ($l = 0; $l < count($lavageAvant); $l++) {
                $lavageNouveau = new Lavage();
                $lavageNouveau->insertLavageDemande($idDemandeNouveau, $lavageAvant[$l]->id_lavage);
            }
        }

        $valeurAjouteeAvant = ValeurAjoute::getAllValeurDemandeById($idDemandeClient);
        if (count($valeurAjouteeAvant) != 0) {
            for ($v = 0; $v < count($valeurAjouteeAvant); $v++) {
                $valeurNouveau = new ValeurAjoute();
                $valeurNouveau->insertValeurAjoute($idDemandeNouveau, $valeurAjouteeAvant[$v]->id_valeur_ajoutee);
            }
        }

        if (!empty($mp)) {
            $tissusAvant = V_tissus::getAllV_tissu($idDemandeClient);
            if (count($tissusAvant) != 0) {
                for ($t = 0; $t < count($tissusAvant); $t++) {
                    $tissusNouveau = new Tissus();
                    $data = [
                        'id_type_tissus' => $tissusAvant[$t]->id_type_tissus,
                        'id_categorie_tissus' => $tissusAvant[$t]->id_categorie_tissus,
                        'designation' => $tissusAvant[$t]->designation,
                        'reference' => $tissusAvant[$t]->reference,
                        'id_composition_tissus' => $tissusAvant[$t]->id_composition_tissus,
                        'couleur' => $tissusAvant[$t]->couleur,
                        'id_unite_mesure_matiere' => $tissusAvant[$t]->id_unite_mesure_matiere,
                        'prix_unitaire' => $tissusAvant[$t]->prix_unitaire,
                        'frais' => $tissusAvant[$t]->frais,
                        'id_unite_monetaire' => $tissusAvant[$t]->id_unite_monetaire,
                        'grammage' => $tissusAvant[$t]->grammage,
                        'laize_utile' => $tissusAvant[$t]->laize_utile,
                        'id_famille_tissus' => $tissusAvant[$t]->id_famille_tissus,
                        'l_retrait_lavage' => $tissusAvant[$t]->l_retrait_lavage,
                        'w_retrait_lavage' => $tissusAvant[$t]->w_retrait_lavage,
                        'l_retrait_teinture' => $tissusAvant[$t]->l_retrait_teinture,
                        'w_retrait_teinture' => $tissusAvant[$t]->w_retrait_teinture,
                        'nom_fiche_technique' => $tissusAvant[$t]->nom_fiche_technique,
                        'id_classe' => $tissusAvant[$t]->id_classe,
                        'etat' => $tissusAvant[$t]->etat
                    ];
                    $tissusNouveau->insertTissus($data, $tissusAvant[$t]->photo, $tissusAvant[$t]->fiche_technique, $tissusAvant[$t]->quantite, $idDemandeNouveau);
                    $idTissu = Tissus::lastInsertTissusByDC($idDemandeNouveau);
                    $conso = new ConsoTissus();
                    $conso->insertConsoTissu($idTissu, 0, 0, $idDemandeClient);
                }
            }

            // if(!empty($fdc)){

            // }

            $accessoireAvant = V_accessoire::getAllV_accessoireByDC($idDemandeClient);
            if (count($accessoireAvant) != 0) {
                for ($a = 0; $a < count($accessoireAvant); $a++) {
                    $data1 = [
                        'id_type_accessoire' => $accessoireAvant[$a]->id_type_accessoire,
                        'utilisation' => $accessoireAvant[$a]->utilisation,
                        'designation' => $accessoireAvant[$a]->designation,
                        'reference' => $accessoireAvant[$a]->reference,
                        'couleur' => $accessoireAvant[$a]->couleur,
                        'id_unite_mesure_matiere' => $accessoireAvant[$a]->id_unite_mesure_matiere,
                        'prix_unitaire' => $accessoireAvant[$a]->prix_unitaire,
                        'frais' => $accessoireAvant[$a]->frais,
                        'id_unite_monetaire' => $accessoireAvant[$a]->id_unite_monetaire,
                        'id_famille_accessoire' => $accessoireAvant[$a]->id_famille_accessoire,
                        'nom_fiche_technique' => $accessoireAvant[$a]->nom_fiche_technique,
                        'id_classe' => $accessoireAvant[$a]->id_classe,
                        'etat' => $accessoireAvant[$a]->etat
                    ];
                    $accessoireNouveau = new Accessoire();
                    $photo = "";
                    $accessoireNouveau->insertAccessoire($data1, $accessoireAvant[$a]->photo, $accessoireAvant[$a]->fiche_technique, $accessoireAvant[$a]->quantite, $idDemandeNouveau);
                }
            }
        }

        if (!empty($smv)) {
            $smvAvant = Smv::getSmvByIdDemande($idDemandeClient);
            if (count($smvAvant) != 0) {
                for ($s = 0; $s < count($smvAvant); $s++) {
                    $smvNouveau = new Smv();
                    $smvNouveau->insertSmv($smvAvant[$s]->smv_prod, $smvAvant[$s]->smv_finition, $smvAvant[$s]->prix_print, $smvAvant[$s]->id_unite_monetaire, $smvAvant[$s]->nombre_points, $smvAvant[$s]->smv_brod_main, $idDemandeNouveau, $smvAvant[$s]->id_stade_demande_client, $smvAvant[$s]->commentaire);
                }
            }
        }

        if (!empty($pri)) {
            $priAvant = Pri::getPriByIdDemande($idDemandeClient);
            if (count($priAvant) != 0) {
                for ($p = 0; $p < count($priAvant); $p++) {
                    $priNouveau = new Pri();
                    $priNouveau->insertPriNouveau($priAvant[$p]->date_pri, $priAvant[$p]->prix, $priAvant[$p]->id_unite_monetaire, $idDemandeNouveau, $priAvant[$p]->commentaire);
                }
            }
        }

        if ($request->hasFile('ficheDT')) {
            $uploadedPDF = $request->file('ficheDT');
            $pdfPath = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
        }

        if (empty($nomDT) && $request->hasFile('ficheDT')) {
            $nomDT = $request->file('ficheDT')->getClientOriginalName();
        }
        DemandeClient::insertDossierTechnique($idDemandeNouveau, $pdfPath, $nomDT);

        return redirect()->route('CRM.listeDemande');
    }

    public function ajoutTaille(Request $request)
    {
        $iddemande = $request->input('idDemande');
        $taille = $request->input('uniteTailleMin');
        $qte = $request->input('qte');
        DemandeClient::insertTailles($iddemande, $taille, $qte);
        return redirect()->route('CRM.detailDemande', ['idDemande' => $iddemande]);
    }
}
