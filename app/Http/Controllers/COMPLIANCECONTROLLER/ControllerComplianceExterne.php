<?php

namespace App\Http\Controllers\COMPLIANCECONTROLLER;

use App\Http\Controllers\Controller;
use App\Models\COMPLIANCE\Audit;
use App\Models\COMPLIANCE\AvancementPlanAction;
use App\Models\COMPLIANCE\Budget;
use App\Models\COMPLIANCE\Constat;
use App\Models\COMPLIANCE\Norme;
use App\Models\COMPLIANCE\PlanAction;
use App\Models\COMPLIANCE\Section;
use App\Services\ServicesConstat;
use Illuminate\Http\Request;

class ControllerComplianceExterne extends Controller
{
    public function listeAuditExterne(Request $request)
    {
        $date = $request->input('date');
        $section = $request->input('section');
        $norme = $request->input('norme');
        $condition="";
        if(!empty($norme)){
            $condition = " and norme_id=".$norme;
        }
        if(!empty($section)){
            $condition= $condition." and section_id=".$section;
        }
        if(!empty($date)){
            $condition = $condition." and dateaudit='".$date."'";
        }
        $condition = $condition." order by audit_id desc";
        $audit = Audit::getListeAudit($condition);
        $section = Section::getAllSection();
        $norme = Norme::listeNorme();
        return view('COMPLIANCE.auditExterne', compact('norme','section','audit'));
    }

    public function ajoutAuditExterne(Request $request)
    {
        $request->validate([
            'fichierAudit' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $dateAudit = $request->input('dateAudit');
        $section = $request->input('section');
        $norme = $request->input('norme');
        $description = $request->input('description');
        $referenceNC = $request->input('referenceNC');

       $audit = new Audit();
       $audit->insertAudit($dateAudit,$section,$referenceNC,$description,3,$norme);

       $dernierAudit = Audit::getLastAudit();
        if ($request->hasFile('fichierAudit')) {
            $s = new ServicesConstat;
            $file = $request->file('fichierAudit');
            $filename = $s->uploadImage("uploads/audit",$file);
            // Récupérer le nom d'origine du fichier
            $originalFileName = $file->getClientOriginalName();
            $fichier = new Constat();
            $fichier->insertFichierAudit($filename,$dernierAudit[0]->id);
        }else{
            $fichier = new Constat();
            $fichier->insertFichierAudit("",$dernierAudit[0]->id);
        }

        return redirect()->route(route: 'COMPLIANCEEXTERNE.listeAuditExterne');
    }

    public function detailAuditExterne(Request $request)
    {
        $id = $request->input('id');
        $audit = Audit::getListeAuditById($id);
        $fichier = Constat::listeFichierByAudit($id);
        $planAction = PlanAction::listePlanActionByAudit($id);
        return view('COMPLIANCE.detailAuditExtene', compact('fichier','planAction','audit'));
    }


    public function ajoutPlanActionExterne(Request $request)
    {
        $priorite = $request->input('priorite');
        $moyen = $request->input('moyen');
        $numero = $request->input('numero');
        $idEmploye = $request->input('idEmploye');
        $dateOper = $request->input('dateOper');
        $idAudit = $request->input('idAudit');
        $deadline = $request->input('deadline');
        $commentaire = $request->input('commentaire');
        $planAction = new PlanAction();
        $planAction->insertPlanActionExterne($numero,$idAudit,$moyen,$dateOper,$priorite,$idEmploye,$deadline,$commentaire);
        return redirect()->route(route: 'COMPLIANCEEXTERNE.listePlanActionExterne');
    }

    public function listePlanActionExterne(Request $request)
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
        $planAction = PlanAction::listePlanActionExterne($condition);
        $section = Section::getAllSection();
        return view('COMPLIANCE.planActionExterne', compact('section','planAction'));
    }

    public function ajoutAvancementExterne(Request $request)
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
                return redirect()->route(route: 'COMPLIANCEEXTERNE.listePlanActionExterne');
            } else {
                return redirect()->route('COMPLIANCEEXTERNE.listePlanActionExterne')
                    ->with('error', $erreur);
            }
        } elseif (count($dernierAvancement) == 0) {
            $avancementPlan = new AvancementPlanAction();
            $avancementPlan->insertAvancementPlanAction($idPlanAction, $dateOper, $designation, $avancement);
            return redirect()->route(route: 'COMPLIANCEEXTERNE.listePlanActionExterne');
        }
    }




}
