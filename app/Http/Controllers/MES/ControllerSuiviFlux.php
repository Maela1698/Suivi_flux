<?php

namespace App\Http\Controllers\MES;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerSuiviFlux extends Controller
{
    //
    public function suiviFlux(){
        return view('MES.suivi.flux.listeSuiviFlux');
    }
}
