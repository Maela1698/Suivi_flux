<?php

namespace App\Http\Controllers\COMPLIANCECONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\COMPLIANCE\Constat;
use App\Models\COMPLIANCE\ConstatPerimetre;
use App\Models\COMPLIANCE\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControlleurComplianceNotia extends Controller
{
    public function listePerimetre(Request $request)
    {
        $typeperimetre = Questionnaire::getAllTypePerimetre();
        $axe = Questionnaire::getAllAxe();
        $questionnaires = Questionnaire::getAllQuestionnaire();
        return view('COMPLIANCE.listeQuestionnaires',compact('questionnaires','axe','typeperimetre'));
    }
    public function listeQuestionnaire(Request $request)
    {
        $typeperimetre = Questionnaire::getAllTypePerimetre();
        $questionnaires = Questionnaire::getAllQuestionnaire();
        $departement = Questionnaire::getAllDepartement();
        return view('COMPLIANCE.listeQuestionnairesProcedure',compact('questionnaires','departement','typeperimetre'));
    }
    public function listeConstatProcedure(Request $request)
    {
        $constats = DB::table('vue_constats')->where('typeaudit_id',4);
        if($request->has('section_id') && $request->section_id != null){
            $constats->where('section_id',$request->section_id);
        }
        if($request->has('priorite') && $request->priorite != null){
            $constats->where('priorite',$request->priorite);
        }
        if($request->has('startdate') && $request->startdate != null && $request->has('enddate') && $request->enddate != null){
            $constats->whereBetween('dateconstat', [$request->startdate, $request->enddate]);
        }
        $constat = $constats->get();
        $section = Questionnaire::getAllSection();
        return view('COMPLIANCE.listeConstatProcedure',compact('constat','section'));
    }
    public function listeConstatPerimetre(Request $request)
    {
        $constats = DB::table('vue_constats')->where('typeaudit_id',2);
        if($request->has('section_id') && $request->section_id != null){
            $constats->where('section_id',$request->section_id);
        }
        if($request->has('priorite') && $request->priorite != null){
            $constats->where('priorite',$request->priorite);
        }
        if($request->has('startdate') && $request->startdate != null && $request->has('enddate') && $request->enddate != null){
            $constats->whereBetween('dateconstat', [$request->startdate, $request->enddate]);
        }
        $constat = $constats->get();
        $section = Questionnaire::getAllSection();
        return view('COMPLIANCE.listeConstatPerimetre',compact('constat','section'));
    }
    public function ajoutQuestionnaireProcedure(Request $request)
    {
        $numero = $request->input('numero');
        $statut = $request->input('statut');
        $question = $request->input('question');
        $criticite = $request->input('criticite');
        $procede = $request->input('procede');
        $observation = $request->input('observation');

        Questionnaire::create([
            'typeaudit_id' => 4,
            'question' => $question,
            'statut' => $statut,
            'criticite' => $criticite,
            'procede_id' =>$procede,
            'observation' =>$observation,
            'numero' =>$numero,
            'datequestion' => now()->format('Y-m-d')
        ]);
        return redirect()->route('COMPLIANCE.listeQuestionnaire');
    }
    public function ajoutQuestionnaire(Request $request)
    {
        $numero = $request->input('numero');
        $statut = $request->input('statut');
        $question = $request->input('question');
        $axe = $request->input('axe');
        $type = $request->input('type');

        Questionnaire::create([
            'typeaudit_id' => 2,
            'question' => $question,
            'statut' => $statut,
            'axe_id' => $axe,
            'typeperimetre_id' => $type,
            'numero' => $numero,
            'datequestion' => now()->format('Y-m-d')
        ]);
        return redirect()->route('COMPLIANCE.listePerimetre');
    }
    public function ajoutConstatProcedure(Request $request){
        $constatPerimetre = new ConstatPerimetre();
        $dateconstat = $request->input('dateconstat');
        $section_id = $request->input('section_id');
        $priorite = $request->input('priorite');
        $description = $request->input('description');
        $question = $request->input('questionnaire_id');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('FichierPerimetre', $filename, 'public');
        } else {
            $filePath = '';
        }
        $last_id_constat = Constat::getLastConstat();
        $constatPerimetre->insertConstatPerimetre($dateconstat, $section_id, $priorite, $description, 4, $question);
        $constatPerimetre->insertFichierConstatPerimetre($filePath, $last_id_constat[0]->id, $question);

        return redirect()->route('COMPLIANCE.detailQuestionnaireProcedure', ['idquestionnaire' => $question]);
    }
    public function ajoutConstatPerimetre(Request $request){
        $constatPerimetre = new ConstatPerimetre();
        $dateconstat = $request->input('dateconstat');
        $section_id = $request->input('section_id');
        $priorite = $request->input('priorite');
        $description = $request->input('description');
        $question = $request->input('questionnaire_id');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('FichierPerimetre', $filename, 'public');
        } else {
            $filePath = '';
        }
        $last_id_constat = Constat::getLastConstat();
        $constatPerimetre->insertConstatPerimetre($dateconstat, $section_id, $priorite, $description, 2, $question);
        $constatPerimetre->insertFichierConstatPerimetre($filePath, $last_id_constat[0]->id, $question);

        return redirect()->route('COMPLIANCE.detailQuestionnaire', ['idquestionnaire' => $question]);
    }
    public function detailQuestionnaireProcedure(Request $request)
    {
        $idquestion = $request->input('idquestionnaire');
        $questionnairesbyid = Questionnaire::getAllQuestionnaireById($idquestion);
        $section = Questionnaire::getAllSection();
        $constatassocie = Questionnaire::getAllConstatByIdConstats($idquestion);
        return view('COMPLIANCE.detailQuestionnaireProcedure',compact('questionnairesbyid','section','constatassocie'));
    }
    public function detailQuestionnaire(Request $request)
    {
        $idquestion = $request->input('idquestionnaire');
        $questionnairesbyid = Questionnaire::getAllQuestionnaireById($idquestion);
        $section = Questionnaire::getAllSection();
        $constatassocie = Questionnaire::getAllConstatByIdConstats($idquestion);
        return view('COMPLIANCE.detailQuestionnaire',compact('questionnairesbyid','section','constatassocie'));
    }
    public function detailConstatPerimetre(Request $request)
    {
        $idconstat = $request->input('idconstat');
        $fichier = Constat::listeFichierByConstat($idconstat);
        $constat = Constat::getConstatById($idconstat);
        return view('COMPLIANCE.detailConstatPerimetre',data: compact('constat','fichier'));
    }
    public function getTypes($departementId)
    {
        $types = Questionnaire::getAllTypePerimetreByIdDepartement($departementId);
        return response()->json($types);
    }


}
