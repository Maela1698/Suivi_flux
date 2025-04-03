<?php

namespace App\Http\Controllers\QUALITECONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\QUALITEModel\QualiteRouleauTissu;
use App\Models\QUALITEModel\TestConformiteTissu;
use App\Models\WMSModel\QUALITEModel\CODIFICATIONACCESSOIRE_INSPECTIONACCESSOIRE;
use App\Models\WMSModel\QUALITEModel\DEFAUTFABRICINSPECTION;
use App\Models\WMSModel\QUALITEModel\INSPECTIONACCESSOIRE;
use App\Models\WMSModel\QUALITEModel\ListeQualiteRouleauFabricTissu;
use App\Models\WMSModel\QUALITEModel\QUALITEROULEAUTISSU_TESTDISCORGING;
use App\Models\WMSModel\QUALITEModel\QUALITEROULEAUTISSU_TESTNUANCE;
use App\Models\WMSModel\QUALITEModel\QUALITEROULEAUTISSU_TESTRETRACTION;
use App\Models\WMSModel\QUALITEModel\TESTDISCORGING;
use App\Models\WMSModel\QUALITEModel\TESTFABRICINSPECTION;
use App\Models\WMSModel\QUALITEModel\TESTNUANCE;
use App\Models\WMSModel\QUALITEModel\TESTRETRACTION;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QUALITEController extends Controller
{

    //!-------------------------------------------------Controller Tissu-------------------------------------------------!//
    function importRouleauQualiteTissu(Request $request)
    {

        // Valider le fichier
        $request->validate([
            'csvImport' => 'required|file|mimes:csv,txt',
        ]);

        // Chemin du fichier uploadé
        $filePath = $request->file('csvImport')->getRealPath();

        // Ouvrir le fichier CSV
        if (($handle = fopen($filePath, 'r')) !== false) {
            // Lire l'en-tête (première ligne)
            $header = fgetcsv($handle, 0, $this->detectDelimiter($filePath));

            // Vérifier les colonnes attendues
            $expectedColumns = ['reference', 'lot', 'laize', 'metrage', 'poids'];
            if ($header !== $expectedColumns) {
                return back()->withErrors('error', 'Les colonnes du fichier CSV sont incorrectes.');
            }

            // Lire les données ligne par ligne
            while (($data = fgetcsv($handle, 0, $this->detectDelimiter($filePath))) !== false) {
                // Mapper les colonnes avec les données
                $row = array_combine($header, $data);

                // Insérer dans la base
                QualiteRouleauTissu::create([
                    'reference' => $row['reference'],
                    'lot' => $row['lot'],
                    'laize' => $row['laize'],
                    'metrage' => $row['metrage'],
                    'poids' => $row['poids'],
                    'identreetissu' => $request->input('identreetissu'),
                ]);
            }

            fclose($handle);

            return back()->with('success', 'Données importées avec succès.');
        }

        return back()->withErrors('error', 'Impossible de lire le fichier.');
    }

    function detectDelimiter($filePath)
    {
        $delimiters = [",", ";"];
        $handle = fopen($filePath, 'r');
        $firstLine = fgets($handle);
        fclose($handle);

        foreach ($delimiters as $delimiter) {
            if (substr_count($firstLine, $delimiter) > 0) {
                return $delimiter;
            }
        }

        return ",";
    }
    public function testConformite(Request $request)
    {
        // TODO: Un simple ajout not duplicated
        $data = $request->except(['lab_dip', 'swatch']);
        $lab_dip = $request->file('lab_dip');
        $lab_dipfileContent = file_get_contents($lab_dip->getPathname());
        $data['lab_dip'] = base64_encode($lab_dipfileContent);
        $swatch = $request->file('swatch');
        $swatchfileContent = file_get_contents($swatch->getPathname());
        $data['swatch'] = base64_encode($swatchfileContent);
        $validationData = TestConformiteTissu::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            dd($errors);

            return redirect()->back()->withErrors($errors)->withInput($data);
        }
        try {
            DB::beginTransaction();
            $testConformite = TestConformiteTissu::where('identreetissu', $data['identreetissu'])->first();
            if (!$testConformite) {
                $testConformite = new TestConformiteTissu($data);
            } else {
                $testConformite->fill($data);
            }
            $res = $testConformite->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement du test, veuillez réessayer.' . $e;

            return back()->withInput($data)->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
    public function testFabricInspection(Request $request)
    {

        $data = $request->all();
        $validationData = TESTFABRICINSPECTION::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            dd($errors);
            return redirect()->back()->withErrors($errors)->withInput($data);
        }
        try {
            DB::beginTransaction();
            $testFabricInspection = TESTFABRICINSPECTION::where('identreetissu', $data['identreetissu'])->first();
            if (!$testFabricInspection) {
                $testFabricInspection = new TESTFABRICINSPECTION($data);
            } else {
                $testFabricInspection->fill($data);
            }
            $res = $testFabricInspection->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement du test, veuillez réessayer.' . $e;

            return back()->withInput($data)->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
    function listeRouleauFabricInspection(Request $request)
    {
        $data = $request->all();
        $validationData = ListeQualiteRouleauFabricTissu::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withErrors($errors)->withInput($data);
        }
        try {
            DB::beginTransaction();

            $listeRouleauFabricInspection = ListeQualiteRouleauFabricTissu::where('idqualiterouleautissu', $data['idqualiterouleautissu'])->first();
            if (!$listeRouleauFabricInspection) {
                $listeRouleauFabricInspection = new ListeQualiteRouleauFabricTissu($data);
            } else {
                $listeRouleauFabricInspection->fill($data);
            }
            $res = $listeRouleauFabricInspection->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement du test, veuillez réessayer.' . $e;

            return back()->withInput($data)->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
    public function testFabricInspectionDefaut(Request $request)
    {
        $data = $request->except('image');
        $image = $request->file('image');
        $imagefileContent = file_get_contents($image->getPathname());
        $data['image'] = base64_encode($imagefileContent);
        $validationData = DEFAUTFABRICINSPECTION::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            dd($errors);
            return redirect()->back()->withErrors($errors)->withInput($data);
        }
        try {
            DB::beginTransaction();

            $testFabricInspectionDefaut = new DEFAUTFABRICINSPECTION($data);

            $res = $testFabricInspectionDefaut->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement du test, veuillez réessayer.' . $e;

            return back()->withInput($data)->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
    public function testRetraction(Request $request)
    {

        $data = $request->all();
        $validationData = TESTRETRACTION::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            dd($errors);
            return redirect()->back()->withErrors($errors)->withInput($data);
        }
        try {
            DB::beginTransaction();
            $testRetraction = TESTRETRACTION::where('identreetissu', $data['identreetissu'])->first();
            if (!$testRetraction) {
                $testRetraction = new TESTRETRACTION($data);
            } else {
                $testRetraction->fill($data);
            }
            $res = $testRetraction->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement du test, veuillez réessayer.' . $e;

            return back()->withInput($data)->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
    public function testRetractionRouleau(Request $request)
    {

        $data = $request->all();
        $validationData = QUALITEROULEAUTISSU_TESTRETRACTION::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            dd($errors);
            return redirect()->back()->withErrors($errors)->withInput($data);
        }
        try {
            DB::beginTransaction();
            $testRetraction = QUALITEROULEAUTISSU_TESTRETRACTION::where('idqualiterouleautissu', $data['idqualiterouleautissu'])->first();
            if (!$testRetraction) {
                $testRetraction = new QUALITEROULEAUTISSU_TESTRETRACTION($data);
            } else {
                $testRetraction->fill($data);
            }
            $res = $testRetraction->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement du test, veuillez réessayer.' . $e;

            return back()->withInput($data)->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
    public function testNuance(Request $request)
    {
        $data = $request->all();
        $validationData = TESTNUANCE::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            dd($errors);
            return redirect()->back()->withErrors($errors)->withInput($data);
        }
        try {
            DB::beginTransaction();
            $testNuance = TESTNUANCE::where('identreetissu', $data['identreetissu'])->first();
            if (!$testNuance) {
                $testNuance = new TESTNUANCE($data);
            } else {
                $testNuance->fill($data);
            }
            $res = $testNuance->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement du test, veuillez réessayer.' . $e;

            return back()->withInput($data)->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
    public function testNuanceRouleau(Request $request)
    {
        $data = $request->except('image');
        $image = $request->file('image');
        $imagefileContent = file_get_contents($image->getPathname());
        $data['image'] = base64_encode($imagefileContent);
        $validationData = QUALITEROULEAUTISSU_TESTNUANCE::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            dd($errors);
            return redirect()->back()->withErrors($errors)->withInput($data);
        }
        try {
            DB::beginTransaction();
            $testNuance = QUALITEROULEAUTISSU_TESTNUANCE::where('idqualiterouleautissu', $data['idqualiterouleautissu'])->first();
            if (!$testNuance) {
                $testNuance = new QUALITEROULEAUTISSU_TESTNUANCE($data);
            } else {
                $testNuance->fill($data);
            }
            $res = $testNuance->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement du test, veuillez réessayer.' . $e;

            return back()->withInput($data)->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
    public function testDisgorging(Request $request)
    {
        $data = $request->all();
        $validationData = TESTDISCORGING::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            dd($errors);
            return redirect()->back()->withErrors($errors)->withInput($data);
        }
        try {
            DB::beginTransaction();
            $testDisgorging = TESTDISCORGING::where('identreetissu', $data['identreetissu'])->first();
            if (!$testDisgorging) {
                $testDisgorging = new TESTDISCORGING($data);
            } else {
                $testDisgorging->fill($data);
            }
            $res = $testDisgorging->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement du test, veuillez réessayer.' . $e;

            return back()->withInput($data)->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
    public function testDisgorgingRouleau(Request $request)
    {
        $data = $request->except('image');
        $image = $request->file('image');
        $imagefileContent = file_get_contents($image->getPathname());
        $data['image'] = base64_encode($imagefileContent);
        $validationData = QUALITEROULEAUTISSU_TESTDISCORGING::getValidationRules();
        $rules = $validationData['rules'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            dd($errors);
            return redirect()->back()->withErrors($errors)->withInput($data);
        }
        try {
            DB::beginTransaction();
            // $testDisgorging = QUALITEROULEAUTISSU_TESTDISCORGING::where('idqualiterouleautissu', $data['idqualiterouleautissu'])->first();
            // if (!$testDisgorging) {
            $testDisgorging = new QUALITEROULEAUTISSU_TESTDISCORGING($data);
            // } else {
            //     $testDisgorging->fill($data);
            // }
            $res = $testDisgorging->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement du test, veuillez réessayer.' . $e;

            return back()->withInput($data)->withErrors(['error' => $errorMessage]);
        }
        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
    //!-------------------------------------------------Controller Accessoire-------------------------------------------------!//
    public function inspectionAccessoire(Request $request)
    {
        $data = $request->except(['image', 'fields']);
        $image = $request->file('image');
        if (isset($image)) {
            $imagefileContent = file_get_contents($image->getPathname());
            $data['image'] = base64_encode($imagefileContent);
        }
        $fields = $request->input('fields', []);

        try {
            DB::beginTransaction();

            // Handle INSPECTIONACCESSOIRE creation or update
            $inspectionAccessoire = INSPECTIONACCESSOIRE::where('identreewms', $data['identreewms'])->first();
            if (!$inspectionAccessoire) {
                $inspectionAccessoire = new INSPECTIONACCESSOIRE($data);
            } else {
                $inspectionAccessoire->fill($data);
            }

            $res = $inspectionAccessoire->save();
            $idinspectionaccessoire = $inspectionAccessoire->id;

            // Handle CODIFICATIONACCESSOIRE_INSPECTIONACCESSOIRE creation or update
            foreach ($fields as $field) {
                $idcodificationaccessoire = $field['idcodificationaccessoire'] ?? null;
                $defectquantity = $field['defectquantity'] ?? null;
                $remarque = $field['remarque'] ?? null;

                // Skip processing if defectquantity is null
                if (!$idcodificationaccessoire || $defectquantity === null) {
                    continue;
                }


                // Check if the record exists
                $cai = CODIFICATIONACCESSOIRE_INSPECTIONACCESSOIRE::where('idinspectionaccessoire', $idinspectionaccessoire)
                    ->where('idcodificationaccessoire', $idcodificationaccessoire)
                    ->first();

                if (!$cai) {
                    // Create a new record if it doesn't exist
                    $cai = new CODIFICATIONACCESSOIRE_INSPECTIONACCESSOIRE();
                    $cai->idcodificationaccessoire = $idcodificationaccessoire;
                    $cai->idinspectionaccessoire = $idinspectionaccessoire;
                }

                // Update fields
                $cai->defectquantity = $defectquantity;
                $cai->remarque = $remarque;
                $cai->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $errorMessage = 'Une anomalie est survenue lors du processus d\'enregistrement du test, veuillez réessayer. ' . $e->getMessage();
            return back()->withInput($data)->withErrors(['error' => $errorMessage]);
        }

        $message = $res ? 'La procédure d\'enregistrement s\'est déroulée avec succès.' : 'Une erreur est survenue, empêchant l\'enregistrement des données.';
        $status = $res ? 'success' : 'error';

        return back()->with($status, $message);
    }
}
