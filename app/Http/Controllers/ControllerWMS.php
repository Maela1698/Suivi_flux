<?php

namespace App\Http\Controllers;

use App\Http\Controllers\WMSCONTROLLER\TissuController;
use App\Models\BonCommande;
use App\Models\CategorieTissus;
use App\Models\ClasseMatierePremiere;
use App\Models\FamilleTissus;
use App\Models\Tiers;
use App\Models\UniteMesureMatierePremiere;
use App\Models\UniteMonetaire;
use App\Models\V_donne_bc;
use App\Models\WMSModel\Cellule;
use App\Models\WMSModel\EntreeTissu;
use App\Models\WMSModel\Parite;
use App\Models\WMSModel\Rack;
use App\Models\WMSModel\SectionWMS;
use App\Models\WMSModel\StockTissu;
use App\Models\WMSModel\StockTissu_Tiers_Modele;
use App\Models\WMSModel\UtilisationWMS;
use App\Models\WMSModel\V_Entree_Tissu;
use App\Models\WMSModel\V_PRIX_TOTAL_TISSU_FAMILLE_ENTREE;
use App\Models\WMSModel\V_PRIX_TOTAL_TISSU_FAMILLE_SORTIE;
use App\Models\WMSModel\V_PRIX_TOTAL_TISSU_FAMILLE_STOCK;
use App\Models\WMSModel\V_Rack_Cellule;
use App\Models\WMSModel\V_Reservation_tissu;
use App\Models\WMSModel\V_Retour_Tissu;
use App\Models\WMSModel\V_Sortie_Tissu;
use App\Models\WMSModel\V_Stock_Tissu;
use App\Models\WMSModel\V_Total_Entree_Tissu;
use App\Models\WMSModel\V_Total_Metrage_Tissu_Famille_Entree;
use App\Models\WMSModel\V_TOTAL_METRAGE_TISSU_FAMILLE_SORTIE;
use App\Models\WMSModel\V_TOTAL_METRAGE_TISSU_FAMILLE_STOCK;
use App\Models\WMSModel\V_TOTAL_SORTIE_TISSU;
use App\Models\WMSModel\V_TOTAL_STOCK_TISSU;
use App\Models\WMSModel\WMS\V_PRIX_TOTAL_TISSU_OBSOLETE_STOCK;
use App\Models\WMSModel\WMS\V_TOTAL_METRAGE_TISSU_OBSOLETE_STOCK;
use App\Models\WMSModel\WMS\V_TOTAL_STOCK_TISSU_OBSOLETE;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ControllerWMS extends BaseController
{
    //?------------------------------ Lien Page ------------------------------?//
    public function wms_page_accueil()
    {
        return view('WMS.page.accueilWMS');
    }

    public function wms_page_parite()
    {
        $parite = Parite::where('etat', 0)->orderBy('dateparite', 'DESC')->paginate(5);

        return view('WMS.page.parite', compact('parite'));
    }

    public function wms_page_section()
    {
        $section = SectionWMS::where('etat', 0)->get();

        return view('WMS.page.section', compact('section'));
    }

    public function wms_page_rack()
    {
        $catTissu = CategorieTissus::where('etat', 0)->get();
        $section = SectionWMS::where('etat', 0)->get();
        $rack = Rack::where('etat', 0)->get();

        return view('WMS.page.rack', compact('section', 'catTissu', 'rack'));
    }

    public function wms_page_cellule($idrack)
    {
        $rack = Rack::where('id', $idrack)->first();
        $cellule = Cellule::where('idrack', $idrack)->where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();

        return view('WMS.page.cellule', compact('rack', 'cellule', 'classeMatiere'));
    }

    public function wms_page_utilisation()
    {
        return view('WMS.page.utilisation');
    }

    public function wms_page_magasin_tissu(Request $request)
    {
        $donnes = V_donne_bc::query()
            ->where('etat', 10)
            ->where('type_bc', 'Tissu')
            ->where('idtypebc', '!=', 3)
            ->orderBy('id_donne_bc', 'desc');

        $columns = ['type_bc', 'type_saison', 'nom_modele', 'client', 'fournisseur', 'des_tissus', 'ref_tissus', 'des_accessoire', 'ref_accessoire'];

        if ($request->search) {
            $searchTerm = $request->input('search');
            $donnes->where(function ($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }
        if ($request->startDeadline && $request->endDeadline) {
            $donnes->when($donnes->first()->deadline == 0, function ($query) use ($request) {
                // Si 'deadline' est égale à 0, on utilise 'echeance'
                return $query->whereBetween('echeance', [$request->startDeadline, $request->endDeadline]);
            }, function ($query) use ($request) {
                // Sinon, on utilise 'deadline'
                return $query->whereBetween('deadline', [$request->startDeadline, $request->endDeadline]);
            });
        }
        if ($request->startEmmission && $request->endEmmission) {
            $donnes->whereBetween('date_bc', [$request->startEmmission, $request->endEmmission]);
        }

        if ($request->idetatbc) {
            // Si idetatbc == 1, on ajoute la condition sur 'datearrive' et 'deadline'
            if ($request->input('idetatbc') == 1) {
                $donnes->where(function ($query) {
                    $query->where(function ($subQuery) {
                        $subQuery->whereNull('datearrive')  // Vérifie si datearrive est NULL
                            ->where('echeance', '>=', now()); // Comparaison avec la date actuelle
                    })->orWhere(function ($subQuery) {
                        $subQuery->whereNotNull('datearrive') // Vérifie si datearrive n'est pas NULL
                            ->where('datearrive', '>=', now()); // Comparaison avec la date actuelle
                    });
                });
            }

            if ($request->input('idetatbc') == 2) {
                $donnes->where(function ($query) {
                    $query->where('reste', '>', 0)
                        ->where('magasin_quantite', '>', 0);
                });
            }

            if ($request->input('idetatbc') == 3) {
                $donnes->where(function ($query) {
                    $query->where('reste', '=', 0);
                });
            }

            if ($request->input('idetatbc') == 4) {
                $donnes->where(function ($query) {
                    $query->where(function ($subQuery) {
                        $subQuery->whereNull('datearrive')  // Vérifie si datearrive est NULL
                            ->where('echeance', '<', now()); // Comparaison avec la date actuelle
                    })->orWhere(function ($subQuery) {
                        $subQuery->whereNotNull('datearrive') // Vérifie si datearrive n'est pas NULL
                            ->where('datearrive', '<', now()); // Comparaison avec la date actuelle
                    });
                });
            }

            if ($request->input('idetatbc') == 5) {
                $donnes->where('raison', '!=', 0);
            }

            if ($request->input('idetatbc') == 6) {
                $donnes->where(function ($query) {
                    $query->where('deposit', '=', 0)
                        ->where('payer', '<', 1);
                });
            }

            if ($request->input('idetatbc') == 7) {
                $donnes->where(function ($query) {
                    $query->where('deposit', '>', 0)
                        ->where('payer', '<', 1);
                });
            }

            if ($request->input('idetatbc') == 8) {
                $donnes->where(function ($query) {
                    $query->where('deposit', '>', 0)
                        ->where('payer', '>=', 1);
                });
            }
        }

        // Récupérer les résultats après application de tous les filtres
        $donne = $donnes->get();

        $today = Carbon::now()->format('Y-m-d');
        $typebc = BonCommande::getAllTypeBc();
        // $donne = BonCommande::getAllDonneBcValide(   );
        $tscf = BonCommande::getTscf();
        $etat = BonCommande::getAllEtatBc();
        $familleTissu = FamilleTissus::where('etat', 0)->get();

        return view('WMS.page.magasin-tissu', compact('typebc', 'donne', 'today', 'tscf', 'etat', 'familleTissu'));
    }

    public function wms_page_tissu_entree_accueil($idFamilleTissu)
    {
        $familleTissu = FamilleTissus::where('id', $idFamilleTissu)->first();
        $historyEntree = V_Entree_Tissu::where('idfamilletissus', $idFamilleTissu)
            ->orderBy('dateentree', 'desc')->limit(100)->get();
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalEntree = V_Total_Entree_Tissu::where('idfamilletissus', $idFamilleTissu)->value('entree');
        $prixTotal = V_PRIX_TOTAL_TISSU_FAMILLE_ENTREE::where('idfamilletissus', $idFamilleTissu)->value('prixtotal');
        $totalMetrage = V_Total_Metrage_Tissu_Famille_Entree::where('idfamilletissus', $idFamilleTissu)->value('metrage');
        $frequenceEntree = 0;
        $nomCategorie = "";
        $idCategorie = "";
        $idClasse = "";
        $nomClasse = "";
        $idUtilisationWMS = "";
        $nomUtilisationWMS = "";
        $nomClient = "";
        $idClient = "";
        $nomFournisseur = "";
        $idFournisseur = "";
        $debut = "";
        $fin = "";
        $recherche = "";
        return view('WMS.Tissu.accueilEntreeTissu', compact('recherche', 'fin', 'debut', 'idFournisseur', 'nomFournisseur', 'idClient', 'nomClient', 'idUtilisationWMS', 'nomUtilisationWMS', 'idClasse', 'nomClasse', 'idCategorie', 'nomCategorie', 'historyEntree', 'familleTissu', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'totalEntree', 'prixTotal', 'totalMetrage', 'frequenceEntree'));
    }

    public function exportCSVEntreeTissu(Request $request)
    {
        $idFamilleTissu = $request->input('idFamilleTissu');
        $spreadsheet = new Spreadsheet();

        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('EntreeTissu');

        $sheet1->setCellValue('A1', 'Désignation')
            ->setCellValue('B1', 'Reference tissu')
            ->setCellValue('C1', 'Composition')
            ->setCellValue('D1', 'Couleur')
            ->setCellValue('E1', 'Catégorie')
            ->setCellValue('F1', 'Classe')
            ->setCellValue('G1', 'Utilisation')
            ->setCellValue('H1', 'Saison')
            ->setCellValue('I1', 'Fournisseur')
            ->setCellValue('J1', 'Client')
            ->setCellValue('K1', 'Modèle')
            ->setCellValue('L1', 'Laize')
            ->setCellValue('M1', 'Date entrée')
            ->setCellValue('N1', 'Date  facturation')
            ->setCellValue('O1', 'Numéro BC')
            ->setCellValue('P1', 'Numéro BL')
            ->setCellValue('Q1', 'Numéro Facture')
            ->setCellValue('R1', 'Quantité commander')
            ->setCellValue('S1', 'Quantité reçu')
            ->setCellValue('T1', 'Reste à recevoir')
            ->setCellValue('U1', 'Unité commande')
            ->setCellValue('V1', 'Taux reçu')
            ->setCellValue('W1', 'Grammage')
            ->setCellValue('X1', 'Nombre de rouleau')
            ->setCellValue('Y1', 'Nombre de lot')
            ->setCellValue('Z1', 'Prix unitaire')
            ->setCellValue('AA1', 'Unité monétaire')
            ->setCellValue('AB1', 'Parité')
            ->setCellValue('AC1', 'Fret')
            ->setCellValue('AD1', 'Commentaire')
            ->setCellValue('AE1', 'Quantité retourner au fournisseur');

        $debut = $request->input('debut', null);
        $fin = $request->input('fin', null);
        $recherche = $request->input('recherche', null);
        $keywords = explode(' ', $recherche);
        $idCategorie = $request->input('idcategorietissu', null);
        $idClasse = $request->input('idclassematierepremiere', null);
        $idUtilisationWMS = $request->input('idutilisationwms', null);
        $idClient = $request->input('idclient', null);
        $idFournisseur = $request->input('idfournisseur', null);
        $idFamilleTissus = $request->input('idfamilletissu', null);
        $data1 = "";
        $nomCategorie = "";
        $nomClasse = "";
        $nomUtilisationWMS = "";
        $nomClient = "";
        $nomFournisseur = "";

        if (empty($debut) && empty($fin) && empty($recherche) && empty($keywords) && empty($idCategorie) && empty($idClasse) && empty($idUtilisationWMS) && empty($idClient) && empty($idFournisseur) && empty($idFamilleTissus)) {

            $data1 = V_Entree_Tissu::where('idfamilletissus', $idFamilleTissu)
                ->orderBy('dateentree', 'desc')->get();
        } else {

            $partCategorie = "";
            if (!empty($idCategorie)) {
                $partCategorie = explode('/', $idCategorie);
                $nomCategorie = $partCategorie[1];
                $idCategorie = $partCategorie[0];
            }

            $partClasse = "";
            if (!empty($idClasse)) {
                $partClasse = explode('/', $idClasse);
                $nomClasse = $partClasse[1];
                $idClasse = $partClasse[0];
            }

            $partUtilisationWMS = "";
            if (!empty($idUtilisationWMS)) {
                $partUtilisationWMS = explode('/', $idUtilisationWMS);
                $nomUtilisationWMS = $partUtilisationWMS[1];
                $idUtilisationWMS = $partUtilisationWMS[0];
            }

            $partClient = "";
            if (!empty($idClient)) {
                $partClient = explode('/', $idClient);
                $nomClient = $partClient[1];
                $idClient = $partClient[0];
            }

            $partFournisseur = "";
            if (!empty($idFournisseur)) {
                $partFournisseur = explode('/', $idFournisseur);
                $nomFournisseur = $partFournisseur[1];
                $idFournisseur = $partFournisseur[0];
            }

            if ($debut != null && $fin == null) {
                $fin = $debut;
            }
            if ($debut == null && $fin != null) {
                $debut = $fin;
            }
            if ($debut !== null && $fin !== null && $fin < $debut) {
                [$debut, $fin] = [$fin, $debut]; // Swap $debut and $fin
            }

            $query = V_Entree_Tissu::where(function ($query) use ($debut, $fin, $keywords, $idCategorie, $idClasse, $idUtilisationWMS, $idClient, $idFournisseur, $idFamilleTissus) {
                // Searching with the "keywords" term across multiple fields
                $query->when($keywords, function ($query, $keywords) {
                    $query->where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->where('colonne', 'ILIKE', "%{$keyword}%"); // Remplacez par le nom de votre colonne
                        }
                    });
                });

                // Filtering by specific criteria based on the ID variables
                $query->when($idCategorie, function ($query, $idCategorie) {
                    return $query->where('idcategorietissus', $idCategorie);
                });
                $query->when($idClasse, function ($query, $idClasse) {
                    return $query->where('idclassematierepremiere', $idClasse);
                });
                $query->when($idUtilisationWMS, function ($query, $idUtilisationWMS) {
                    return $query->where('idutilisationwms', $idUtilisationWMS);
                });
                $query->when($idClient, function ($query, $idClient) {
                    return $query->where('idclient', $idClient);
                });
                $query->when($idFournisseur, function ($query, $idFournisseur) {
                    return $query->where('idfournisseur', $idFournisseur);
                });
                $query->when($idFamilleTissus, function ($query, $idFamilleTissus) {
                    return $query->where('idfamilletissus', $idFamilleTissus);
                });

                // Filtering by date range
                if ($debut !== null && $fin !== null) {
                    $query->whereBetween('dateentree', [$debut, $fin]);
                }
            });
            $historyCalcul = $query->get();
            $data1 = $query->orderBy('dateentree', 'desc')->get();
        }



        $rowNum = 2;
        foreach ($data1 as $row) {
            $sheet1->setCellValue('A' . $rowNum, $row->des_tissu)
                ->setCellValue('B' . $rowNum, $row->reftissu)
                ->setCellValue('C' . $rowNum, $row->composition)
                ->setCellValue('D' . $rowNum, $row->couleur)
                ->setCellValue('E' . $rowNum, $row->categorie)
                ->setCellValue('F' . $rowNum, $row->classe)
                ->setCellValue('G' . $rowNum, $row->utilisation)
                ->setCellValue('H' . $rowNum, $row->saison)
                ->setCellValue('I' . $rowNum, $row->fournisseur)
                ->setCellValue('J' . $rowNum, $row->client)
                ->setCellValue('K' . $rowNum, $row->modele)
                ->setCellValue('L' . $rowNum, $row->laize)
                ->setCellValue('M' . $rowNum, $row->dateentree)
                ->setCellValue('N' . $rowNum, $row->datefacturation)
                ->setCellValue('O' . $rowNum, $row->numerobc)
                ->setCellValue('P' . $rowNum, $row->numerobl)
                ->setCellValue('Q' . $rowNum, $row->numerofacture)
                ->setCellValue('R' . $rowNum, $row->qtecommande)
                ->setCellValue('S' . $rowNum, $row->qterecu)
                ->setCellValue('T' . $rowNum, $row->resterecevoir)
                ->setCellValue('U' . $rowNum, $row->unite_mesure)
                ->setCellValue('V' . $rowNum, $row->tauxecart)
                ->setCellValue('W' . $rowNum, $row->grammage)
                ->setCellValue('X' . $rowNum, $row->nbrouleau)
                ->setCellValue('Y' . $rowNum, $row->nblot)
                ->setCellValue('Z' . $rowNum, $row->prixunitaire)
                ->setCellValue('AA' . $rowNum, $row->unite_monetaire)
                ->setCellValue('AB' . $rowNum, $row->valeur)
                ->setCellValue('AC' . $rowNum, $row->fret)
                ->setCellValue('AD' . $rowNum, $row->commentaire)
                ->setCellValue('AE' . $rowNum, $row->retour_fournisseur);
            $rowNum++;
        }



        $writer = new Xlsx($spreadsheet);
        $fileName = 'ENTREE_Tissu.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        $writer->save('php://output');
    }


    // TODO: Passer la variable idfamilletissus
    public function wms_page_tissu_entree($idFamilleTissu)
    {
        $familleTissu = FamilleTissus::find($idFamilleTissu);
        $catTissu = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $uniteCommande = UniteMesureMatierePremiere::where('etat', 0)->get();
        $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
        $cellule = Cellule::where('idrack', 1)
            ->where('etat', 0)->get();

        return view('WMS.Tissu.entreeTissu', compact('catTissu', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'uniteCommande', 'uniteMonetaire', 'cellule', 'familleTissu'));
    }

    public function wms_page_tissu_stock($idFamilleTissu)
    {

        $stock = [];
        $stockTissu = V_Stock_Tissu::where('idfamilletissus', $idFamilleTissu)
            ->where(function ($query) {
                $query->where('obsolete', '!=', 1)
                    ->orWhereNull('obsolete'); // Gérer le cas où 'obsolete' est NULL
            })
            ->orderBy('id', 'desc') // Trier par ID en ordre décroissant
            ->limit(100) // Limiter à 100 résultats
            ->get();

        foreach ($stockTissu as $stocks) {
            // Récupérer les données de EntreeWMS
            $entreeTissu = EntreeTissu::where('idstocktissu', $stocks->id)->first();

            // Vérifier si une entrée a été trouvée
            if ($entreeTissu) {
                $stocks->idunitemonetaire = $entreeTissu->idunitemonetaire;
                $stocks->numbc = $entreeTissu->numerobc;
                $stocks->qtecommande = $entreeTissu->qtecommande;
            }

            // Ajouter à la collection
            $stock[] = $stocks;
        }

        // $stock contient maintenant au maximum 100 éléments, triés par ID décroissant

        $familleTissu = FamilleTissus::find($idFamilleTissu);
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalEntree = V_TOTAL_STOCK_TISSU::where('idfamilletissus', $idFamilleTissu)->value('stock');
        $prixTotal = V_PRIX_TOTAL_TISSU_FAMILLE_STOCK::where('idfamilletissus', $idFamilleTissu)->value('prixtotal');
        $totalMetrage = V_TOTAL_METRAGE_TISSU_FAMILLE_STOCK::where('idfamilletissus', $idFamilleTissu)->value('metrage');
        $rackCellule = V_Rack_Cellule::listeV_Rack_Cellule();
        $nomCategorie = "";
        $idCategorie = "";
        $idClasse = "";
        $nomClasse = "";
        $idUtilisationWMS = "";
        $nomUtilisationWMS = "";
        $nomClient = "";
        $idClient = "";
        $nomFournisseur = "";
        $idFournisseur = "";
        $recherche = "";
        return view('WMS.Tissu.stockTissu', compact('recherche', 'idFournisseur', 'nomFournisseur', 'idClient', 'nomClient', 'idUtilisationWMS', 'nomUtilisationWMS', 'idClasse', 'nomClasse', 'idCategorie', 'nomCategorie', 'rackCellule', 'stock', 'familleTissu', 'categorie', 'classeMatiere', 'uniteMonetaire', 'utilisation', 'client', 'fournisseur', 'totalEntree', 'prixTotal', 'totalMetrage'));
    }


    public function exportCSVStockTissu(Request $request)
    {
        $idFamilleTissu = $request->input('idFamilleTissu');
        $spreadsheet = new Spreadsheet();

        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('EntreeTissu');

        $sheet1->setCellValue('A1', 'Classe Pareto')
            ->setCellValue('B1', 'Cellule')
            ->setCellValue('C1', 'Désignation')
            ->setCellValue('D1', 'Réference')
            ->setCellValue('E1', 'Couleur')
            ->setCellValue('F1', 'Composition')
            ->setCellValue('G1', 'Classe')
            ->setCellValue('H1', 'Catégorie')
            ->setCellValue('I1', 'Utilisation')
            ->setCellValue('J1', 'Somme Entrée')
            ->setCellValue('K1', 'Somme Sortie')
            ->setCellValue('L1', 'Retour Manque')
            ->setCellValue('M1', 'Retour Surplus')
            ->setCellValue('N1', 'Retour Inventaire')
            ->setCellValue('O1', 'Fournisseur')
            ->setCellValue('P1', 'Client')
            ->setCellValue('Q1', 'Modèle')
            ->setCellValue('R1', 'Quantité en stock')
            ->setCellValue('S1', 'Prix Unitaire');

        $recherche = $request->input('recherche', null);
        $keywords = explode(' ', $recherche);
        $idCategorie = $request->input('idcategorietissu', null);
        $idClasse = $request->input('idclassematierepremiere', null);
        $idUtilisationWMS = $request->input('idutilisationwms', null);
        $idClient = $request->input('idclient', null);
        $idFournisseur = $request->input('idfournisseur', null);
        $idFamilleTissu = $request->input('idfamilletissu', null);

        $data1 = [];
        if ($idCategorie == "/") {
            $idCategorie = "";
        }
        if ($idClasse == "/") {
            $idClasse = "";
        }
        if ($idUtilisationWMS == "/") {
            $idUtilisationWMS = "";
        }
        if ($idClient == "/") {
            $idClient = "";
        }
        if ($idFournisseur == "/") {
            $idFournisseur = "";
        }

        if (empty($recherche)  && empty($idCategorie) && empty($idClasse) && empty($idUtilisationWMS) && empty($idClient) && empty($idFournisseur)) {

            $stockTissu = V_Stock_Tissu::where('idfamilletissus', $idFamilleTissu)
                ->where(function ($query) {
                    $query->where('obsolete', '!=', 1)
                        ->orWhereNull('obsolete');
                })
                ->orderBy('id', 'desc')
                ->limit(100)
                ->get();

            foreach ($stockTissu as $stocks) {
                $entreeTissu = EntreeTissu::where('idstocktissu', $stocks->id)->first();

                // Vérifier si une entrée a été trouvée
                if ($entreeTissu) {
                    $stocks->idunitemonetaire = $entreeTissu->idunitemonetaire;
                    $stocks->numbc = $entreeTissu->numerobc;
                    $stocks->qtecommande = $entreeTissu->qtecommande;
                }

                $data1[] = $stocks;
            }
        } else {

            $partCategorie = "";
            $nomCategorie = "";
            if (!empty($idCategorie)) {
                $partCategorie = explode('/', $idCategorie);
                $nomCategorie = $partCategorie[1];
                $idCategorie = $partCategorie[0];
            }


            $partClasse = "";
            $nomClasse = "";
            if (!empty($idClasse)) {
                $partClasse = explode('/', $idClasse);
                $nomClasse = $partClasse[1];
                $idClasse = $partClasse[0];
            }


            $partUtilisationWMS = "";
            $nomUtilisationWMS = "";
            if (!empty($idUtilisationWMS)) {
                $partUtilisationWMS = explode('/', $idUtilisationWMS);
                $nomUtilisationWMS = $partUtilisationWMS[1];
                $idUtilisationWMS = $partUtilisationWMS[0];
            }


            $partClient = "";
            $nomClient = "";
            if (!empty($idClient)) {
                $partClient = explode('/', $idClient);
                $nomClient = $partClient[1];
                $idClient = $partClient[0];
            }


            $partFournisseur = "";
            $nomFournisseur = "";
            if (!empty($idFournisseur)) {
                $partFournisseur = explode('/', $idFournisseur);
                $nomFournisseur = $partFournisseur[1];
                $idFournisseur = $partFournisseur[0];
            }

            $query = V_Stock_Tissu::where(function ($query) use ($keywords, $idCategorie, $idClasse, $idUtilisationWMS, $idClient, $idFournisseur, $idFamilleTissu) {
                // Searching with the "keywords" term across multiple fields
                $query->when($keywords, function ($query, $keywords) {
                    $query->where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->where('colonne', 'ILIKE', "%{$keyword}%"); // Remplacez par le nom de votre colonne
                        }
                    });
                });

                // Filtering by specific criteria based on the ID variables
                $query->when($idCategorie, function ($query, $idCategorie) {
                    return $query->where('idcategorietissus', $idCategorie);
                });
                $query->when($idClasse, function ($query, $idClasse) {
                    return $query->where('idclassematierepremiere', $idClasse);
                });
                $query->when($idUtilisationWMS, function ($query, $idUtilisationWMS) {
                    return $query->where('idutilisationwms', $idUtilisationWMS);
                });
                $query->when($idFournisseur, function ($query, $idFournisseur) {
                    return $query->where('idfournisseur', $idFournisseur);
                });
                $query->when($idFamilleTissu, function ($query, $idFamilleTissu) {
                    return $query->where('idfamilletissus', $idFamilleTissu);
                });

                $query->when($idClient, function ($query, $idClient) {
                    return $query->where('idclient', $idClient);
                });
            });

            $data1 = $query->where(function ($query) {
                $query->where('obsolete', '!=', 1)
                    ->orWhereNull('obsolete'); // Use orWhereNull for 'IS NULL'
            })->get();
        }



        $rowNum = 2;
        foreach ($data1 as $row) {
            $sheet1->setCellValue('A' . $rowNum, $row->pareto_classification)
                ->setCellValue('B' . $rowNum, $row->designation_cellue)
                ->setCellValue('C' . $rowNum, $row->designation)
                ->setCellValue('D' . $rowNum, $row->reference)
                ->setCellValue('E' . $rowNum, $row->couleur)
                ->setCellValue('F' . $rowNum, $row->composition)
                ->setCellValue('G' . $rowNum, $row->classe)
                ->setCellValue('H' . $rowNum, $row->categorie)
                ->setCellValue('I' . $rowNum, $row->utilisation)
                ->setCellValue('J' . $rowNum, $row->sommeqterecu)
                ->setCellValue('K' . $rowNum, $row->sommeqtesortie)
                ->setCellValue('L' . $rowNum, $row->retour_manque)
                ->setCellValue('M' . $rowNum, $row->retour_surplus)
                ->setCellValue('N' . $rowNum, $row->retour_inventaire)
                ->setCellValue('O' . $rowNum, $row->fournisseur)
                ->setCellValue('P' . $rowNum, $row->nomtier)
                ->setCellValue('Q' . $rowNum, $row->modele)
                ->setCellValue('R' . $rowNum, $row->qtestock)
                ->setCellValue('S' . $rowNum, $row->prixunitaire);
            $rowNum++;
        }



        $writer = new Xlsx($spreadsheet);
        $fileName = 'STOCK_Tissu.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        $writer->save('php://output');
    }
    public function wms_page_tissu_stock_detail($idstocktissu)
    {
        $stock = V_Stock_Tissu::find($idstocktissu);
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();

        return view('WMS.Tissu.stockTissu', compact('stock', 'familleTissu', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'totalEntree', 'prixTotal', 'totalMetrage'));
    }
    public function wms_page_tissu_stock_obsolete()
    {
        $stock = V_Stock_Tissu::where('obsolete', 1)
            ->paginate(50);
        $familleTissu = FamilleTissus::all();
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalEntree = V_TOTAL_STOCK_TISSU_OBSOLETE::value('stock');
        $prixTotal = V_PRIX_TOTAL_TISSU_OBSOLETE_STOCK::value('prixtotal');
        $totalMetrage = V_TOTAL_METRAGE_TISSU_OBSOLETE_STOCK::value('metrage');

        return view('WMS.Tissu.obsolete-tissu', compact('stock', 'familleTissu', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'totalEntree', 'prixTotal', 'totalMetrage'));
    }
    public function wms_page_tissu_rajout_tissu($idstock)
    {
        $stock = V_Stock_Tissu::find($idstock);
        $stockTiersModele = StockTissu_Tiers_Modele::where('idstocktissu', $idstock)->first();
        $catTissu = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $uniteCommande = UniteMesureMatierePremiere::where('etat', 0)->get();
        $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
        $cellule = V_Rack_Cellule::where('section', 'ILIKE', '%Tissu%')->get();
        return view('WMS.Tissu.rajout-tissu-sans-tscf', compact('stock', 'stockTiersModele', 'catTissu', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'uniteCommande', 'uniteMonetaire', 'cellule',));
    }

    public function wms_page_tissu_sortie_accueil($idFamilleTissu)
    {
        $sortie = V_Sortie_Tissu::where('idfamilletissus', $idFamilleTissu)
            ->where(function ($query) {
                $query->where('obsolete', '!=', 1)
                    ->orWhereNull('obsolete');
            })
            ->orderBy('datesortie', 'desc')
            ->limit(100)
            ->get();

        $familleTissu = FamilleTissus::where('id', $idFamilleTissu)->first();
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalSortie = V_TOTAL_SORTIE_TISSU::where('idfamilletissus', $idFamilleTissu)
            ->where(function ($query) {
                $query->where('obsolete', '!=', 1)
                    ->orWhereNull('obsolete'); // Use orWhereNull for 'IS NULL'
            })->value('sortie');
        $prixTotal = V_PRIX_TOTAL_TISSU_FAMILLE_SORTIE::where('idfamilletissus', $idFamilleTissu)
            ->where(function ($query) {
                $query->where('obsolete', '!=', 1)
                    ->orWhereNull('obsolete'); // Use orWhereNull for 'IS NULL'
            })->value('prixtotal');
        $totalMetrage = V_TOTAL_METRAGE_TISSU_FAMILLE_SORTIE::where('idfamilletissus', $idFamilleTissu)
            ->where(function ($query) {
                $query->where('obsolete', '!=', 1)
                    ->orWhereNull('obsolete'); // Use orWhereNull for 'IS NULL'
            })->value('metrage');
        $frequenceSortie = 0;
        $nomCategorie = "";
        $idCategorie = "";
        $idClasse = "";
        $nomClasse = "";
        $idUtilisationWMS = "";
        $nomUtilisationWMS = "";
        $nomClient = "";
        $idClient = "";
        $nomFournisseur = "";
        $idFournisseur = "";
        $debut = "";
        $fin = "";
        $commentaire = "";
        $recherche = "";
        return view('WMS.Tissu.accueilSortieTissu', compact('commentaire', 'recherche', 'fin', 'debut', 'idFournisseur', 'nomFournisseur', 'idClient', 'nomClient', 'idUtilisationWMS', 'nomUtilisationWMS', 'idClasse', 'nomClasse', 'idCategorie', 'nomCategorie', 'sortie', 'familleTissu', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'totalSortie', 'prixTotal', 'totalMetrage', 'frequenceSortie'));
    }

    public function exportCSVSortieTissu(Request $request)
    {
        $idFamilleTissu = $request->input('idFamilleTissu');
        $spreadsheet = new Spreadsheet();

        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('EntreeTissu');

        $sheet1->setCellValue('A1', 'Date sortie')
            ->setCellValue('B1', 'NumeroBCI')
            ->setCellValue('C1', 'Catégorie')
            ->setCellValue('D1', 'Classe de la matière')
            ->setCellValue('E1', 'Référence tissu')
            ->setCellValue('F1', 'Désignation')
            ->setCellValue('G1', 'Composition')
            ->setCellValue('H1', 'Couleur')
            ->setCellValue('I1', 'Fournisseur')
            ->setCellValue('J1', 'Client')
            ->setCellValue('K1', 'Modèle')
            ->setCellValue('L1', 'Laize')
            ->setCellValue('M1', 'Destinataire')
            ->setCellValue('N1', 'Receveur')
            ->setCellValue('O1', 'Quantité livré')
            ->setCellValue('P1', 'Prix unitaire')
            ->setCellValue('Q1', 'Commentaire');

        $debut = $request->input('debut', null);
        $debut = $request->input('debut', null);
        $fin = $request->input('fin', null);
        $recherche = $request->input('recherche', null);
        $commentaire = $request->input('commentaire', null);
        $keywords = explode(' ', $recherche);
        $idCategorie = $request->input('idcategorietissu', null);
        $idfamilletissu = $request->input('idfamilletissu');
        $partClasse = "";
        $nomClasse = "";
        $idUtilisationWMS = $request->input('idutilisationwms', null);
        $partUtilisationWMS = "";
        $nomUtilisationWMS = "";
        $idClient = $request->input('idclient', null);
        $partClient = "";
        $nomClient = "";
        $idFournisseur = $request->input('idfournisseur', null);
        $partFournisseur = "";
        $nomFournisseur = "";
        $idFamilleTissu = $request->input('idfamilletissu', null);
        $idFamilleTissus = $request->input('idfamilletissu', null);
        $data1="";
        if (empty($debut) && empty($fin) && empty($recherche) && empty($keywords) && empty($idCategorie) && empty($idClasse) && empty($idUtilisationWMS) && empty($idClient) && empty($idFournisseur) && empty($idFamilleTissus)) {

            $data1 = V_Sortie_Tissu::where('idfamilletissus', $idFamilleTissu)
            ->where(function ($query) {
                $query->where('obsolete', '!=', 1)
                    ->orWhereNull('obsolete');
            })
            ->orderBy('datesortie', 'desc')
            ->get();
        } else {
            $partCategorie = "";
            $nomCategorie = "";
            if (!empty($idCategorie)) {
                $partCategorie = explode('/', $idCategorie);
                $nomCategorie = $partCategorie[1];
                $idCategorie = $partCategorie[0];
            }

            $idClasse = $request->input('idclassematierepremiere', null);
            $partClasse = "";
            $nomClasse = "";
            if (!empty($idClasse)) {
                $partClasse = explode('/', $idClasse);
                $nomClasse = $partClasse[1];
                $idClasse = $partClasse[0];
            }

            $idUtilisationWMS = $request->input('idutilisationwms', null);
            $partUtilisationWMS = "";
            $nomUtilisationWMS = "";
            if (!empty($idUtilisationWMS)) {
                $partUtilisationWMS = explode('/', $idUtilisationWMS);
                $nomUtilisationWMS = $partUtilisationWMS[1];
                $idUtilisationWMS = $partUtilisationWMS[0];
            }

            $idClient = $request->input('idclient', null);
            $partClient = "";
            $nomClient = "";
            if (!empty($idClient)) {
                $partClient = explode('/', $idClient);
                $nomClient = $partClient[1];
                $idClient = $partClient[0];
            }

            $idFournisseur = $request->input('idfournisseur', null);
            $partFournisseur = "";
            $nomFournisseur = "";
            if (!empty($idFournisseur)) {
                $partFournisseur = explode('/', $idFournisseur);
                $nomFournisseur = $partFournisseur[1];
                $idFournisseur = $partFournisseur[0];
            }
            $tiersModele = StockTissu_Tiers_Modele::where('idclient', $idClient)->get();
            $idFamilleTissu = $request->input('idfamilletissu', null);
            if ($debut != null && $fin == null) {
                $fin = $debut;
            }
            if ($debut == null && $fin != null) {
                $debut = $fin;
            }
            if ($debut !== null && $fin !== null && $fin < $debut) {
                [$debut, $fin] = [$fin, $debut];
            }
            $query = V_Sortie_Tissu::where(function ($query) use ($commentaire, $tiersModele, $debut, $fin, $keywords, $idCategorie, $idClasse, $idUtilisationWMS, $idClient, $idFournisseur, $idfamilletissu) {

                $query->when($keywords, function ($query, $keywords) {
                    $query->where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->where('colonne', 'ILIKE', "%{$keyword}%"); // Remplacez par le nom de votre colonne
                        }
                    });
                });

                $query->when($idCategorie, function ($query, $idCategorie) {
                    return $query->where('idcategorietissus', $idCategorie);
                });
                $query->when($commentaire, function ($query, $commentaire) {
                    return $query->where('commentaire', 'ILIKE', "%{$commentaire}%");
                });
                $query->when($idClasse, function ($query, $idClasse) {
                    return $query->where('idclassematierepremiere', $idClasse);
                });
                $query->when($idUtilisationWMS, function ($query, $idUtilisationWMS) {
                    return $query->where('idutilisationwms', $idUtilisationWMS);
                });
                $query->when($idClient, function ($query, $idClient) {
                    return $query->where('idclient', $idClient);
                });
                $query->when($idFournisseur, function ($query, $idFournisseur) {
                    return $query->where('idfournisseur', $idFournisseur);
                });
                $query->when($idfamilletissu, function ($query, $idfamilletissu) {
                    return $query->where('idfamilletissus', $idfamilletissu);
                });
                if ($tiersModele->isNotEmpty()) {
                    $ids = $tiersModele->pluck('idstocktissu')->toArray();
                    $query->whereIn('id', $ids);
                }
                // Filtering by date range
                if ($debut !== null && $fin !== null) {
                    $query->whereBetween('datesortie', [$debut, $fin]);
                }
            });

            $data1 = $query->where(function ($query) {
                $query->where('obsolete', '!=', 1)
                    ->orWhereNull('obsolete'); // Use orWhereNull for 'IS NULL'
            })->orderBy('datesortie', 'desc')->get();
        }



        $rowNum = 2;
        foreach ($data1 as $row) {
            $sheet1->setCellValue('A' . $rowNum, $row->des_tissu)
                ->setCellValue('B' . $rowNum, $row->reftissu)
                ->setCellValue('C' . $rowNum, $row->composition)
                ->setCellValue('D' . $rowNum, $row->couleur)
                ->setCellValue('E' . $rowNum, $row->categorie)
                ->setCellValue('F' . $rowNum, $row->classe)
                ->setCellValue('G' . $rowNum, $row->utilisation)
                ->setCellValue('H' . $rowNum, $row->saison)
                ->setCellValue('I' . $rowNum, $row->fournisseur)
                ->setCellValue('J' . $rowNum, $row->client)
                ->setCellValue('K' . $rowNum, $row->modele)
                ->setCellValue('L' . $rowNum, $row->laize)
                ->setCellValue('M' . $rowNum, $row->dateentree)
                ->setCellValue('N' . $rowNum, $row->datefacturation)
                ->setCellValue('O' . $rowNum, $row->numerobc)
                ->setCellValue('P' . $rowNum, $row->numerobl)
                ->setCellValue('Q' . $rowNum, $row->numerofacture)
                ->setCellValue('R' . $rowNum, $row->qtecommande)
                ->setCellValue('S' . $rowNum, $row->qterecu)
                ->setCellValue('T' . $rowNum, $row->resterecevoir)
                ->setCellValue('U' . $rowNum, $row->unite_mesure)
                ->setCellValue('V' . $rowNum, $row->tauxecart)
                ->setCellValue('W' . $rowNum, $row->grammage)
                ->setCellValue('X' . $rowNum, $row->nbrouleau)
                ->setCellValue('Y' . $rowNum, $row->nblot)
                ->setCellValue('Z' . $rowNum, $row->prixunitaire)
                ->setCellValue('AA' . $rowNum, $row->unite_monetaire)
                ->setCellValue('AB' . $rowNum, $row->valeur)
                ->setCellValue('AC' . $rowNum, $row->fret)
                ->setCellValue('AD' . $rowNum, $row->commentaire)
                ->setCellValue('AE' . $rowNum, $row->retour_fournisseur);
            $rowNum++;
        }



        $writer = new Xlsx($spreadsheet);
        $fileName = 'ENTREE_Tissu.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        $writer->save('php://output');
    }

    public function wms_page_tissu_obolete_sortie_accueil()
    {
        $sortie = V_Sortie_Tissu::where('obsolete', 1)
            ->orderBy('datesortie', 'desc')
            ->paginate(50);
        $familleTissu = FamilleTissus::where('etat', 0)->get();
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalSortie = V_TOTAL_SORTIE_TISSU::where('obsolete', 1)->sum('sortie');
        $prixTotal = V_PRIX_TOTAL_TISSU_FAMILLE_SORTIE::where('obsolete', 1)->sum('prixtotal');
        $totalMetrage = V_TOTAL_METRAGE_TISSU_FAMILLE_SORTIE::where('obsolete', 1)->sum('metrage');
        $frequenceSortie = 0;

        return view('WMS.Tissu.sortie-obsolete-tissu', compact('sortie', 'familleTissu', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'totalSortie', 'prixTotal', 'totalMetrage', 'frequenceSortie'));
    }

    public function wms_page_tissu_sortie($idStock)
    {
        $stock = V_Stock_Tissu::where('id', $idStock)->first();
        $catTissu = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        // $historyEntree = [];
        // foreach ($stock as $key => $stocks) {
        //     $stockTiersModele = StockTissu_Tiers_Modele::where('idstocktissu', $idStock)->first();
        //     dd($stockTiersModele);
        //     $stocks->idclient = $stockTiersModele ? $stockTiersModele->idclient : null;
        //     $stocks->modele = $stockTiersModele ? $stockTiersModele->modele : null;
        //     $historyEntree = $stocks;
        // }
        return view('WMS.Tissu.sortieTissu', compact('stock', 'catTissu', 'classeMatiere', 'utilisation', 'client', 'fournisseur'));
    }

    public function wms_page_rajout_tscf_tissu(Request $request, $idStock)
    {
        $donnes = V_donne_bc::query()
            ->where('etat', 10)
            ->where('type_bc', 'Tissu')
            ->where('idtypebc', '!=', 3)
            ->orderBy('id_donne_bc', 'desc');

        $columns = ['type_bc', 'type_saison', 'nom_modele', 'client', 'fournisseur', 'des_tissus', 'ref_tissus', 'des_accessoire', 'ref_accessoire'];

        if ($request->search) {
            $searchTerm = $request->input('search');
            $donnes->where(function ($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }
        if ($request->startDeadline && $request->endDeadline) {
            $donnes->when($donnes->first()->deadline == 0, function ($query) use ($request) {
                // Si 'deadline' est égale à 0, on utilise 'echeance'
                return $query->whereBetween('echeance', [$request->startDeadline, $request->endDeadline]);
            }, function ($query) use ($request) {
                // Sinon, on utilise 'deadline'
                return $query->whereBetween('deadline', [$request->startDeadline, $request->endDeadline]);
            });
        }
        if ($request->startEmmission && $request->endEmmission) {
            $donnes->whereBetween('date_bc', [$request->startEmmission, $request->endEmmission]);
        }

        if ($request->idetatbc) {
            // Si idetatbc == 1, on ajoute la condition sur 'datearrive' et 'deadline'
            if ($request->input('idetatbc') == 1) {
                $donnes->where(function ($query) {
                    $query->where(function ($subQuery) {
                        $subQuery->whereNull('datearrive')  // Vérifie si datearrive est NULL
                            ->where('echeance', '>=', now()); // Comparaison avec la date actuelle
                    })->orWhere(function ($subQuery) {
                        $subQuery->whereNotNull('datearrive') // Vérifie si datearrive n'est pas NULL
                            ->where('datearrive', '>=', now()); // Comparaison avec la date actuelle
                    });
                });
            }

            if ($request->input('idetatbc') == 2) {
                $donnes->where(function ($query) {
                    $query->where('reste', '>', 0)
                        ->where('magasin_quantite', '>', 0);
                });
            }

            if ($request->input('idetatbc') == 3) {
                $donnes->where(function ($query) {
                    $query->where('reste', '=', 0);
                });
            }

            if ($request->input('idetatbc') == 4) {
                $donnes->where(function ($query) {
                    $query->where(function ($subQuery) {
                        $subQuery->whereNull('datearrive')  // Vérifie si datearrive est NULL
                            ->where('echeance', '<', now()); // Comparaison avec la date actuelle
                    })->orWhere(function ($subQuery) {
                        $subQuery->whereNotNull('datearrive') // Vérifie si datearrive n'est pas NULL
                            ->where('datearrive', '<', now()); // Comparaison avec la date actuelle
                    });
                });
            }

            if ($request->input('idetatbc') == 5) {
                $donnes->where('raison', '!=', 0);
            }

            if ($request->input('idetatbc') == 6) {
                $donnes->where(function ($query) {
                    $query->where('deposit', '=', 0)
                        ->where('payer', '<', 1);
                });
            }

            if ($request->input('idetatbc') == 7) {
                $donnes->where(function ($query) {
                    $query->where('deposit', '>', 0)
                        ->where('payer', '<', 1);
                });
            }

            if ($request->input('idetatbc') == 8) {
                $donnes->where(function ($query) {
                    $query->where('deposit', '>', 0)
                        ->where('payer', '>=', 1);
                });
            }
        }

        // Récupérer les résultats après application de tous les filtres
        $donne = $donnes->get();

        $today = Carbon::now()->format('Y-m-d');
        $typebc = BonCommande::getAllTypeBc();
        // $donne = BonCommande::getAllDonneBcValide(   );
        $tscf = BonCommande::getTscf();
        $etat = BonCommande::getAllEtatBc();
        $stock = StockTissu::where('id', $idStock)->first();

        return view('WMS.Tissu.tscf-rajout-tissu', compact('typebc', 'donne', 'today', 'tscf', 'etat', 'stock'));
    }

    // //!-------------------------------- Lien retour Tissu --------------------------------!//
    public function wms_page_retour_tissu($idFamilleTissu)
    {
        $familleTissu = FamilleTissus::find($idFamilleTissu);
        $historyRetour = V_Retour_Tissu::where('idfamilletissus', $idFamilleTissu)->paginate(50);

        return view('WMS.Tissu.retourTissu', compact('familleTissu', 'historyRetour'));
    }

    // //!-------------------------------- Lien reservation Tissu --------------------------------!//
    public function wms_page_reservation_tissu()
    {
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $historyReservation = V_Reservation_tissu::paginate(50);

        return view('WMS.Tissu.reservationTissu', compact('historyReservation', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur'));
    }

    //!-------------------------------- Lien consommable --------------------------------!//
    public function wms_page_accueil_consommable()
    {
        return view('WMS.Tissu.Consommable.accueilEntreeConso');
    }

    public function wms_page_consommable_entree()
    {
        return view('WMS.Tissu.Consommable.entreeConso');
    }

    public function wms_page_consommable_stock()
    {
        return view('WMS.Tissu.Consommable.stockConso');
    }

    public static function modificationCellule(Request $request)
    {
        $idStock = $request->input('idstocktissu');
        $idCellule = $request->input('cellule');
        $idEntree = EntreeTissu::getEntreeTissuByStock($idStock);
        for ($i = 0; $i < count($idEntree); $i++) {
            for ($j = 0; $j < count($idCellule); $j++) {
                $cellule = new EntreeTissu();
                $cellule->insertCelluleEntree($idEntree[$i]->id, $idCellule[$j]);
            }
        }
        return back();
    }
}
