<?php

namespace App\Http\Controllers\COMPLIANCECONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\COMPLIANCE\AvancementPlanAction;
use App\Models\COMPLIANCE\Constat;
use App\Models\COMPLIANCE\NewConstat;
use App\Models\COMPLIANCE\PlanAction;
use App\Models\COMPLIANCE\ResponsableSection;
use App\Models\COMPLIANCE\Section;
use App\Models\COMPLIANCE\VConstat;
use App\Models\COMPLIANCE\VPlanAction;
use App\Models\COMPLIANCE\VResponsableLibre;
use App\Models\COMPLIANCE\VResponsableSection;
use App\Models\ListeEmploye;
use App\Models\Planning;
use App\Models\VListEmploye;
use App\Services\ServicesConstat;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class ControllerCompliance extends Controller
{
        /**
     * Vérifie si la nouvelle valeur d'avancement est inférieure à l'ancienne.
     *
     * @param int $newAvancement La nouvelle valeur d'avancement.
     * @param int $currentAvancement La valeur actuelle d'avancement.
     * @throws Exception Si la nouvelle valeur est inférieure à l'actuelle.
     */
    private function verifyAvancement(int $newAvancement, int $currentAvancement): void{
        if ($newAvancement < $currentAvancement) {
            throw new Exception('la valeur doit etre superieur à '.$currentAvancement.'%');
        }
    }


    public function updateAvancement(Request $request){
        try{
            $constat = Constat::find($request->id_constat);
            $this->verifyAvancement($request->avancement, $constat->avancement);
            $constat->avancement = $request->avancement;
            $constat->save();
            return redirect()->route('COMPLIANCE.listeConstat');
        }
        catch (QueryException $e) {
            if ($e->getCode() == 23514) {
                Session::flash('check_violation', 'la valeur doit etre inferieur à 100%');
                Session::flash('avancement_invalide', $request->avancement);
            }
            return redirect()->route('COMPLIANCE.listeConstat');
        }
        catch (Exception $e) {
            Session::flash('check_violation', $e->getMessage());
            Session::flash('avancement_invalide', $request->avancement);
            return redirect()->route('COMPLIANCE.listeConstat');
        }
    }
    
    public function listeConstat(Request $request){
        $sections = Section::where('etat',0)->get();
        $constats = VConstat::where('typeaudit_id',1);

        $dateDebut = null;
        $dateFin = null;
        $selectedDateRange = $request->daterange ?? '';
        if (!empty($selectedDateRange)) {
            list($deadline_debut,$deadline_fin) = explode(' au ',$selectedDateRange);
            $deadline_debut = Carbon::createFromFormat('d-m-Y', $deadline_debut);
            $deadline_fin = Carbon::createFromFormat('d-m-Y', $deadline_fin);
            $dateDebut = $deadline_debut->format('d-m-Y');
            $dateFin = $deadline_fin->format('d-m-Y');
            $constats = $constats->whereBetween('dateconstat',[$deadline_debut,$deadline_fin]);
        }

        $selectedResolution = $request->resolution ?? '';
        if (!empty($selectedResolution)) {
            if ($selectedResolution === 'true') {
                $constats = $constats->where('constat_avancement', 100);
            } elseif ($selectedResolution === 'false') {
                $constats = $constats->where('constat_avancement', '<', 100);
            }
        }

        $selectedSection = $request->id_section ?? '';
        if(!empty($selectedSection)){
            $constats = $constats->where('section_id',$selectedSection);
        }

        $constats = $constats->orderBy('constat_id','desc')->get();

        if($constats->isNotEmpty()) {
            $ids = $constats->pluck('constat_id')->toArray();
            $idsString = implode(',', $ids);
            $constat_stat = DB::select("SELECT * FROM f_stat_constat(ARRAY[$idsString], 1)");

            $constat_stat = $constat_stat[0];
            // dd($constat_stat);
            $constat_stat->taux_resolu = (number_format($constat_stat->taux_resolu, 2)*100);
            $constat_stat->taux_a_traiter = (number_format($constat_stat->taux_a_traiter, 2)*100);
            $constat_stat->taux_retard = (number_format($constat_stat->taux_retard, 2)*100);
        }
        else{
            $constat_stat = [];
            $constat_stat = (object) [
                'nb_constat' => 0,
                'resolu' => 0,
                'taux_resolu' => 0,
                'taux_a_traiter' => 0,
                'taux_retard' => 0
            ];
        }
        return view('COMPLIANCE.listeConstat', compact('constats', 'sections', 'constat_stat','dateDebut','dateFin'));
    }

    public function getSections(){
        $sections = Section::where('etat', 0)->get();
        return response()->json($sections);
    }

    public function addSection(Request $request) {
        try {
            if (!$request->id_employe) {
                $section = new Section();
                $section->addSection($request->nom_section);
            }
            else{
                DB::beginTransaction();       
                $section = new Section();
                $section->addSection($request->nom_section);
                
                $resp_section = new ResponsableSection();
                $resp_section->addResponsableSection($section->id,$request->id_employe);
                
                DB::commit();
            }
            return redirect()->route('COMPLIANCE.listeConstat');
        } 
        catch (QueryException $e) {
            DB::rollBack();
            if ($e->getCode() == 23505) {
                Session::flash('section-violation', 'Une section avec cette désignation existe déjà.');
            }
            return redirect()->route('COMPLIANCE.listeConstat');
        }
        catch (\Exception $e) {
             DB::rollBack();
            Session::flash('test_error', $e->getMessage());
            return redirect()->route('COMPLIANCE.listeConstat');
        }
    }

    public function getResponsableSection(){
        $resp_sections = VResponsableSection::where('etat', 0)->get();
        $resp_libres = VResponsableLibre::all();
        return response()->json([
            'resp_sections' => $resp_sections,
            'resp_libres' => $resp_libres
        ]);
    }

    public function newAjoutConstat(Request $request){
        $request->validate([
            'fichierConstat' => 'image|mimes:jpeg,png,jpg,gif',
            'date_constat' => 'required|date',
            'id_section' => 'required|integer',
            'priorite' => 'required|string',
            'description' => 'nullable|string',
            'action' => 'nullable|string',
            'deadline' => 'nullable|date',
            'numero' => 'nullable|string',
        ]);

        $data = [
            'dateconstat' => $request->date_constat,
            'section_id' => $request->id_section,
            'priorite' => $request->priorite,
            'description' => $request->description ?? '',
            'action' => $request->action ?? '',
            'deadline' => $request->deadline ?? null,
            'numero' => $request->numero ?? '',
            'typeaudit_id' => 1
        ];

        NewConstat::create($data);
        $dernierConstat = Constat::orderBy('id','DESC')->limit(1)->get();

        if ($request->hasFile('fichierConstat')) {
            $s = new ServicesConstat;
            $file = $request->file('fichierConstat');
            $filename = $s->uploadImage("uploads/constat",$file);
            
            $fichier = new Constat();
            $fichier->insertFichierConstat($filename, $dernierConstat[0]->id);
        }else{
            $fichier = new Constat();
            $fichier->insertFichierConstat("", $dernierConstat[0]->id);
        }
        return redirect()->route(route: 'COMPLIANCE.listeConstat');
    }

    public function getConstatDetail (Request $request) {
        $constatId = $request->input('id');
        $constat = VConstat::find($constatId);

        if ($constat) {
            return response()->json([
                'constat_numero' => $constat->constat_numero,
                'dateconstat' => $constat->dateconstat,
                'description' => $constat->description,
                'action' => $constat->action,
                'constat_deadline' => $constat->constat_deadline,
                'constat_avancement' => $constat->constat_avancement,
                'section_id' => $constat->section_id,
                'priorite' => $constat->priorite,
                'fichier' => $constat->chemin
             ]);
        }

        return response()->json(['error' => 'Constat non trouvé'], 404);
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
