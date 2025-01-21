<?php

namespace App\Http\Controllers\WMSCONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\Tiers;
use App\Models\V_donne_bc;
use App\Models\WMSModel\V_Rack_Cellule;
use Illuminate\Http\Request;

class AutoCompleteController extends Controller
{
    public function autocomplete_num_bc(Request $request)
    {
        $query = $request->get('query');
        $data = V_donne_bc::where('numerobc', 'ilike', '%'.$query.'%')
            ->select('id_donne_bc', 'numerobc')
            ->distinct()
            ->get();

        return response()->json($data);
    }

    //? désignation tissu
    public function autocomplete_des_tissu(Request $request)
    {
        $query = $request->get('query');
        $data = V_donne_bc::where('numerobc', 'ilike', '%'.$query.'%')
            ->select('id_donne_bc', 'des_tissus')
            ->get();

        return response()->json($data);
    }

    //? réference tissu
    public function autocomplete_ref_tissu(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $query = $request->get('query');
        $data = V_donne_bc::where(function ($q) use ($query) {
            $q->where('numerobc', 'ilike', '%'.$query.'%')
                ->orWhere('des_tissu', 'ilike', '%'.$query.'%');
        })
            ->select('id_donne_bc', 'ref_tissus')
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No results found'], 404);
        }

        return response()->json($data);
    }

    //? Couleur tissu
    public function autocomplete_couleur_tissu(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $query = $request->get('query');
        $data = V_donne_bc::where(function ($q) use ($query) {
            $q->where('numerobc', 'ilike', '%'.$query.'%')
                ->orWhere('des_tissu', 'ilike', '%'.$query.'%')
                ->orWhere('ref_tissus', 'ilike', '%'.$query.'%');
        })
            ->select('id_donne_bc', 'couleur')
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No results found'], 404);
        }

        return response()->json($data);
    }

    public function autocomplete_cellule_tissu(Request $request)
    {
        $query = $request->get('query');
        $data = V_Rack_Cellule::where(function ($q) use ($query) {
            $q->where('designation', 'ilike', '%'.$query.'%');
        })
            ->select('idcellule', 'des_cellule', 'des_rack', 'designation')
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No results found'], 404);
        }

        return response()->json($data);
    }

    public function autocomplete_fournisseur(Request $request)
    {
        $query = $request->get('query');
        $data = Tiers::where(function ($q) use ($query) {
            $q->where('nomtier', 'ilike', '%'.$query.'%')
                ->orwhere('idacteur', 2);
        })
            ->select('id', 'nomtier')
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No results found'], 404);
        }

        return response()->json($data);
    }

    // TODO: A prendre les valeurs sur la table stocktissu_tiers_modele, Idem pour les modeles
    public function autocomplete_client(Request $request)
    {
        $query = $request->get('query');
        $data = Tiers::where(function ($q) use ($query) {
            $q->where('nomtier', 'ilike', '%'.$query.'%')
                ->orwhere('idacteur', 1);
        })
            ->select('id', 'nomtier')
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No results found'], 404);
        }

        return response()->json($data);
    }
}
