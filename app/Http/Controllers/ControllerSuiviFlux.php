<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerSuiviFlux extends Controller
{
    //
    public function suiviFlux(){
        return view('MES.suivi.flux.listeSuiviFlux');
    }
}
