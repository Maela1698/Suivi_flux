<?php

namespace App\Http\Controllers\MES;

use App\Http\Controllers\Controller;
use App\Models\MES\SuiviFluxMes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControllerSuiviFlux extends Controller
{

    public function suiviFlux(){
        return view('MES.suivi.flux.listeSuiviFlux');
    }

    public function modificationStadeRAD(Request $request)
    {
        $qteCoupe = $request->input('qteCoupe');
        $qteEntreeChaine = $request->input('qteEntreeChaine');
        $qteTransferes = $request->input('qteTransferes');
        $pretALivrer = $request->input('pretALivrer');
        $qteDejaLivre = $request->input('qteDejaLivre');
        $entreeRepassage = $request->input('entreeRepassage');
        $sortieRepassage = $request->input('sortieRepassage');
        $idSuivi = $request->input('idSuivi');
        $dateActuelle = Carbon::now()->format('Y-m-d');
        SuiviFluxMes::updateSuiviFluxMes($dateActuelle,$qteCoupe,$qteEntreeChaine,$qteTransferes,$pretALivrer,$qteDejaLivre,$entreeRepassage,$sortieRepassage,$idSuivi);
        return redirect()->route('RAD.detailRad');
    }
}
