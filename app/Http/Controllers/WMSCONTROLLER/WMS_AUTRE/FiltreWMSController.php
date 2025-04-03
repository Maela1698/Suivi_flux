<?php

namespace App\Http\Controllers\WMSCONTROLLER\WMS_AUTRE;

use App\Http\Controllers\Controller;
use App\Models\ClasseMatierePremiere;
use App\Models\Tiers;
use App\Models\UniteMonetaire;
use App\Models\WMSModel\WMS\Client_StockWMS;
use App\Models\WMSModel\WMS\FamilleWMS;
use App\Models\WMSModel\WMS\Type_wms;
use App\Models\WMSModel\WMS\V_ENTREE_WMS;
use App\Models\WMSModel\WMS\V_SORTIE_WMS;
use App\Models\WMSModel\WMS\V_STOCK_WMS;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FiltreWMSController extends Controller
{
    function filtreEntreeWMS(Request $request, $idtypewms)
    {
        $debut = $request->input('debut', null);
        $fin = $request->input('fin', null);
        $recherche = $request->input('recherche', null);
        $idFamillewms = $request->input('idfamillewms', null);
        $partFamille = "";
        $nomFamille = "";
        if (!empty($idFamillewms)) {
            $partFamille = explode('/', $idFamillewms);
            $nomFamille = $partFamille[1];
            $idFamillewms = $partFamille[0];
        }

        $idClasse = $request->input('idclassematierepremiere', null);
        $partClasse = "";
        $nomClasse = "";
        if (!empty($idClasse)) {
            $partClasse = explode('/', $idClasse);
            $nomClasse = $partClasse[1];
            $idClasse = $partClasse[0];
        }
        $idClient = $request->input('idclient', null);
        $partClient = "";
        $nomClient = "";
        if(!empty($idClient)){
            $partClient = explode('/', $idClient);
            $nomClient = $partClient[1];
            $idClient = $partClient[0];
        }
        $idFournisseur = $request->input('idfournisseur', null);
        $partFournisseur = "";
        $nomFournisseur = "";
        if(!empty($idFournisseur)){
            $partFournisseur = explode('/', $idFournisseur);
            $nomFournisseur = $partFournisseur[1];
            $idFournisseur = $partFournisseur[0];
        }
        $keywords = explode(' ', $recherche);
        if ($debut != null && $fin == null) {
            $fin = $debut;
        }
        if ($debut == null && $fin != null) {
            $debut = $fin;
        }
        if ($debut !== null && $fin !== null && $fin < $debut) {
            [$debut, $fin] = [$fin, $debut]; // Swap $debut and $fin
        }
        $query = V_ENTREE_WMS::where(function ($query) use ($debut, $fin, $keywords, $idFamillewms, $idClasse,  $idClient, $idFournisseur, $idtypewms) {
            // Searching with the "keywords" term across multiple fields
            $query->when($keywords, function ($query, $keywords) {
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->where('colonne', 'ILIKE', "%{$keyword}%"); // Remplacez par le nom de votre colonne
                    }
                });
            });

            // Filtering by specific criteria based on the ID variables
            $query->when($idFamillewms, function ($query, $idFamillewms) {
                return $query->where('idfamillewms', $idFamillewms);
            });
            $query->when($idClasse, function ($query, $idClasse) {
                return $query->where('idclassematierepremiere', $idClasse);
            });

            $query->when($idClient, function ($query, $idClient) {
                return $query->where('idclient', $idClient);
            });
            $query->when($idFournisseur, function ($query, $idFournisseur) {
                return $query->where('idfournisseur', $idFournisseur);
            });
            $query->when($idtypewms, function ($query, $idtypewms) {
                return $query->where('idwms_type', $idtypewms);
            });


            // Filtering by date range
            if ($debut !== null && $fin !== null) {
                $query->whereBetween('dateentree', [$debut, $fin]);
            }
        });
        $entreeWMSCalcul = $query->get();
        $entreeWMS = $query->paginate(50)
            ->appends([
                'recherche' => $recherche,
                'idclassematierepremiere' => $idClasse,
                'idclient' => $idClient,
                'idfournisseur' => $idFournisseur,
                'idfamillewms' => $idFamillewms,
            ]);
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $familleWMS = FamilleWMS::where('idwms_type', $idtypewms)->where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $typeWMS = Type_wms::find($idtypewms);
        $totalEntree = $entreeWMSCalcul->count();
        $prixTotal = 0;
        for ($i = 0; $i < $entreeWMSCalcul->count(); $i++) {
            $prixTotal += $entreeWMSCalcul[$i]->qteentree * $entreeWMSCalcul[$i]->prixeuro;
        }
        $totalMetrage = $entreeWMSCalcul->sum('qteentree');
        $frequenceEntree = 0;
        if ($debut != null && $fin != null) {
            $diffJour = Carbon::parse($debut)->diffInDays(Carbon::parse($fin)) + 1;
            // Prevent division by zero if the dates are the same
            $frequenceEntree = $diffJour > 0 ? $entreeWMSCalcul->count() / $diffJour : $entreeWMSCalcul->count();
        }
        return view('WMS.WMS-Autre.accueil-entree-wms', compact('nomFamille','idFamillewms','debut','fin','recherche','idFournisseur','nomFournisseur','idClient','nomClient','nomClasse','idClasse','entreeWMS', 'typeWMS', 'familleWMS', 'classeMatiere', 'client', 'fournisseur', 'totalEntree', 'prixTotal', 'totalMetrage', 'frequenceEntree'));
    }
    public function filtreStockWMS(Request $request)
    {
        $debut = $request->input('debut', null);
        $fin = $request->input('fin', null);
        $idtypewms = $request->input('idwms_type', null);
        $recherche = $request->input('recherche', null);
        $idFamillewms = $request->input('idfamillewms', null);
        $partFamille = "";
        $nomFamille = "";
        if (!empty($idFamillewms)) {
            $partFamille = explode('/', $idFamillewms);
            $nomFamille = $partFamille[1];
            $idFamillewms = $partFamille[0];
        }

        $idClasse = $request->input('idclassematierepremiere', null);
        $partClasse = "";
        $nomClasse = "";
        if (!empty($idClasse)) {
            $partClasse = explode('/', $idClasse);
            $nomClasse = $partClasse[1];
            $idClasse = $partClasse[0];
        }
        $idClient = $request->input('idclient', null);
        $partClient = "";
        $nomClient = "";
        if(!empty($idClient)){
            $partClient = explode('/', $idClient);
            $nomClient = $partClient[1];
            $idClient = $partClient[0];
        }
        $idFournisseur = $request->input('idfournisseur', null);
        $partFournisseur = "";
        $nomFournisseur = "";
        if(!empty($idFournisseur)){
            $partFournisseur = explode('/', $idFournisseur);
            $nomFournisseur = $partFournisseur[1];
            $idFournisseur = $partFournisseur[0];
        }
        $keywords = explode(' ', $recherche);
        $tiersModele = Client_StockWMS::where('idclient', $idClient)->get();
        $query = V_STOCK_WMS::where(function ($query) use ($keywords, $idClasse, $idFournisseur, $idFamillewms, $tiersModele, $idtypewms) {
            // Searching with the "keywords" term across multiple fields
            $query->when($keywords, function ($query, $keywords) {
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->where('colonne', 'ILIKE', "%{$keyword}%"); // Remplacez par le nom de votre colonne
                    }
                });
            });

            $query->when($idClasse, function ($query, $idClasse) {
                return $query->where('idclassematierepremiere', $idClasse);
            });
            $query->when($idFournisseur, function ($query, $idFournisseur) {
                return $query->where('idfournisseur', $idFournisseur);
            });
            $query->when($idFamillewms, function ($query, $idFamillewms) {
                return $query->where('idfamillewms', $idFamillewms);
            });
            $query->when($idtypewms, function ($query, $idtypewms) {
                return $query->where('idwms_type', $idtypewms);
            });
            if ($tiersModele->isNotEmpty()) {
                $ids = $tiersModele->pluck('idstockwms')->toArray();
                $query->whereIn('id', $ids);
            }
        });


        $stockWMSCalcul = $query->where(function ($query) {
            $query->where('obsolete', '!=', 1)
                ->orWhereNull('obsolete'); // Use orWhereNull for 'IS NULL'
        })->get();
        $stockWMS = $query->where(function ($query) {
            $query->where('obsolete', '!=', 1)
                ->orWhereNull('obsolete'); // Use orWhereNull for 'IS NULL'
        })->paginate(50)
            ->appends([
                'recherche' => $recherche,
                'idclassematierepremiere' => $idClasse,
                'idclient' => $idClient,
                'idfournisseur' => $idFournisseur,
            ]);

        $familleWMS = FamilleWMS::where('idwms_type', $idtypewms)->where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalEntree = $stockWMSCalcul->count();
        $prixTotal = 0;
        $typeWMS = Type_wms::find($idtypewms);
        $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
        for ($i = 0; $i < $stockWMSCalcul->count(); $i++) {
            $prixTotal += $stockWMSCalcul[$i]->qtestock * $stockWMSCalcul[$i]->prixunitaire;
        }
        $totalMetrage = $stockWMSCalcul->sum('qtestock');

        return view('WMS.WMS-Autre.stock-wms', compact('nomFamille','idFamillewms','recherche','idFournisseur','nomFournisseur','idClient','nomClient','nomClasse','idClasse','stockWMS', 'familleWMS', 'classeMatiere', 'uniteMonetaire', 'typeWMS', 'client', 'fournisseur', 'totalEntree', 'prixTotal', 'totalMetrage'));
    }
    public function filtreStockWMSObsolete(Request $request)
    {
        $debut = $request->input('debut', null);
        $fin = $request->input('fin', null);
        $idtypewms = $request->input('idwms_type', null);
        $recherche = $request->input('recherche', null);
        $idFamillewms = $request->input('idfamillewms', null);
        $idClasse = $request->input('idclassematierepremiere', null);
        $idClient = $request->input('idclient', null);
        $idFournisseur = $request->input('idfournisseur', null);
        $keywords = explode(' ', $recherche);
        $tiersModele = Client_StockWMS::where('idclient', $idClient)->get();
        $query = V_STOCK_WMS::where(function ($query) use ($keywords, $idClasse, $idFournisseur, $idFamillewms, $tiersModele, $idtypewms) {
            // Searching with the "keywords" term across multiple fields
            $query->when($keywords, function ($query, $keywords) {
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->where('colonne', 'ILIKE', "%{$keyword}%"); // Remplacez par le nom de votre colonne
                    }
                });
            });

            $query->when($idClasse, function ($query, $idClasse) {
                return $query->where('idclassematierepremiere', $idClasse);
            });
            $query->when($idFournisseur, function ($query, $idFournisseur) {
                return $query->where('idfournisseur', $idFournisseur);
            });
            $query->when($idFamillewms, function ($query, $idFamillewms) {
                return $query->where('idfamillewms', $idFamillewms);
            });
            $query->when($idtypewms, function ($query, $idtypewms) {
                return $query->where('idwms_type', $idtypewms);
            });
            if ($tiersModele->isNotEmpty()) {
                $ids = $tiersModele->pluck('idstockwms')->toArray();
                $query->whereIn('id', $ids);
            }
        });


        $stockWMSCalcul = $query->where(function ($query) {
            $query->where('obsolete',  1); // Use orWhereNull for 'IS NULL'
        })->get();
        $stockWMS = $query->where(function ($query) {
            $query->where('obsolete', 1); // Use orWhereNull for 'IS NULL'
        })->paginate(50)
            ->appends([
                'recherche' => $recherche,
                'idtypewms' => $idtypewms,
                'idclassematierepremiere' => $idClasse,
                'idclient' => $idClient,
                'idfournisseur' => $idFournisseur,
            ]);

        $familleWMS = FamilleWMS::where('idwms_type', $idtypewms)->where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalEntree = $stockWMSCalcul->count();
        $prixTotal = 0;
        $typeWMS = Type_wms::find($idtypewms);
        $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
        for ($i = 0; $i < $stockWMSCalcul->count(); $i++) {
            $prixTotal += $stockWMSCalcul[$i]->qtestock * $stockWMSCalcul[$i]->prixunitaire;
        }
        $totalMetrage = $stockWMSCalcul->sum('qtestock');

        return view('WMS.WMS-Autre.obsolete-accessoire', compact('stockWMS', 'familleWMS', 'classeMatiere', 'uniteMonetaire', 'typeWMS', 'client', 'fournisseur', 'totalEntree', 'prixTotal', 'totalMetrage'));
    }

    public function filtreSortieWMS(Request $request)
    {
        $debut = $request->input('debut', null);
        $fin = $request->input('fin', null);
        $recherche = $request->input('recherche', null);
        $commentaire = $request->input('commentaire', null);
        $idFamillewms = $request->input('idfamillewms', null);

        $idClasse = $request->input('idclassematierepremiere', null);
        $idClient = $request->input('idclient', null);
        $idFournisseur = $request->input('idfournisseur', null);
        $tiersModele = Client_StockWMS::where('idclient', $idClient)->get();
        $idtypewms = $request->input('idwms_type', null);
        $keywords = explode(' ', $recherche);
        if ($debut != null && $fin == null) {
            $fin = $debut;
        }
        if ($debut == null && $fin != null) {
            $debut = $fin;
        }
        if ($debut !== null && $fin !== null && $fin < $debut) {
            [$debut, $fin] = [$fin, $debut]; // Swap $debut and $fin
        }
        $query = V_SORTIE_WMS::where(function ($query) use ($commentaire,$tiersModele, $debut, $fin, $keywords, $idClasse, $idClient, $idFournisseur,$idFamillewms) {
            // Searching with the "keywords" term across multiple fields
            $query->when($keywords, function ($query, $keywords) {
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->where('colonne', 'ILIKE', "%{$keyword}%"); // Remplacez par le nom de votre colonne
                    }
                });
            });

            // Filtering by specific criteria based on the ID variables

            $query->when($idClasse, function ($query, $idClasse) {
                return $query->where('idclassematierepremiere', $idClasse);
            });

            $query->when($idFamillewms, function ($query, $idFamillewms) {
                return $query->where('idfamillewms', $idFamillewms);
            });

            $query->when($commentaire, function ($query, $commentaire) {
                return $query->where('commentaire','ILIKE', "%{$commentaire}%");
            });

            $query->when($idFournisseur, function ($query, $idFournisseur) {
                return $query->where('idfournisseur', $idFournisseur);
            });
            if ($tiersModele->isNotEmpty()) {
                $ids = $tiersModele->pluck('idstockwms')->toArray();
                $query->whereIn('idstockwms', $ids);
            }
            // Filtering by date range
            if ($debut !== null && $fin !== null) {
                $query->whereBetween('datesortie', [$debut, $fin]);
            }
        });
        $typeWMS = Type_wms::find($idtypewms);
        $sortieWMSCalcul = $query->where(function ($query) {
            $query->where('obsolete', '!=', 1)
                ->orWhereNull('obsolete'); // Use orWhereNull for 'IS NULL'
        })->get();
        $sortieWMS = $query->where(function ($query) {
            $query->where('obsolete', '!=', 1)
                ->orWhereNull('obsolete'); // Use orWhereNull for 'IS NULL'
        })->paginate(50)
            ->appends([
                'recherche' => $recherche,
                'idtypewms' => $idtypewms,
                'idclassematierepremiere' => $idClasse,
                'idclient' => $idClient,
                'typeWMS' => $typeWMS,
                'idfournisseur' => $idFournisseur,
                'commentaire' => $commentaire,
            ]);
        $familleWMS = FamilleWMS::where('idwms_type', $idtypewms)->where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalSortie = $sortieWMSCalcul->count();

        $prixTotal = 0;
        for ($i = 0; $i < $sortieWMSCalcul->count(); $i++) {
            $prixTotal += $sortieWMSCalcul[$i]->qtesortie * $sortieWMSCalcul[$i]->prixunitaire;
        }
        $totalMetrage = $sortieWMSCalcul->sum('qtesortie');
        $frequenceSortie = 0;
        if ($debut != null && $fin != null) {
            $diffJour = Carbon::parse($debut)->diffInDays(Carbon::parse($fin)) + 1;
            // Prevent division by zero if the dates are the same
            $frequenceSortie = $diffJour > 0 ? $sortieWMSCalcul->count() / $diffJour : $sortieWMSCalcul->count();
        }

        return view('WMS.WMS-Autre.accueil-sortie-wms', compact('typeWMS', 'familleWMS', 'classeMatiere', 'client', 'fournisseur', 'sortieWMS', 'totalSortie', 'prixTotal', 'totalMetrage', 'frequenceSortie'));
    }

    public function filtreSortieWMSObsolete(Request $request)
    {
        $debut = $request->input('debut', null);
        $fin = $request->input('fin', null);
        $recherche = $request->input('recherche', null);
        $idFamillewms = $request->input('idfamillewms', null);
        $idClasse = $request->input('idclassematierepremiere', null);
        $idClient = $request->input('idclient', null);
        $idFournisseur = $request->input('idfournisseur', null);
        $tiersModele = Client_StockWMS::where('idclient', $idClient)->get();
        $idtypewms = $request->input('idwms_type', null);
        $keywords = explode(' ', $recherche);
        if ($debut != null && $fin == null) {
            $fin = $debut;
        }
        if ($debut == null && $fin != null) {
            $debut = $fin;
        }
        if ($debut !== null && $fin !== null && $fin < $debut) {
            [$debut, $fin] = [$fin, $debut]; // Swap $debut and $fin
        }
        $query = V_SORTIE_WMS::where(function ($query) use ($tiersModele, $debut, $fin, $keywords, $idClasse, $idClient, $idFournisseur) {
            // Searching with the "keywords" term across multiple fields
            $query->when($keywords, function ($query, $keywords) {
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $query->where('colonne', 'ILIKE', "%{$keyword}%"); // Remplacez par le nom de votre colonne
                    }
                });
            });

            // Filtering by specific criteria based on the ID variables

            $query->when($idClasse, function ($query, $idClasse) {
                return $query->where('idclassematierepremiere', $idClasse);
            });

            $query->when($idFournisseur, function ($query, $idFournisseur) {
                return $query->where('idfournisseur', $idFournisseur);
            });
            if ($tiersModele->isNotEmpty()) {
                $ids = $tiersModele->pluck('idstockwms')->toArray();
                $query->whereIn('idstockwms', $ids);
            }
            // Filtering by date range
            if ($debut !== null && $fin !== null) {
                $query->whereBetween('datesortie', [$debut, $fin]);
            }
        });
        $sortieWMSCalcul = $query->where(function ($query) {
            $query->where('obsolete',  1); // Use orWhereNull for 'IS NULL'
        })->get();
        $sortieWMS = $query->where(function ($query) {
            $query->where('obsolete',  1); // Use orWhereNull for 'IS NULL'
        })->paginate(50)
            ->appends([
                'recherche' => $recherche,
                'idtypewms' => $idtypewms,
                'idclassematierepremiere' => $idClasse,
                'idclient' => $idClient,
                'idfournisseur' => $idFournisseur,
            ]);
        $familleWMS = FamilleWMS::where('idwms_type', $idtypewms)->where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $totalSortie = $sortieWMSCalcul->count();
        $typeWMS = Type_wms::find($idtypewms);
        $prixTotal = 0;
        for ($i = 0; $i < $sortieWMSCalcul->count(); $i++) {
            $prixTotal += $sortieWMSCalcul[$i]->qtesortie * $sortieWMSCalcul[$i]->prixunitaire;
        }
        $totalMetrage = $sortieWMSCalcul->sum('qtesortie');
        $frequenceSortie = 0;
        if ($debut != null && $fin != null) {
            $diffJour = Carbon::parse($debut)->diffInDays(Carbon::parse($fin)) + 1;
            // Prevent division by zero if the dates are the same
            $frequenceSortie = $diffJour > 0 ? $sortieWMSCalcul->count() / $diffJour : $sortieWMSCalcul->count();
        }

        return view('WMS.WMS-Autre.obsolete-accessoire', compact('typeWMS', 'familleWMS', 'classeMatiere', 'client', 'fournisseur', 'sortieWMS', 'totalSortie', 'prixTotal', 'totalMetrage', 'frequenceSortie'));
    }
}
