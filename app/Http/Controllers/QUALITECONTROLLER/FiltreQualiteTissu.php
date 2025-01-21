<?php

namespace App\Http\Controllers\QUALITECONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\CategorieTissus;
use App\Models\ClasseMatierePremiere;
use App\Models\FamilleTissus;
use App\Models\Tiers;
use App\Models\WMSModel\UtilisationWMS;
use App\Models\WMSModel\V_Entree_Tissu;
use Illuminate\Http\Request;

class FiltreQualiteTissu extends Controller
{
    public function filtreEntreeTissu(Request $request)
    {
        $debut = $request->input('debut', null);
        $fin = $request->input('fin', null);
        $recherche = $request->input('recherche', null);
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
        $historyEntree = V_Entree_Tissu::where(function ($query) use ($debut, $fin, $recherche, $idCategorie, $idClasse, $idUtilisationWMS, $idClient, $idFournisseur, $idFamilleTissu) {
            // Searching with the "recherche" term across multiple fields
            $query->when($recherche, function ($query, $recherche) {
                $query->where(function ($query) use ($recherche) {
                    $query->where('numerofacture', 'ilike', '%' . $recherche . '%')
                        ->orWhere('couleur', 'ilike', '%' . $recherche . '%')
                        ->orWhere('categorie', 'ilike', '%' . $recherche . '%')
                        ->orWhere('reftissu', 'ilike', '%' . $recherche . '%')
                        ->orWhere('des_tissu', 'ilike', '%' . $recherche . '%')
                        ->orWhere('modele', 'ilike', '%' . $recherche . '%')
                        ->orWhere('saison', 'ilike', '%' . $recherche . '%')
                        ->orWhere('commentaire', 'ilike', '%' . $recherche . '%')
                        ->orWhere('numerobc', 'ilike', '%' . $recherche . '%');
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
        })->orderBy('dateentree', 'desc')
            ->take(100)
            ->get();
        $familleTissu = FamilleTissus::where('etat', 0)->get();
        $categorie = CategorieTissus::where('etat', 0)->get();
        $classeMatiere = ClasseMatierePremiere::where('etat', 0)->get();
        $utilisation = UtilisationWMS::where('etat', 0)->get();
        $client = Tiers::where('idacteur', 1)->get();
        $fournisseur = Tiers::where('idacteur', 2)->get();

        return view('WMS.QUALITE.Tissu.EntreeTissu', compact('historyEntree', 'familleTissu', 'categorie', 'classeMatiere', 'utilisation', 'client', 'fournisseur'));
    }
}
