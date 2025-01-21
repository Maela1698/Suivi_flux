<?php

namespace App\Http\Controllers;

use App\Models\ActeurTier;
use App\Models\EtatTiers;
use App\Models\Tiers;
use App\Models\QualiteTiers;
use App\Models\UniteMonetaire;
use App\Models\Cahiercharge;
use App\Models\FiltreTier;
use App\Models\Pays;
use Illuminate\Http\Request;

class controllerTier extends Controller
{
    public function accueil(Request $request)
    {
        $filters = [
            'idTiers' => $request->input('idTiers'),
            'idPays' => $request->input('idPays'),
            'idEtat' => $request->input('idEtat'),
            'idActeur' => $request->input('idActeur'),
            'autre' => $request->input('autre'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
        ];

        $tiers = FiltreTier::query()->where('etat_tier', 0); // Commencez par une requête de base sur le modèle

        $columns = ['nomtier', 'emailtier', 'adresse', 'ville', 'numphone', 'website'];

        $nomTiers = null;
        if ($request->idTiers) {
            $tiers->where('id_tier', $request->input('idTiers'));
            $nomTiers = Tiers::where('id', $request->idTiers)->pluck('nomtier')->first();
        }

        $nomPays = null;
        if ($request->idPays) {
            $tiers->where('idpays', $request->input('idPays'));
            $nomPays = Pays::where('id', $request->idPays)->pluck('nom_fr_fr')->first();
        }

        if ($request->idEtat) {
            $tiers->where('idetat', $request->input('idEtat'));
        }

        if ($request->idActeur) {
            $tiers->where('idacteur', $request->input('idActeur'));
        }

        if ($request->autre) {
            $searchTerm = $request->input('autre');
            $tiers->where(function ($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }

        if ($request->start && $request->end) {
            $tiers->whereBetween('dateentree', [$request->start, $request->end]);
        }

        // Récupérer les résultats après application de tous les filtres
        $tierss = $tiers->get();

        // Récupérer d'autres informations nécessaires pour la vue
        $tierscount = Tiers::getCountTier($filters);
        $tiersclient = Tiers::getCountClient($filters);
        $tiersfournisseur = Tiers::getCountFournisseur($filters);
        $tiersprospect = Tiers::getCountProspect($filters);
        $acteur = ActeurTier::getAllActeurTier();
        $etat = EtatTiers::getAllEtatTiers();

        return view('CRM.tier.listeTier', compact('tierss', 'tierscount', 'tiersclient', 'tiersfournisseur', 'tiersprospect', 'acteur', 'etat', 'nomTiers', 'nomPays'));
    }

    public function detailTier(Request $request)
    {
        $idtier = $request->input('idTier') ?? session('idTier');
        $detail = Tiers::getDetailTierById($idtier);
        $cahiertier = Tiers::getCahierChargeById($idtier);
        $interlocateur = Tiers::getInterlocateurById($idtier);
        return view('CRM.tier.detailTier', compact('detail', 'cahiertier', 'interlocateur'));
    }
    public function ajoutTier()
    {
        $acteur = ActeurTier::getAllActeurTier();
        $unite = UniteMonetaire::getAllUniteMonetaire();
        $qualite = QualiteTiers::getAllQualiteTiers();
        $etat = EtatTiers::getAllEtatTiers();
        return view('CRM.tier.ajoutTier', compact('acteur', 'unite', 'qualite', 'etat'));
    }

    public function listeEtatTier()
    {
        return view('CRM.tier.listeEtat');
    }
    public function listeQualite()
    {
        return view('CRM.tier.listeQualite');
    }
    public function listeUnite()
    {
        return view('CRM.tier.listeUnite');
    }













    /*-------ajout---------------*/
    public function nouveauTier(Request $request)
    {

        $request->validate([
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageBase64 = "";
        if ($request->hasFile('logo')) {
            $photo = $request->file('logo');
            $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
        }


        $request->validate([
            'cahierCharge' => 'mimes:pdf|max:10000',
        ]);

        $pdfPath = "";
        if ($request->hasFile('cahierCharge')) {
            $uploadedPDF = $request->file('cahierCharge');
            $pdfPath = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
        }
        // Gérer le fichier photo
        $photoPath = null;
        if ($request->hasFile('logo')) {
            // Récupérer le fichier
            $file = $request->file('logo');

            // Récupérer le nom d'origine du fichier
            $originalFileName = $file->getClientOriginalName();

            // Stocker le fichier avec son nom d'origine et récupérer le chemin
            $file->storeAs('photos_tiers', $originalFileName, 'public');
            $photoPath = $originalFileName;
        }
        $cachierCharge = null;
        if ($request->hasFile('cahierCharge')) {
            // Récupérer le fichier
            $file1 = $request->file('cahierCharge');

            // Récupérer le nom d'origine du fichier
            $originalFileName1 = $file1->getClientOriginalName();

            // Stocker le fichier avec son nom d'origine et récupérer le chemin
            $file1->storeAs('cachier_charges', $originalFileName1, 'public');
            $cachierCharge = $originalFileName1;
        }

        $tier = new Tiers([
            'nomtier' => $request->input('nomTier'),
            'idacteur' => $request->input('idActeur'),
            'adresse' => $request->input('adresse'),
            'ville' => $request->input('ville'),
            'codepostal' => $request->input('codePostal'),
            'idpays' => $request->input('idPays'),
            'numphone' => $request->input('numPhone'),
            'emailtier' => $request->input('emailTier'),
            'website' => $request->input('webSite'),
            'idunite' => $request->input('idUnite'),
            'idqualite' => $request->input('idQualite'),
            'idetat' => $request->input('idEtat'),
            'merchsenior' => $request->input('merchSenior', ''),
            'contactmerchsenior' => $request->input('contactMerchSenior', ''),
            'emailmerchsenior' => $request->input('emailMerchSenior', ''),
            'merchjunior' => $request->input('merchJunior', ''),
            'contactmerchjunior' => $request->input('contactMerchJunior', ''),
            'emailmerchjunior' => $request->input('emailMerchJunior', ''),
            'assistant' => $request->input('assistant', ''),
            'contactassistant' => $request->input('contactAssistant', ''),
            'emailassistant' => $request->input('emailAssistant', ''),
            'idutilisateur' => $request->input('idUtilisateur', 1),
            'logo' => $imageBase64, // Stocke le chemin du fichier logo
            'dateentree' => $request->input('dateentree', now()->format('d-m-Y')),
            'etat' => $request->input('etat', 0) // Défaut à 0 si non spécifié
        ]);

        // Sauvegarde de l'instance dans la base de données
        $tier->save();

        $nbrLigne = $request->input('nombreLigne');
        $idTier = $tier->id;

        for ($i = 0; $i < $nbrLigne; $i++) {
            $tier->insertIntelocateur($idTier,$request->input('nom' . $i), $request->input('email' . $i), $request->input('contact' . $i));
        }
        $CahierCharge = new CahierCharge([
            'idtiers' => $idTier,
            'cahiercharge' => $pdfPath, // Assurez-vous que ce champ existe dans le formulaire
            'etat' => 0 // Défaut à 0 si non spécifié
        ]);
        $CahierCharge->save();
        return redirect()->route('CRM.detailTier')
        ->with('idTier', $idTier);
    }
    /*-------ajout---------------*/



    /*-----auto complete--------*/
    public function recherche(Request $request)
    {
        $query = $request->get('nomPays');

        $countries = Pays::where('nom_fr_fr', 'ILIKE', '%' . $query . '%')->get();

        return response()->json($countries);
    }
    public function rechercheTiers(Request $request)
    {
        $query = $request->get('nomTiers');

        $tiers = Tiers::where('nomtier', 'ILIKE', '%' . $query . '%')->where('etat', 0)->get();

        return response()->json($tiers);
    }
    public function rechercheTiersDemande(Request $request)
    {
        $query = $request->get('nomTiers');

        $tiers = Tiers::where('nomtier', 'ILIKE', '%' . $query . '%')->get();

        return response()->json($tiers);
    }
    /*-----auto complete--------*/


    public function deleteTier(Request $request)
    {
        $idtier = $request->input('idTiers');
        Tiers::deleteTier($idtier);
        return redirect()->route('CRM.accueil');
    }
    // public function updateTiers(Request $request)
    // {
    //     $idtier = $request->input('idTiers');
    //     $acteur = ActeurTier::getAllActeurTier();
    //     $unite = UniteMonetaire::getAllUniteMonetaire();
    //     $qualite = QualiteTiers::getAllQualiteTiers();
    //     $etat = EtatTiers::getAllEtatTiers();
    //     $interlocateur = Tiers::getInterlocateurById($idtier);
    //     $tier = Tiers::getAllTiersById($idtier);
    //     $cahiercharge = Tiers::getCahierChargeById($idtier);
    //     $detailtier = Tiers::getDetailTierById($idtier);
    //     return view('CRM.tier.updateTier', compact('acteur', 'unite', 'qualite', 'etat', 'interlocateur', 'tier', 'cahiercharge', 'detailtier', 'idtier'));
    // }


    // public function modifTier(Request $request)
    // {


    //     $id = $request->input('idTiers');
    //     // Récupérer l'instance du Tier existant
    //     $tier = Tiers::findOrFail($id);

        // $request->validate([
        //     'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
        // $imageBase64 = "";
        // if ($request->hasFile('logo')) {
        //     $photo = $request->file('logo');
        //     $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
        // }else{
        //     $imageBase64 = $request->input('photoRecent');
        // }

        // $tier->updatePhoto($imageBase64, $id);

    //     $request->validate([
    //         'cahierCharge' => 'mimes:pdf|max:18360',
    //     ]);
    //     $pdfPath = "";
    //     if ($request->hasFile('cahierCharge')) {
    //         $uploadedPDF = $request->file('cahierCharge');
    //         $pdfPath = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
    //     }else{
    //         $pdfPath = $request->input('cahierCRecent');
    //     }


    //     $cahierCharge = CahierCharge::firstOrNew(['idtiers' => $id]);
    //     $cahierCharge->cahiercharge = $pdfPath;
    //     $cahierCharge->save();


    //     // Mettre à jour les informations du Tier
    //     $tier->update([
    //         'nomtier' => $request->input('nomTier'),
    //         'idacteur' => $request->input('idActeur'),
    //         'adresse' => $request->input('adresse'),
    //         'ville' => $request->input('ville'),
    //         'codepostal' => $request->input('codePostal'),
    //         'idpays' => $request->input('idPays'),
    //         'numphone' => $request->input('numPhone'),
    //         'emailtier' => $request->input('emailTier'),
    //         'website' => $request->input('webSite'),
    //         'idunite' => $request->input('idUnite'),
    //         'idqualite' => $request->input('idQualite'),
    //         'idetat' => $request->input('idEtat'),
    //         'merchsenior' => $request->input('merchSenior', ''),
    //         'contactmerchsenior' => $request->input('contactMerchSenior', ''),
    //         'emailmerchsenior' => $request->input('emailMerchSenior', ''),
    //         'merchjunior' => $request->input('merchJunior', ''),
    //         'contactmerchjunior' => $request->input('contactMerchJunior', ''),
    //         'emailmerchjunior' => $request->input('emailMerchJunior', ''),
    //         'assistant' => $request->input('assistant', ''),
    //         'contactassistant' => $request->input('contactAssistant', ''),
    //         'emailassistant' => $request->input('emailAssistant', ''),
    //         'idutilisateur' => $request->input('idUtilisateur', 1),
    //         'dateentree' => $request->input('dateentree', now()->format('d-m-Y')),
    //         'etat' => $request->input('etat', 0)
    //     ]);

    //     // Mettre à jour les interlocuteurs associés
    //     $nombreLignesExistantes = $request->input('nombreLignesExistantes');
    //     $nombreLignesNouvelles = $request->input('nombreLignesNouvelles');
    //     $tier->deleteById($id); // Supprime les interlocuteurs existants pour les remplacer
    //     for ($i = 0; $i < $nombreLignesNouvelles; $i++) {
    //         $tier->insertIntelocateur(
    //             $request->input('nomAjout' . $i),
    //             $request->input('emailAjout' . $i),
    //             $request->input('contactAjout' . $i)
    //         );
    //     }
    //     for ($i = 0; $i < $nombreLignesExistantes; $i++) {
    //         $tier->insertIntelocateur(
    //             $request->input('nom' . $i),
    //             $request->input('email' . $i),
    //             $request->input('contact' . $i)
    //         );
    //     }

    //     return redirect()->route('CRM.detailTier')
    //         ->with('idTier', $id);
    // }


    public function updateTiers(Request $request)
    {
        $idtier = $request->input('idTiers');
        $acteur=ActeurTier::getAllActeurTier();
        $unite=UniteMonetaire::getAllUniteMonetaire();
        $qualite=QualiteTiers::getAllQualiteTiers();
        $etat=EtatTiers::getAllEtatTiers();
        $interlocateur = Tiers::getInterlocateurById($idtier);
        $tier = Tiers::getAllTiersById($idtier);
        $cahiercharge = Tiers::getCahierChargeById($idtier);
        $detailtier = Tiers::getDetailTierById($idtier);
        return view('CRM.tier.updateTier',compact('acteur','unite','qualite','etat','interlocateur','tier','cahiercharge','detailtier','idtier'));
    }


    public function modifTier(Request $request){
        $request->validate([
            'logo' => 'nullable|file|mimes:jpg,jpeg,png,PNG,JPG,JPEG|max:2048',
            'cahierCharge' => 'nullable|file|mimes:pdf|max:15360',
        ]);

        $id =$request->input('idTiers');
        // Récupérer l'instance du Tier existant
        $tier = Tiers::findOrFail($id);

        // Gérer le fichier logo
        $photoPath = null;
        $request->validate([
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageBase64 = "";
        if ($request->hasFile('logo')) {
            $photo = $request->file('logo');
            $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
        }else{
            $imageBase64 = $request->input('photoRecent');
        }

        $tier->updatePhoto($imageBase64, $id);

        // Gérer le fichier cahier de charge
        if ($request->hasFile('cahierCharge')) {
            $file1 = $request->file('cahierCharge');
            $originalFileName1 = $file1->getClientOriginalName();
            $file1->storeAs('cachier_charges', $originalFileName1, 'public');

            // Mettre à jour ou créer l'entrée CahierCharge correspondante
            $cahierCharge = CahierCharge::firstOrNew(['idtiers' => $id]);
            $cahierCharge->cahiercharge = $originalFileName1;
            $cahierCharge->save();
        }

        // Mettre à jour les informations du Tier
        $tier->update([
            'nomtier' => $request->input('nomTier'),
            'idacteur' => $request->input('idActeur'),
            'adresse' => $request->input('adresse'),
            'ville' => $request->input('ville'),
            'codepostal' => $request->input('codePostal'),
            'idpays' => $request->input('idPays'),
            'numphone' => $request->input('numPhone'),
            'emailtier' => $request->input('emailTier'),
            'website' => $request->input('webSite'),
            'idunite' => $request->input('idUnite'),
            'idqualite' => $request->input('idQualite'),
            'idetat' => $request->input('idEtat'),
            'merchsenior' => $request->input('merchSenior', ''),
            'contactmerchsenior' => $request->input('contactMerchSenior', ''),
            'emailmerchsenior' => $request->input('emailMerchSenior', ''),
            'merchjunior' => $request->input('merchJunior', ''),
            'contactmerchjunior' => $request->input('contactMerchJunior', ''),
            'emailmerchjunior' => $request->input('emailMerchJunior', ''),
            'assistant' => $request->input('assistant', ''),
            'contactassistant' => $request->input('contactAssistant', ''),
            'emailassistant' => $request->input('emailAssistant', ''),
            'idutilisateur' => $request->input('idUtilisateur', 1),
            'dateentree' => $request->input('dateentree', now()->format('d-m-Y')),
            'etat' => $request->input('etat', 0)
        ]);

        // Mettre à jour les interlocuteurs associés
        $nombreLignesExistantes = $request->input('nombreLignesExistantes');
        $nombreLignesNouvelles = $request->input('nombreLignesNouvelles');
        $tier->deleteById($id);// Supprime les interlocuteurs existants pour les remplacer
        for ($i = 0; $i < $nombreLignesNouvelles; $i++) {
            $tier->insertIntelocateur($id,
                $request->input('nomAjout' . $i),
                $request->input('emailAjout' . $i),
                $request->input('contactAjout' . $i)
            );
        }
        for ($i = 0; $i < $nombreLignesExistantes; $i++) {
            $tier->insertIntelocateur($id,
                $request->input('nom' . $i),
                $request->input('email' . $i),
                $request->input('contact' . $i)
            );
        }

        return redirect()->route('CRM.detailTier')
            ->with('idTier', $id);
    }

}
