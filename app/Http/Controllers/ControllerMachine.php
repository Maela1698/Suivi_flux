<?php

namespace App\Http\Controllers;

use App\Models\Tiers;

use App\Models\Machine;
use App\Models\PieceMachine;
use Illuminate\Http\Request;
use App\Models\DemandeClient;
use App\Models\ElementMachine;
use App\Models\EmpruntMachine;
use App\Models\SecteurMachine;
use App\Models\UniteMonetaire;
use App\Models\VFiltreMachine;
use Illuminate\Support\Facades\DB;
use App\Models\LocalisationMachine;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ControllerMachine extends Controller
{
    //

    // auto-completions
    public static function findfournisseurmachine(Request $request)
    {
        $query = $request->get('nomfournisseur');

        $fournisseur = DB::table('fournisseurmachine')
            ->where('nom_fournisseur', 'ILIKE', '%' . $query . '%')
            ->where('etat', 0)
            ->get();

        return response()->json($fournisseur);
    }
    public static function findcategoriemachine(Request $request)
    {
        $query = $request->get('categorie');

        $marque_machine = DB::table('categoriemachine')
            ->where('categorie', 'ILIKE', '%' . $query . '%')
            ->where('etat', 0)
            ->get();

        return response()->json($marque_machine);
    }
    public static function findmarquemachine(Request $request)
    {
        $query = $request->get('marque');

        $marque_machine = DB::table('marquemachine')
            ->where('marque', 'ILIKE', '%' . $query . '%')
            ->where('etat', 0)
            ->get();

        return response()->json($marque_machine);
    }
    public static function findelementmachine(Request $request)
    {
        $query = $request->get('element');
        $idmachine = $request->get('id_machine');


        $element_machine = DB::table('elementmachine')
            ->where('element', 'ILIKE', '%' . $query . '%')
            ->where('idmachine', 'ILIKE', '%' . $idmachine . '%')
            ->where('etat', 0)
            ->get();

        return response()->json($element_machine);
    }
    public static function findpiecemachine(Request $request)
    {
        $query = $request->get('piece');

        $piece_machine = DB::table('piecemachine')
            ->where('designation', 'ILIKE', '%' . $query . '%')
            ->where('etat', 0)
            ->get();

        return response()->json($piece_machine);
    }
    public static function findallmachine(Request $request)
    {
        $query = $request->get('machine');

        $piece_machine = DB::table('listemachine')
            ->where('machine', 'ILIKE', '%' . $query . '%')
            // ->where('etat', 0)
            ->get();

        return response()->json($piece_machine);
    }
    public static function findallsecteur(Request $request)
    {
        $query = $request->get('secteur');

        $secteurs = DB::table('secteurmachine')
            ->where('secteur', 'ILIKE', '%' . $query . '%')
            ->where('etat', 0)
            ->get();

        return response()->json($secteurs);
    }
    public static function findalllocalisation(Request $request)
    {
        $query = $request->get('localisation');

        $loca = DB::table('localisationmachine')
            ->where('localisation', 'ILIKE', '%' . $query . '%')
            ->where('etat', 0)
            ->get();

        return response()->json($loca);
    }
    // end auto-completions


    // affichage
    public static function accueilgmao(Request $request)
    {
        $filters = [
            'fournisseur' => $request->input('fournisseur'),
            'marque' => $request->input('marque'),
            'code' => $request->input('code'),
            'categorie' => $request->input('categorie'),
            'start_fin_service' => $request->input('start_fin_service'),
            'end_fin_service' > $request->input('end_fin_service'),
            'start_fin_contrat' => $request->input('start_fin_contrat'),
            'end_fin_contrat' => $request->input('end_fin_contrat'),
            'scanned_code' => $request->input('scanned_code'),
            'idlocalisation' => $request->input('idlocalisation'),
            'secteur' => $request->input('secteur'),

            // j'aimerais rajouter secteur dans ce filtre pour pouvoir l'utiliser
        ];

        // $machines_all = VFiltreMachine::query()
        //     ->whereNotIn('machine_etat', [300, 400])
        //     ->orderBy('id_machine');

        $machines_all = VFiltreMachine::query()
            //
            ->whereNotIn('machine_etat', [300, 400])
            ->orderBy('id_machine')
            ->distinct();


        $hasFilters = false;

        // Filtre pour le fournisseur
        $id_from_fournisseur = null;
        if ($request->fournisseur) {
            $machines_all->where('id_from_fournisseur', 'ILIKE', '%' . $request->input('fournisseur') . '%');
            $id_from_fournisseur = VFiltreMachine::where('id_from_fournisseur', $request->fournisseur)
                ->pluck('id_from_fournisseur')
                ->first();
            $hasFilters = true;
        }

        // Filtre pour la marque
        if ($request->marque) {
            $machines_all->where('marque', 'ILIKE', '%' . $request->input('marque') . '%');
            $hasFilters = true;
        }

        // Filtre pour le code machine
        if ($request->code) {
            $machines_all->where('codemachine', 'ILIKE', '%' . $request->input('code') . '%');
            $hasFilters = true;
        }

        // Filtre pour le code scanné
        if ($request->scanned_code) {
            $machines_all->where('codemachine', 'ILIKE', '%' . $request->input('scanned_code') . '%');
            $hasFilters = true;
        }

        // Vérifiez si le scanned_code est passé
        // if ($request->input('scanned_code')) {
        //     $output = shell_exec('python D:\COURS\Uwamp7\UwAmp\www\STAGE LOI\1-ASSEMBLEUR\python\qr_scanner2.py');
        //     Log::info('QR Scanner Output: ' . $output);
        // }

        // Filtre pour la catégorie
        if ($request->categorie) {
            $machines_all->where('catgoriemachine', 'ILIKE', '%' . $request->input('categorie') . '%');
            $hasFilters = true;
        }

        // Filtre pour les dates de fin de service
        if ($request->start_fin_service && $request->end_fin_service) {
            $machines_all->whereBetween('dateentreemachine', [$request->start_fin_service, $request->end_fin_service]);
            $hasFilters = true;
        }

        // Filtre pour les dates de fin de contrat
        if ($request->start_fin_contrat && $request->end_fin_contrat) {
            $machines_all->whereBetween('datefincontrat', [$request->start_fin_contrat, $request->end_fin_contrat]);
            $hasFilters = true;
        }

        if ($request->idlocalisation) {
            $machines_all->where('id_localisation', 'ILIKE', '%' . $request->input('idlocalisation') . '%');
            $hasFilters = true;
        }

        if ($request->secteur) {
            $machines_all->where('id_secteur', $request->input('secteur'));
            $hasFilters = true;
        }

        // Exécuter la requête
        $machines_all = $machines_all->get();


        $localisations = LocalisationMachine::findAllLocalisation();
        $secteurs = SecteurMachine::findAllSecteur();
        // $machines_all = VFiltreMachine::all();


        $locales = VFiltreMachine::findLocal($filters);
        $emprunts = VFiltreMachine::findEmprunt($filters);

        $nbrMachines = VFiltreMachine::findnbrMachines($filters);
        $nbrMachineLocales = VFiltreMachine::findnbrMachineLocales($filters);
        $nbrMachineEmprunt = VFiltreMachine::findnbrMachineEmprunt($filters);
        $cout_presta = VFiltreMachine::sumCoutEmprunt($filters);
        $liste_machine = DB::select('SELECT * FROM listemachine where etat=0');

        return view(
            'GMAO.gestions_equipement.accueil',
            compact(
                'machines_all',
                'locales',
                'emprunts',
                'nbrMachines',
                'nbrMachineLocales',
                'nbrMachineEmprunt',
                'cout_presta',
                'localisations',
                'secteurs',
                'liste_machine'
            )
        );
    }
    // public function scanQrCode()
    // {
    //     // Exécute le script Python
    //     // $output = exec('python D:\COURS\Uwamp7\UwAmp\www\STAGE LOI\1-ASSEMBLEUR\python\qr_scanner2.py');

    //     // // Lire le fichier de résultats
    //     // $result = json_decode(file_get_contents('result.json'), true);

    //     // return response()->json($result);


    //     //     public function scanQR()
    //     // {
    //     // Chemin vers l'exécutable Python et le script
    //     $pythonPath = 'C:\Users\ASUS\AppData\Local\Programs\Python\Python313\python.exe'; // Changez ce chemin si nécessaire
    //     $scriptPath = 'D:\COURS\Uwamp7\UwAmp\www\STAGE LOI\1-ASSEMBLEUR\python\qr_scanner2.py'; // Mettez le chemin correct de votre script Python


    //     // donner la permisssion d'exécution
    //     // chmod +x D:\COURS\Uwamp7\UwAmp\www\STAGE LOI\1-ASSEMBLEUR\python\qr_scanner2.py



    //     // Exécutez le script Python
    //     $command = escapeshellcmd("$pythonPath $scriptPath");
    //     $output = [];
    //     $returnVar = 0;

    //     exec($command, $output, $returnVar);

    //     // Vérifiez si l'exécution a réussi
    //     if ($returnVar === 0) {
    //         echo implode("\n", $output); // Affiche la sortie du script
    //     } else {
    //         echo "Error executing Python script.";
    //     }


    //     // Traitez les résultats (par exemple, le contenu de result.json)
    //     // $resultPath = '/path/to/your/result.json';
    //     // if (file_exists($resultPath)) {
    //     //     $result = json_decode(file_get_contents($resultPath), true);
    //     //     return response()->json($result);
    //     // }

    //     $resultPath = storage_path('app/result.json');
    //     if (file_exists($resultPath)) {
    //         $result = json_decode(file_get_contents($resultPath), true);
    //         echo "Scanned code: " . $result['scanned_code'];
    //     } else {
    //         echo "No scanned code found.";
    //     }

    //     return response()->json(['error' => 'No result found'], 404);
    //     // }
    // }
    public function scan(Request $request)
    {
        // 3)
        // $pythonPath = 'C:\\Users\\ASUS\\AppData\\Local\\Programs\\Python\\Python313\\python.exe';
        // $scriptPath = 'D:\\COURS\\Uwamp7\\UwAmp\\www\\STAGE LOI\\1-ASSEMBLEUR\\python\\qr_scanner2.py';

        // $process = new Process([$pythonPath, $scriptPath, $request->mode]); // Assurez-vous que le mode est passé
        // $process->run();

        // if (!$process->isSuccessful()) {
        //     return response()->json(['error' => 'Erreur lors de l\'exécution du script Python.'], 500);
        // }

        // $output = $process->getOutput();
        // Log::info("Output from Python script: " . $output); // Log l'output pour le debug
        // $result = json_decode($output, true);

        // if (isset($result['scanned_code'])) {
        //     return response()->json(['scanned_code' => $result['scanned_code']]);
        // } else {
        //     return response()->json(['error' => 'Aucun code scanné trouvé.'], 404);
        // }



        // 2)
        // $pythonPath = 'C:\\Users\\ASUS\\AppData\\Local\\Programs\\Python\\Python313\\python.exe';
        // $scriptPath = 'D:\\COURS\\Uwamp7\\UwAmp\\www\\STAGE LOI\\1-ASSEMBLEUR\\python\\qr_scanner2.py';

        // $mode = $request->input('mode', 'webcam');
        // $imagePath = $request->input('image_path');

        // if ($mode === 'webcam') {
        //     // Mode scan par webcam
        //     $process = new Process([$pythonPath, $scriptPath, 'webcam']);
        // } elseif ($mode === 'image' && !empty($imagePath)) {
        //     // Mode scan par image (vérifiez que le chemin de l'image est défini)
        //     $process = new Process([$pythonPath, $scriptPath, $imagePath]);
        // } else {
        //     return response()->json(['error' => 'Mode de scan ou chemin de l\'image non valide.'], 400);
        // }

        // // Exécuter le script Python
        // $process->run();

        // // Vérifiez s'il y a une erreur lors de l'exécution
        // if (!$process->isSuccessful()) {
        //     return response()->json(['error' => 'Erreur lors de l\'exécution du script Python.'], 500);
        // }

        // // Récupérez la sortie et décodez le JSON
        // $output = $process->getOutput();
        // $result = json_decode($output, true);

        // if (isset($result['scanned_code'])) {
        //     return response()->json(['scanned_code' => $result['scanned_code']]);
        // } else {
        //     return response()->json(['error' => 'Aucun code scanné trouvé.'], 404);
        // }



        // 1)
        $mode = $request->input('mode', 'webcam'); // Récupérer le mode (webcam ou image)
        $pythonPath = 'C:\\Users\\ASUS\\AppData\\Local\\Programs\\Python\\Python313\\python.exe';
        $scriptPath = 'D:\\COURS\\Uwamp7\\UwAmp\\www\\STAGE LOI\\1-ASSEMBLEUR\\python\\qr_scanner2.py';

        // Si le mode est 'webcam', exécutez le script sans paramètres supplémentaires
        if ($mode === 'webcam') {
            $process = new Process([$pythonPath, $scriptPath, 'webcam']);
        } elseif ($mode === 'image') {
            $imagePath = $request->input('image_path'); // Assurez-vous d'envoyer le chemin de l'image
            $process = new Process([$pythonPath, $scriptPath, $imagePath]);
        } else {
            return response()->json(['error' => 'Mode non reconnu.'], 400);
        }

        $process->run();

        if (!$process->isSuccessful()) {
            return response()->json(['error' => 'Erreur lors de l\'exécution du script Python.'], 500);
        }

        $output = $process->getOutput();
        $result = json_decode($output, true);

        if (isset($result['scanned_code'])) {
            return response()->json(['scanned_code' => $result['scanned_code']]);
        } else {
            return response()->json(['error' => 'Aucun code scanné trouvé.'], 404);
        }
        // }
    }
    public static function detailsmachine($idmachine)
    {
        $details_machine = VFiltreMachine::findMachineById($idmachine);
        $liste_machine = DB::select('SELECT * FROM listemachine where id=?', [$idmachine]);
        $elements = VFiltreMachine::findElementByIdMachine($idmachine)
            ->where('etat_pm', 0);

        $pieces = PieceMachine::findPieceMachine($idmachine)
            ->where('etat', 0);
        return view(
            'GMAO.gestions_equipement.detailsmachine',
            compact(
                'details_machine',
                'liste_machine',
                'elements',
                'pieces'
            )
        );
    }
    public static function showajoutpiece()
    {
        // $categorie_machine = DB::select('SELECT * FROM taillemachine');
        // , compact('categorie_machine')
        return view('GMAO.gestions_equipement.ajoutpieces');
    }
    public static function listepieces()
    {
        $pieces = PieceMachine::findAllPieceMachine();
        return view('GMAO.gestions_equipement.listepieces', compact('pieces'));
    }
    public static function showaffectermachine($idmachine)
    {
        $id_machine = $idmachine;
        $details_machine = VFiltreMachine::findMachineById($idmachine);
        return view('GMAO.gestions_equipement.affectermachine', compact(
            'details_machine',
            'id_machine'
        ));
    }
    public static function showupdatemachine($idmachine)
    {
        $id_machine = $idmachine;
        $details_machine_filtre = DB::table('v_filtre_machine')
            ->where('id_machine', $idmachine)
            ->first();
        $categorie_machine = DB::select('SELECT * FROM taillemachine');
        $unite = UniteMonetaire::getAllUniteMonetaire();
        return view('GMAO.gestions_equipement.formupdatemachine', compact(
            'details_machine_filtre',
            'id_machine',
            'categorie_machine',
            'unite'
        ));
    }
    public function showdeplacermachine($idmachine)
    {
        $id_machine = $idmachine;
        $details_machine = VFiltreMachine::findMachineById($idmachine);
        $details_jointure_secteur = SecteurMachine::findMachineSecteurJointure($idmachine);
        return view('GMAO.gestions_equipement.deplacermachine', compact(
            'details_machine',
            'id_machine',
            'details_jointure_secteur',
        ));
    }
    public function showajoutsecteur()
    {
        return view('GMAO.gestions_equipement.formajoutsecteur');
    }
    public function showupdatepiece($id_piece)
    {
        $piece = DB::table('piecemachine')->where('id', $id_piece)->first();

        if (!$piece) {
            return redirect()->back()->with('error', 'Pièce non trouvée.');
        }

        return view('GMAO.gestions_equipement.modifierpiece', compact('piece'));
    }
    // end affichage
    // $details_machine = VFiltreMachine::findMachineById($idmachine);




    // CRUD

    // machine
    public function updatemachine(Request $request, $idmachine)
    {
        $validated = $request->validate([
            'type' => 'required|in:100,200',
            'date_entree' => 'required|date',
            'date_fin_contrat' => 'nullable|date|after_or_equal:date_entree',
            'nomfournisseur' => 'required|numeric',
            'marque' => 'required|numeric',
            'id_fr' => 'nullable|string',
            'code' => 'nullable|string',
            'categorie' => 'required|numeric',
            'id_taille_machine' => 'required|numeric',
            'reference' => 'nullable|string',
            'capacite' => 'nullable|string',
            'cout' => 'nullable|string',
            'prixu' => 'required|string',
            'coutprestation' => 'nullable|numeric',
            'id_unite_monetaire' => 'nullable|integer',
            'image' => 'nullable|string',
            'photo' => 'nullable|string',
            'photo_machine' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'document' => 'mimes:pdf|max:10000',
            'idUnite' => 'required|numeric'
        ]);

        // Préparation de l'image encodée en base64, si une nouvelle image est fournie
        $imageBase64 = $request->hasFile('photo_machine') ? base64_encode(file_get_contents($request->file('photo_machine')->getRealPath())) : null;
        $imageBase64 = preg_replace('/[^A-Za-z0-9\/\+=]/', '', $imageBase64);


        $image_data = base64_decode($imageBase64, true);
        if ($image_data === false) {
            echo "La chaîne Base64 est invalide.";
        } else {
            echo "La chaîne Base64 est valide.";
        }


        // Préparation du document encodé en base64, si un nouveau fichier est fourni
        $pdfPath1 = $request->hasFile('document') ? base64_encode(file_get_contents($request->file('document')->getRealPath())) : null;

        try {
            // Récupération de la machine à mettre à jour
            $machine = Machine::findOrFail($idmachine);

            // Mise à jour des champs de la machine
            $machine->update([
                'dateentreemachine' => $request->date_entree,
                'id_from_fournisseur' => $request->id_fr ?: null,
                'codemachine' => $request->code,
                'idmarquemachine' => $request->marque ?: null,
                'idcategoriemachine' => $request->categorie ?: null,
                'id_fournisseur_machine' => $request->nomfournisseur ?: null,
                'reference' => $request->reference,
                'capacite' => $request->capacite,
                'proprietee' => $request->type,
                'idtaillemachine' => $request->id_taille_machine ?: null,
                'prixu' => $request->prixu,
                'photo' => $request->image ?? $imageBase64 ?? $machine->photo,
                'idunitemonetaire' => $request->idUnite,
            ]);

            // Gestion de l'EmpruntMachine si le type est '200'
            if ($request->type == '200') {
                EmpruntMachine::updateOrCreate(
                    ['idmachine' => $machine->id],
                    [
                        'datefincontrat' => $request->date_fin_contrat,
                        'cout_prestation' => $request->coutprestation,
                    ]
                );
            } else {
                EmpruntMachine::where('idmachine', $machine->id)->delete();
            }

            // Insertion ou mise à jour du document
            if ($request->hasFile('document')) {
                $file1 = $request->file('document');
                $originalFileName1 = $request->code;
                $nomDossier = $request->input('code') ?: $originalFileName1;
                Machine::insertdossierMachine($machine->id, $pdfPath1, $nomDossier);
            }

            return redirect()->route('GMAO.showupdatemachine', ['idmachine' => $idmachine])->with('success', 'Machine mise à jour avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
    public function storemachine(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:100,200',
            'date_entree' => 'required|date',
            'nomfournisseur' => 'required|numeric',
            'marque' => 'required|numeric',
            'id_fr' => 'nullable|string',
            'code' => 'nullable|string',
            'categorie' => 'required|numeric',
            'id_taille_machine' => 'required|numeric',
            'reference' => 'nullable|string',
            'capacite' => 'nullable|string',
            'cout' => 'nullable|string',
            'prixu' => 'required|string',
            'date_fin_contrat' => 'nullable|date',
            'coutprestation' => 'nullable|numeric',
            'id_unite_monetaire' => 'nullable|integer',
            'image' => 'nullable|string',
            'photo' => 'nullable|string',
            'photo_machine' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'document' => 'mimes:pdf|max:10000',
            'idUnite' => 'required|numeric'
        ]);
        // dd($request->all());

        $imageBase64 = "";
        if ($request->hasFile('photo_machine')) {
            $photo = $request->file('photo_machine');
            $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
        }

        $pdfPath1 = "";
        if ($request->hasFile('document')) {
            $uploadedPDF = $request->file('document');
            $pdfPath1 = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
        }

        try {
            $machine = Machine::create([
                'dateentreemachine' => $request->date_entree,
                'id_from_fournisseur' => $request->id_fr ?: null,
                'codemachine' => $request->code,
                'idmarquemachine' => $request->marque ?: null,
                'idcategoriemachine' => $request->categorie ?: null,
                'id_fournisseur_machine' => $request->nomfournisseur ?: null,
                'reference' => $request->reference,
                'capacite' => $request->capacite,
                'proprietee' => $request->type, //la valeur n'est pas insérer dans la base or normalement ceci est soit 100 soit 200 car cette valeur vient de radios buttons
                'idtaillemachine' => $request->id_taille_machine ?: null,
                'prixu' => $request->prixu,
                'photo' => $request->image ?? $imageBase64,
                'idunitemonetaire' => $request->idUnite,
            ]);

            if ($request->type == '200') {
                EmpruntMachine::create([
                    'idmachine' => $machine->id,
                    'datefincontrat' => $request->date_fin_contrat,
                    'cout_prestation' => $request->coutprestation,
                ]);
            }

            if ($request->hasFile('document')) {
                $file1 = $request->file('document');
                $originalFileName1 = $request->code;
                $nomDossier = $request->input('code') ?: $originalFileName1;

                Machine::insertdossierMachine($machine->id, $pdfPath1, $nomDossier);
            }

            return redirect()->route('GMAO.showajoutmachine')->with('success', 'Machine ajoutée avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
    public function ajoutDossierMachine(Request $request)
    {
        $request->validate([
            'ficheDT' => 'mimes:pdf|max:15360',
        ]);

        $pdfPath = "";
        if ($request->hasFile('ficheDT')) {
            $uploadedPDF = $request->file('ficheDT');
            $pdfPath = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
        }

        $nomDossier2 = $request->input('nomdossier');
        $idmachine = $request->input('idmachine');
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
            Machine::insertdossierMachine($idmachine, $pdfPath, $nomDossier2);
            return redirect()->route('GMAO.showajoutmachine', ['idmachine' => $idmachine]);
        }
    }
    public function ajoutlocalisation(Request $request)
    {
        $validated = $request->validate([
            'localisation'  => 'required|string|max:255'
        ]);

        $localisation = $request->input('localisation');

        $insert = LocalisationMachine::insertLocalisation($localisation);

        if ($insert) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    // élément
    public function ajoutelement(Request $request)
    {
        $validated = $request->validate([
            'id_machine' => 'required|integer',
            'element' => 'required|string|max:255'
        ]);

        $id_machine = $request->input('id_machine');
        $element = $request->input('element');

        $insert = VFiltreMachine::insertElement($id_machine, $element);

        if ($insert) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    public static function storepiece(Request $request)
    {
        $validated = $request->validate([
            'date_ajout' => 'required|date',
            'designation' => 'nullable|string',
            'reference' => 'nullable|string',
            'duree_vie' => 'required|string',
            'nbr' => 'required|numeric|min:1',
            'image' => 'nullable|string',
            'photo' => 'nullable|string',
            'photo_machine' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageBase64 = "";
        if ($request->hasFile('photo_machine')) {
            $photo = $request->file('photo_machine');
            $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
        }

        try {
            for ($i = 0; $i < $request->nbr; $i++) {
                PieceMachine::create([
                    'designation' => $request->designation,
                    'reference' => $request->reference,
                    'dureevie' => $request->duree_vie,
                    'photo' => $request->image ?? $imageBase64,
                    'nombre' => 1,
                    'etat' => 0,
                    'date_ajout_piece' => $request->date_ajout,
                ]);
            }
            return redirect()->route('GMAO.showajoutpiece')->with('success', 'Pièce(s) ajoutée(s) avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
    public static function updatePiece(Request $request, $id)
    {
        $validated = $request->validate([
            'date_ajout' => 'required|date',
            'designation' => 'nullable|string',
            'reference' => 'nullable|string',
            'duree_vie' => 'required|string',
            'image' => 'nullable|string',
            'photo_machine' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageBase64 = $request->image ?? '';
        if ($request->hasFile('photo_machine')) {
            $photo = $request->file('photo_machine');
            $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
        }

        try {
            $piece = PieceMachine::findOrFail($id);

            $piece->designation = $request->designation;
            $piece->reference = $request->reference;
            $piece->dureevie = $request->duree_vie;
            $piece->photo = $imageBase64;
            $piece->date_ajout_piece = $request->date_ajout;
            $piece->save();

            return redirect()->route('GMAO.showajoutpiece')->with('success', 'Pièce mise à jour avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function updateElement(Request $request)
    {
        $request->validate([
            'idelement' => 'required|integer|exists:elementmachine,id',
            'element' => 'required|string|max:250',
        ]);

        $element = ElementMachine::find($request->idelement);

        if ($element) {
            $element->element = $request->element;
            $element->save();

            return redirect()->back()->with('success', 'Elément mis à jour avec succès.');
        } else {
            return redirect()->back()->withErrors('Erreur : élément introuvable.');
        }
    }


    // secteurs et localisation
    public static function affectermachine(Request $request)
    {
        try {
            $request->validate([
                'id_machine' => 'required|numeric',
                // 'idsecteur' => 'required|numeric',
                'secteur' => 'required|numeric',
                'date_affectation' => 'required|date',
                'commentaire' => 'nullable|string',
            ]);

            $idsecteur = $request->input('secteur');
            $id_machines = $request->input('id_machine');
            $date_affectation = $request->input('date_affectation');
            $commentaire = $request->input('commentaire');


            LocalisationMachine::affecterSecteurMachine($idsecteur, $id_machines, $date_affectation, $commentaire);

            $etat = 100;
            $machine = Machine::updateEtatMachine2($id_machines, $etat);
            // if ($machine) {
            //     $machine->etat = 10;
            //     $machine->save();

            //     return response()->json(['success' => true]);
            // }
            return redirect()->route('GMAO.accueilgmao')
                ->with('success', 'Machine affectée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public static function affecterpiece(Request $request)
    {
        try {
            $request->validate([
                'id_machine' => 'required|integer',
                'date_affectation' => 'required|date',
                'element1.*' => 'required',
                'id_element1.*' => 'required_with:element1.*',
                'id_piece1.*' => 'required_with:piece1.*',
                'piece1.*' => 'required',
                'commentaire' => 'nullable|string',
            ]);


            $id_machine = $request->input('id_machine');
            $date_affectation = $request->input('date_affectation');
            $commentaire = $request->input('commentaire');

            $id_elements = $request->input('id_element1');
            $id_pieces = $request->input('id_piece1');

            foreach ($id_elements as $index => $idelement) {
                $idpiece = $id_pieces[$index];

                Log::info('id_element1: ' . $idelement);
                Log::info('id_piece1: ' . $idpiece);


                PieceMachine::affecterPieceMachine($idelement, $idpiece, $id_machine, $date_affectation, $commentaire);
                PieceMachine::where('id', $idpiece)->update(['etat' => 10]);
            }

            return redirect()->route('GMAO.gestions_equipement.detailsmachine', ['id_machine' => $id_machine])
                ->with('success', 'Pièce(s) affectée(s) avec succès.');
        } catch (\Exception $e) {
            // Rediriger en cas d'erreur avec un message d'erreur
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public static function updateEtat(Request $request)
    {
        $piece = PieceMachine::find($request->id_piece);
        if ($piece) {
            $piece->etat = $request->etat;
            $piece->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Pièce non trouvée']);
    }

    public static function updateEtat2(Request $request)
    {
        $piece = PieceMachine::find($request->id_piece);
        if ($piece) {
            $piece->etat = $request->etat;
            $piece->save();

            return response()->json(['success' => true, 'id_machine' => $request->idmachine]);
        }

        return response()->json(['success' => false, 'message' => 'Pièce non trouvée']);
    }
    public function updateElementStatus(Request $request)
    {
        $request->validate([
            'idElement2' => 'required|integer|exists:elementmachine,id',
        ]);

        $element = ElementMachine::find($request->idElement2);

        if ($element) {
            $element->etat = 400;
            $element->save();

            return redirect()->back()->with('success', 'Élément retiré avec succès.');
        } else {
            return redirect()->back()->withErrors('Erreur : élément introuvable.');
        }
    }

    public static function updateEtatMachine(Request $request)
    {
        $machine = Machine::find($request->id);
        if ($machine) {
            $machine->etat = $request->etat;
            $machine->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Pièce non trouvée']);
    }
    public static function update_localisation_machine(Request $request)
    {
        $localisation = LocalisationMachine::find($request->id);
        if ($localisation) {
            $localisation->localisation = $request->modified_loc;
            $localisation->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Localisation non trouvée']);
    }

    public static function delete_update_machine(Request $request)
    {
        $machine = Machine::find($request->id);
        if ($machine) {
            $machine->etat = 400;
            $machine->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Machine non trouvée']);
    }

    public static function delete_update_localisation(Request $request)
    {
        $localisation = LocalisationMachine::find($request->id);
        if ($localisation) {
            $localisation->etat = 10;
            $localisation->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'localisation non trouvée']);
    }

    public function deplacermachine(Request $request)
    {
        $request->validate([
            'date_deplacement' => 'required|date',
            'secteur1' => 'required|integer|exists:secteurmachine,id',
            'secteur2' => 'required|integer|exists:secteurmachine,id',
            'id_machine' => 'required|integer|exists:listemachine,id',
            'commentaire' => 'nullable|string|max:255'
        ]);

        try {
            // Insertion de la nouvelle affectation dans `join_secteur_machine`
            $newAffectationId = DB::table('join_secteur_machine')->insert([
                'idsecteurmachine' => $request->input('secteur2'),
                'idlistemachine' => $request->input('id_machine'),
                'date_affectation_machine' => $request->input('date_deplacement'),
                'etat_secteur_machine' => 0,
                'commentaire' => $request->input('commentaire')
            ]);

            // Récupération et mise à jour de la dernière affectation de la machine
            DB::table('join_secteur_machine')
                ->where('id_j_secteur_machine', $request->input('id_j_secteur_machine'))
                ->update(['etat_secteur_machine' => 10]);

            // Enregistrement du déplacement dans `historique_deplacement_machine`
            DB::table('historique_deplacement_machine')->insert([
                'idsecteurmachine1' => $request->input('secteur1'),
                'idsecteurmachine2' => $request->input('secteur2'),
                'idlistemachine' => $request->input('id_machine'),
                'date_deplacement' => $request->input('date_deplacement'),
                'commentaire' => $request->input('commentaire')
            ]);

            return redirect()->back()->with('success', 'Déplacement enregistré avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement du déplacement : ' . $e->getMessage());
        }
    }
    public function getMachines($secteurId)
    {
        $machines = VFiltreMachine::where('idsecteurmachine', $secteurId)
            ->whereNotIn('machine_etat', [300, 400])
            ->where('etat_emprunt', 0)
            ->get();

        // Retourner les machines en format JSON
        return response()->json($machines);
    }
    // public function getMachinesByCode($scanned_code)
    // {
    //     $machines = VFiltreMachine::where('codemachine', $scanned_code)
    //         ->whereNotIn('machine_etat', [300, 400])
    //         ->where('etat_emprunt', 0)
    //         ->get();

    //     // Retourner les machines en format JSON
    //     return response()->json($machines);
    // }
    public function getMachinesByCode($scanned_code)
    {
        $machines = VFiltreMachine::where('codemachine', $scanned_code)
            ->pluck('id_machine');

        return response()->json($machines);
    }


    public function getSecteurs($idLocalisation)
    {
        $secteurs = SecteurMachine::where('idlocalisationmachine', $idLocalisation)->get();

        return response()->json($secteurs);
    }

    public function insertSecteur(Request $request)
    {
        $request->validate([
            // 'idlocalisation' => 'required|integer|exists:localisationmachine,id',
            'localisation' => 'required|numeric',
            'secteur' => 'required|string|max:50',
        ]);

        try {
            DB::table('secteurmachine')->insert([
                'idlocalisationmachine' => $request->input('localisation'),
                'secteur' => $request->input('secteur'),
                'etat' => 0,
            ]);

            return redirect()->back()->with('success', 'Secteur ajouté avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l’ajout du secteur : ' . $e->getMessage());
        }
    }
    public function updateSecteur(Request $request, $id)
    {
        $request->validate([
            'idlocalisation' => 'required|numeric|exists:localisationmachine,id',
            'secteur' => 'required|string|max:250',
        ]);

        try {
            DB::table('secteurmachine')->where('id', $id)->update([
                'idlocalisationmachine' => $request->input('idlocalisation'),
                'secteur' => $request->input('secteur'),
            ]);

            return redirect()->back()->with('success', 'Secteur mis à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du secteur : ' . $e->getMessage());
        }
    }
    public function updateEtatSecteur($id)
    {
        try {
            DB::table('secteurmachine')->where('id', $id)->update(['etat' => 10]);

            return redirect()->back()->with('success', 'Secteur marqué comme supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l\'état du secteur : ' . $e->getMessage());
        }
    }
    public function insertSecteurMachine(Request $request)
    {
        $request->validate([
            'secteur' => 'required|numeric',
            'id_machine' => 'required|numeric',
            'date_affectation' => 'required|date',
            'commentaire' => 'nullable|string|max:255'
        ]);

        try {
            DB::table('join_secteur_machine')->insert([
                'idsecteurmachine' => $request->input('secteur'),
                'idlistemachine' => $request->input('id_machine'),
                'date_affectation_machine' => $request->input('date_affectation'),
                'etat_secteur_machine' => 0,
                'commentaire' => $request->input('commentaire')
            ]);

            return redirect()->route('GMAO.detailsmachine', ['idmachine' => $request->input('id_machine')])
                ->with('success', 'Affectation ajoutée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('GMAO.detailsmachine', ['idmachine' => $request->input('id_machine')])
                ->with('error', 'Erreur lors de l’ajout de l’affectation : ' . $e->getMessage());
        }
    }
    // END CRUD





    public static function photogmao()
    {
        return view('GMAO.photo');
    }
    public function upload(Request $request)
    {
        $imageData = $request->input('image');
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $imageName = time() . '.png';
        File::put(public_path('images') . '/' . $imageName, base64_decode($imageData));

        return response()->json(['success' => 'Photo uploaded successfully']);
    }
    public static function showajoutmachine()
    {
        $categorie_machine = DB::select('SELECT * FROM taillemachine');
        $unite = UniteMonetaire::getAllUniteMonetaire();
        return view('GMAO.gestions_equipement.formajoutmachine', compact('categorie_machine', 'unite'));
    }

    public static function showprocessQrCode()
    {
        return view('GMAO.gestions_equipement.qr');
    }
    public static function processQrCode(Request $request)
    {
        // Récupérer les données envoyées depuis le QR Code
        $qrData = $request->input('qr_data');

        // Traitement des données ou requête SQL sur PostgreSQL
        // Par exemple, récupération d'informations en fonction du QR Code scanné
        $result = DB::table('listemachine')->where('id', $qrData)->first();

        return response()->json($result);
    }



    // REACT
    public function storeResult(Request $request)
    {
        $data = $request->validate([
            'scanned_code' => 'required|string',
        ]);
        return response()->json(['message' => 'Code scanné reçu', 'data' => $data]);
    }
    // END REACT


















    // public function upload2(Request $request)
    // {
    //     $imageData = $request->input('image');
    //     $imageData = str_replace('data:image/png;base64,', '', $imageData);
    //     $imageData = str_replace(' ', '+', $imageData);
    //     $imageName = time() . '.png';

    //     // Enregistre l'image dans le répertoire public/images
    //     File::put(public_path('images') . '/' . $imageName, base64_decode($imageData));

    //     return response()->json(['success' => 'Photo uploaded successfully']);
    // }





}
