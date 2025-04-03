<?php

namespace App\Http\Controllers\QUALITETISSUCONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\CategorieTissus;
use App\Models\ClasseMatierePremiere;
use App\Models\FamilleTissus;
use App\Models\QUALITETISSU\Disgorging;
use App\Models\QUALITETISSU\DisgorgingLot;
use App\Models\QUALITETISSU\ElongationRouleau;
use App\Models\QUALITETISSU\Qualiterouleautissu;
use App\Models\QUALITETISSU\ShadeTest;
use App\Models\QUALITETISSU\ShadeTestRouleau;
use App\Models\QUALITETISSU\TestConformite;
use App\Models\QUALITETISSU\TestElongation;
use App\Models\Tiers;
use App\Models\WMSModel\UtilisationWMS;
use App\Models\WMSModel\V_Entree_Tissu;
use App\Services\ServicesConstat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ListeInspecterController extends Controller
{
    public function listeEntreeTissuInspecter()
    {
        $familleTissu = FamilleTissus::where('etat', 0)->get();
        $historyEntree = V_Entree_Tissu::where('qterecu', '>=', 0)->orderBy('dateentree', 'desc')
            ->paginate(100);
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        return view('QUALITETISSU.listeTissuInspecter', compact('historyEntree', 'familleTissu', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur'));
    }

    public function inspectionTissu(Request $request)
    {
        $idEntreeTissu = $request->input('identreetissu');
        $entree = V_Entree_Tissu::listeEntreeTissuById($idEntreeTissu);
        $qualiteRouleau = Qualiterouleautissu::getQualiteRouleauTissuByEntreeTissu($idEntreeTissu);
        $lot = Qualiterouleautissu::listeLotRouleau($idEntreeTissu);
        $nbQualite = Qualiterouleautissu::nbQualiteRouleau($idEntreeTissu);
        if ($nbQualite != 0) {
            // conformite
            $nbConformite = TestConformite::nbTestConformite($idEntreeTissu);
            if ($nbConformite == 0) {
                $conformite = new TestConformite();
                $conformite->insertTestConformite($idEntreeTissu,  "", "");
            }

            // elongation
            $nbElongation = TestElongation::nbTestElongation($idEntreeTissu);
            if ($nbElongation == 0) {
                $elongation = new TestElongation();
                $elongation->insertTestElongation($idEntreeTissu);

                for ($t = 0; $t < count($qualiteRouleau); $t++) {
                    $testElongation = new ElongationRouleau();
                    $testElongation->insertElongationRouleau($qualiteRouleau[$t]->id);
                }
            }

            // shade
            $nbShade = ShadeTest::nbShadeTest($idEntreeTissu);
            if ($nbShade == 0) {
                $shade = new ShadeTest();
                $shade->insertShadeTest($idEntreeTissu);

                for ($s = 0; $s < count($qualiteRouleau); $s++) {
                    $shadeR = new ShadeTestRouleau();
                    $shadeR->insertShadeTestRouleau($qualiteRouleau[$s]->id);
                }
            }

            // disgorging
            $nbDisgorging = Disgorging::nbDisgorging($idEntreeTissu);
            if ($nbDisgorging == 0) {
                $disgorging = new Disgorging();
                $disgorging->insertDisgorging($idEntreeTissu);

                for ($d = 0; $d < count($lot); $d++) {
                    $disgorgingLot = new DisgorgingLot();
                    $disgorgingLot->insertDisgorgingLot($idEntreeTissu, $lot[$d]->lot);
                }
            }
            $employe = Qualiterouleautissu::listeEmployeQualiteMagasin();
            $lavage = Qualiterouleautissu::listeLavage();
            $conformite = TestConformite::listeTestConformite($idEntreeTissu);
            $elongation = TestElongation::listeTestElongation($idEntreeTissu);
            $elongationRouleau = ElongationRouleau::listeElongationRouleau($idEntreeTissu);
            $shade = ShadeTest::listeShadeTest($idEntreeTissu);
            $shadeRouleau = ShadeTestRouleau::listeShadeTestRouleau($idEntreeTissu);
            $disgorging = Disgorging::listeDisgorging($idEntreeTissu);
            $disgorgingLot = DisgorgingLot::listeDisgorgingLot($idEntreeTissu);
            return view('QUALITETISSU.inspectionTissu', compact('entree','disgorgingLot', 'disgorging', 'shadeRouleau', 'shade', 'elongationRouleau', 'elongation', 'conformite', 'idEntreeTissu', 'lot', 'qualiteRouleau', 'lavage', 'employe'));
        } else {
            $erreur ="Vous n'avez pas encore importer la liste des rouleaux sur cette entrée";
            return redirect()->route('QUALITETISSU.listeEntreeTissuInspecter')->with('error', $erreur);
        }
    }

    public function ajoutInspectionQualite(Request $request)
    {

        $idEntreeTissu = $request->input('idEntreeTissu');
        // conformite
        $dateconformite = $request->input('dateconformite');
        $request->validate([
            'imagelaps' => 'image|mimes:jpeg,png,jpg,gif|max:10000',
        ]);
        $imageConformite = "";
        if ($request->hasFile('imagelaps')) {
            $s = new ServicesConstat;
            $file = $request->file('imagelaps');
            $imageConformite = $s->uploadImage("uploads/conformite", $file);
        }
        $passed = $request->input('passedConformite');

        TestConformite::updateConformite($imageConformite, $passed, $dateconformite, $idEntreeTissu);

        // test elongation
        $dateElongation = $request->input('dateElongation');
        $datePreparation = $request->input('datePreparation');
        $dateEvaluation = $request->input('dateEvaluation');
        $inspecteur = $request->input('inspecteur');
        $lavage = $request->input('lavage');
        $tempsRelaxation = $request->input('tempsRelaxation');
        $passedElongation = $request->input('passedElongation');
        $observationElongation = $request->input('observationElongation');
        $idqualiterouleautissu = $request->input('idqualiterouleautissuElongation');
        $elongationLongueur = $request->input('elongationLongueur');
        $elongationLaize = $request->input('elongationLaize');
        $longueurretrait = $request->input('longueurretrait');
        $laizeretrait = $request->input('laizeretrait');
        $ecartAngulaire = $request->input('ecartAngulaire');
        TestElongation::updateTestElongation($idEntreeTissu, $dateElongation, $datePreparation, $dateEvaluation, $inspecteur, $lavage, $tempsRelaxation, $observationElongation, $passedElongation);

        for ($e = 0; $e < count($idqualiterouleautissu); $e++) {
            ElongationRouleau::updateElongationRouleau($idqualiterouleautissu[$e], $elongationLongueur[$e], $elongationLaize[$e], $longueurretrait[$e], $laizeretrait[$e], $ecartAngulaire[$e]);
        }

        // shade test
        $dateShadeTest = $request->input('dateShadeTest');
        $dateExecution = $request->input('dateExecution');
        $endroit = $request->input('endroit');
        $passedShade = $request->input('passedShade');
        $nuanceShade = $request->input('nuanceShade');
        $observationShade = $request->input('observationShade');
        $idqualiterouleautissuShade = $request->input('idqualiterouleautissuShade');
        // Validation des fichiers
        foreach ($idqualiterouleautissuShade as $id) {
            $request->validate([
                "imageShade.*" => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
            ]);
        }
        ShadeTest::updateShadeTest($idEntreeTissu, $dateShadeTest, $dateExecution, $endroit, $passedShade, $nuanceShade, $observationShade);
        $imagePaths = [];
        $imageShades = $request->file('imageShade');
        for ($u = 0; $u < count($idqualiterouleautissuShade); $u++) {
            if (isset($imageShades[$u])) {
                $s = new ServicesConstat();
                $imagePaths[$u] = $s->uploadImage("uploads/shade", $imageShades[$u]);
            } else {
                $imagePaths[$u] = null;
            }
        }
        for ($sh = 0; $sh < count($idqualiterouleautissuShade); $sh++) {
            ShadeTestRouleau::updateShadeTestRouleau($idqualiterouleautissuShade[$sh], $imagePaths[$sh]);
        }

        // disgorging
        $dateDisgoring = $request->input('dateDisgoring');
        $datePreparationDis = $request->input('datePreparationDisgoring');
        $dateEvaluationDis = $request->input('dateEvaluationDisgoring');
        $passedDisgoring = $request->input('passedDisgoring');
        Disgorging::updateDisgorging($idEntreeTissu, $dateDisgoring, $datePreparationDis, $dateEvaluationDis, $passedDisgoring);

        $lot = $request->input('lot', []);
        $imageDisgorging = $request->file('imageDisgorging', []);
        $typefrottement = $request->input('typefrottement', []);
        // dd($typefrottement);
        $echellegris = $request->input('echellegris', []);
        $duree = $request->input('duree', []);
        $validationtest = $request->input('validationtest', []);
        $remarque = $request->input('remarque', []);
        $imagePathDisgorging = [];
        for ($d = 0; $d < count($lot); $d++) {
            $imagePathDisgorging[$d] = isset($imageDisgorging[$d])
                ? (new ServicesConstat())->uploadImage("uploads/disgorging", $imageDisgorging[$d])
                : null;
        }

        for ($dl = 0; $dl < count($lot); $dl++) {
            DisgorgingLot::updateDisgorgingLot(
                $idEntreeTissu,
                $lot[$dl],
                $imagePathDisgorging[$dl] ?? null,
                $typefrottement[$dl],
                $echellegris[$dl],
                $duree[$dl],
                $validationtest[$dl],
                $remarque[$dl]
            );
        }

        return redirect()->route('QUALITETISSU.inspectionTissu', ['identreetissu' => $idEntreeTissu]);
    }
}
