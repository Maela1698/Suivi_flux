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
        $qteRejetChaine = SuiviFluxMes::sommeRejetChaine($condition);
        $qteRejetCoupe = SuiviFluxMes::sommeRejetCoupe($condition);
        $pourcentageCoupe = ($qte_coupe/$qte_po)*100;
        $pourcentageExpediee = ($qte_deja_livrer/$qte_coupe)*100;
        $pourcentageBoxing = ($qte_pret_livrer/$qte_coupe)*100;
        $pourcentageRepassage = ($sortie_repassage/$qte_coupe)*100;
        $pourcentageRejetCoupe = ($qteRejetCoupe/$qte_coupe)*100;
        $pourcentageRejetChaine = ($qteRejetChaine/$qte_coupe)*100;
        if($condition == ""){
            $condition = " order by id desc limit 100";
        }else{
            $condition = $condition." order by id desc";
        }
        $suivi = SuiviFluxMes::getAllSuiviFluxMes($condition);


        return view('MES.suivi.flux.listeSuiviFlux',compact('pourcentageExpediee','pourcentageRepassage','pourcentageRejetChaine','pourcentageRejetCoupe','pourcentageBoxing','pourcentageCoupe','nomStyle','nomTiers','idStyle','idTiers','modele','of','endEntree','startEntree','suivi','qte_po','qte_coupe','qte_entree_chaine','qte_transfere','qte_pret_livrer','qte_deja_livrer','entree_repassage','sortie_repassage','balanceatransferer','balancealivrer','balancerepassage'));
    }

    public function modificationSuiviMes(Request $request)
    {
        $startEntree = $request->input('startEntree');
        $endEntree = $request->input('endEntree');
        $of = $request->input('of');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');

        $qteCoupe = $request->input('qteCoupe');
        $qteEntreeChaine = $request->input('qteEntreeChaine');
        $qteTransferes = $request->input('qteTransferes');
        $pretALivrer = $request->input('pretALivrer');
        $qteDejaLivre = $request->input('qteDejaLivre');
        $entreeRepassage = $request->input('entreeRepassage');
        $sortieRepassage = $request->input('sortieRepassage');
        $idSuivi = $request->input('idSuivi');
        $commentaire = $request->input('commentaire');
        $rejetChaine = $request->input('rejetChaine');
        $rejetCoupe = $request->input('rejetCoupe');
        $dateActuelle = Carbon::now()->format('Y-m-d');
        $coupeFinal = $request->input('coupeFinal');

        $erreur ="";
        if($qteCoupe<$qteEntreeChaine){
            $erreur = $erreur." -La quantité entree chaine ne doit pas etre superieur à la quantité coupée de ".$qteCoupe."|";
        }
        if($qteEntreeChaine<$qteTransferes){
            $erreur =  $erreur."-La quantité transferee ne doit pas etre superieur à la quantité entree de ".$qteEntreeChaine."|";
        }
        if($qteCoupe<$pretALivrer){
            $erreur =  $erreur."-La quantité pret a livrer doit ne doit pas etre superieur à la quantité coupée de ".$qteCoupe."|";
        }
        if($pretALivrer<$qteDejaLivre){
            $erreur =  $erreur."-La quantité deja livrer doit ne doit pas etre superieur à la quantité pret a livrer de ".$pretALivrer."|";
        }
        if($qteCoupe<$entreeRepassage){
            $erreur =  $erreur."La quantité entree repassage doit ne doit pas etre superieur à la quantité coupée de ".$qteCoupe."|";
        }
        if($entreeRepassage<$sortieRepassage){
            $erreur =  $erreur."-La quantité sortie repassage doit ne doit pas etre superieur à la quantité entree repassage de ".$entreeRepassage."|";
        }
        if(empty($coupeFinal)){
            $coupeFinal=0;
        }
        if(empty($erreur)){
            SuiviFluxMes::updateSuiviFluxMes($dateActuelle, $qteCoupe, $qteEntreeChaine, $qteTransferes, $pretALivrer, $qteDejaLivre, $entreeRepassage, $sortieRepassage, $commentaire, $rejetCoupe,$rejetChaine,$coupeFinal,$idSuivi);
            return redirect()->route('MES.suiviFlux', compact('startEntree', 'endEntree', 'of', 'modele', 'idTiers', 'idStyle', 'nomTiers', 'nomStyle'));
        }else{
            return redirect()->route('MES.suiviFlux', compact('startEntree', 'endEntree', 'of', 'modele', 'idTiers', 'idStyle', 'nomTiers', 'nomStyle'))->with('error', $erreur);
        }

    }

}
