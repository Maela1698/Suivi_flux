<?php

namespace App\Http\Controllers\MES;

use App\Http\Controllers\Controller;
use App\Models\MES\SuiviFluxMes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ControllerSuiviFlux extends Controller
{

    public function suiviFlux(Request $request)
    {
        $startEntree = $request->input('startEntree');
        $endEntree = $request->input('endEntree');
        $of = $request->input('of');
        $modele = $request->input('modele');
        $idTiers = $request->input('idTiers');
        $idStyle = $request->input('idStyle');
        $nomTiers = $request->input('nomTiers');
        $nomStyle = $request->input('nomStyle');
        $condition = "";

        if ($nomTiers == null) {
            $idTiers = "";
        }

        if ($nomStyle == null) {
            $idStyle = "";
        }
        if ($startEntree != null && $endEntree != null) {
            $condition = " and ex_factory BETWEEN '" . $startEntree . "'  AND '" . $endEntree . "'";
        }
        if ($of != null) {
            $condition = $condition . " and numero_commande ILIKE '%" . $of . "%'";
        }
        if ($modele != null) {
            $condition = $condition . " and nom_modele ILIKE '%" . $modele . "%'";
        }
        if ($idTiers != null) {
            $condition = $condition . " and id_tiers = " . $idTiers;
        }
        if ($idStyle != null) {
            $condition = $condition . " and id_style = " . $idStyle;
        }

        $qte_coupe = SuiviFluxMes::sommeQteCoupe($condition);
        $qte_entree_chaine = SuiviFluxMes::sommeQteEntreeChaine($condition);
        $qte_transfere = SuiviFluxMes::sommeQteTransferer($condition);
        $qte_pret_livrer = SuiviFluxMes::sommeQtePretLivrer($condition);
        $qte_deja_livrer = SuiviFluxMes::sommeQteDejaLivrer($condition);
        $entree_repassage = SuiviFluxMes::sommeEntreeRepassage($condition);
        $sortie_repassage = SuiviFluxMes::sommeSortieRepassage($condition);
        $balanceatransferer = SuiviFluxMes::sommeBalanceATransferer($condition);
        $balancealivrer = SuiviFluxMes::sommeBalanceALivrer($condition);
        $balancerepassage = SuiviFluxMes::sommeBalanceRepassage($condition);
        $qte_po = SuiviFluxMes::sommeQtePo($condition);
        $qteRejetChaine = SuiviFluxMes::sommeRejetChaine($condition);
        $qteRejetCoupe = SuiviFluxMes::sommeRejetCoupe($condition);
        $nombreOf  = SuiviFluxMes::sommeNombreOf($condition);
        $nombreSuivi = SuiviFluxMes::sommeNombreSuiviFux($condition);
        $sommeEtat = SuiviFluxMes::sommeEtat($condition);
        $etat=0;
        if($nombreSuivi==$sommeEtat){
            $etat=1;
        }

        $pourcentageCoupe=0;
        if($qte_po!=0){
            $pourcentageCoupe = ($qte_coupe / $qte_po) * 100;
        }

        $pourcentageExpediee=0;
        $pourcentageBoxing=0;
        $pourcentageRepassage=0;
        $pourcentageRejetCoupe=0;
        $pourcentageRejetChaine=0;
        $pourcentageTransferer=0;
        if ($qte_coupe != 0) {
            $pourcentageExpediee = ($qte_deja_livrer / $qte_coupe) * 100;
            $pourcentageBoxing = ($qte_pret_livrer / $qte_coupe) * 100;
            $pourcentageRepassage = ($sortie_repassage / $qte_coupe) * 100;
            $pourcentageRejetCoupe = ($qteRejetCoupe / $qte_coupe) * 100;
            $pourcentageRejetChaine = ($qteRejetChaine / $qte_coupe) * 100;
            $pourcentageTransferer = ($qte_transfere / $qte_coupe) * 100;
        }

        if ($condition == "") {
            $condition = " order by id desc limit 100";
        } else {
            $condition = $condition . " order by id desc";
        }
        $suivi = SuiviFluxMes::getAllSuiviFluxMes($condition);
        $now = now();

        foreach ($suivi as $s) {
            $s->diff_date = self::diff_date($now, $s->ex_factory);
            $s->pourcentage = self::getPourcentageByDifferenceDate($s->date_livraison_confirme, $s->ex_factory, $now);
        }
        return view('MES.suivi.flux.listeSuiviFlux', compact('pourcentageTransferer','etat','nombreOf','pourcentageExpediee', 'pourcentageRepassage', 'pourcentageRejetChaine', 'pourcentageRejetCoupe', 'pourcentageBoxing', 'pourcentageCoupe', 'nomStyle', 'nomTiers', 'idStyle', 'idTiers', 'modele', 'of', 'endEntree', 'startEntree', 'suivi', 'qte_po', 'qte_coupe', 'qte_entree_chaine', 'qte_transfere', 'qte_pret_livrer', 'qte_deja_livrer', 'entree_repassage', 'sortie_repassage', 'balanceatransferer', 'balancealivrer', 'balancerepassage'));
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
        }elseif($qteCoupe>=$qteEntreeChaine){
            $erreur = $erreur."";
        }

        if($qteEntreeChaine<$qteTransferes){
            $erreur =  $erreur."-La quantité transferee ne doit pas etre superieur à la quantité entree de ".$qteEntreeChaine."|";
        }elseif($qteEntreeChaine>=$qteTransferes){
            $erreur = $erreur."";
        }

        if($qteCoupe<$pretALivrer){
            $erreur =  $erreur."-La quantité pret a livrer doit ne doit pas etre superieur à la quantité coupée de ".$qteCoupe."|";
        }elseif($qteCoupe>=$pretALivrer){
            $erreur = $erreur."";
        }

        if($pretALivrer<$qteDejaLivre){
            $erreur =  $erreur."-La quantité deja livrer doit ne doit pas etre superieur à la quantité pret a livrer de ".$pretALivrer."|";
        }elseif($pretALivrer>=$qteDejaLivre){
            $erreur = $erreur."";
        }

        if($qteCoupe<$entreeRepassage){
            $erreur =  $erreur."La quantité entree repassage doit ne doit pas etre superieur à la quantité coupée de ".$qteCoupe."|";
        }elseif($qteCoupe>=$entreeRepassage){
            $erreur = $erreur."";
        }

        if($entreeRepassage<$sortieRepassage){
            $erreur =  $erreur."-La quantité sortie repassage doit ne doit pas etre superieur à la quantité entree repassage de ".$entreeRepassage."|";
        }elseif($entreeRepassage>=$sortieRepassage){
            $erreur = $erreur."";
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

    public static function diff_date($date1, $date2){
        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);


        $diff = $date1->diffInDays($date2); // Différence en jours (toujours positive)
        $etat = 0;
        $jourJ = false;
        if($date2 >= $date1){
            $etat = 1;
        }
        if($etat == 1){
            $diff++;
        }
        if($diff == 0){
            $jourJ = true;
        }
        return [
            'diff' => $diff,
            'etat' => $etat,
            'jourJ' => $jourJ
        ];
    }

    public static function getPourcentageByDifferenceDate($dateConfirmeDemande,$dateLivrason,$today){
        $dateConfirmeDemande = Carbon::parse($dateConfirmeDemande);
        $dateLivrason = Carbon::parse($dateLivrason);
        $today = Carbon::parse($today);

        // $diff = $dateConfirmeDemande->diffInDays($dateLivrason);
        $diff = self::diff_date($dateConfirmeDemande,$dateLivrason);
        // $dateReste = $today->diffInDays($dateLivrason);
        $dateReste = self::diff_date($today,$dateLivrason);
        // $dateVita = $diff - $dateReste;
        $dateVita = $diff['diff'] - $dateReste['diff'];
        if($dateVita < 0){
            $dateVita = $dateVita * -1;
        }
        $pourcentage = 100;
        if($diff != 0){
            $pourcentage = ($dateVita / $diff['diff']) * 100;
        }
        return $pourcentage;
    }

    public function exportCSVFlux()
    {
        $fileName = 'suivi_flux_' . Carbon::now()->format('d_m_Y') . '.csv';

        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');

            // Ajouter l'entête du fichier CSV
            fputcsv($handle, [
            'Client',
            'Style',
            'OF N°',
            'Designation',
            'size',
            'qte P.O',
            'Qte coupe',
            'Qte entree chaine',
            'Qte transferes(sortie chaine)',
            'Balance a transfere',
            'Pret a livrer(BOXING)',
            'Qte deja livre(Expediee)',
            'Balance a livrer(Expediee)',
            'Ex-Factory',
            'Commentaire'],separator: ';');

            // Récupérer les données de la base
            $demandes = DB::table('v_suivifluxmes')->get();

            // Insérer les données dans le CSV
            foreach ($demandes as $demande) {
                fputcsv($handle, [
            $demande->nomtier ,
            $demande->nom_modele ,
            $demande->numero_commande ,
            $demande->nom_style ,
            $demande->unite_taille ,
            $demande->qte_po ,
            $demande->qte_coupe ,
            $demande->qte_entree_chaine ,
            $demande->qte_transfere ,
            $demande->balanceatransferer ,
            $demande->qte_pret_livrer ,
            $demande->qte_deja_livrer ,
            $demande->balancealivrer,
            $demande->ex_factory,
            $demande->commentaire
            ],';');
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$fileName.'"');

        return $response;
    }
}
