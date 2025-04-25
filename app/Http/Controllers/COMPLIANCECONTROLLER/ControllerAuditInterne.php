<?php

namespace App\Http\Controllers\COMPLIANCECONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\COMPLIANCE\AuditInterne;
use App\Models\COMPLIANCE\PhotoAuditInterne;
use App\Models\COMPLIANCE\Section;
use App\Models\COMPLIANCE\SectionCompliance;
use App\Models\COMPLIANCE\VAuditInterne;
use App\Models\COMPLIANCE\VSectionCompliance;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use DateTime;

class ControllerAuditInterne extends Controller
{

    public function getPreviousMoisAnnee($selectedMoisAnnee) {
        // Convertir la chaîne en objet DateTime
        $date = new DateTime($selectedMoisAnnee . '-01');
    
        // Soustraire un mois
        $date->modify('-1 month');
    
        // Retourner le résultat au format "AAAA-MM"
        return $date->format('Y-m');
    }
    public function getRapport(Request $request){
        $audits = VAuditInterne::orderBy('id','desc');
        $resolus = VAuditInterne::orderBy('id','desc');
        $restes = VAuditInterne::orderBy('id','desc');
        $mois_annee_affichage = '';
        $selectedMoisAnnee = $request->mois_annee ?? null;
        if (!empty($selectedMoisAnnee)){
            
            $mois_annee_audit = $this->getPreviousMoisAnnee($selectedMoisAnnee);
            $date_audit = $this->transformToDate($mois_annee_audit);
            $mois_annee_affichage = new DateTime($selectedMoisAnnee);
            $mois_annee_affichage = $mois_annee_affichage->format('Y-M');

            $date_resolu = $this->transformToDate($selectedMoisAnnee);
            $audits = $audits->whereBetween('date_detection', [$date_audit['debut'], $date_audit['fin']])
                 ->where('avancement', '<', 100)
                 ->get();
            $resolus = $resolus->whereBetween('deadline',[$date_resolu['debut'],$date_resolu['fin']])
                ->where('avancement', 100)
                ->get();
            if($audits->isNotEmpty()){
                $audit_ids = $audits->pluck('id')->toArray();
                $restes = $restes->whereBetween('deadline',[$date_resolu['debut'],$date_resolu['fin']])
                ->where('avancement', '<',100)
                ->whereNotIn('id', $audit_ids)
                ->get();
            }
        }
        return view('COMPLIANCE.auditInterne.rapport',compact('audits','resolus','restes','mois_annee_affichage'));
    }

    public function getRapportHebdo(Request $request){
        $audits = VAuditInterne::orderBy('date_detection');
        $resolus = VAuditInterne::orderBy('date_detection');
        $restes = VAuditInterne::orderBy('id','desc');
        $mois_annee_affichage = '';

        $selectedDateRange = $request->daterange  ?? '';
        if (!empty($selectedDateRange)) {
            list($deadline_debut,$deadline_fin) = explode(' au ',$selectedDateRange);
            $deadline_debut = Carbon::createFromFormat('d-m-Y', $deadline_debut);
            $deadline_fin = Carbon::createFromFormat('d-m-Y', $deadline_fin);
            $dateDebut = $deadline_debut->format('d-m-Y');
            $dateFin = $deadline_fin->format('d-m-Y');

            $mois_annee = $deadline_debut->format('Y-m');
            $moisAnnee = $this->transformToDate($mois_annee);
            $mois_annee_affichage =  $deadline_debut->format('Y-M');
            
            $dateFinMety = $deadline_fin->format('Y-m-d');
            
            $audits = $audits->whereBetween('date_detection',[$moisAnnee['debut'],$dateFinMety])->where('avancement','<',100);
            $resolus = $resolus->whereBetween('date_realisation',[$deadline_debut,$deadline_fin])->where('avancement',100);
            $audits_ids = $audits->pluck('id')->toArray();
            $restes = $restes
                // ->where('date_detection','<=',$deadline_fin)
                ->where('avancement','<',100)
                ->whereNotIn('id',$audits_ids);

            $audits = $audits->get();
            $resolus = $resolus->get(); 
            $restes = $restes->get();
        }
        return view('COMPLIANCE.auditInterne.rapportHebdo',compact('audits','resolus','restes','mois_annee_affichage'));
    }

    public function transformToDate($selectedMoisAnnee){
        // Créer un objet DateTime à partir de la chaîne "AAAA-MM"
        $date = new DateTime($selectedMoisAnnee . '-01');
        
        // Obtenir la première date du mois
        $firstDay = $date->format('Y-m-d');

        // Modifier l'objet DateTime pour obtenir la dernière date du mois
        $date->modify('last day of this month');
        $lastDay = $date->format('Y-m-d');

        // Retourner un tableau associatif avec les dates de début et de fin
        return [
            'debut' => $firstDay,
            'fin' => $lastDay,
        ];
    }

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

    public function getSectionCompliance(){
        $sections = VSectionCompliance::where('etat', true)->get();
        return response()->json($sections);
    }

    public function readAudit(Request $request): View{
        $sections = VSectionCompliance::where('etat',true)->get();
        $audits = VAuditInterne::orderBy('id','desc');

        $dateDebut = null;
        $dateFin = null;
        $selectedDateRange = $request->daterange ?? '';
        if (!empty($selectedDateRange)) {
            list($deadline_debut,$deadline_fin) = explode(' au ',$selectedDateRange);
            $deadline_debut = Carbon::createFromFormat('d-m-Y', $deadline_debut);
            $deadline_fin = Carbon::createFromFormat('d-m-Y', $deadline_fin);
            $dateDebut = $deadline_debut->format('d-m-Y');
            $dateFin = $deadline_fin->format('d-m-Y');
            $audits = $audits->whereBetween('date_detection',[$deadline_debut,$deadline_fin]);
        }

        $selectedResolution = $request->resolution ?? '';
        if (!empty($selectedResolution)) {
            if ($selectedResolution === 'true') {
                $audits = $audits->where('avancement', 100);
            } elseif ($selectedResolution === 'false') {
                $audits = $audits->where('avancement', '<', 100);
            }
        }

        $selectedSection = $request->id_section ?? '';
        $section = null;
        if(!empty($selectedSection)){
            $audits = $audits->where('id_section',$selectedSection);
            $section = VSectionCompliance::where('id',$selectedSection)->first();
        }

        $audits = $audits->get();

        $constat_stat = [];
        if($audits->isNotEmpty()) {
            $ids = $audits->pluck('id')->toArray();

            // Convertir chaque identifiant en une chaîne entourée de guillemets simples
            $idsString = "'" . implode("','", $ids) . "'";
            
            // Appeler la fonction en utilisant la chaîne correctement formatée
            $constat_stat = DB::select("SELECT * FROM f_stat_constat(ARRAY[$idsString])");

            $constat_stat = $constat_stat[0];
            $constat_stat->taux_resolu = (number_format($constat_stat->taux_resolu, 2)*100);
            $constat_stat->taux_a_traiter = (number_format($constat_stat->taux_a_traiter, 2)*100);
            $constat_stat->taux_retard = (number_format($constat_stat->taux_retard, 2)*100);
        }
        else{
            $constat_stat = (object) [
                'nb_constat' => 0,
                'resolu' => 0,
                'taux_resolu' => 0,
                'taux_a_traiter' => 0,
                'taux_retard' => 0
            ];
        }
        $request->session()->put('filters', [
            'daterange' => $selectedDateRange,
            'resolution' => $selectedResolution,
            'id_section' => $selectedSection,
        ]);
        return view('COMPLIANCE.listeConstat', compact('audits', 'sections', 'constat_stat','dateDebut','dateFin','section'));
    }

    public function getAuditInterneDetail (Request $request) {
        $id = $request->input('id');
        $audit = VAuditInterne::find($id);
        if ($audit) {
            return response()->json([
                'id' => $audit->id,
                'date_detection' => $audit->date_detection,
                'constat' => $audit->constat,
                'action' => $audit->action,
                'deadline' => $audit->deadline,
                'avancement' => $audit->avancement['valeur'],
                'id_section' => $audit->id_section,
                'priorite' => $audit->priorite['valeur'],
                'photo_initial' => $audit->photo_initial,
                'mime_type_initial' => $audit->mime_type_initial,
                'photo_final' => $audit->photo_final,
                'mime_type_final' => $audit->mime_type_final,
                'nom_emp' => $audit->nom_emp ?? '--',
                'prenom_emp' => $audit->prenom_emp ?? '--',
                'new_deadline' => $audit->new_deadline,
                'date_real' => $audit->date_realisation
            ]);
        }
        return response()->json(['error' => 'audit non trouvé'], 404);
    }

    public function createAuditInterne(Request $request){
        $request->validate([
            'date_detection' => 'required|date',
            'id_section' => 'required|integer',
            'priorite' => 'required|string',
            'constat' => 'required|string',
            'action' => 'required|string',
            'deadline' => 'required|date',
        ]);

        $data = [
            'date_detection' => $request->date_detection,
            'id_section' => $request->id_section,
            'priorite' => $request->priorite,
            'constat' => $request->constat,
            'action' => $request->action,
            'deadline' => $request->deadline,
        ];
        $audit_interne = new AuditInterne();
        $audit_interne->store($data);
        return redirect()->route(route: 'COMPLIANCE.readAuditInterne');
    }
    
    public function doAjoutMultiple(Request $request){
        // Récupérer les données du formulaire
        $constats = $request->input('constat');
        $actions = $request->input('action');
        $priorites = $request->input('priorite');
        $deadlines = $request->input('deadline');
        $photos = $request->file('photo_initial');
        $date_detection = $request->date_detection;
        $id_section = $request->id_section;

        // dd($photos);
        // Créer un tableau pour stocker les données structurées
        $data = [];

        // Parcourir les données et les organiser dans le tableau
        foreach ($constats as $index => $constat) {
            $data[] = [
                'constat' => $constat,
                'date_detection' => $date_detection,
                'id_section' => $id_section,
                'action' => $actions[$index],
                'priorite' => $priorites[$index],
                'deadline' => $deadlines[$index],
                'photo_initial' => isset($photos[$index]) ? $photos[$index] : null,
            ];
        }
        $this->createNewAuditInterne($data);
        $request->session()->put('filters', [
            'resolution' => 2,
            'id_section' => $id_section,
        ]);

        $filters = $request->session()->get('filters', []);
        return redirect()->route('COMPLIANCE.readAuditInterne', $filters);
    }

    public function createNewAuditInterne($data){
       
        foreach($data as $audit){
            $audit_interne = new AuditInterne();
            $audit_interne->store($audit);
            if($audit['photo_initial'] !== null){
                $this->insertOrUpdatePhoto($audit_interne->id, $audit['photo_initial']);
            }
            
        }
    }

    public function verifyIfExist($id_audit){
        $id_photo = "P".$id_audit;
        $photo = PhotoAuditInterne::find($id_photo);
        if($photo){
            return true;
        }
        return false;
    }

    public function updateAvancement(Request $request){
        try{
            DB::beginTransaction();
            $audit = AuditInterne::find($request->id_audit);
            $this->verifyAvancement($request->avancement,$audit->avancement);
            $audit->avancement = $request->avancement;
            if($request->deadline){
                $audit->deadline = $request->deadline;
            }
            if($request->new_deadline){
                $audit->new_deadline = $request->new_deadline;
            }
            if($request->date_real){
                $audit->date_realisation = $request->date_real;
            }
            $audit->save();
            if($request->hasFile('photo_initial')){
                $file = $request->file('photo_initial');
                $this->insertOrUpdatePhoto($audit->id,$file);
            }
            if($request->hasFile('photo_final')){
                $file = $request->file('photo_final');
                $this->updatePhoto($audit->id,$file);
            }
            DB::commit();
            $filters = $request->session()->get('filters', []);

            return redirect()->route('COMPLIANCE.readAuditInterne', $filters)->with('scrollTo', '#audit-' . $audit->id);
        }
        catch (QueryException $e) {
            DB::rollBack();
            if ($e->getCode() == 23514) {
                Session::flash('check_violation', 'la valeur doit etre inferieur à 100%');
                Session::flash('avancement_invalide', $request->avancement);
            }
            $filters = $request->session()->get('filters', []);
            return redirect()->route('COMPLIANCE.readAuditInterne',$filters);
        }
        catch (Exception $e){
            DB::rollBack();
            Session::flash('check_violation', $e->getMessage());
            Session::flash('avancement_invalide', $request->avancement);
            $filters = $request->session()->get('filters', []);
            return redirect()->route('COMPLIANCE.readAuditInterne',$filters);
        }
    }

    public function insertOrUpdatePhoto($id_audit,UploadedFile $file){
        try{
            if(!$this->verifyIfExist($id_audit)){
                $mime_type = $file->getMimeType();
                $image_base64 = base64_encode(file_get_contents($file->getRealPath()));
                $data_photo_audit = [
                    'id' => 'P'.$id_audit,
                    'id_audit_interne' => $id_audit,
                    'photo_initial' => $image_base64,
                    'mime_type_initial' => $mime_type,
                ];
                PhotoAuditInterne::create($data_photo_audit);
            }
            else{
                $mime_type = $file->getMimeType();
                $photo_audit = PhotoAuditInterne::find("P".$id_audit);
                $image_base64 = base64_encode(file_get_contents($file->getRealPath()));
                $photo_audit->photo_initial = $image_base64;
                $photo_audit->mime_type_initial = $mime_type;
                $photo_audit->save();
            }
            return redirect()->route('COMPLIANCE.readAuditInterne');
        }
        catch(Exception $e){
             Session::flash('photo_audit_exception',$e->getMessage());
            return redirect()->route('COMPLIANCE.readAuditInterne');
        }
    }

    public function updatePhoto($id_audit,UploadedFile $file){
        try{
            $mime_type = $file->getMimeType();
            $photo_audit = PhotoAuditInterne::find("P".$id_audit);
            $image_base64 = base64_encode(file_get_contents($file->getRealPath()));
            $photo_audit->photo_final = $image_base64;
            $photo_audit->mime_type_final = $mime_type;
            $photo_audit->save();
            return redirect()->route('COMPLIANCE.readAuditInterne');
        }
        catch(Exception $e){
            Session::flash('photo_audit_exception',$e->getMessage());
            return redirect()->route('COMPLIANCE.readAuditInterne');
        }
    }

    public function ajoutMultiple(){
        $date = Carbon::now()->toDateString();
        $sections = VSectionCompliance::where('etat',true)->get();
        return view('COMPLIANCE.auditInterne.ajoutMultiple',compact('sections','date'));
    }

 

    
}