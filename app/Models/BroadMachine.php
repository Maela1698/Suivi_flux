<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BroadMachine extends Model
{
    use HasFactory;

    public static function getAllDemandeWithBroadMachine($idDC)
    {
        $select = DB::select("select * from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%Broderie machine%' and id_demande_client=" . $idDC);

        return self::hydrate($select);
    }

    public static function getAllDemandeBroadMachine($condition)
    {
        $select = DB::select("select * from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%Broderie machine%' " .$condition);

        return self::hydrate($select);
    }

    public static function sommeQuantiteBroderieMachine($condition)
    {
        $select = DB::select("
        select sum(qte_commande_provisoire) as somme from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%Broderie machine%' " . $condition);
        return self::hydrate($select);
    }

    public static function sommeNegoBroderieMachine($condition)
    {
        $select = DB::select("
        select count(*) as somme from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%Broderie machine%' and type_stade ILIKE '%NEGO%' " . $condition);
        return self::hydrate($select);
    }

    public static function sommeProtoBroderieMachine($condition)
    {
        $select = DB::select("
        select count(*) as somme from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%Broderie machine%' and type_stade ILIKE '%PROTO%' " . $condition);
        return self::hydrate($select);
    }

    public static function sommeTDSBroderieMachine($condition)
    {
        $select = DB::select("
        select count(*) as somme from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%Broderie machine%' and type_stade ILIKE '%TDS%' " . $condition);
        return self::hydrate($select);
    }

    public static function sommePPSBroderieMachine($condition)
    {
        $select = DB::select("
        select count(*) as somme from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%Broderie machine%' and type_stade ILIKE '%PPS%'  or type_stade ILIKE '%CONFORM%' or type_stade ILIKE '%GARMENT%' " . $condition);
        return self::hydrate($select);
    }

    public static function sommePRODBroderieMachine($condition)
    {
        $select = DB::select("
        select count(*) as somme from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%Broderie machine%' and type_stade ILIKE '%PROD%'  or type_stade ILIKE '%SHIPMENT_SAMPLE%' " . $condition);
        return self::hydrate($select);
    }



    public function insertDemandeBroadMachine($idDC, $dateEntree)
    {
        DB::table('demandeclientbroadmachine')->insert([
            'id_demande_client' => $idDC,
            'dateentree_broadmachine' => $dateEntree,
            'etat' => 0
        ]);
    }

    public function insertDemandeBroadMachineWithSDC($idDC, $dateEntree,$idSDC)
    {
        DB::table('demandeclientbroadmachine')->insert([
            'id_demande_client' => $idDC,
            'dateentree_broadmachine' => $dateEntree,
            'id_sdc' => $idSDC,
            'etat' => 0
        ]);
    }

    public function updateDemandeBroadMachine($idDC, $idSDC)
    {
        DB::table('demandeclientbroadmachine')
            ->where('id_demande_client', $idDC)
            ->update([
                'id_sdc' => $idSDC,
                'etat' => 0
            ]);
    }

    public static function getDemandeBroadMachine()
    {
        $select = DB::select("select * from v_demandeclientbroadmachine where etat=0 order by id asc");

        return self::hydrate($select);
    }

    public static function getEtapeBroadMachine()
    {
        $select = DB::select("select * from v_demandeclientbroadmachine where etat=0 order by id asc");

        return self::hydrate($select);
    }

    public static function getDemandeBroadMachinePremier($condition)
    {
        $select = DB::select("
        SELECT DISTINCT ON (id_demande_client) id_demande_client,  stadesdc,id_sdc,etat,date_entree,id,
        nom_modele,theme,nomtier,id_tiers,nom_style,id_style,type_saison,id_saison,type_stade,
        etat_pao,etat_essai_pnx,etat_cotation,etat_demande_achat_mp,etat_broder_machine
        FROM v_demandeClientBroadMachine  where etat=0 " . $condition . "
        ORDER BY id_demande_client,id_sdc,etat,date_entree,nom_modele,
        theme,nomtier,id_tiers,nom_style,id_style,type_saison,id_saison,type_stade,
         etat_pao,etat_essai_pnx,etat_cotation,etat_demande_achat_mp,etat_broder_machine,
        id desc
        ");

        return self::hydrate($select);
    }

    public static function getDemandeChangeEtatBroadMachine($condition)
    {
        $select = DB::select("
        WITH premiers AS (
        SELECT DISTINCT ON (id_demande_client) id_demande_client, type_stade, stadesdc
        FROM v_demandeClientBroadMachine
        ORDER BY id_demande_client, type_stade, id asc)
        SELECT *
        FROM v_demandeClientBroadMachine
        WHERE   stadesdc NOT ILIKE '%PROD%' " . $condition . "  and (id_demande_client, type_stade, stadesdc) NOT IN (
        SELECT id_demande_client, type_stade, stadesdc
        FROM premiers)
        ");

        return self::hydrate($select);
    }

    public static function getDemandeProdBrodMachine($condition)
    {
        $select = DB::select("
        select * from v_demandeClientBroadMachine where stadesdc ilike '%prod%' " . $condition . " order by id asc;
        ");
        return self::hydrate($select);
    }

    public function updatePAOBrodMachine($id)
    {
        DB::table('demandeclientbroadmachine')
        ->where('id', $id)
        ->update([
            'etat_pao' => 1,
        ]);
    }

    public function updateEssaiPnxBrodMachine($id)
    {
        DB::table('demandeclientbroadmachine')
        ->where('id', $id)
        ->update([
            'etat_essai_pnx' => 1,
        ]);
    }


    public function updateCotationBrodMachine($id)
    {
        DB::table('demandeclientbroadmachine')
        ->where('id', $id)
        ->update([
            'etat_cotation' => 1,
        ]);
    }

    public function updateDemandeAchatMpBrodMachine($id)
    {
        DB::table('demandeclientbroadmachine')
        ->where('id', $id)
        ->update([
            'etat_demande_achat_mp' => 1,
        ]);
    }

    public function updateBrodMachineBrodMachine($id)
    {
        DB::table('demandeclientbroadmachine')
        ->where('id', $id)
        ->update([
            'etat_broder_machine' => 1,
        ]);
    }

    public static function getSmvBmc()
    {
        $select = DB::select("select * from smvBmc where etat=0 order by id asc");
        return self::hydrate($select);
    }

    public static function updateTempsMachine($tempsMachine)
    {
        DB::select('update smvBmc set temps=?  where id=7', [$tempsMachine]);
    }

    public static function updateTempsNettoyage($tempsNettoyage)
    {
        DB::select('update smvBmc set temps=?  where id=9', [$tempsNettoyage]);
    }

    public static function updateTempsGarnissage($tempsGarnissage)
    {
        DB::select('update smvBmc set temps=?  where id=10', [$tempsGarnissage]);
    }

    public function insertNombrePoints($idDC, $smv,$temps_machine,$temps_nettoyage, $temps_garnissage, $somme_nb_points)
    {
        DB::table('nombrepoints')->insert([
            'id_demande_client' => $idDC,
            'smv' => $smv,
            'temps_machine' => $temps_machine,
            'temps_nettoyage' => $temps_nettoyage,
            'temps_garnissage' => $temps_garnissage,
            'somme_nb_points' => $somme_nb_points,
            'etat' => 0
        ]);
    }

    public function insertDetailNombrePoints($id_nb_points, $nombre_points,$taille,$quantite)
    {
        DB::table('detailnombrepoints')->insert([
            'id_nb_points' => $id_nb_points,
            'nombre_points' => $nombre_points,
            'taille' => $taille,
            'quantite' => $quantite,
            'etat' => 0
        ]);
    }

    public static function getNombrePointsByDemande($id_demande_client)
    {
        $select = DB::select("select * from nombrepoints where id_demande_client=".$id_demande_client);
        return self::hydrate($select);
    }

    public static function getDetailNombrePointsByIdNbPoints($id_nb_points)
    {
        $select = DB::select("select * from detailNombrePoints where id_nb_points=".$id_nb_points);
        return self::hydrate($select);
    }

    public static function updateNombrePoints($smv,$temps_machine,$temps_nettoyage,$temps_garnissage,$somme_nb_points,$id_demande_client)
    {
        DB::select('update nombrepoints set smv=?, temps_machine=?, temps_nettoyage=?, temps_garnissage=?, somme_nb_points=? where id_demande_client=?', [$smv,$temps_machine,$temps_nettoyage,$temps_garnissage,$somme_nb_points,$id_demande_client]);
    }

    public static function updateDetailNombrePoints($taille,$quantite,$nombre_points,$id_nb_points)
    {
        DB::select('update detailnombrepoints set  quantite=?, nombre_points=? where id_nb_points=? and taille=?', [$quantite,$nombre_points,$id_nb_points,$taille]);
    }

    public function insertSuiviFluxBrodMachine($idDC, $date_operation,$quantite,$recoupe,$type_flux)
    {
        DB::table('suivifluxbrodmachine')->insert([
            'id_demande_client' => $idDC,
            'date_operation' => $date_operation,
            'quantite' => $quantite,
            'recoupe' => $recoupe,
            'type_flux' => $type_flux,
            'etat' => 0
        ]);
    }

    public static function listeSuiviFluxMachine()
    {
        $select = DB::select("select * from v_suiviFluxBrodMachine where etat=0 order by id_suivi_flux desc");
        return self::hydrate($select);
    }




}
