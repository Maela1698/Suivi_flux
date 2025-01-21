<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LBT extends Model
{
    use HasFactory;

    public static function getDemandeTeinture($idDemande)
    {
        $select = DB::select("select * from v_valeurAjouteeDemandeVamm where  id_demande_client=" . $idDemande);
        return self::hydrate($select);
    }


    public static function getDemandeBlanchissement($idDemande)
    {
        $select = DB::select("select *from v_lavage_demande_ligne where types_lavage ilike '%Blanchissement%' and id_demande_client=" . $idDemande);
        return self::hydrate($select);
    }

    public static function getDemandeAutreQueBlanchissement($idDemande)
    {
        $select = DB::select("
        SELECT *
        FROM v_lavage_demande_ligne
        WHERE (types_lavage NOT LIKE 'Blanchissement'
        OR types_lavage LIKE 'Blanchissement,%'
        OR types_lavage LIKE '%,Blanchissement'
        OR types_lavage LIKE '%,Blanchissement,%')
        AND id_demande_client =
       " . $idDemande);
        return self::hydrate($select);
    }


    public static function getAllLavage()
    {
        $select = DB::select("
           select *from lavage where etat=0
        ");
        return self::hydrate($select);
    }

    public static function getAllDemandeLBT($condition)
    {
        $lavage = self::getAllLavage();
        $sql = [];
        for ($i = 0; $i < count($lavage); $i++) {
            $sql[] = "  types_lavage ilike '%" . $lavage[$i]->type_lavage . "%' ";
        }
        $select = DB::select("select * from v_lavageValeurDemande where (types_valeur_ajout ilike '%teinture%' or " . implode("OR", $sql) . ") ".$condition);
        // dd("select * from v_lavageValeurDemande where types_valeur_ajout ilike '%teinture%' or " . implode("OR", $sql) . " ".$condition);

        return self::hydrate($select);
    }

    public static function getDemandeLBTByDemande($idDemande)
    {
        $select = DB::select("select * from v_lavageValeurDemande where  id_demande_client=" . $idDemande);
        return self::hydrate($select);
    }

    public function insertParametreLavage($data)
    {
        DB::table('parametrelavage')->insert([
            'id_demande_client' => $data['id_demande_client'],
            'date_parametre' => $data['date_parametre'],
            'poids_passe' => $data['poids_passe'],
            'poids_unitaire' => $data['poids_unitaire'],
            'temps_passe_estime' => $data['temps_passe_estime'],
            'temps_passe_reel' => $data['temps_passe_reel'],
            'conso_total_eau' => $data['conso_total_eau'],
            'commentaire' => $data['commentaire'],
            'prix_lavage' => $data['prix_lavage'],
            'etat' => 0
        ]);
    }

    public function insertFichierParametreLavage($id_parametre_lavage, $nom_fichier, $fichier)
    {
        DB::table('fichierparametrelavage')->insert([
            'id_parametre_lavage' => $id_parametre_lavage,
            'nom_fichier' => $nom_fichier,
            'fichier' => $fichier,
            'etat' => 0
        ]);
    }

    public static function getParametreLavageByDemande($idDemande)
    {
        $select = DB::select("select *from v_parametrelavage where id_demande_client=" . $idDemande);
        return self::hydrate($select);
    }

    public static function getFichierParametreLavageByDemande($idParam)
    {
        $select = DB::select("select *from fichierparametrelavage where id_parametre_lavage=" . $idParam);
        return self::hydrate($select);
    }

    public function insertParametreBlanchissement($data)
    {
        DB::table('parametreblanchissement')->insert([
            'id_demande_client' => $data['id_demande_client'],
            'date_parametre' => $data['date_parametre'],
            'nb_panneaux' => $data['nb_panneaux'],
            'poids_unitaire' => $data['poids_unitaire'],
            'option_valeur' => $data['option_valeur'],
            'poids_passe' => $data['poids_passe'],
            'prix_blanchissement' => $data['prix_blanchissement'],
            'commentaire' => $data['commentaire'],
            'etat' => 0
        ]);
    }

    public function insertFichierParametreBlanchissement($id_parametre_blanchissement, $nom_fichier, $fichier)
    {
        DB::table('fichierparametreblanchissement')->insert([
            'id_parametre_blanchissement' => $id_parametre_blanchissement,
            'nom_fichier' => $nom_fichier,
            'fichier' => $fichier,
            'etat' => 0
        ]);
    }

    public static function getParametreBlanchissementByDemande($idDemande)
    {
        $select = DB::select("select *from v_parametreblanchissement where id_demande_client=" . $idDemande);
        return self::hydrate($select);
    }


    public function insertParametreTeinture($data)
    {
        DB::table('parametreteinture')->insert([
            'id_demande_client' => $data['id_demande_client'],
            'date_parametre' => $data['date_parametre'],
            'couleur' => $data['couleur'],
            'nb_panneaux' => $data['nb_panneaux'],
            'poids_unitaire' => $data['poids_unitaire'],
            'poids_passe' => $data['poids_passe'],
            'prix_teinture' => $data['prix_teinture'],
            'commentaire' => $data['commentaire'],
            'etat' => 0
        ]);
    }

    public function insertFichierParametreTeinture($id_parametre_teinture, $nom_fichier, $fichier)
    {
        DB::table('fichierparametreteinture')->insert([
            'id_parametre_teinture' => $id_parametre_teinture,
            'nom_fichier' => $nom_fichier,
            'fichier' => $fichier,
            'etat' => 0
        ]);
    }

    public static function getParametreTeintureByDemande($idDemande)
    {
        $select = DB::select("select *from v_parametreTeinture where id_demande_client=" . $idDemande);
        return self::hydrate($select);
    }


    public function insertSuiviFluxLBT($data)
    {
        DB::table('suivifluxlbt')->insert([
            'id_demande_client' => $data['id_demande_client'],
            'date_operation' => $data['date_operation'],
            'type_piece' => $data['type_piece'],
            'type_action' => $data['type_action'],
            'quantite' => $data['quantite'],
            'type_lbt' => $data['type_lbt'],
            'recoupe' => $data['recoupe'],
            'etat' => 0
        ]);
    }


    public static function getSuiviFluxLBT()
    {
        $select = DB::select("select *from v_suiviFluxLBT order by id desc");
        return self::hydrate($select);
    }

    public function insertRapportJournalierTeintureProd($data)
    {
        DB::table('rapportjournalierteintureprod')->insert([
            'daterapport' => $data['daterapport'],
            'teinte' => $data['teinte'],
            'nombre_panneau' => $data['nombre_panneau'],
            'nb_rejet_panneau' => $data['nb_rejet_panneau'],
            'nb_retouche_panneau' => $data['nb_retouche_panneau'],
            'conso_gasoil' => $data['conso_gasoil'],
            'prix_unitaire_gasoil' => $data['prix_unitaire_gasoil'],
            'conso_produit_chimique' => $data['conso_produit_chimique'],
            'prix_unitaire_produit_chimique' => $data['prix_unitaire_produit_chimique'],
            'conso_electrique' => $data['conso_electrique'],
            'prix_kwh' => $data['prix_kwh'],
            'type_teinture_prod' => 1,
            'commentaire' => $data['commentaire'],
            'type_lbt' => "Teinture",
            'etat' => 0
        ]);
    }

    public static function getRapportJournalierTeinture()
    {
        $select = DB::select("select *from v_rapportJournalierTeintureProd order by id desc");
        return self::hydrate($select);
    }

    public function insertRapportJournalierTeintureDev($data)
    {
        DB::table('rapportjournalierteinturedev')->insert([
            'daterapport' => $data['daterapport'],
            'nb_couleur_recherche' => $data['nb_couleur_recherche'],
            'nb_couleur_realise' => $data['nb_couleur_realise'],
            'nb_tentative' => $data['nb_tentative'],
            'conso_produit_chimique' => $data['conso_produit_chimique'],
            'valeur_produit_chimique' => $data['valeur_produit_chimique'],
            'taux_rejet' => $data['taux_rejet'],
            'taux_retouche' => $data['taux_retouche'],
            'type_lbt' => "Teinture",
            'type_teinture_dev' => 1,
            'commentaire' => $data['commentaire'],
            'etat' => 0
        ]);
    }

    public static function getRapportJournalierTeintureDev()
    {
        $select = DB::select("select *from v_rapportJournalierTeintureDev order by id desc");
        return self::hydrate($select);
    }

    public function insertRapportJournalierLavage($data)
    {
        DB::table('rapportjournalierlavage')->insert([
            'date_rapport' => $data['date_rapport'],
            'prix_unitaire_gasoil' => $data['prix_unitaire_gasoil'],
            'conso_gasoil' => $data['conso_gasoil'],
            'conso_produit_chimique' => $data['conso_produit_chimique'],
            'valeur_produit_chimique' => $data['valeur_produit_chimique'],
            'conso_electrique' => $data['conso_electrique'],
            'prix_kwh' => $data['prix_kwh'],
            'taux_retouche' => $data['taux_retouche'],
            'taux_rejet' => $data['taux_rejet'],
            'nc_traites' => $data['nc_traites'],
            'absenteisme' => $data['absenteisme'],
            'commentaire' => $data['commentaire'],
            'nb_piece_lave' => $data['nb_piece_lave'],
            'type_lavage' => $data['type_lavage'],
            'etat' => 0
        ]);
    }

    public static function getRapportJournalierLavage()
    {
        $select = DB::select("select *from v_rapportJournalierLavage order by id desc");
        return self::hydrate($select);
    }


    public static function getRapportJournalierLBT()
    {
        $select = DB::select("
            SELECT *
            FROM v_rapportJournalierLBT
        ");
        return self::hydrate($select);
    }

    public function insertDemandeLBT($id_demande_client, $id_sdc, $dateentree_lbt, $type_lbt, $qte)
    {
        DB::table('demandeclientlbt')->insert([
            'id_demande_client' => $id_demande_client,
            'id_sdc' => $id_sdc,
            'type_lbt' => $type_lbt,
            'dateentree_lbt' => $dateentree_lbt,
            'qte' => $qte,
            'etat' => 0
        ]);
    }

    public static function updateDemandeLBT($id_sdc,$qte,$id_demande_client,$type)
    {
        DB::select('update demandeclientlbt set  id_sdc=? , qte=? where id_demande_client=? and type_lbt=? ', [$id_sdc,$qte,$id_demande_client,$type]);
    }


    public function insertDemandeLBTSansSDC($id_demande_client, $dateentree_lbt, $type_lbt)
    {
        DB::table('demandeclientlbt')->insert([
            'id_demande_client' => $id_demande_client,
            'type_lbt' => $type_lbt,
            'qte' => 0,
            'dateentree_lbt' => $dateentree_lbt,
            'etat' => 0
        ]);
    }

    public static function getDemandeLBT()
    {
        $select = DB::select("
            SELECT *
            FROM v_demandeClientLBT
        ");
        return self::hydrate($select);
    }

    public static function getDemandeLBTPremier()
    {
        $select = DB::select("
        SELECT DISTINCT ON (id_demande_client) id_demande_client, id_sdc
        FROM v_demandeClientLBT
        ORDER BY id_demande_client,id_sdc,
        id asc
        ");
        return self::hydrate($select);
    }

    public static function getDemandeLBTChangeStade()
    {
        $select = DB::select("
       WITH premiers AS (
        SELECT DISTINCT ON (id_demande_client) id_demande_client, type_stade, stadesdc
        FROM v_demandeClientLBT
        ORDER BY id_demande_client,id_sdc,
        id asc)
        SELECT *
        FROM v_demandeClientLBT
        WHERE  stadesdc NOT ILIKE '%PROD%' and (id_demande_client, type_stade, stadesdc) NOT IN (
        SELECT id_demande_client, type_stade, stadesdc
        FROM premiers)
        ");
        return self::hydrate($select);
    }

    public static function getDemandeLBTProd()
    {
        $select = DB::select("
        select * from v_demandeClientLBT where stadesdc ilike '%prod%' order by id asc;
        ");
        return self::hydrate($select);
    }

    public static function getDemandeLBTPremierByDemandeSdc($idDemande, $idSdc)
    {
        $select = DB::select("select *from v_demandeClientLBT where id_demande_client=? and id_sdc=? ",[$idDemande, $idSdc]);
        return self::hydrate($select);
    }

    public static function getDemandeLBTPremierByDemande($idDemande)
    {
        $select = DB::select("select *from v_demandeClientLBT where id_demande_client=? and  id_sdc is null ",[$idDemande]);
        return self::hydrate($select);
    }

    public static function updateApproProduitChimique($id)
    {
        DB::select('update demandeclientlbt set  etat_apro_produit_chimique=1  where id=?', [$id]);
    }

    public static function updatePesage($id)
    {
        DB::select('update demandeclientlbt set  etat_pesage=1  where id=?', [$id]);
    }

    public static function updateLavageBlancTeint($id)
    {
        DB::select('update demandeclientlbt set  etat_lavage_blanc_teint=1  where id=?', [$id]);
    }

    public static function updateTestShrinkage($id)
    {
        DB::select('update demandeclientlbt set  etat_test_shrinkage=1  where id=?', [$id]);
    }

    public static function updatePri($id)
    {
        DB::select('update demandeclientlbt set  etat_pri=1  where id=?', [$id]);
    }

    public static function getModal()
    {
        $select = DB::select("
            SELECT *
            FROM modal
        ");
        return self::hydrate($select);
    }

}
