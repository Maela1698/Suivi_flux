<?php

namespace App\Http\Controllers\COMPLIANCECONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\COMPLIANCE\AuditInterne;
use App\Models\COMPLIANCE\PhotoAuditInterne;
use App\Models\COMPLIANCE\Section;
use App\Models\COMPLIANCE\SectionCompliance;
use App\Models\COMPLIANCE\VAuditInterne;
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
        $selectedMoisAnnee = $request->mois_annee ?? null;
        if (!empty($selectedMoisAnnee)) {
            $selectedMoisAnnee = $this->getPreviousMoisAnnee($selectedMoisAnnee);
            $tranche_date = $this->transformToDate($selectedMoisAnnee);
            $audits = $audits->whereBetween('date_detection', [$tranche_date['debut'], $tranche_date['fin']])
                 ->where('avancement', '<', 100)
                 ->get();
        }
        return view('COMPLIANCE.auditInterne.rapport',compact('audits'));
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
        $sections = SectionCompliance::where('etat', true)->get();
        return response()->json($sections);
    }

    public function readAudit(Request $request): View{
        $sections = SectionCompliance::where('etat',true)->get();
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
        if(!empty($selectedSection)){
            $audits = $audits->where('id_section',$selectedSection);
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
        return view('COMPLIANCE.listeConstat', compact('audits', 'sections', 'constat_stat','dateDebut','dateFin'));
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
                'avancement' => $audit->avancement,
                'id_section' => $audit->id_section,
                'priorite' => $audit->priorite,
                'photo_initial' => $audit->photo_initial,
                'mime_type_initial' => $audit->mime_type_initial,
                'photo_final' => $audit->photo_final,
                'mime_type_final' => $audit->mime_type_final,
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

    public function updateAvancement(Request $request){
        try{
            DB::beginTransaction();
            $audit = AuditInterne::find($request->id_audit);
            $this->verifyAvancement($request->avancement, $audit->avancement);
            $audit->avancement = $request->avancement;
            $audit->save();
            if($request->hasFile('photo_initial')){
                $file = $request->file('photo_initial');
                $this->insertPhoto($audit->id,$file);
            }
            if($request->hasFile('photo_final')){
                $file = $request->file('photo_final');
                $this->updatePhoto($audit->id,$file);
            }
            DB::commit();
            return redirect()->route(route: 'COMPLIANCE.readAuditInterne');
        }
        catch (QueryException $e) {
            DB::rollBack();
            if ($e->getCode() == 23514) {
                Session::flash('check_violation', 'la valeur doit etre inferieur à 100%');
                Session::flash('avancement_invalide', $request->avancement);
            }
            return redirect()->route(route: 'COMPLIANCE.readAuditInterne');
        }
        catch (Exception $e){
            DB::rollBack();
            Session::flash('check_violation', $e->getMessage());
            Session::flash('avancement_invalide', $request->avancement);
            return redirect()->route('COMPLIANCE.readAuditInterne');
        }
    }

    public function insertPhoto($id_audit,UploadedFile $file){
        try{
            $mime_type = $file->getMimeType();
            $image_base64 = base64_encode(file_get_contents($file->getRealPath()));
            $data_photo_audit = [
                'id' => 'P'.$id_audit,
                'id_audit_interne' => $id_audit,
                'photo_initial' => $image_base64,
                'mime_type_initial' => $mime_type,
            ];
            PhotoAuditInterne::create($data_photo_audit);
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
}
