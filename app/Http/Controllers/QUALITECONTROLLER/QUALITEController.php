<?php

namespace App\Http\Controllers\QUALITECONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\QUALITEModel\TestConformiteTissu;
use App\Models\WMSMODEL\QUALITEModel\CODIFICATIONACCESSOIRE_INSPECTIONACCESSOIRE;
use App\Models\WMSMODEL\QUALITEModel\DEFAUTFABRICINSPECTION;
use App\Models\WMSMODEL\QUALITEModel\INSPECTIONACCESSOIRE;
use App\Models\WMSMODEL\QUALITEModel\QUALITEROULEAUTISSU_TESTDISCORGING;
use App\Models\WMSMODEL\QUALITEModel\QUALITEROULEAUTISSU_TESTNUANCE;
use App\Models\WMSMODEL\QUALITEModel\QUALITEROULEAUTISSU_TESTRETRACTION;
use App\Models\WMSMODEL\QUALITEModel\TESTDISCORGING;
use App\Models\WMSMODEL\QUALITEModel\TESTFABRICINSPECTION;
use App\Models\WMSMODEL\QUALITEModel\TESTNUANCE;
use App\Models\WMSMODEL\QUALITEModel\TESTRETRACTION;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QUALITEController extends Controller
{

    //!-------------------------------------------------Controller Tissu-------------------------------------------------!//
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
            $testConformite = new TestConformiteTissu($data);
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
            $testDisgorging = QUALITEROULEAUTISSU_TESTDISCORGING::where('idqualiterouleautissu', $data['idqualiterouleautissu'])->first();
            if (!$testDisgorging) {
                $testDisgorging = new QUALITEROULEAUTISSU_TESTDISCORGING($data);
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
