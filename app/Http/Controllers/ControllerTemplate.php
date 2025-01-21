<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerTemplate extends Controller
{
    public function liste(Request $request)
    {

        return view('TEMPLATE.liste');
    }

}
