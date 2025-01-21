<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerMES extends Controller
{
    //
    public function suiviFlux(){
        return view('MES.suiviFlux.listeSuiviFlux');
    }
}
