<?php

namespace App\Http\Controllers\MES;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerDemande extends Controller
{
    //
    public function getDemandeConfirme(){
        return view('MES.demande.listeDemandeConfirme');
    }

    public function getFicheDemandeConfirme(){
        return view('MES.demande.ficheDemandeConfirme');
    }
}
