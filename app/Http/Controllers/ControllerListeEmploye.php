<?php

namespace App\Http\Controllers;

use App\Models\ListeEmploye;
use Illuminate\Http\Request;

class ControllerListeEmploye extends Controller
{
    public function pageLogin(Request $request)
    {
        return view('loginUtilisateur');
    }

    public function unauthorized(Request $request)
    {
        return view('erreur');
    }
    public function loginUtilisateur(Request $request)
    {
        $pseudo = $request->input('pseudo');
        $mdp = $request->input('mdp');
        $employe = ListeEmploye::loginEmploye($pseudo, $mdp);
        if (count($employe) != 0) {
            $request->session()->put('employe', $employe);
            return redirect()->route('CRM.listeDemande');
        }else{
            return redirect()->route('pageLogin')
            ->with('messageErreurLoginIncorrecte', 'Pseudo ou mot de passe incorrecte');
        }
    }
}
