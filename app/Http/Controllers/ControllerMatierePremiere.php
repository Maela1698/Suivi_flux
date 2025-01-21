<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Accessoire;
use App\Models\CategorieTissus;
use App\Models\ClasseMatierePremiere;
use App\Models\CompositionTissus;
use App\Models\ConsoTissus;
use App\Models\DemandeClient;
use App\Models\FamilleAccessoire;
use App\Models\FamilleTissus;
use App\Models\TestImage;
use App\Models\Tissus;
use App\Models\TypeAccessoire;
use App\Models\TypeTissus;
use App\Models\UniteMesureMatierePremiere;
use App\Models\UniteMonetaire;
use App\Models\V_accessoire;
use App\Models\V_tissus;
use Illuminate\Http\Request;

class ControllerMatierePremiere extends Controller
{
    public function formAjouTissu(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $categorieTissu = CategorieTissus::getAllCategorieTissu();
        $classeMP = ClasseMatierePremiere::getAllClasseMP();
        $uniteMesureMP = UniteMesureMatierePremiere::getAllUniteMesureMP();
        $uniteMonetaire = UniteMonetaire::getAllUniteMonetaire();
        $familleTissu = FamilleTissus::getAllFamilleTissu();
        $typeTissu = TypeTissus::getAllTypeTissu();
        $composition = CompositionTissus::getAllCompositionTissu();
        return view('CRM.matierePremiere.ajoutTissu', compact('demande','idDC', 'categorieTissu', 'classeMP', 'uniteMesureMP', 'uniteMonetaire', 'familleTissu', 'typeTissu', 'composition'));
    }

    public function ajoutTissu(Request $request)
    {
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageBase64 = "";
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
        }

        $request->validate([
            'fiche_technique' => 'mimes:pdf|max:10000',
        ]);

        $pdfPath = "";
        if ($request->hasFile('fiche_technique')) {
            $uploadedPDF = $request->file('fiche_technique');
            $pdfPath = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
        }


        $data = $request->except(['photo', 'fiche_technique']);
        $typeTissu = $request->input('id_type_tissus');
        $demandeDC = $request->session()->get('idDemande');

        $tissu = new Tissus();
        $isExiste = Tissus::isExisteTissu($typeTissu, $demandeDC);
        if ($isExiste == 0) {
            $tissu->insertTissus($data, $imageBase64, $pdfPath, 0, $demandeDC);
            $last = Tissus::lastInsertTissusByDC($demandeDC);
            $conso = new ConsoTissus();
            $conso->insertConsoTissu($last, 0, 0,$demandeDC);
            return redirect()->route('CRM.listeMatierePremiere')
                ->with('id_demande_client', $demandeDC);
        } else {
            return redirect()->route('CRM.formAjouTissu')
                ->with('error', 'Ce type de tissu existe déjà.');
        }
    }

    public function listeMatierePremiere(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $listeTissu = V_tissus::getAllV_tissu($idDC);
        $listeAcc = V_accessoire::getAllV_accessoireByDC($idDC);
        return view('CRM.matierePremiere.listeMatierePremiere', compact('listeTissu', 'listeAcc', 'idDC', 'demande'));
    }

    public function detailTissu(Request $request)
    {
        $id = $request->input('idTissus') ?? session('idTissus');
        $listeTissu = V_tissus::getAllV_tissuById($id);
        return view('CRM.matierePremiere.detailTissu', compact('listeTissu'));
    }

    public function rechercheTypeTissu(Request $request)
    {
        $query = $request->get('typeTissu');
        $countries = TypeTissus::where('type_tissus', 'ILIKE', '%' . $query . '%')->get();
        return response()->json($countries);
    }

    public function rechercheComposition(Request $request)
    {
        $query = $request->get('composition');
        $countries = CompositionTissus::where('composition_tissus', 'ILIKE', '%' . $query . '%')->get();
        return response()->json($countries);
    }

    public function rechercheFamilleTissu(Request $request)
    {
        $query = $request->get('familleTissu');
        $countries = FamilleTissus::where('famille_tissus', 'ILIKE', '%' . $query . '%')->get();
        return response()->json($countries);
    }

    public function formAjoutAccessoire(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $classeMP = ClasseMatierePremiere::getAllClasseMP();
        $uniteMesureMP = UniteMesureMatierePremiere::getAllUniteMesureMP();
        $uniteMonetaire = UniteMonetaire::getAllUniteMonetaire();
        return view('CRM.matierePremiere.ajoutAccessoire', compact('demande','idDC', 'classeMP', 'uniteMesureMP', 'uniteMonetaire'));
    }


    public function ajoutAccessoire(Request $request)
    {
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageBase64 = "";
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
        }

        $request->validate([
            'fiche_technique' => 'mimes:pdf|max:18360',
        ]);
        $pdfPath = "";
        if ($request->hasFile('fiche_technique')) {
            $uploadedPDF = $request->file('fiche_technique');
            $pdfPath = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
        }


        $data = $request->except(['photo', 'fiche_technique']);
        $typeAcc = $request->input('id_type_accessoire');
        $demandeDC = $request->session()->get('idDemande');

        $accessoire = new Accessoire();
        $isExiste = Accessoire::isExisteAccessoire($typeAcc, $demandeDC);
        if ($isExiste == 0) {
            $accessoire->insertAccessoire($data, $imageBase64, $pdfPath, 0, $demandeDC);
            return redirect()->route('CRM.listeMatierePremiere')
                ->with('id_demande_client', $demandeDC);
        } else {
            return redirect()->route('CRM.formAjoutAccessoire')
                ->with('error', 'Ce type d\'accessoire existe déjà.');
        }
    }

    public function detailAccessoire(Request $request)
    {
        $id = $request->input('idAcc') ?? session('idAcc');
        $listeAcc = V_accessoire::getAllV_accessoireById($id);
        return view('CRM.matierePremiere.detailAccesoire', compact('listeAcc'));
    }

    public function rechercheFamilleAccessoire(Request $request)
    {
        $query = $request->get('familleAcc');
        $countries = FamilleAccessoire::where('famille_accessoire', 'ILIKE', '%' . $query . '%')->get();
        return response()->json($countries);
    }

    public function rechercheTypeAccessoire(Request $request)
    {
        $query = $request->get('typeAcc');
        $countries = TypeAccessoire::where('type_accessoire', 'ILIKE', '%' . $query . '%')->get();
        return response()->json($countries);
    }

    public function formAjoutImages()
    {

        return view('CRM.matierePremiere.ajoutImage');
    }

    public function formModifTissu(Request $request)
    {
        $categorieTissu = CategorieTissus::getAllCategorieTissu();
        $idTissu = $request->input('idTissu');
        $tissu = V_tissus::getAllV_tissuById($idTissu);


        $classeMP = ClasseMatierePremiere::getAllClasseMP();
        $uniteMesureMP = UniteMesureMatierePremiere::getAllUniteMesureMP();
        $uniteMonetaire = UniteMonetaire::getAllUniteMonetaire();
        return view('CRM.matierePremiere.modifTissu', compact('classeMP', 'categorieTissu', 'uniteMesureMP', 'uniteMonetaire', 'tissu'));
    }

    public function modifTissu(Request $request)
    {
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageBase64 = "";
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
        }else{
            $imageBase64= $request->input('photoRecent');
        }

        $request->validate([
            'fiche_technique' => 'mimes:pdf|max:10000',
        ]);

        $pdfPath = "";
        if ($request->hasFile('fiche_technique')) {
            $uploadedPDF = $request->file('fiche_technique');
            $pdfPath = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
        }else{
            $pdfPath = $request->input('ficheRecent');
        }


        $data = $request->except(['photo', 'fiche_technique']);
        $typeTissu = $request->input('id_type_tissus');
        $demandeDC = $request->session()->get('idDemande');

        $tissu = new Tissus();
        $tissu->updateTissus($data, $imageBase64, $pdfPath, 0, $demandeDC);

        return redirect()->route('CRM.detailTissu')
            ->with('idTissus', $request->input('id'));
    }

    public function formModifAccessoire(Request $request)
    {
        $idAccessoire = $request->input('idAccessoire');
        $accessoire = V_accessoire::getAllV_accessoireById($idAccessoire);
        $classeMP = ClasseMatierePremiere::getAllClasseMP();
        $uniteMesureMP = UniteMesureMatierePremiere::getAllUniteMesureMP();
        $uniteMonetaire = UniteMonetaire::getAllUniteMonetaire();
        return view('CRM.matierePremiere.modifAccessoire', compact('accessoire', 'classeMP', 'uniteMesureMP', 'uniteMonetaire'));
    }

    public function modifAccessoire(Request $request)
    {
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageBase64 = "";
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $imageBase64 = base64_encode(file_get_contents($photo->getRealPath()));
        }else{
            $imageBase64= $request->input('photoRecent');
        }

        $request->validate([
            'fiche_technique' => 'mimes:pdf|max:18360',
        ]);
        $pdfPath = "";
        if ($request->hasFile('fiche_technique')) {
            $uploadedPDF = $request->file('fiche_technique');
            $pdfPath = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
        }else{
            $pdfPath = $request->input('ficheRecent');
        }

        $data = $request->except(['photo', 'fiche_technique']);
        $typeAcc = $request->input('id_type_accessoire');
        $demandeDC = $request->session()->get('idDemande');

        $accessoire = new Accessoire();

        $accessoire->updateAccessoire($data, $imageBase64, $pdfPath, 0, $demandeDC);
        return redirect()->route('CRM.detailAccessoire')
            ->with('idAcc', $request->input('id'));
    }

    public function deleteTissu(Request $request)
    {
        $idTissu = $request->input('id_tissus');
        $tissu = new Tissus();
        $tissu->deleteTissu($idTissu);
        return redirect()->route('CRM.listeMatierePremiere');
    }

    public function deleteAccessoire(Request $request)
    {
        $idAcc = $request->input('idAccy');
        $accessoire = new Accessoire();
        $accessoire->deleteAccessoire($idAcc);
        return redirect()->route('CRM.listeMatierePremiere');
    }
}
