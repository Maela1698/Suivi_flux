<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BroadMain extends Model
{
    use HasFactory;


    public static function getAllDemandeWithBroadMain($idDC)
    {
        $select = DB::select("select * from v_valeurAjouteeDemandeVamm where type_valeur_ajoutee ILIKE '%Broderie main%'  and id_demande_client=" . $idDC);

        return self::hydrate($select);
    }


    public static function getAllDemandeWithSmockMain($idDC)
    {
        $select = DB::select("select * from v_valeurAjouteeDemandeVamm where  type_valeur_ajoutee ILIKE '%Smock main%' and id_demande_client=" . $idDC);

        return self::hydrate($select);
    }

    public static function getDemandeWithBroadMainAndSmock($condition)
    {
        $select = DB::select(" select * from v_valeurAjouteeDemandeVamm where (type_valeur_ajoutee ILIKE '%Broderie main%' or  type_valeur_ajoutee ILIKE '%smock main%') " .$condition);
        return self::hydrate($select);
    }

    public static function getNbCommandeDevBrodMainAndSmock($condition)
    {
        $select = DB::select(" select count(*) as compte from v_valeurAjouteeDemandeVamm where (type_valeur_ajoutee ILIKE '%Broderie main%' or  type_valeur_ajoutee ILIKE '%smock main%') and type_stade not ilike '%prod%' " .$condition);
        return self::hydrate($select);
    }

    public static function getNbCommandeProdBrodMainAndSmock($condition)
    {
        $select = DB::select(" select count(*) as compte from v_valeurAjouteeDemandeVamm where (type_valeur_ajoutee ILIKE '%Broderie main%' or  type_valeur_ajoutee ILIKE '%smock main%') and type_stade ilike '%prod%' " .$condition);
        return self::hydrate($select);
    }



    public function insertDemandeBroadMain($idDC, $dateEntree, $type)
    {
        DB::table('demandeclientbrodmain')->insert([
            'type' => $type,
            'id_demande_client' => $idDC,
            'dateentree_broadmain' => $dateEntree,
            'etat' => 0
        ]);
    }

    public function insertDemandeBroadMainWithSdc($idDC, $dateEntree, $id_sdc, $type)
    {
        DB::table('demandeclientbrodmain')->insert([
            'type' => $type,
            'id_demande_client' => $idDC,
            'dateentree_broadmain' => $dateEntree,
            'id_sdc' => $id_sdc,
            'etat' => 0
        ]);
    }

    public static function getAllDemandeBroadMain()
    {
        $select = DB::select("select * from v_demandeclientbroadmain where etat=0");

        return self::hydrate($select);
    }

    public function updateDemandeBroadMain($idDC, $idSDC)
    {
        DB::table('demandeclientbrodmain')
            ->where('id_demande_client', $idDC)
            ->update([
                'id_sdc' => $idSDC,
                'etat' => 0
            ]);
    }

    public static function getAllDemandeBroadMainById($id)
    {
        $select = DB::select("select * from v_demandeclientbroadmain where id_demande_client=" . $id);

        return self::hydrate($select);
    }


    public static function insertConsoFilBrodMain($idDC, $nb_heure, $prix, $unite)
    {
        DB::table('consofilbrodmain')->insert([
            'id_demande_client' => $idDC,
            'nb_heure' => $nb_heure,
            'id_unite_monetaire' => $unite,
            'prix' => $prix,
            'etat' => 0
        ]);
    }

    public static function updateConsoFilBroadMain($id, $nb_heure,$unite,$prix)
    {
        DB::table('consofilbrodmain')
            ->where('id', $id)
            ->update([
                'nb_heure' => $nb_heure,
                'id_unite_monetaire' => $unite,
                'prix' => $prix
            ]);
    }

    public function insertDetailConsoFilBrodMain($id_conso, $couleur, $conso)
    {
        DB::table('detailconsofilbrodmain')->insert([
            'id_conso' => $id_conso,
            'couleur' => $couleur,
            'conso' => $conso,
            'etat' => 0
        ]);
    }

    public static function deleteDetailConsoFilByIdConso($idConso){
        DB::select('delete from detailconsofilbrodmain where id_conso='.$idConso);
    }



    public static function getDernierConsoFil()
    {
        $select = DB::select("select * from consofilbrodmain order by id desc limit 1");

        return self::hydrate($select);
    }

    public static function getConsoFilByDemande($id)
    {
        $select = DB::select("select * from v_consoFilBrodMain where id_demande_client=" . $id);

        return self::hydrate($select);
    }

    public function insertSuiviFluxBrodMain($idDemande, $dateOperation, $type_flux, $qte, $recoupe)
    {
        DB::table('suivifluxbrodmain')->insert([
            'id_demande_client' => $idDemande,
            'date_operation' => $dateOperation,
            'type_flux' => $type_flux,
            'qte' => $qte,
            'recoupe' => $recoupe,
            'etat' => 0
        ]);
    }


    public static function getSuiviFluxBrodMain()
    {
        $select = DB::select("select * from v_suivifluxbrodmain where etat=0 order by id_suivi desc");

        return self::hydrate($select);
    }

    public static function getAllDemandeBroderieMainPlanning()
    {
        $select = DB::select("select * from v_demandeclientbroadmain where type=1 and etat=0 and  (stadesdc not ilike '%prod%' or type_stade ilike '%non alloue%')");

        return self::hydrate($select);
    }

    public static function getAllDemandeSmockMainPlanning()
    {
        $select = DB::select("select * from v_demandeclientbroadmain where type=2 and etat=0 and (stadesdc not ilike '%prod%' or type_stade ilike '%non alloue%')");

        return self::hydrate($select);
    }

    public static function getAllDemandeBroderieSmockMainPlanning()
    {
        $select = DB::select("
        SELECT DISTINCT ON (id_demande_client, id_stade_demande_client) *
        FROM v_demandeclientbroadmain
        ORDER BY id_demande_client, id_stade_demande_client, id
        ");
        return self::hydrate($select);
    }

    public static function getAllDemandeBroderieMainProdPlanning()
    {
        $select = DB::select("select * from v_demandeclientbroadmain where type=1 and etat=0 and  stadesdc ilike '%prod%' ");

        return self::hydrate($select);
    }

    public static function getAllDemandeSmockMainProdPlanning()
    {
        $select = DB::select("select * from v_demandeclientbroadmain where type=2 and etat=0 and stadesdc  ilike '%prod%'");

        return self::hydrate($select);
    }

    public static function insertPlanningBrodMain($idDemande, $deadline, $fin, $id_etape)
    {
        DB::table('planningdemandebrodmain')->insert([
            'id_demande_client' => $idDemande,
            'deadline' => $deadline,
            'fin' => $fin,
            'id_etape' => $id_etape
        ]);
    }

    public static function updateApproMpBrodMain($id)
    {
        DB::table('demandeclientbrodmain')
            ->where('id', $id)
            ->update([
                'etat_appro_mp' => 1,
            ]);
    }

    public static function updatePliTissuBrodMain($id)
    {
        DB::table('demandeclientbrodmain')
            ->where('id', $id)
            ->update([
                'etat_plis_tissu' => 1,
            ]);
    }

    public static function updateDessinBrodMain($id)
    {
        DB::table('demandeclientbrodmain')
            ->where('id', $id)
            ->update([
                'etat_dessin' => 1,
            ]);
    }

    public static function updatePoncageBrodMain($id)
    {
        DB::table('demandeclientbrodmain')
            ->where('id', $id)
            ->update([
                'etat_poncage' => 1,
            ]);
    }

    public static function updateDeveloppementBrodMain($id)
    {
        DB::table('demandeclientbrodmain')
            ->where('id', $id)
            ->update([
                'etat_developpement' => 1,
            ]);
    }

    public function insertRapportJournalierBrodMain($data)
    {
        DB::table('rapportjournalierbrodmain')->insert([
            'id_demande_client' => $data['id_demande_client'],
            'date_rapport' => $data['date_rapport'],
            'conso_electricite' => $data['conso_electricite'],
            'valeur_electricite' => $data['valeur_electricite'],
            'nb_lancement' => $data['nb_lancement'],
            'nc_traite' => $data['nc_traite'],
            'taux_rejet' => $data['taux_rejet'],
            'taux_retouche' => $data['taux_retouche'],
            'absenteisme' => $data['absenteisme'],
            'commentaire' => $data['commentaire'],
            'nb_operateur' => $data['nb_operateur'],
            'etat' => 0
        ]);
    }


    public function insertDetailRapportJournalierBrodMain($idRapport,$heure,$qte)
    {
        DB::table('detailrapportjournalierbrodmain')->insert([
            'id_rapport_journalier_brodmain' => $idRapport,
            'heure' => $heure,
            'qte' => $qte,
            'etat' => 0
        ]);
    }

    public static function rapportJournalierBrodMainDernier()
    {
        $select = DB::select("select * from rapportjournalierbrodmain  order by id desc limit 1");
        return self::hydrate($select);
    }

    public static function getRapportJournalierBrodMain()
    {
        $select = DB::select("select * from v_rapportJournalierBrodMain  order by id desc ");
        return self::hydrate($select);
    }
}
