<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Serigraphie extends Model
{
    use HasFactory;

    public static function getAllDemandeClientWithSerigraphie($condition)
    {
        $select = DB::select("select * from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%serigraphie%' " . $condition);
        return self::hydrate($select);
    }

    public static function sommeQuantiteSerigraphie($condition)
    {
        $select = DB::select("
        select sum(qte_commande_provisoire) as somme from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%serigraphie%' " . $condition);
        return self::hydrate($select);
    }

    public static function sommeNegoSerigraphie($condition)
    {
        $select = DB::select("
        select count(*) as somme from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%serigraphie%' and type_stade ILIKE '%NEGO%' " . $condition);
        return self::hydrate($select);
    }

    public static function sommeProtoSerigraphie($condition)
    {
        $select = DB::select("
        select count(*) as somme from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%serigraphie%' and type_stade ILIKE '%PROTO%' " . $condition);
        return self::hydrate($select);
    }

    public static function sommeTDSSerigraphie($condition)
    {
        $select = DB::select("
        select count(*) as somme from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%serigraphie%' and type_stade ILIKE '%TDS%' " . $condition);
        return self::hydrate($select);
    }

    public static function sommePPSSerigraphie($condition)
    {
        $select = DB::select("
        select count(*) as somme from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%serigraphie%' and type_stade ILIKE '%PPS%'  or type_stade ILIKE '%CONFORM%' or type_stade ILIKE '%GARMENT%' " . $condition);
        return self::hydrate($select);
    }

    public static function sommePRODSerigraphie($condition)
    {
        $select = DB::select("
        select count(*) as somme from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%serigraphie%' and type_stade ILIKE '%PROD%'  or type_stade ILIKE '%SHIPMENT_SAMPLE%' " . $condition);
        return self::hydrate($select);
    }

    public static function getAllDemandeWithSerigraphieByDemande($idDC)
    {
        $select = DB::select("select * from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%serigraphie%' and id_demande_client=" . $idDC);

        return self::hydrate($select);
    }

    public static function getAllEtapeSerigrahie()
    {
        $select = DB::select("select *from etapeSerigraphie where etat=0 order by niveauEtape asc");
        return self::hydrate($select);
    }


    public function insertDemandeSerigraphie($idDC, $dateEntree)
    {
        DB::table('demandeclientserigraphie')->insert([
            'id_demande_client' => $idDC,
            'date_entree' => $dateEntree,
            'etat' => 0
        ]);
    }

    public function insertDemandeSerigraphieWithSDC($idDC, $idSDC, $dateEntree)
    {
        DB::table('demandeclientserigraphie')->insert([
            'id_demande_client' => $idDC,
            'id_sdc' => $idSDC,
            'date_entree' => $dateEntree,
            'etat' => 0
        ]);
    }

    public function updateDemandeSerigraphie($idDC, $idSDC)
    {
        DB::table('demandeclientserigraphie')
            ->where('id_demande_client', $idDC)
            ->update([
                'id_sdc' => $idSDC,
                'etat' => 0
            ]);
    }

    public static function getDemandePremierPlanningSerigraphie($condition)
    {
        $select = DB::select("
        SELECT DISTINCT ON (id_demande_client) id_demande_client, stade_demande, stadesdc,id_sdc,etat,date_entree,id,
        nom_modele,theme,nomtier,id_tiers,nom_style,id_style,id_stade_demande_client,type_saison,id_saison,stade_sanssdc,
        etat_achat_encre_echan,etat_pao,etat_pri,etat_impression_dession,
        etat_recher_coloris_validaint,etat_insolacadre,etat_raclage,
        etat_achat_encre_prod,etat_gabarits,etat_prepa_table,etat_prepa_encre_prod,
        fin,deadline
        FROM v_demandeSerigraphie where etat=0 " . $condition . "
        ORDER BY id_demande_client, stade_demande,id_sdc,etat,date_entree,nom_modele,
        theme,nomtier,id_tiers,nom_style,id_style,id_stade_demande_client,type_saison,id_saison,stade_sanssdc,
         etat_achat_encre_echan,etat_pao,etat_pri,etat_impression_dession,
         etat_recher_coloris_validaint,etat_insolacadre,etat_raclage,
         etat_achat_encre_prod,etat_gabarits,etat_prepa_table,etat_prepa_encre_prod,
         fin,deadline,
        id asc;
        ");
        return self::hydrate($select);
    }


    public static function getDemandeChangeStadePlanningSerigraphie($condition)
    {
        $select = DB::select("
       WITH premiers AS (
    SELECT DISTINCT ON (id_demande_client)
        id_demande_client, stade_demande, stadesdc
    FROM v_demandeSerigraphie
    ORDER BY id_demande_client, stade_demande, id
)
SELECT *
FROM v_demandeSerigraphie
WHERE
    stadesdc NOT ILIKE '%PROD%'
     " . $condition . "
    AND (id_demande_client, stade_demande, stadesdc) NOT IN (
        SELECT id_demande_client, stade_demande, stadesdc
        FROM premiers
    )
ORDER BY id asc;
;
        ");
        return self::hydrate($select);
    }

    public static function getAllDemandePlanningSerigraphieByDemande($idDC)
    {
        $select = DB::select("select * from v_demandeSerigraphie where id_demande_client=" . $idDC);
        return self::hydrate($select);
    }

    public static function getDemandeProdlanningSerigraphie($condition)
    {
        $select = DB::select("
        select * from v_demandeSerigraphie where stadesdc ilike '%prod%' " . $condition . " order by id asc;
        ");
        return self::hydrate($select);
    }

    public static function getDemandeWithSerigraphie($condition)
    {
        $select = DB::select("
        select * from v_demandeSerigraphie where etat=0 " . $condition);
        return self::hydrate($select);
    }



    public function insertSuiviFluxSerigraphie($idDCSer, $dateOper, $flux)
    {
        DB::table('suivifluxserigraphie')->insert([
            'id_demande_client' => $idDCSer,
            'date_operation' => $dateOper,
            'type_flux' => $flux,
            'etat' => 0
        ]);
    }
    public function insertDetailSuiviFluxSerigraphie($id_suivi_flux, $unite_taille,$qte,$recoupe)
    {
        DB::table('detailsuivifluxserigraphie')->insert([
            'id_suivi_flux' => $id_suivi_flux,
            'unite_taille' => $unite_taille,
            'qte' => $qte,
            'recoupe' => $recoupe,
            'etat' => 0
        ]);
    }

    public static function deleteDetailSuiviFlux($id)
    {
        DB::select('delete from detailsuivifluxserigraphie where id_suivi_flux=' . $id);
    }

     public static function getSuiviFluxSerByDemande($idDC)
    {
        $select = DB::select("
        select * from suivifluxserigraphie where id_demande_client= " . $idDC);
        return self::hydrate($select);
    }

    public static function getDetailSuiviFluxSerByIdSuivi($id_suivi_flux)
    {
        $select = DB::select("
        select * from detailsuivifluxserigraphie where id_suivi_flux= " . $id_suivi_flux." order by id asc");
        return self::hydrate($select);
    }

    public function updateEtatAchatEncreEchan($id)
    {
        DB::select('update demandeclientserigraphie set etat_achat_encre_echan=1  where id=?', [$id]);
    }

    public function updateEtatPao($id)
    {
        DB::select('update demandeclientserigraphie set etat_pao=1  where id=?', [$id]);
    }

    public function updateEtatPri($id)
    {
        DB::select('update demandeclientserigraphie set etat_pri=1  where id=?', [$id]);
    }

    public function updateEtatImpressionDessin($id)
    {
        DB::select('update demandeclientserigraphie set etat_impression_dession=1  where id=?', [$id]);
    }

    public function updateEtatRecherchColorisValida($id)
    {
        DB::select('update demandeclientserigraphie set etat_recher_coloris_validaint=1  where id=?', [$id]);
    }

    public function updateEtatInsolaCadre($id)
    {
        DB::select('update demandeclientserigraphie set etat_insolacadre=1  where id=?', [$id]);
    }
    public function updateEtatRaclage($id)
    {
        DB::select('update demandeclientserigraphie set etat_raclage=1  where id=?', [$id]);
    }
    public function updateEtatAchatEncreProd($id)
    {
        DB::table('demandeclientserigraphie')
            ->where('id', $id)
            ->update([
                'etat_achat_encre_prod' => 1,
            ]);
    }
    public function updateEtatGabarits($id)
    {
        DB::table('demandeclientserigraphie')
            ->where('id', $id)
            ->update([
                'etat_gabarits' => 1,
            ]);
    }
    public function updateEtatPrepaTable($id)
    {
        DB::table('demandeclientserigraphie')
            ->where('id', $id)
            ->update([
                'etat_prepa_table' => 1,
            ]);
    }
    public function updateEtatPrepaEncreProd($id)
    {
        DB::table('demandeclientserigraphie')
            ->where('id', $id)
            ->update([
                'etat_prepa_encre_prod' => 1,
            ]);
    }

    public static function getDemandeWithSerigraphieById($id)
    {
        $select = DB::select("select * from v_demandeSerigraphie where id=" . $id);
        return self::hydrate($select);
    }

    public static function getSuiviFluxSerigraphie($condition)
    {
        $select = DB::select("select * from v_suiviFluxSerigraphie where etat=0 ".$condition." order by id desc");

        return self::hydrate($select);
    }

    public static function getSuiviFluxSerigraphieById($id)
    {
        $select = DB::select("select * from v_suiviFluxSerigraphie where id=".$id);

        return self::hydrate($select);
    }

    public function insertRapportJournalier($data)
    {
        DB::table('rapportjournalier')->insert([
            'date_pro' => $data['date_pro'],
            'taux_retouche' => $data['taux_retouche'],
            'taux_rejet' => $data['taux_rejet'],
            'produit_chmique' => $data['produit_chmique'],
            'valeur' => $data['valeur'],
            'electricite' => $data['electricite'],
            'reclam_loading' => $data['reclam_loading'],
            'nc_traite' => $data['nc_traite'],
            'absenteisme' => $data['absenteisme'],
            'commentaire' => $data['commentaire'],
            'nb_operateur' => $data['nb_operateur'],
            'id_demande_client' => $data['id_demande_ser'],
            'etat' => 0
        ]);
    }

    public function insertDetailRapportJournalier($idRapport, $heure, $qte)
    {
        DB::table('detailrapportjournalier')->insert([
            'id_rapport_journalier' => $idRapport,
            'heure' => $heure,
            'qte' => $qte,
            'etat' => 0
        ]);
    }

    public static function rapportJournalierDernier()
    {
        $select = DB::select("select * from rapportjournalier  order by id desc limit 1");
        return self::hydrate($select);
    }

    public static function getAllRapportJournalier($condition)
    {
        $select = DB::select("select * from v_rapportjournalierser where etat=0 " . $condition . " order by id desc");
        return self::hydrate($select);
    }

    public static function rapportJournalierById($id)
    {
        $select = DB::select("select * from rapportjournalier where id=" . $id);
        return self::hydrate($select);
    }

    public static function rapportDetailJournalierById($id)
    {
        $select = DB::select("select * from detailrapportjournalier where id_rapport_journalier=" . $id . " order by heure asc");
        return self::hydrate($select);
    }

    public function updateRapportJournalier($data)
    {
        DB::table('rapportjournalier')
            ->where('id', $data['id'])
            ->update([
                'taux_retouche' => $data['taux_retouche'],
                'taux_rejet' => $data['taux_rejet'],
                'produit_chmique' => $data['produit_chmique'],
                'valeur' => $data['valeur'],
                'electricite' => $data['electricite'],
                'reclam_loading' => $data['reclam_loading'],
                'nc_traite' => $data['nc_traite'],
                'absenteisme' => $data['absenteisme'],
                'commentaire' => $data['commentaire'],
                'nb_operateur' => $data['nb_operateur'],
                'etat' => 0
            ]);
    }

    public static function deleteDetailRapportById($id)
    {
        DB::select('delete from detailrapportjournalier where id_rapport_journalier=' . $id);
    }

    public static function getAllTypeEncre()
    {
        $select = DB::select("select * from typeencre where etat=0");
        return self::hydrate($select);
    }

    public function insertParametreSer($smv_print, $qte_coupe, $id_demande_ser, $prix_print)
    {
        DB::table('parametreser')->insert([
            'smv_print' => $smv_print,
            'qte_coupe' => $qte_coupe,
            'id_demande_client' => $id_demande_ser,
            'prix_print' => $prix_print,
            'etat' => 0
        ]);
    }



    public function insertDetailParametreSer($id_parametre_ser, $id_type_encre, $id_encre, $grammage, $couche)
    {
        DB::table('detailparametreser')->insert([
            'id_parametre_ser' => $id_parametre_ser,
            'id_type_encre' => $id_type_encre,
            'id_encre' => $id_encre,
            'grammage' => $grammage,
            'couche' => $couche,
            'etat' => 0
        ]);
    }

    public static function getDernierParametreSer()
    {
        $select = DB::select("select * from parametreser order by id desc limit 1");
        return self::hydrate($select);
    }

    public static function getParametreSerByDemande($idDemande)
    {
        $select = DB::select("select * from parametreser where id_demande_client=".$idDemande);
        return self::hydrate($select);
    }

    public static function updateParametreSer($smv_print, $qte_coupe, $id_demande_ser, $prix_print)
    {
        DB::select('update parametreser set smv_print=? , qte_coupe=?, prix_print=? where id_demande_client=?', [$smv_print, $qte_coupe,$prix_print,$id_demande_ser]);
    }

    public static function deleteDetailParametreSer($idDetail)
    {
        DB::select('delete from detailparametreser where id=?', [$idDetail]);
    }

    public static function getAllDetailrapport($idDemandeSer)
    {
        $select = DB::select("select * from v_detailparametreser where id_demande_client=" . $idDemandeSer);
        return self::hydrate($select);
    }

    public static function isRapportProdSerExiste($datePro)
    {
        $select = DB::select("select * from rapportjournalier where DATE(date_pro) ='" . $datePro . "'");
        return self::hydrate($select);
    }


    public function insertPlanningSerigraphie($id_demande_ser, $deadline, $fin, $id_etape)
    {
        DB::table('planningdemandeser')->insert([
            'id_demande_ser' => $id_demande_ser,
            'deadline' => $deadline,
            'fin' => $fin,
            'id_etape' => $id_etape
        ]);
    }

    public static function sommeQteRapportSerigraphie($condition)
    {
        $select = DB::select("
        select SUM(total_qte) as somme from v_rapportJournalierSer where  etat=0 " . $condition);
        return self::hydrate($select);
    }

    public static function sommeEfficienceRapportSerigraphie($condition)
    {
        $select = DB::select("
        select SUM(efficience) as somme from v_rapportJournalierSer where  etat=0 " . $condition);
        return self::hydrate($select);
    }

    public static function sommeCARapportSerigraphie($condition)
    {
        $select = DB::select("
        select SUM(chiffre_affaire) as somme from v_rapportJournalierSer where  etat=0 " . $condition);
        return self::hydrate($select);
    }

    public static function sommeRetoucheRapportSerigraphie($condition)
    {
        $select = DB::select("
        select SUM(taux_retouche) as somme from v_rapportJournalierSer where  etat=0 " . $condition);
        return self::hydrate($select);
    }

    public static function sommeElectriciteRapportSerigraphie($condition)
    {
        $select = DB::select("
        select SUM(electricite) as somme from v_rapportJournalierSer where  etat=0 " . $condition);
        return self::hydrate($select);
    }

    public static function sommeValeurRapportSerigraphie($condition)
    {
        $select = DB::select("
        select SUM(valeur) as somme from v_rapportJournalierSer where  etat=0 " . $condition);
        return self::hydrate($select);
    }

    public static function sommeNcTraiteRapportSerigraphie($condition)
    {
        $select = DB::select("
        select SUM(nc_traite) as somme from v_rapportJournalierSer where  etat=0 " . $condition);
        return self::hydrate($select);
    }

    public static function sommeAbsenteismeRapportSerigraphie($condition)
    {
        $select = DB::select("
        select SUM(absenteisme) as somme from v_rapportJournalierSer where  etat=0 " . $condition);
        return self::hydrate($select);
    }

    public static function sommeQuantiteCoupeSuiviFlux($condition)
    {
        $select = DB::select("
        select SUM(recoupe) as recoupe from v_suiviFluxSerigraphie where  etat=0 " . $condition);
        return self::hydrate($select);
    }

    public static function sommeQuantiteRecuSuiviFlux($condition)
    {
        $select = DB::select("
        select SUM(qte) as qte from v_suiviFluxSerigraphie where  etat=0 and type_flux=1 " . $condition);
        return self::hydrate($select);
    }

    public static function sommeQuantiteLivreSuiviFlux($condition)
    {
        $select = DB::select("
        select SUM(qte) as qte from v_suiviFluxSerigraphie where  etat=0 and type_flux=2 " . $condition);
        return self::hydrate($select);
    }
}
