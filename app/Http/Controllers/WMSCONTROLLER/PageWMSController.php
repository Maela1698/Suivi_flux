<?php

namespace App\Http\Controllers\WMSCONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\BonCommande;
use App\Models\ClasseMatierePremiere;
use App\Models\Tiers;
use App\Models\UniteMesureMatierePremiere;
use App\Models\UniteMonetaire;
use App\Models\V_donne_bc;
use App\Models\WMSModel\WMS\EntreeWMS;
use App\Models\WMSModel\WMS\FamilleWMS;
use App\Models\WMSModel\WMS\SortieWMS;
use App\Models\WMSModel\WMS\Type_wms;
use App\Models\WMSModel\WMS\V_ENTREE_WMS;
use App\Models\WMSModel\WMS\V_RESERVATION_WMS;
use App\Models\WMSModel\WMS\V_RETOUR_WMS;
use App\Models\WMSModel\WMS\V_SORTIE_WMS;
use App\Models\WMSModel\WMS\V_STOCK_WMS;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageWMSController extends Controller
{
    function page_magasin_wms(Request $request, $idtypewms)
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
        $tscf = BonCommande::getTscf();
        $etat = BonCommande::getAllEtatBc();
        $typeWMS = Type_wms::find($idtypewms);
        return view('WMS.page.magasin-wms', compact('typebc', 'donne', 'today', 'tscf', 'etat', 'idtypewms', 'typeWMS'));
    }
    function page_accueil_entree_wms($idtypewms)
    {
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $familleWMS = FamilleWMS::where('idwms_type', $idtypewms)->where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $typeWMS = Type_wms::find($idtypewms);
        $entreeWMS = V_ENTREE_WMS::where('idwms_type', $idtypewms)->get();
        $totalEntree = $entreeWMS->count();
        $prixTotal = 0;
        for ($i = 0; $i < $entreeWMS->count(); $i++) {
            $prixTotal += $entreeWMS[$i]->qteentree * $entreeWMS[$i]->prixunitaire;
        }
        return view('WMS.WMS-Autre.accueil-entree-wms', compact('typeWMS', 'entreeWMS', 'totalEntree', 'prixTotal', 'client', 'fournisseur', 'familleWMS', 'classeMatiere'));
    }
    function page_entree_wms($idtypewms)
    {
        $familleWMS = FamilleWMS::where('idwms_type', $idtypewms)->where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $uniteCommande = UniteMesureMatierePremiere::where('etat', 0)->get();
        $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
        $typeWMS = Type_wms::find($idtypewms);
        return view('WMS.WMS-Autre.entree-wms', compact('typeWMS', 'classeMatiere', 'client', 'fournisseur', 'uniteCommande', 'uniteMonetaire', 'familleWMS'));
    }
    function page_stock_wms($idtypewms)
    {
        $familleWMS = FamilleWMS::where('idwms_type', $idtypewms)->where('etat', 0)->get();
        $stockWMS = [];
        $WMSStock = V_STOCK_WMS::where('idwms_type', $idtypewms)
            ->where('obsolete', 0)
            ->get();

        foreach ($WMSStock as $WMSStocks) {
            // Include idunitemonetaire in the WMSStock collection
            $WMSStocks->idunitemonetaire = EntreeWMS::where('idstockwms', $WMSStocks->id)->first()->value('idunitemonetaire');
            $WMSStocks->numbc = EntreeWMS::where('idstockwms', $WMSStocks->id)->first()->value('numbc');
            $WMSStocks->qtecommande = EntreeWMS::where('idstockwms', $WMSStocks->id)->first()->value('qtecommande');
            $stockWMS[] = $WMSStocks;
        }
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $typeWMS = Type_wms::find($idtypewms);
        $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
        return view('WMS.WMS-Autre.stock-wms', compact('familleWMS', 'typeWMS', 'classeMatiere', 'client', 'fournisseur', 'stockWMS', 'uniteMonetaire'));
    }
    function page_obsolete_accessoire()
    {
        $familleWMS = FamilleWMS::where('idwms_type', 1)->where('etat', 0)->get();
        $stockWMS = [];
        $WMSStock = V_STOCK_WMS::where('idwms_type', 1)->where('obsolete', 1)
            ->get();

        foreach ($WMSStock as $WMSStocks) {
            // Include idunitemonetaire in the WMSStock collection
            $WMSStocks->idunitemonetaire = EntreeWMS::where('idstockwms', $WMSStocks->id)->first()->value('idunitemonetaire');
            $WMSStocks->numbc = EntreeWMS::where('idstockwms', $WMSStocks->id)->first()->value('numbc');
            $WMSStocks->qtecommande = EntreeWMS::where('idstockwms', $WMSStocks->id)->first()->value('qtecommande');
            $stockWMS[] = $WMSStocks;
        }
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $typeWMS = Type_wms::find(1);
        $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
        return view('WMS.WMS-Autre.obsolete-accessoire', compact('familleWMS', 'typeWMS', 'classeMatiere', 'client', 'fournisseur', 'stockWMS', 'uniteMonetaire'));
    }
    function page_accueil_sortie_wms($idtypewms)
    {
        $familleWMS = FamilleWMS::where('idwms_type', $idtypewms)->where('etat', 0)->get();
        $sortieWMS = V_SORTIE_WMS::where('idwms_type', $idtypewms)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $typeWMS = Type_wms::find($idtypewms);
        return view('WMS.WMS-Autre.accueil-sortie-wms', compact('typeWMS', 'classeMatiere', 'client', 'fournisseur', 'sortieWMS'));
    }
    // function page_sortie_wms($idtypewms)
    // {
    //     $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
    //     $client = Tiers::where('idacteur', 1)->get();
    //     $fournisseur = Tiers::where('idacteur', 2)->get();
    //     $uniteCommande = UniteMesureMatierePremiere::where('etat', 0)->get();
    //     $uniteMonetaire = UniteMonetaire::where('etat', 0)->get();
    //     $typeWMS = Type_wms::find($idtypewms);
    //     return view('WMS.WMS-Autre.sortie-wms', compact('typeWMS', 'classeMatiere', 'client', 'fournisseur', 'uniteCommande', 'uniteMonetaire'));
    // }
    function page_retour_wms($idtypewms)
    {
        $retourWMS = V_RETOUR_WMS::where('idwms_type', $idtypewms)->where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $typeWMS = Type_wms::find($idtypewms);
        return view('WMS.WMS-Autre.retour-wms', compact('typeWMS', 'classeMatiere', 'client', 'fournisseur', 'retourWMS'));
    }
    function wms_page_reservation_wms()
    {
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $historyReservation = V_RESERVATION_WMS::all();

        return view('WMS.WMS-Autre.reservation-wms', compact('historyReservation', 'classeMatiere', 'client', 'fournisseur'));
    }
}
