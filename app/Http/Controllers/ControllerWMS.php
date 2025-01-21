<?php

namespace App\Http\Controllers;

use App\Models\BonCommande;
use App\Models\CategorieTissus;
use App\Models\ClasseMatierePremiere;
use App\Models\FamilleTissus;
use App\Models\Tiers;
use App\Models\UniteMesureMatierePremiere;
use App\Models\UniteMonetaire;
use App\Models\V_donne_bc;
use App\Models\WMSModel\Cellule;
use App\Models\WMSModel\Parite;
use App\Models\WMSModel\Rack;
use App\Models\WMSModel\SectionWMS;
use App\Models\WMSModel\StockTissu;
use App\Models\WMSModel\UtilisationWMS;
use App\Models\WMSModel\V_Entree_Tissu;
use App\Models\WMSModel\V_Sortie_Tissu;
use App\Models\WMSModel\V_Stock_Tissu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ControllerWMS extends BaseController
{
    //?------------------------------ Lien Page ------------------------------?//
    public function wms_page_accueil()
    {
        return view('WMS.page.accueilWMS');
    }

    public function wms_page_parite()
    {
        $parite = Parite::where('etat', 0)->paginate(5);

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
                    $query->orWhere($column, 'ILIKE', '%'.$searchTerm.'%');
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
        $historyEntree = V_Entree_Tissu::where('idfamilletissus', $idFamilleTissu)->get();

        return view('WMS.Tissu.accueilEntreeTissu', compact('historyEntree', 'familleTissu'));
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
        $stock = V_Stock_Tissu::where('idfamilletissus', $idFamilleTissu)->get();

        return view('WMS.Tissu.stockTissu', compact('stock'));
    }

    public function wms_page_tissu_sortie_accueil($idFamilleTissu)
    {
        $sortie = V_Sortie_Tissu::where('idfamilletissus', $idFamilleTissu)->get();

        return view('WMS.Tissu.accueilSortieTissu', compact('sortie'));
    }

    public function wms_page_tissu_sortie($idStock)
    {
        $stock = V_Stock_Tissu::where('id', $idStock)->first();
        $catTissu = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();

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
                    $query->orWhere($column, 'ILIKE', '%'.$searchTerm.'%');
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
}
