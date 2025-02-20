<?php

namespace App\Http\Controllers\LRP;

use App\Http\Controllers\Controller;
use App\Models\Chaine;
use App\Models\LRP\PP\DetailsMeeting;
use App\Models\LRP\PP\Meeting;
use App\Models\LRP\PP\VPPMeeting;
use App\Models\LRP\TraceMaela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerPlanningPPMeeting extends Controller{
    
    public function getMeetings(){
        $meetings = VPPMeeting::all();
        // Formater les données pour FullCalendar
        $formattedMeetings = $meetings->map(function ($meeting) {
            return [
                'title' => $meeting->nom_modele,
                'start' => $meeting->dateppm . 'T' . $meeting->heure_debut, // Format : 'YYYY-MM-DDTHH:MM:SS'
                'color' =>  ($meeting->isretard && !$meeting->details_meeting_etat) ? "rgb(255, 60, 60)" :
                            ($meeting->details_meeting_etat ? "#25D366" : "gray"),
                'id_demande' => $meeting->id,
                'details_meeting_etat' => $meeting->details_meeting_etat,
                'isretard' => $meeting->isretard,
            ];
        });

        return response()->json($formattedMeetings);
    }

    public function getPlanning(){
        return view('PLANNING.PPM.calendar.calendarPPM');
    }

    public function getNbPPM(Request $request) {
        $month = $request->query('month');
    
        $data = DB::table('v_stat_ppmeeting')
        ->where('mois', $month)
        ->select('nbppm', 'taux_achevement','taux_retard','taux_abs')
        ->first();

        return response()->json([
            'nbppm' => $data->nbppm ?? 0, 
            'taux_achevement' => $data->taux_achevement ?? 0,
            'taux_retard' => $data->taux_retard ?? 0,
            'taux_abs' => $data->taux_abs ?? 0,
        ]);
    }

    public function getStatWeekPPM(Request $request){
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
    
        if (!$startDate || !$endDate) {
            return response()->json(['error' => 'Les paramètres startDate et endDate sont requis.'], 400);
        }
    
        $data = DB::select('SELECT * FROM f_stat_week_ppm(?, ?)', [$startDate, $endDate]);
    
        if (!empty($data)) {
            return response()->json([
                'nbppm' => $data[0]->nbppm ?? 0,
                'taux_fini' =>  $data[0]->taux_fini ?? 0,
                'taux_retard' => $data[0]->taux_retard ?? 0,
            ]);
        } else {
            return response()->json(['nbppm' => 0]);
        }
    }

    public function getMeetingById($id) {
        $detail_meeting = VPPMeeting::find($id);
    
        if (!$detail_meeting) {
            return response()->json(['error' => 'Meeting non trouvé'], 404);
        }
    
        return response()->json([
            'id_details_ppmeeting' => $detail_meeting->id_details_ppmeeting,
            'nom_modele' => $detail_meeting->nom_modele,
            'dateppm' => $detail_meeting->dateppm,
            'heure_debut' => $detail_meeting->heure_debut,
            'effectif' => $detail_meeting->effectif,
            'photo_commande' => $detail_meeting->photo_commande ? 'data:image/png;base64,' . $detail_meeting->photo_commande : null,
            'details_meeting_etat' => $detail_meeting->details_meeting_etat,
            'id_chaine' => $detail_meeting->id_chaine,
            'id_meeting' => $detail_meeting->id_meeting,
            'id_demande' => $detail_meeting->id_demande,
            'date_entree_chaine'  => $detail_meeting->date_entree_chaine,
            'date_entree_coupe' => $detail_meeting->date_entree_coupe,
            'date_entree_finition' => $detail_meeting->date_entree_finition,
            'effectif_reel' => $detail_meeting->effectif_reel,
            'effectif_prevu' => $detail_meeting->effectif_prevu
        ]);
    }

    public function updateStatus($id, Request $request){
        DB::beginTransaction();
        try {
            $validatedData['effectif_reel'] = null;
            if ($request->has('effectif_reel')) {
                $validatedData = $request->validate([
                    'effectif_reel' => 'required|numeric|min:1',
                ]);
            }
            $etat = (bool)$request->checkbox;
            $detail_meeting = DetailsMeeting::findOrFail($id);
            $detail_meeting->etat = $etat;
            $detail_meeting->heure_debut = $request->heure_debut;
            $detail_meeting->date_entree_chaine = $request->date_entree_chaine;
            $detail_meeting->date_entree_coupe = $request->date_entree_coupe;
            $detail_meeting->date_entree_finition = $request->date_entree_finition;
            if($validatedData['effectif_reel'] != null){
                $detail_meeting->effectif_reel = $validatedData['effectif_reel'];
            }
            $detail_meeting->id_chaine = $request->id_chaine;
            $detail_meeting->effectif_prevu = $request->effectif_prevu;

            if(self::checkIfDateExists($request->dateppm)){
                $meeting = Meeting::where('date',$request->dateppm)->first();
                $detail_meeting->id_meeting = $meeting->id;
                $detail_meeting->save();
                DB::commit();
            }
            else{
                $meeting = new Meeting();
                $meeting->date = $request->dateppm;
                $meeting->save();
                
                $detail_meeting->delete();

                $new_detail_meeting = new DetailsMeeting();
                $new_detail_meeting->id_meeting = $meeting->id;
                $new_detail_meeting->id_demande = $request->id_demande;
                $new_detail_meeting->heure_debut = $request->heure_debut;
                $new_detail_meeting->date_entree_chaine = $request->date_entree_chaine;
                $new_detail_meeting->date_entree_coupe = $request->date_entree_coupe;
                $new_detail_meeting->date_entree_finition = $request->date_entree_finition;
                if($validatedData['effectif_reel'] != null){
                    $new_detail_meeting->effectif_reel = $validatedData['effectif_reel'];
                }
                $new_detail_meeting->id_chaine = $request->id_chaine;
                $new_detail_meeting->effectif_prevu = $request->effectif_prevu;


                $new_detail_meeting->save();
                DB::commit();
            }
            return redirect()->route('PLANNING.PPM.calendar')->with('success', 'L\'état de la réunion a été mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('PLANNING.PPM.calendar')->with('error', 'Une erreur est survenue lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public static function checkIfDateExists($dateppm){
        return Meeting::where('date', $dateppm)->exists();
    }

    public function getAllChaines(){
        $chaines = Chaine::all();
        return response()->json($chaines);
    }
}