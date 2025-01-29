<?php

namespace App\Http\Controllers\COMPLIANCECONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\COMPLIANCE\AvancementPlanAction;
use App\Models\COMPLIANCE\Constat;
use App\Models\COMPLIANCE\PlanAction;
use App\Models\COMPLIANCE\Section;
use App\Models\Planning;
use App\Services\ServicesConstat;
use Illuminate\Http\Request;

class ControllerCompliance extends Controller
{
    public function listeConstat(Request $request)
    {
        $date = $request->input('date');
        $section = $request->input('section');
        $priorite = $request->input('priorite');
        $condition = "";
        if (!empty($date)) {
            $condition = $condition . " and dateconstat='" . $date . "'";
        }
        if (!empty($section)) {
            $condition = $condition . " and section='" . $section . "'";
        }
        if (!empty($priorite)) {
            $condition = $condition . " and priorite=" . $priorite;
        }
        $fichier = Constat::getAllFichier();
        $section = Section::getAllSection();
        $condition = $condition . " order by constat_id desc";
        $constat = Constat::getConstatByTypeAudit(1, $condition);

        return view('COMPLIANCE.listeConstat', compact('constat', 'section', 'fichier'));
    }

    public function ajoutConstat(Request $request)
    {

        $request->validate([
            'fichierConstat' => 'image|mimes:jpeg,png,jpg,gif', // Validation
        ]);

        $dateConstat = $request->input('dateConstat');
        $section = $request->input('section');
        $priorite = $request->input('priorite');
        $description = $request->input('description');

        $constat = new Constat();
        $constat->insertConstat($dateConstat, $section, $priorite, $description, 1);

        $dernierConstat = Constat::getLastConstat();

        if ($request->hasFile('fichierConstat')) {
            $s = new ServicesConstat;
            $file = $request->file('fichierConstat');
            $filename = $s->uploadImage("uploads/constat",$file);
            // Récupérer le nom d'origine du fichier
            $originalFileName = $file->getClientOriginalName();

            $fichier = new Constat();
            $fichier->insertFichierConstat($filename, $dernierConstat[0]->id);
        }else{
            $fichier = new Constat();
            $fichier->insertFichierConstat("", $dernierConstat[0]->id);
        }
        $fichier = Constat::getAllFichier();
        return redirect()->route(route: 'COMPLIANCE.listeConstat');
    }

    public function modifConstatInterne(Request $request)
    {

        $request->validate([
            'fichierRecent' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $dateConstat = $request->input('dateConstat');
        $idConstat = $request->input('idConstat');
        $priorite = $request->input('priorite');
        $description = $request->input('description');

        Constat::updateConstat($dateConstat, $priorite, $description, $idConstat);

        if ($request->hasFile('fichierRecent')) {
            $s = new ServicesConstat;
            $file = $request->file('fichierRecent');
            $filename = $s->uploadImage("uploads/constat",$file);
            Constat::updateFichierConstat($filename,$idConstat);
        }
        return redirect()->route('COMPLIANCE.detailConstat', ['id' => $idConstat]);
    }


    public function detailConstat(Request $request)
    {
        $id = $request->input('id');
        $constat = Constat::getConstatById($id);
        $fichier = Constat::listeFichierByConstat($constat[0]->constat_id);
        $planAction = PlanAction::listePlanActionByConstat($id);
        $section = Section::getAllSection();
        return view('COMPLIANCE.detailConstat', compact('section', 'planAction', 'fichier', 'constat'));
    }

    public function rechercheEmployeByNomPrenom(Request $request)
    {
        $query = $request->get('nom');
        $employe = PlanAction::getListeEmployeByNomPrenom($query);
        return response()->json($employe);
    }

    public function ajoutPlanAction(Request $request)
    {
        $idConstat = $request->input('idConstat');
        $dateOper = $request->input('dateOper');
        $numero = $request->input('numero');
        $moyen = $request->input('moyen');
        $priorite = $request->input('priorite');
        $deadline = $request->input('deadline');
        $nomEmploye = $request->input('nomEmploye');
        $idEmploye = $request->input('idEmploye');
        $commentaire = $request->input('commentaire');
        $planAction = new PlanAction();
        $planAction->insertPlanAction($numero, $idConstat, $moyen, $dateOper, $priorite, $idEmploye, $deadline, $commentaire);
        return redirect()->route(route: 'COMPLIANCE.listePlanAction');
    }

    public function listePlanAction(Request $request)
    {
        $section = $request->input('section');
        $priorite = $request->input('priorite');
        $idEmploye = $request->input('idEmploye');
        $condition = "";
        if (!empty($section)) {
            $condition = $condition . " and section='" . $section . "'";
        }
        if (!empty($priorite)) {
            $condition = $condition . " and priorite=" . $priorite;
        }
        if (!empty($idEmploye)) {
            $condition = $condition . " and responsable_id=" . $idEmploye;
        }
        $condition = $condition . " order by planaction_id desc";
        $planAction = PlanAction::listePlanAction($condition);
        $section = Section::getAllSection();
        return view('COMPLIANCE.planAction', compact('section', 'planAction'));
    }

    public function ajoutAvancement(Request $request)
    {
        $idPlanAction = $request->input('idPlanAction');
        $dateOper = $request->input('dateOper');
        $designation = $request->input('designation');
        $avancement = $request->input('avancement');
        $dernierAvancement = AvancementPlanAction::getLastAvancement($idPlanAction);
        $erreur = "";
        if (count($dernierAvancement) > 0) {
            if ($dernierAvancement[0]->dateavancement >= $dateOper) {
                $erreur = "La date doit être superieur a " . $dernierAvancement[0]->dateavancement . "\n";
            }
            if ($dernierAvancement[0]->avancement >= $avancement) {
                $erreur = $erreur . " L'avancement doit être superieur a " . $dernierAvancement[0]->avancement;
            }
            if (empty($erreur)) {
                $avancementPlan = new AvancementPlanAction();
                $avancementPlan->insertAvancementPlanAction($idPlanAction, $dateOper, $designation, $avancement);
                return redirect()->route(route: 'COMPLIANCE.listePlanAction');
            } else {
                return redirect()->route('COMPLIANCE.listePlanAction')
                    ->with('error', $erreur);
            }
        } elseif (count($dernierAvancement) == 0) {
            $avancementPlan = new AvancementPlanAction();
            $avancementPlan->insertAvancementPlanAction($idPlanAction, $dateOper, $designation, $avancement);
            return redirect()->route(route: 'COMPLIANCE.listePlanAction');
        }
    }

    public function detailPlanAction(Request $request)
    {
        $id = $request->input('id');
        $planAction = PlanAction::listePlanActionById($id);
        return view('COMPLIANCE.detailPlanAction', compact('planAction'));
    }
}
