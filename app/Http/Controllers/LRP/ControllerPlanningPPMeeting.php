<?php

namespace App\Http\Controllers\LRP;

use App\Http\Controllers\Controller;
use App\Models\LRP\PP\Meeting;
use App\Models\LRP\PP\VPPMeeting;
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
                'color' => "#FFD700",
                'id_demande' => $meeting->id
            ];
        });

        return response()->json($formattedMeetings);
    }

    public function getPlanning(){
        return view('PLANNING.PPM.calendar.calendarPPM');
    }

    public function getNbPPM(Request $request) {
        $month = $request->query('month');
    
        $data = DB::table('v_nb_ppm_by_month')
        ->where('mois', $month)
        ->select('nbppm', 'taux_achevement')
        ->first();

        return response()->json([
            'nbppm' => $data->nbppm ?? 0, 
            'taux_achevement' => $data->taux_achevement ?? 0
    ]);
    }

    public function getMeetingById($id) {
        $meeting = VPPMeeting::find($id);
    
        if (!$meeting) {
            return response()->json(['error' => 'Meeting non trouvé'], 404);
        }
    
        return response()->json([
            'nom_modele' => $meeting->nom_modele,
            'dateppm' => $meeting->dateppm,
            'heure_debut' => $meeting->heure_debut,
            'effectif' => $meeting->effectif,
            'photo_commande' => $meeting->photo_commande ? 'data:image/png;base64,' . $meeting->photo_commande : null
        ]);
    }
}