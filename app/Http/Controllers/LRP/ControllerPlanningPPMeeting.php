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
                'color' => "#25D366",
            ];
        });

        return response()->json($formattedMeetings);
    }

    public function getPlanning(){
        return view('PLANNING.PPM.calendar.calendarPPM');
    }

    public function getNbPPM(Request $request) {
        $month = $request->query('month');
    
        $nbppm = DB::table('v_nb_ppm_by_month')
            ->where('mois', $month)
            ->value('nbppm') ?? 0; // Si aucune valeur trouvée, retourner 0
    
        return response()->json(['nbppm' => $nbppm]);
    }
}