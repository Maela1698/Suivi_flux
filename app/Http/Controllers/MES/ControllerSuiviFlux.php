<?php

namespace App\Http\Controllers\MES;

use App\Http\Controllers\Controller;
use App\Models\MES\SuiviFluxMes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControllerSuiviFlux extends Controller
{

    public function suiviFlux(Request $request){
        $startEntree = $request->input('startEntree');
        $endEntree = $request->input('endEntree');
        $of = $request->input('of');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');
        $condition="";

        if($nomTiers == null){
            $idTiers = "";
        }

        if($nomStyle == null){
            $idStyle = "";
        }
        if($startEntree != null && $endEntree != null){
            $condition = " and ex_factory BETWEEN '".$startEntree."'  AND '".$endEntree."'";
        }
        if($of != null){
            $condition = $condition." and numero_commande ILIKE '%".$of."%'";
        }
        if($modele != null){
            $condition = $condition." and nom_modele ILIKE '%".$modele."%'";
        }
        if($idTiers != null){
            $condition = $condition." and id_tiers = ".$idTiers;
        }
        if($idStyle != null){
            $condition = $condition." and id_style = ".$idStyle;
        }

        $qte_coupe = SuiviFluxMes::sommeQteCoupe($condition);
        $qte_entree_chaine = SuiviFluxMes::sommeQteEntreeChaine($condition);
        $qte_transfere = SuiviFluxMes::sommeQteTransferer($condition);
        $qte_pret_livrer= SuiviFluxMes::sommeQtePretLivrer($condition);
        $qte_deja_livrer = SuiviFluxMes::sommeQteDejaLivrer($condition);
        $entree_repassage = SuiviFluxMes::sommeEntreeRepassage($condition);
        $sortie_repassage = SuiviFluxMes::sommeSortieRepassage($condition);
        $balanceatransferer=SuiviFluxMes::sommeBalanceATransferer($condition);
        $balancealivrer = SuiviFluxMes::sommeBalanceALivrer($condition);
        $balancerepassage = SuiviFluxMes::sommeBalanceRepassage($condition);
        $qte_po = SuiviFluxMes::sommeQtePo($condition);
        if($condition == ""){
            $condition = " order by id desc limit 100";
        }else{
            $condition = $condition." order by id desc";
        }
        $suivi = SuiviFluxMes::getAllSuiviFluxMes($condition);
        $now = now();

        foreach ($suivi as $s) {
            $s->diff_date = self::diff_date($now, $s->ex_factory);
            $s->pourcentage = self::getPourcentageByDifferenceDate($s->date_livraison_confirme, $s->ex_factory, $now);
        }

        

        return view('MES.suivi.flux.listeSuiviFlux',compact('idStyle','idTiers','modele','of','endEntree','startEntree','suivi','qte_po','qte_coupe','qte_entree_chaine','qte_transfere','qte_pret_livrer','qte_deja_livrer','entree_repassage','sortie_repassage','balanceatransferer','balancealivrer','balancerepassage'));
    }

    public function modificationSuiviMes(Request $request)
    {
        $qteCoupe = $request->input('qteCoupe');
        $qteEntreeChaine = $request->input('qteEntreeChaine');
        $qteTransferes = $request->input('qteTransferes');
        $pretALivrer = $request->input('pretALivrer');
        $qteDejaLivre = $request->input('qteDejaLivre');
        $entreeRepassage = $request->input('entreeRepassage');
        $sortieRepassage = $request->input('sortieRepassage');
        $idSuivi = $request->input('idSuivi');
        $commentaire = $request->input('commentaire');
        $dateActuelle = Carbon::now()->format('Y-m-d');
        SuiviFluxMes::updateSuiviFluxMes($dateActuelle, $qteCoupe, $qteEntreeChaine, $qteTransferes, $pretALivrer, $qteDejaLivre, $entreeRepassage, $sortieRepassage, $commentaire, $idSuivi);
        return redirect()->route('MES.suiviFlux');
    }

    public static function diff_date($date1, $date2){
        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);

        $diff = $date1->diffInDays($date2); // Différence en jours (toujours positive)
        $etat = $date2 >= $date1; // true si la deuxième date est après ou égale à la première
        return [
            'diff' => $diff,
            'etat' => $etat
        ];
    }

    public static function getPourcentageByDifferenceDate($dateConfirmeDemande,$dateLivrason,$today){
        $dateConfirmeDemande = Carbon::parse($dateConfirmeDemande);
        $dateLivrason = Carbon::parse($dateLivrason);
        $today = Carbon::parse($today);

        $diff = $dateConfirmeDemande->diffInDays($dateLivrason);
        // dump($diff);
        $dateReste = $today->diffInDays($dateLivrason);
        $dateVita = $diff - $dateReste;

        $pourcentage = 100; 
        if($diff != 0){
            $pourcentage = ($dateVita / $diff) * 100;
        }
        return $pourcentage;
    }

}
