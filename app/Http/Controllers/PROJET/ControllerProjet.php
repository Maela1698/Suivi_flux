<?php

namespace App\Http\Controllers\PROJET;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ControllerProjet extends Controller
{
    //
    public function readPortefeuille():View {
        return view('projet/page/portefeuille');
    }
}
