<?php

namespace App\Http\Controllers;

use App\Models\ConsoAccessoire;
use App\Models\DemandeClient;
use App\Models\FicheCoupe;
use App\Models\V_accessoire;
use App\Models\V_tissus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ControllerFCTO extends Controller
{
    public function ficheCoupe(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $fiche = FicheCoupe::getFicheCoupeByDC($idDC);
        return view('CRM.FCTO.ficheCoupe', compact('demande', 'fiche'));
    }

    public function ajoutFicheCoupe(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $idTissu = $request->input('tissu');
        $tissu = V_tissus::getAllV_tissuById($idTissu);
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $tailleDemande = DemandeClient::getTailleByIdDemande($idDC);
        return view('CRM.FCTO.fcto', compact('tissu', 'demande', 'tailleDemande'));
    }

    public function trimCard(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $tissu = V_tissus::getAllV_tissu($idDC);
        $accessoire = V_accessoire::getAllV_accessoireByDC($idDC);
        return view('CRM.FCTO.trimCard', compact('tissu', 'accessoire', 'demande'));
    }


    public function ordreFabrication(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $demande = DemandeClient::getAllListeDemandeById($idDC);
        $tailleDemande = DemandeClient::getTailleByIdDemande($idDC);
        $tissu = V_tissus::getAllV_tissu($idDC);
        $accessoire = V_accessoire::getAllV_accessoireByDC($idDC);
        $idDistinct = ConsoAccessoire::getIdConsoAccyDistinct();
        $idPareil = ConsoAccessoire::getIdConsoAccyPareil();
        $accessoirePareil =[];
        for ($i = 0; $i < count($idPareil); $i++) {
            $accessoirePareil[] = V_accessoire::getAllV_accessoireById($idPareil[$i]->id_accessoire)->first();
        }


        // for($j=0; $j<count($idDistinct); $j++){
        //     $consoAccy[] = ConsoAccessoire::getAllConsoAccyById($idDistinct[$j]->id_accessoire)->first();

        // }
        $consoAccy= ConsoAccessoire::getAllConsoAccyById(2);

        return view('CRM.FCTO.ordreFabrication', compact('accessoirePareil','consoAccy', 'demande', 'tailleDemande', 'tissu', 'accessoire', 'idDistinct'));
    }

    public function afficherConsoAccessoires()
{
    // Récupérer toutes les données de la table consoaccessoire
    $consoAccessoires = DB::table('consoaccessoire')->get();

    // Retourner les données à la vue
    return view('CRM.FCTO.index', compact('consoAccessoires'));
}


    // public function exportCSV()
    // {
    //     // Récupérer les données de la première feuille de la base de données PostgreSQL
    //     $data1 = DB::table('v_accessoire')->get();

    //     // Récupérer les données de la deuxième feuille de la base de données PostgreSQL (par exemple, une autre table)
    //     $data2 = DB::table('v_tissus')->get();

    //     // Convertir les données de la première feuille en CSV
    //     $csv = '';
    //     $columns1 = ['id', 'id_accessoire', 'conso_accessoire', 'id_demande_client', 'etat'];
    //     $csv .= implode(',', $columns1) . "\n";

    //     foreach ($data1 as $row) {
    //         $csv .= $row->id . ',' . $row->id . ',' . $row->conso_accessoire . ',' . $row->id_demande_client . ',' . $row->etat . "\n";
    //     }

    //     // Ajouter une ligne vide pour séparer les deux sections dans le fichier CSV
    //     $csv .= "\n";

    //     // Convertir les données de la deuxième feuille en CSV
    //     $columns2 = ['id', 'couleur', 'photo'];
    //     $csv .= implode(',', $columns2) . "\n";

    //     foreach ($data2 as $row) {
    //         $csv .= $row->id . ',' . $row->couleur . ',' . $row->photo . "\n";
    //     }

    //     // Retourner le CSV en réponse avec le bon type MIME
    //     return response($csv, 200, [
    //         'Content-Type' => 'text/csv',
    //         'Content-Disposition' => 'attachment; filename="export.csv"',
    //     ]);
    // }

    public function exportCSV(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $spreadsheet = new Spreadsheet();


        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('DemandeClient');


        $sheet1->setCellValue('A1', 'Saison')
            ->setCellValue('B1', 'Client')
            ->setCellValue('C1', 'Modele')
            ->setCellValue('D1', 'Image');

        $data1 = DemandeClient::getAllListeDemandeById($idDC);
        $rowNum = 2;
        foreach ($data1 as $row) {
            $sheet1->setCellValue('A' . $rowNum, $row->type_saison)
                ->setCellValue('B' . $rowNum, $row->nomtier)
                ->setCellValue('C' . $rowNum, $row->nom_modele)
                ->setCellValue('D' . $rowNum, $row->photo_commande);
            $rowNum++;
        }


        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('DetailTaille');

        $sheet2->setCellValue('A1', 'Taille')
            ->setCellValue('B1', 'Quantite');

        $data2 = DemandeClient::getTailleByIdDemande($idDC);
        $rowNum = 2;
        foreach ($data2 as $row) {
            $sheet2->setCellValue('A' . $rowNum, $row->unite_taille)
                ->setCellValue('B' . $rowNum, $row->quantite);
            $rowNum++;
        }

        $data3 = V_tissus::getAllV_tissu($idDC);
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Tissu');
        $sheet2->setCellValue('A1', 'Designation')
            ->setCellValue('B1', 'TypeTissu')
            ->setCellValue('C1', 'Conso cotation')
            ->setCellValue('D1', 'Conso commandee')
            ->setCellValue('E1', 'Laize commandee')
            ->setCellValue('F1', 'Qte commandee')
            ->setCellValue('G1', 'Qte recue')
            ->setCellValue('H1', 'Laize moy recue');
        for ($i = 0; $i < count($data3); $i++) {
            $sheet2->setCellValue('A' . $i + 2, $data3[$i]->designation . '/' . $data3[$i]->reference . '/' . $data3[$i]->couleur . '/' . $data3[$i]->grammage . 'g/' . $data3[$i]->laize_utile . 'm')
                ->setCellValue('B' . $i + 2, $data3[$i]->type_tissus)
                ->setCellValue('C' . $i + 2,  $data3[$i]->quantite)
                ->setCellValue('D' . $i + 2, '0')
                ->setCellValue('E' . $i + 2, '0')
                ->setCellValue('F' . $i + 2, '0')
                ->setCellValue('G' . $i + 2, '0')
                ->setCellValue('H' . $i + 2, '0')
            ;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'FICHE_DE_COUPE_' . $data1[0]->nom_modele . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        $writer->save('php://output');
    }

    public function insertFicheCoupe(Request $request)
    {
        $idDC = $request->session()->get('idDemande');
        $nomFichier = $request->input('nomFichier');
        $pdfPath = "";
        $uploadedPDF = $request->file('fichierCoupeDemande');
        $originalFileName ="";
        if(empty($nomFichier)){
            $file = $request->file('fichierCoupeDemande');
            $originalFileName = $file->getClientOriginalName();
        }else{
            $originalFileName=$nomFichier;
        }
        $pdfPath = base64_encode(file_get_contents($uploadedPDF->getRealPath()));
        $ficheCoupe = new FicheCoupe();
        $ficheCoupe->insertFicheCoupe($originalFileName, $pdfPath, $idDC);
        return redirect()->route('CRM.ficheCoupe');
    }

    public function openExcel($id)
    {
        // Récupérer le fichier depuis la base de données
        $fileRecord = FicheCoupe::getFicheCoupeById($id);
        $decodedFile = base64_decode($fileRecord[0]->fichier);

        return response($decodedFile)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'inline; filename="' . $fileRecord[0]->nomfichier . '"');
    }
}
