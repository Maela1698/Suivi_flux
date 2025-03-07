<?php

namespace App\Http\Controllers\COMPLIANCECONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\COMPLIANCE\AvancementPlanAction;
use App\Models\COMPLIANCE\Constat;
use App\Models\COMPLIANCE\PlanAction;
use App\Models\COMPLIANCE\Section;
use App\Models\COMPLIANCE\VPlanAction;
use App\Models\ListeEmploye;
use App\Models\Planning;
use App\Models\VListEmploye;
use App\Services\ServicesConstat;
use Carbon\Carbon;
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
        $section = Section::all();

        $employees = VListEmploye::all();

        $planActions = VPlanAction::where('audit_id',null);

        $deadline_debut = null;
        $deadline_fin = null;

        $selectedSection = null;
        if ($request->has('id_section') && $request->id_section != '') {
            $selectedSection = Section::where('id',$request->id_section)->first();
            if($selectedSection){
                $planActions = $planActions->where('id_section', $selectedSection->id);
            }
        }

        $selectedPriorite = $request->priorite ?? '';
        if (!empty($selectedPriorite)) {
            $planActions = $planActions->where('priorite', $selectedPriorite);
        }

        $selectedResponsableId = $request->responsable_id ?? null;
        if (!empty($selectedResponsableId)) {
            $planActions = $planActions->where('responsable_id', $selectedResponsableId);
        }

        $selectedDateRange = $request->daterange ?? '';
        if (!empty($selectedDateRange)) {
            list($deadline_debut,$deadline_fin) = explode(' au ',$selectedDateRange);
            $deadline_debut = Carbon::createFromFormat('d-m-Y', $deadline_debut);
            $deadline_fin = Carbon::createFromFormat('d-m-Y', $deadline_fin); 
            $planActions = $planActions->whereBetween('deadline',[$deadline_debut,$deadline_fin]);
        }

        $planActions = $planActions->orderBy('planaction_id','desc')->get();
        return view('COMPLIANCE.planAction', compact('section', 'planActions','selectedSection','selectedPriorite', 'employees','selectedResponsableId'));
    }

    public function planActionApercu(Request $request){
        $planActions = VPlanAction::where('audit_id',null);
        $section = null;
        $priorite = '';
        $responsable = null;
    
        if ($request->has('id_section') && !empty($request->id_section)) {
            $planActions->where('id_section', $request->id_section);
            $section = Section::find($request->id_section);
        }
    
        if ($request->has('priorite') && !empty($request->priorite)) {
            $planActions->where('priorite', $request->priorite);
        }
    
        if ($request->has('responsable_id') && !empty($request->responsable_id)) {
            $planActions->where('responsable_id', $request->responsable_id);
            $responsable = ListeEmploye::find($request->responsable_id);
        }

        
    
        $planActions = $planActions->orderBy('planaction_id','desc')->get();
    
        return view('COMPLIANCE.auditInterne.planActionApercuPdf', compact('planActions','section','responsable'));
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
