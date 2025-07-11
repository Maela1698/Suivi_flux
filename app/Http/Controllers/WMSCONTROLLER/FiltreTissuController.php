<?php

namespace App\Http\Controllers\WMSCONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\CategorieTissus;
use App\Models\ClasseMatierePremiere;
use App\Models\FamilleTissus;
use App\Models\Tiers;
use App\Models\WMSModel\StockTissu_Tiers_Modele;
use App\Models\WMSModel\UtilisationWMS;
use App\Models\WMSModel\V_Entree_Tissu;
use App\Models\WMSModel\V_Sortie_Tissu;
use App\Models\WMSModel\V_Stock_Tissu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class FiltreTissuController extends Controller
{
    public function filtreEntreeTissu(Request $request)
    {
        $debut = $request->input('debut', null);
        $fin = $request->input('fin', null);
        $recherche = $request->input('recherche', null);
        $keywords = explode(' ', $recherche);
        $idCategorie = $request->input('idcategorietissu', null);
        $idClasse = $request->input('idclassematierepremiere', null);
        $idUtilisationWMS = $request->input('idutilisationwms', null);
        $idClient = $request->input('idclient', null);
        $idFournisseur = $request->input('idfournisseur', null);
        $idFamilleTissu = $request->input('idfamilletissu', null);
        if ($debut != null && $fin == null) {
            $fin = $debut;
        }
        if ($debut == null && $fin != null) {
            $debut = $fin;
        }
        if ($debut !== null && $fin !== null && $fin < $debut) {
            [$debut, $fin] = [$fin, $debut]; // Swap $debut and $fin
        }

        $query = V_Entree_Tissu::where(function ($query) use ($debut, $fin, $keywords, $idCategorie, $idClasse, $idUtilisationWMS, $idClient, $idFournisseur, $idFamilleTissu) {
            // Searching with the "keywords" term across multiple fields
            $query->when($keywords, function ($query, $keywords) {
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->where('colonne', 'LIKE', "%{$keyword}%"); // Remplacez par le nom de votre colonne
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
            $query->when($idFamilleTissu, function ($query, $idFamilleTissu) {
                return $query->where('idfamilletissus', $idFamilleTissu);
            });

            // Filtering by date range
            if ($debut !== null && $fin !== null) {
                $query->whereBetween('dateentree', [$debut, $fin]);
            }
        });
        $historyCalcul = $query->get();
        $historyEntree = $query->orderBy('dateentree', 'desc')->paginate(50)
            ->appends([
                'idfamilletissu' => $idFamilleTissu,
                'recherche' => $recherche,
                'debut' => $debut,
                'fin' => $fin,
                'idcategorietissu' => $idCategorie,
                'idclassematierepremiere' => $idClasse,
                'idutilisationwms' => $idUtilisationWMS,
                'idclient' => $idClient,
                'idfournisseur' => $idFournisseur,
            ]);
        $familleTissu = FamilleTissus::where('id', $idFamilleTissu)->first();
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalEntree = $historyCalcul->count();
        $prixTotal = 0;
        for ($i = 0; $i < $historyCalcul->count(); $i++) {
            $prixTotal += $historyCalcul[$i]->qterecu * $historyCalcul[$i]->prixeuro;
        }
        $totalMetrage = $historyCalcul->sum('qterecu');
        $frequenceEntree = 0;
        if ($debut != null && $fin != null) {
            $diffJour = Carbon::parse($debut)->diffInDays(Carbon::parse($fin)) + 1;
            // Prevent division by zero if the dates are the same
            $frequenceEntree = $diffJour > 0 ? $historyCalcul->count() / $diffJour : $historyCalcul->count();
        }
        return view('WMS.Tissu.accueilEntreeTissu', compact('historyEntree', 'familleTissu', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'totalEntree', 'prixTotal', 'totalMetrage', 'frequenceEntree'));
    }

    public function filtreStockTissu(Request $request)
    {
        $recherche = $request->input('recherche', null);
        $keywords = explode(' ', $recherche);
        $idCategorie = $request->input('idcategorietissu', null);
        $idClasse = $request->input('idclassematierepremiere', null);
        $idUtilisationWMS = $request->input('idutilisationwms', null);
        $idClient = $request->input('idclient', null);
        $idFournisseur = $request->input('idfournisseur', null);
        $idFamilleTissu = $request->input('idfamilletissu', null);
        $tiersModele = StockTissu_Tiers_Modele::where('idclient', $idClient)->get();
        $query = V_Stock_Tissu::where(function ($query) use ($keywords, $idCategorie, $idClasse, $idUtilisationWMS, $idClient, $idFournisseur, $idFamilleTissu, $tiersModele) {
            // Searching with the "keywords" term across multiple fields
            $query->when($keywords, function ($query, $keywords) {
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->where('colonne', 'LIKE', "%{$keyword}%"); // Remplacez par le nom de votre colonne
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
            if ($tiersModele->isNotEmpty()) {
                $ids = $tiersModele->pluck('idstocktissu')->toArray();
                $query->whereIn('id', $ids);
            }
        });


        $stockCalcul = $query->where(function ($query) {
            $query->where('obsolete', '!=', 1)
                ->orWhereNull('obsolete'); // Use orWhereNull for 'IS NULL'
        })->get();
        $stock = $query->where(function ($query) {
            $query->where('obsolete', '!=', 1)
                ->orWhereNull('obsolete'); // Use orWhereNull for 'IS NULL'
        })->paginate(50)
            ->appends([
                'idfamilletissu' => $idFamilleTissu,
                'recherche' => $recherche,
                'idcategorietissu' => $idCategorie,
                'idclassematierepremiere' => $idClasse,
                'idutilisationwms' => $idUtilisationWMS,
                'idclient' => $idClient,
                'idfournisseur' => $idFournisseur,
            ]);

        $familleTissu = FamilleTissus::where('id', $idFamilleTissu)->first();
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalEntree = $stockCalcul->count();
        $prixTotal = 0;
        for ($i = 0; $i < $stockCalcul->count(); $i++) {
            $prixTotal += $stockCalcul[$i]->qtestock * $stockCalcul[$i]->prixunitaire;
        }
        $totalMetrage = $stockCalcul->sum('qtestock');

        return view('WMS.Tissu.stockTissu', compact('stock', 'familleTissu', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'totalEntree', 'prixTotal', 'totalMetrage'));
    }
    public function filtreStockTissuObsolete(Request $request)
    {
        $recherche = $request->input('recherche', null);
        $keywords = explode(' ', $recherche);
        $idCategorie = $request->input('idcategorietissu', null);
        $idClasse = $request->input('idclassematierepremiere', null);
        $idUtilisationWMS = $request->input('idutilisationwms', null);
        $idClient = $request->input('idclient', null);
        $idFournisseur = $request->input('idfournisseur', null);
        $idFamilleTissu = $request->input('idfamilletissu', null);
        $tiersModele = StockTissu_Tiers_Modele::where('idclient', $idClient)->get();
        $query = V_Stock_Tissu::where(function ($query) use ($tiersModele, $keywords, $idCategorie, $idClasse, $idUtilisationWMS, $idClient, $idFournisseur, $idFamilleTissu) {
            // Searching with the "keywords" term across multiple fields
            $query->when($keywords, function ($query, $keywords) {
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->where('colonne', 'LIKE', "%{$keyword}%"); // Remplacez par le nom de votre colonne
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
            $query->when($idFamilleTissu, function ($query, $idFamilleTissu) {
                return $query->where('idfamilletissus', $idFamilleTissu);
            });
            if ($tiersModele->isNotEmpty()) {
                $ids = $tiersModele->pluck('idstocktissu')->toArray();
                $query->whereIn('id', $ids);
            }
        });
        $stockCalcul = $query->where(function ($query) {
            $query->where('obsolete', 1); // Use orWhereNull for 'IS NULL'
        })->get();
        $stock = $query->where(function ($query) {
            $query->where('obsolete', 1); // Use orWhereNull for 'IS NULL'
        })->paginate(50)
            ->appends([
                'idfamilletissu' => $idFamilleTissu,
                'recherche' => $recherche,
                'idcategorietissu' => $idCategorie,
                'idclassematierepremiere' => $idClasse,
                'idutilisationwms' => $idUtilisationWMS,
                'idclient' => $idClient,
                'idfournisseur' => $idFournisseur,
            ]);
        $familleTissu = FamilleTissus::where('id', $idFamilleTissu)->first();
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalEntree = $stockCalcul->count();
        $prixTotal = 0;
        for ($i = 0; $i < $stockCalcul->count(); $i++) {
            $prixTotal += $stockCalcul[$i]->qtestock * $stockCalcul[$i]->prixunitaire;
        }
        $totalMetrage = $stockCalcul->sum('qtestock');

        return view('WMS.Tissu.obsolete-tissu', compact('stock', 'familleTissu', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'totalEntree', 'prixTotal', 'totalMetrage'));
    }

    public function filtreSortieTissu(Request $request, $idfamilletissu)
    {
        $debut = $request->input('debut', null);
        $fin = $request->input('fin', null);
        $recherche = $request->input('recherche', null);
        $keywords = explode(' ', $recherche);
        $idCategorie = $request->input('idcategorietissu', null);
        $idClasse = $request->input('idclassematierepremiere', null);
        $idUtilisationWMS = $request->input('idutilisationwms', null);
        $idClient = $request->input('idclient', null);
        $idFournisseur = $request->input('idfournisseur', null);
        $tiersModele = StockTissu_Tiers_Modele::where('idclient', $idClient)->get();
        $idFamilleTissu = $request->input('idfamilletissu', null);
        if ($debut != null && $fin == null) {
            $fin = $debut;
        }
        if ($debut == null && $fin != null) {
            $debut = $fin;
        }
        if ($debut !== null && $fin !== null && $fin < $debut) {
            [$debut, $fin] = [$fin, $debut]; // Swap $debut and $fin
        }
        $query = V_Sortie_Tissu::where(function ($query) use ($tiersModele, $debut, $fin, $keywords, $idCategorie, $idClasse, $idUtilisationWMS, $idClient, $idFournisseur, $idfamilletissu) {
            // Searching with the "keywords" term across multiple fields
            $query->when($keywords, function ($query, $keywords) {
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->where('colonne', 'LIKE', "%{$keyword}%"); // Remplacez par le nom de votre colonne
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
        })->orderBy('datesortie', 'desc')
            ->paginate(50);
        $stockCalcul = $query->where(function ($query) {
            $query->where('obsolete', '!=', 1)
                ->orWhereNull('obsolete'); // Use orWhereNull for 'IS NULL'
        })->get();
        $sortie = $query->where(function ($query) {
            $query->where('obsolete', '!=', 1)
                ->orWhereNull('obsolete'); // Use orWhereNull for 'IS NULL'
        })->paginate(50)
            ->appends([
                'idfamilletissu' => $idFamilleTissu,
                'recherche' => $recherche,
                'idcategorietissu' => $idCategorie,
                'idclassematierepremiere' => $idClasse,
                'idutilisationwms' => $idUtilisationWMS,
                'idclient' => $idClient,
                'idfournisseur' => $idFournisseur,
            ]);
        $familleTissu = FamilleTissus::where('id', $idfamilletissu)->first();
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalSortie = $sortie->count();
        $prixTotal = 0;
        for ($i = 0; $i < $sortie->count(); $i++) {
            $prixTotal += $sortie[$i]->qtesortie * $sortie[$i]->prixunitaire;
        }
        $totalMetrage = $sortie->sum('qtesortie');
        $frequenceSortie = 0;
        if ($debut != null && $fin != null) {
            $diffJour = Carbon::parse($debut)->diffInDays(Carbon::parse($fin)) + 1;
            // Prevent division by zero if the dates are the same
            $frequenceSortie = $diffJour > 0 ? $sortie->count() / $diffJour : $sortie->count();
        }

        return view('WMS.Tissu.accueilSortieTissu', compact('sortie', 'sortie', 'familleTissu', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'totalSortie', 'prixTotal', 'totalMetrage', 'frequenceSortie'));
    }
    public function filtreSortieTissuObsolete(Request $request)
    {
        $debut = $request->input('debut', null);
        $fin = $request->input('fin', null);
        $recherche = $request->input('recherche', null);
        $keywords = explode(' ', $recherche);
        $idCategorie = $request->input('idcategorietissu', null);
        $idClasse = $request->input('idclassematierepremiere', null);
        $idUtilisationWMS = $request->input('idutilisationwms', null);
        $idClient = $request->input('idclient', null);
        $idFournisseur = $request->input('idfournisseur', null);
        $tiersModele = StockTissu_Tiers_Modele::where('idclient', $idClient)->get();

        if ($debut != null && $fin == null) {
            $fin = $debut;
        }
        if ($debut == null && $fin != null) {
            $debut = $fin;
        }
        if ($debut !== null && $fin !== null && $fin < $debut) {
            [$debut, $fin] = [$fin, $debut]; // Swap $debut and $fin
        }
        $query = V_Sortie_Tissu::where(function ($query) use ($tiersModele, $debut, $fin, $keywords, $idCategorie, $idClasse, $idUtilisationWMS, $idClient, $idFournisseur) {
            // Searching with the "keywords" term across multiple fields
            $query->when($keywords, function ($query, $keywords) {
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->where('colonne', 'LIKE', "%{$keyword}%"); // Remplacez par le nom de votre colonne
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

            if ($tiersModele->isNotEmpty()) {
                $ids = $tiersModele->pluck('idstocktissu')->toArray();
                $query->whereIn('id', $ids);
            }
            // Filtering by date range
            if ($debut !== null && $fin !== null) {
                $query->whereBetween('datesortie', [$debut, $fin]);
            }
        });
        $sortieCalcul = $query->where(function ($query) {
            $query->where('obsolete', 1); // Use orWhereNull for 'IS NULL'
        })->get();
        $sortie = $query->where(function ($query) {
            $query->where('obsolete', 1); // Use orWhereNull for 'IS NULL'
        })->paginate(50)
            ->appends([
                'recherche' => $recherche,
                'idcategorietissu' => $idCategorie,
                'idclassematierepremiere' => $idClasse,
                'idutilisationwms' => $idUtilisationWMS,
                'idclient' => $idClient,
                'idfournisseur' => $idFournisseur,
            ]);
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalSortie = $sortieCalcul->count();
        $prixTotal = 0;
        for ($i = 0; $i < $sortieCalcul->count(); $i++) {
            $prixTotal += $sortieCalcul[$i]->qtesortie * $sortieCalcul[$i]->prixunitaire;
        }
        $totalMetrage = $sortieCalcul->sum('qtesortie');
        $frequenceSortie = 0;
        if ($debut != null && $fin != null) {
            $diffJour = Carbon::parse($debut)->diffInDays(Carbon::parse($fin)) + 1;
            // Prevent division by zero if the dates are the same
            $frequenceSortie = $diffJour > 0 ? $sortieCalcul->count() / $diffJour : $sortieCalcul->count();
        }

        return view('WMS.Tissu.sortie-obsolete-tissu', compact('sortie', 'sortie', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur', 'totalSortie', 'prixTotal', 'totalMetrage', 'frequenceSortie'));
    }
}
