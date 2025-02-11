<?php

namespace App\Http\Controllers;

use App\Models\Tracer;
use Illuminate\Http\Request;

class ControllerTracer extends Controller
{
    public static function ajouteprevision(Request $request)
    {
        $iddemande = $request->input('iddemande');
        $idrecap = $request->input('idrecap');
        $tissus = $request->input('tissus');
        $accy = $request->input('accy');
        $okprod = $request->input('okprod');
        Tracer::insertPrevision($iddemande,$okprod,$tissus);
        Tracer::insertOkProdRecap($idrecap,$iddemande,$okprod,$tissus,$accy);
        return redirect()->route('PLANNING.detailRecap',['idDemande'=>$iddemande,'idRecap'=>$idrecap]);
    }
    public static function modifprevision(Request $request)
    {
        $iddemande = $request->input('iddemande');
        $idrecap = $request->input('idrecap');
        $tissus = $request->input('tissus');
        $accy = $request->input('accy');
        $okprod = $request->input('okprod');
        Tracer::updatePrevision($iddemande,$okprod,$tissus);
        Tracer::updateOkProd($iddemande,$okprod,$tissus,$accy);
        return redirect()->route('PLANNING.detailRecap',['idDemande'=>$iddemande,'idRecap'=>$idrecap]);
    }

    public static function updateTrace(Request $request)
    {
        $demandeTrace=$request->input('demandeTrace');
        $finiTrace=$request->input('finiTrace');
        $datetrace=$request->input('datetrace');
        if($finiTrace==null){
            $finiTrace=0;
        }
        Tracer::updateDatePrevisionTrace($datetrace,$finiTrace,$demandeTrace);

        $nomTiers=$request->input('nomTiers');
        $idTiers=$request->input('idTiers');
        $modele=$request->input('modele');
        if($nomTiers==null){
            $idTiers="";
        }

        return redirect()->route('LRP.listeDemandeForPpmeeting',['nomTiers' => $nomTiers, 'idTiers' => $idTiers, 'modele' => $modele]);
    }

    public static function calendrierTrace(Request $request)
    {
       $liste="";
        return view('PLANNING.TRACE.calendrier', data: compact('liste'));
    }

}
