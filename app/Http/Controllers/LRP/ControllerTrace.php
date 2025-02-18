<?php

namespace App\Http\Controllers\LRP;

use App\Http\Controllers\Controller;
use App\Models\LRP\PP\VPPMeeting;
use App\Models\LRP\TRACE\Trace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerTrace extends Controller
{
    //
    public function getTraces(){
        $traces = VPPMeeting::all();
        $formattedTraces = $traces->map(function ($trace) {
            return [
                'title' => $trace->nom_modele,
                'start' => $trace->datetrace,
                'id_demande' => $trace->id,
                'etat_trace' => $trace->etat_trace,
                'isretardtrace' => $trace->isretardtrace
            ];
        });

        return response()->json($formattedTraces);
    }

    public function getTraceById($id){
        $trace = VPPMeeting::find($id);
    
        if (!$trace) {
            return response()->json(['error' => 'Trace non trouvé'], 404);
        }
    
        return response()->json([
            'trace_id' => $trace->trace_id,
            'nom_modele' => $trace->nom_modele,
            'photo_commande' => $trace->photo_commande ? 'data:image/png;base64,' . $trace->photo_commande : null,
            'datetrace' => $trace->datetrace,
            'etat_trace' => $trace->etat_trace
        ]);
    }

    public function updateStatusTrace($id, Request $request){
        try {
            $etat_trace = 0;
            if($request->checkbox){
                $etat_trace = 1;
            }
            $trace = Trace::findOrFail($id);
            $trace->etat = $etat_trace;
            $trace->datetrace = $request->datetrace;
            $trace->save(); 
            return redirect()->route('LRP.calendrierTrace')->with('success', 'L\'état de la réunion a été mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('LRP.calendrierTrace')->with('error', 'Une erreur est survenue lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function getStatTrace(Request $request) {
        $month = $request->query('month');
    
        $data = DB::table('v_stat_trace')
        ->where('mois', $month)
        ->select('nbtrace', 'taux_achevement','taux_retard')
        ->first();

        return response()->json([
            'nbtrace' => $data->nbtrace ?? 0, 
            'taux_achevement' => $data->taux_achevement ?? 0,
            'taux_retard' => $data->taux_retard ?? 0,
    ]);
    }
}
