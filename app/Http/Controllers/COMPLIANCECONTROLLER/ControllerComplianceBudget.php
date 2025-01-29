<?php

namespace App\Http\Controllers\COMPLIANCECONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\COMPLIANCE\Budget;
use App\Models\COMPLIANCE\Norme;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControllerComplianceBudget extends Controller
{
    public function listeBudgetCompliance(Request $request)
    {
        $norme = Norme::listeNorme();
        $budget = Budget::listeBudgetCompliance();
        return view('COMPLIANCE.budgetCompliance', compact('budget', 'budget', 'norme'));
    }

    public function ajoutBudgetCompliance(Request $request)
    {
        $dateOper = $request->input('dateOper');
        $annee = Carbon::parse($dateOper)->year;
        $norme = $request->input('norme');
        $budgetReel = $request->input('budgetReel');
        $budgetPrevisionnel = $request->input('budgetPrevisionnel');
        $budgetExiste = Budget::isBudgetAnneeExiste($annee, $norme);
        if ($budgetExiste != 0) {
            return redirect()->route(route: 'COMPLIANCEBUDGET.listeBudgetCompliance')->with('error', 'Budget déjà existant pour cette année');
        } elseif ($budgetExiste == 0) {
            $budget = new Budget();
            $budget->insertBudget($norme, $annee, $dateOper, $budgetReel, $budgetPrevisionnel);
            return redirect()->route(route: 'COMPLIANCEBUDGET.listeBudgetCompliance');
        }
    }

    public function detailBudgetNorme(Request $request)
    {
       $annee= $request->input('annee');
        $norme= $request->input('norme');
        $budget = Budget::detailBudgetByNorme($norme, $annee);
        $budgetCompliance = Budget::listeBudgetComplianceByNormeAnnee($norme, $annee);
        return view('COMPLIANCE.detailBudgetCompliance', compact('budgetCompliance','budget'));
    }

    public function modifBudgetReel(Request $request)
    {
       $dateEntree= $request->input('dateEntree');
        $budgetReel= $request->input('budgetReel');
        $annee= $request->input('annee');
        $norme= $request->input('norme');
        $budgetPrevisionnel= $request->input('budgetPrevisionnel');
        $dernierBudget = Budget::dernierBudgetNorme($norme, $annee);
        $dernierMontant = $dernierBudget[0]->montant;
        $montant = $budgetReel-$dernierMontant;
        // dd($montant);
        $budget = new Budget();
        $budget->insertBudget($norme, $annee, $dateEntree, $montant, $budgetPrevisionnel);
        return redirect()->route('COMPLIANCEBUDGET.detailBudgetNorme', ['annee' => $annee, 'norme'=>$norme]);
    }
}
