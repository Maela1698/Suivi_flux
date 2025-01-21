<?php

namespace App\Http\Controllers\WMSCONTROLLER\WMS_AUTRE;

use App\Http\Controllers\Controller;
use App\Models\ClasseMatierePremiere;
use App\Models\Tiers;
use App\Models\WMSModel\WMS\FamilleWMS;
use App\Models\WMSModel\WMS\Type_wms;
use App\Models\WMSModel\WMS\V_ENTREE_WMS;
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
        $idClasse = $request->input('idclassematierepremiere', null);
        $idClient = $request->input('idclient', null);
        $idFournisseur = $request->input('idfournisseur', null);
        if ($debut != null && $fin == null) {
            $fin = $debut;
        }
        if ($debut == null && $fin != null) {
            $debut = $fin;
        }
        if ($debut !== null && $fin !== null && $fin < $debut) {
            [$debut, $fin] = [$fin, $debut]; // Swap $debut and $fin
        }
        $entreeWMS = V_ENTREE_WMS::where(function ($query) use ($debut, $fin, $recherche, $idFamillewms, $idClasse,  $idClient, $idFournisseur,) {
            // Searching with the "recherche" term across multiple fields
            $query->when($recherche, function ($query, $recherche) {
                $query->where(function ($query) use ($recherche) {
                    $query->where('designation', 'ilike', '%' . $recherche . '%')
                        ->orWhere('couleur', 'ilike', '%' . $recherche . '%')
                        ->orWhere('categorie', 'ilike', '%' . $recherche . '%')
                        ->orWhere('reference', 'ilike', '%' . $recherche . '%')
                        ->orWhere('modele', 'ilike', '%' . $recherche . '%')
                        ->orWhere('saison', 'ilike', '%' . $recherche . '%')
                        ->orWhere('commentaire', 'ilike', '%' . $recherche . '%')
                        ->orWhere('numbl', 'ilike', '%' . $recherche . '%')
                        ->orWhere('numbc', 'ilike', '%' . $recherche . '%');
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


            // Filtering by date range
            if ($debut !== null && $fin !== null) {
                $query->whereBetween('dateentree', [$debut, $fin]);
            }
        })->orderBy('dateentree', 'desc')
            ->take(100)
            ->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $familleWMS = FamilleWMS::where('idwms_type', $idtypewms)->where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();
        $typeWMS = Type_wms::find($idtypewms);
        $totalEntree = $entreeWMS->count();
        $prixTotal = 0;
        for ($i = 0; $i < $entreeWMS->count(); $i++) {
            $prixTotal += $entreeWMS[$i]->qteentree * $entreeWMS[$i]->prixunitaire;
        }
        $totalMetrage = $entreeWMS->sum('qteentree');
        $frequenceEntree = 0;
        if ($debut != null && $fin != null) {
            $diffJour = Carbon::parse($debut)->diffInDays(Carbon::parse($fin)) + 1;
            // Prevent division by zero if the dates are the same
            $frequenceEntree = $diffJour > 0 ? $entreeWMS->count() / $diffJour : $entreeWMS->count();
        }
        return view('WMS.WMS-Autre.accueil-entree-wms', compact('entreeWMS', 'typeWMS', 'familleWMS', 'classeMatiere', 'client', 'fournisseur', 'totalEntree', 'prixTotal', 'totalMetrage', 'frequenceEntree'));
    }
}
