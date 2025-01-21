<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeClient extends Model
{
    use HasFactory;
    protected $table = 'demandeclient';
    public $timestamps = false;
    protected $fillable = [
        'date_entree',
        'date_livraison',
        'id_client',
        'id_style',
        'nom_modele',
        'id_incontern',
        'theme',
        'id_phase',
        'id_saison',
        'qte_commande_provisoire',
        'taille_min',
        'id_unite_taille_min',
        'id_unite_taille_max',
        'taille_base',
        'requete_client',
        'commentaire_merch',
        'id_stade',
        'id_etat',
        'id_periode',
        'photo_commande',
        'etat'
    ];



    public static function insertDossierTechnique($idDemande,$dossier,$nomdossier){
        DB::insert('insert into dossierTechniqueDemandeClient values(default,?,?,?,?)',[$idDemande,$dossier,$nomdossier,0]);
    }

    public static function getAllListeDemande(){
        $select=DB::select('select * from v_demandeClient where etat=0 order by id desc');
        return self::hydrate($select);
    }
    public static function getAllListeDemandeById($idDemande){
        $select=DB::select('select * from v_demandeClient where  id=?',[$idDemande]);
        return self::hydrate($select);
    }
    public static function getCountNbrCommande($filters = []){
        $demande = FiltreDemande::query()->where('etat', 0);

        $columns = ['taille_base', 'type_incontern', 'type_phase', 'taillemin', 'taillemax'];

        if (isset($filters['theme']) && $filters['theme']) {
            $demande->where('theme', 'ILIKE', '%' . $filters['theme'] . '%');
        }

        if (isset($filters['modele']) && $filters['modele']) {
            $demande->where('nom_modele', 'ILIKE', '%' . $filters['modele'] . '%');
        }

        if (isset($filters['idTiers']) && $filters['idTiers']) {
            $demande->where('id_tiers', $filters['idTiers']);
        }

        if (isset($filters['stade']) && $filters['stade']) {
            $demande->where('id_stade', $filters['stade']);
        }

        if (isset($filters['etat']) && $filters['etat']) {
            $demande->where('id_etat', $filters['etat']);
        }

        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $demande->where('id_saison', $filters['idSaison']);
        }

        if (isset($filters['autre']) && $filters['autre']) {
            $searchTerm = $filters['autre'];
            $demande->where(function($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }

        if (isset($filters['startEntree']) && isset($filters['endEntree']) && $filters['startEntree'] && $filters['endEntree']) {
            $demande->whereBetween('date_entree', [$filters['startEntree'], $filters['endEntree']]);
        }

        if (isset($filters['startLivre']) && isset($filters['endLivre']) && $filters['startLivre'] && $filters['endLivre']) {
            $demande->whereBetween('date_livraison', [$filters['startLivre'], $filters['endLivre']]);
        }

        $total = $demande->count();
        return $total;
    }
    public static function getCountEnCourNego($filters = []){
        $demande = FiltreDemande::query()->where('etat', 0)->where('id_etat',1);

        $columns = ['taille_base', 'type_incontern', 'type_phase', 'taillemin', 'taillemax'];

        if (isset($filters['theme']) && $filters['theme']) {
            $demande->where('theme', 'ILIKE', '%' . $filters['theme'] . '%');
        }

        if (isset($filters['modele']) && $filters['modele']) {
            $demande->where('nom_modele', 'ILIKE', '%' . $filters['modele'] . '%');
        }

        if (isset($filters['idTiers']) && $filters['idTiers']) {
            $demande->where('id_tiers', $filters['idTiers']);
        }

        if (isset($filters['stade']) && $filters['stade']) {
            $demande->where('id_stade', $filters['stade']);
        }

        if (isset($filters['etat']) && $filters['etat']) {
            $demande->where('id_etat', $filters['etat']);
        }

        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $demande->where('id_saison', $filters['idSaison']);
        }

        if (isset($filters['autre']) && $filters['autre']) {
            $searchTerm = $filters['autre'];
            $demande->where(function($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }

        if (isset($filters['startEntree']) && isset($filters['endEntree']) && $filters['startEntree'] && $filters['endEntree']) {
            $demande->whereBetween('date_entree', [$filters['startEntree'], $filters['endEntree']]);
        }

        if (isset($filters['startLivre']) && isset($filters['endLivre']) && $filters['startLivre'] && $filters['endLivre']) {
            $demande->whereBetween('date_livraison', [$filters['startLivre'], $filters['endLivre']]);
        }

        $total = $demande->count();
        return $total;
    }
    public static function getCountValide($filters = []){
        $demande = FiltreDemande::query()->where('etat', 0)->where('id_etat',2);

        $columns = ['taille_base', 'type_incontern', 'type_phase', 'taillemin', 'taillemax'];

        if (isset($filters['theme']) && $filters['theme']) {
            $demande->where('theme', 'ILIKE', '%' . $filters['theme'] . '%');
        }

        if (isset($filters['modele']) && $filters['modele']) {
            $demande->where('nom_modele', 'ILIKE', '%' . $filters['modele'] . '%');
        }

        if (isset($filters['idTiers']) && $filters['idTiers']) {
            $demande->where('id_tiers', $filters['idTiers']);
        }

        if (isset($filters['stade']) && $filters['stade']) {
            $demande->where('id_stade', $filters['stade']);
        }

        if (isset($filters['etat']) && $filters['etat']) {
            $demande->where('id_etat', $filters['etat']);
        }

        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $demande->where('id_saison', $filters['idSaison']);
        }

        if (isset($filters['autre']) && $filters['autre']) {
            $searchTerm = $filters['autre'];
            $demande->where(function($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }

        if (isset($filters['startEntree']) && isset($filters['endEntree']) && $filters['startEntree'] && $filters['endEntree']) {
            $demande->whereBetween('date_entree', [$filters['startEntree'], $filters['endEntree']]);
        }

        if (isset($filters['startLivre']) && isset($filters['endLivre']) && $filters['startLivre'] && $filters['endLivre']) {
            $demande->whereBetween('date_livraison', [$filters['startLivre'], $filters['endLivre']]);
        }

        $total = $demande->count();
        return $total;
    }
    public static function getCountRefus($filters = []){
        $demande = FiltreDemande::query()->where('etat', 0)->where('id_etat',3);

        $columns = ['taille_base', 'type_incontern', 'type_phase', 'taillemin', 'taillemax'];

        if (isset($filters['theme']) && $filters['theme']) {
            $demande->where('theme', 'ILIKE', '%' . $filters['theme'] . '%');
        }

        if (isset($filters['modele']) && $filters['modele']) {
            $demande->where('nom_modele', 'ILIKE', '%' . $filters['modele'] . '%');
        }

        if (isset($filters['idTiers']) && $filters['idTiers']) {
            $demande->where('id_tiers', $filters['idTiers']);
        }

        if (isset($filters['stade']) && $filters['stade']) {
            $demande->where('id_stade', $filters['stade']);
        }

        if (isset($filters['etat']) && $filters['etat']) {
            $demande->where('id_etat', $filters['etat']);
        }

        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $demande->where('id_saison', $filters['idSaison']);
        }

        if (isset($filters['autre']) && $filters['autre']) {
            $searchTerm = $filters['autre'];
            $demande->where(function($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }

        if (isset($filters['startEntree']) && isset($filters['endEntree']) && $filters['startEntree'] && $filters['endEntree']) {
            $demande->whereBetween('date_entree', [$filters['startEntree'], $filters['endEntree']]);
        }

        if (isset($filters['startLivre']) && isset($filters['endLivre']) && $filters['startLivre'] && $filters['endLivre']) {
            $demande->whereBetween('date_livraison', [$filters['startLivre'], $filters['endLivre']]);
        }

        $total = $demande->count();
        return $total;
    }
    public static function getDossierTechniqueById($idDemande){
        $select=DB::select('select * from dossierTechniqueDemandeClient where etat=0 and id_demande_client=? order by id desc',[$idDemande]);
        return self::hydrate($select);
    }
    public static function deleteDossierTech($idDemande,$dossier){
        DB::update('update dossiertechniquedemandeclient set etat=1  where id=? and id_demande_client=?',[$dossier,$idDemande]);
    }
    public static function deleteTaille($idTaille,$idDemande){
        DB::update('update detailtailledemandeclient set etat=?  where id_unite_taille=? and id_demande_client=?',[1,$idTaille,$idDemande]);
    }
    public static function annuleDemandeClient($idDemande){
        DB::update('update demandeClient set id_etat=?  where id=?',[3,$idDemande]);
    }
    public static function valideDemandeClient($idDemande){
        DB::update('update demandeClient set id_etat=?  where id=?',[2,$idDemande]);
    }

    public static function getRangTailleMinById($idUnite){
        $results = DB::select('select rang from unitetaille where id=?',[$idUnite]);
        $unite = null;
        if (!empty($results)) {
            $unite = $results[0]->rang;
        }
        return $unite;
    }
    public static function getRangTailleMaxById($idUnite){
        $results = DB::select('select rang from unitetaille where id=?',[$idUnite]);
        $unite = null;
        if (!empty($results)) {
            $unite = $results[0]->rang;
        }
        return $unite;
    }
    public static function getTailleByRang($tailleMin,$tailleMax){
        $select=DB::select('select * from uniteTaille where rang>=? and rang<=?',[$tailleMin,$tailleMax]);
        return self::hydrate($select);
    }
    public static function insertTailles($idDemande,$idUniteTaille,$quantite){
        DB::insert('insert into detailTailleDemandeClient values(default,?,?,?,?,?)',[$idDemande,$idUniteTaille,$quantite,0,0]);
    }

    public static function getResteTailleMin($idDemande){
        $select=DB::select('select * from unitetaille where rang<?',[$idDemande]);
        return self::hydrate($select);
    }
    public static function getResteTailleMax($idDemande){
        $select=DB::select('select * from unitetaille where rang>',[$idDemande]);
        return self::hydrate($select);
    }

    public static function getTailleByIdDemande($idDemande){
        $select=DB::select('select * from v_detailTailleDemandeClient where id_demande_client=? and etat=0 order by rang asc',[$idDemande]);
        return self::hydrate($select);
    }
    public static function getLavageByIdDemande($idDemande){
        $select=DB::select('select * from v_lavageDemandeClient where id_demande_client=? and etat=0',[$idDemande]);
        return self::hydrate($select);
    }
    public static function getValeurAjoutByIdDemande($idDemande){
        $select=DB::select('select * from v_valeurAjouteeDemande where id_demande_client=? and etat=0',[$idDemande]);
        return self::hydrate($select);
    }
    public static function updateTailleDemande($quantite,$taille,$idDemande){
        DB::update('update detailtailledemandeclient set quantite=?  where id_unite_taille=? and id_demande_client=?',[$quantite,$taille,$idDemande]);
    }
    public static function updateStadeDemande($idStade,$idDemande){
        DB::update('update demandeclient set id_stade=?  where id=?',[$idStade,$idDemande]);
    }
    public static function deleteDemandeById($idDemande){
        DB::update('update demandeClient set etat=? where id=?',[1,$idDemande]);
    }
    public static function updateTailleDemandeDetail($tailleMin,$tailleMax,$idDemande){
        DB::update('update demandeClient set id_unite_taille_min=?,id_unite_taille_max=? where id=?',[$tailleMin,$tailleMax,$idDemande]);
    }

    public static function deleteTaillesByDemande($id)
    {
        DB::delete('DELETE FROM detailtailledemandeclient WHERE id_demande_client = ?', [$id]);
    }
    public static function updateTaille($taillemin,$taillemax,$idDemande)
    {
        DB::update('update demandeClient set id_taille_min=?,id_taille_max=? where id= ?', [$taillemin,$taillemax,$idDemande]);
    }
    public static function updateDossierTechnique($dossier_technique_demande,$nom_dossier_technique,$idDemande)
    {
        DB::update('update dossiertechniquedemandeclient set dossier_technique_demande=?,nom_dossier_technique=? where id_demande_client= ?', [$dossier_technique_demande,$nom_dossier_technique,$idDemande]);
    }

    public static function getAllDemandeById($idDemande){
        $select=DB::select('select * from demandeclient where  id=?',[$idDemande]);
        return self::hydrate($select);
    }



    public static function getCountProto($filters = []){
        $demande = FiltreDemande::query()->where('etat', 0)->where('type_stade','ILIKE','%PROTO%');

        $columns = ['taille_base', 'type_incontern', 'type_phase', 'taillemin', 'taillemax'];

        if (isset($filters['theme']) && $filters['theme']) {
            $demande->where('theme', 'ILIKE', '%' . $filters['theme'] . '%');
        }

        if (isset($filters['modele']) && $filters['modele']) {
            $demande->where('nom_modele', 'ILIKE', '%' . $filters['modele'] . '%');
        }

        if (isset($filters['idTiers']) && $filters['idTiers']) {
            $demande->where('id_tiers', $filters['idTiers']);
        }

        if (isset($filters['stade']) && $filters['stade']) {
            $demande->where('id_stade', $filters['stade']);
        }

        if (isset($filters['etat']) && $filters['etat']) {
            $demande->where('id_etat', $filters['etat']);
        }

        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $demande->where('id_saison', $filters['idSaison']);
        }

        if (isset($filters['autre']) && $filters['autre']) {
            $searchTerm = $filters['autre'];
            $demande->where(function($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }

        if (isset($filters['startEntree']) && isset($filters['endEntree']) && $filters['startEntree'] && $filters['endEntree']) {
            $demande->whereBetween('date_entree', [$filters['startEntree'], $filters['endEntree']]);
        }

        if (isset($filters['startLivre']) && isset($filters['endLivre']) && $filters['startLivre'] && $filters['endLivre']) {
            $demande->whereBetween('date_livraison', [$filters['startLivre'], $filters['endLivre']]);
        }

        $total = $demande->count();
        return $total;
    }
    public static function getCountTds($filters = []){
        $demande = FiltreDemande::query()->where('etat', 0)->where('type_stade','ILIKE','%TDS%');

        $columns = ['taille_base', 'type_incontern', 'type_phase', 'taillemin', 'taillemax'];

        if (isset($filters['theme']) && $filters['theme']) {
            $demande->where('theme', 'ILIKE', '%' . $filters['theme'] . '%');
        }

        if (isset($filters['modele']) && $filters['modele']) {
            $demande->where('nom_modele', 'ILIKE', '%' . $filters['modele'] . '%');
        }

        if (isset($filters['idTiers']) && $filters['idTiers']) {
            $demande->where('id_tiers', $filters['idTiers']);
        }

        if (isset($filters['stade']) && $filters['stade']) {
            $demande->where('id_stade', $filters['stade']);
        }

        if (isset($filters['etat']) && $filters['etat']) {
            $demande->where('id_etat', $filters['etat']);
        }

        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $demande->where('id_saison', $filters['idSaison']);
        }

        if (isset($filters['autre']) && $filters['autre']) {
            $searchTerm = $filters['autre'];
            $demande->where(function($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }

        if (isset($filters['startEntree']) && isset($filters['endEntree']) && $filters['startEntree'] && $filters['endEntree']) {
            $demande->whereBetween('date_entree', [$filters['startEntree'], $filters['endEntree']]);
        }

        if (isset($filters['startLivre']) && isset($filters['endLivre']) && $filters['startLivre'] && $filters['endLivre']) {
            $demande->whereBetween('date_livraison', [$filters['startLivre'], $filters['endLivre']]);
        }

        $total = $demande->count();
        return $total;
    }
    public static function getCountPps($filters = []){
        $demande = FiltreDemande::query()
        ->where('etat', 0)
        ->where(function($query) {
            $query->where('type_stade', 'ILIKE', '%PPS%')
                  ->orWhere('type_stade', 'ILIKE', '%CONFORMI%')
                  ->orWhere('type_stade', 'ILIKE', '%GARMENT%');
        });

        $columns = ['taille_base', 'type_incontern', 'type_phase', 'taillemin', 'taillemax'];

        if (isset($filters['theme']) && $filters['theme']) {
            $demande->where('theme', 'ILIKE', '%' . $filters['theme'] . '%');
        }

        if (isset($filters['modele']) && $filters['modele']) {
            $demande->where('nom_modele', 'ILIKE', '%' . $filters['modele'] . '%');
        }

        if (isset($filters['idTiers']) && $filters['idTiers']) {
            $demande->where('id_tiers', $filters['idTiers']);
        }

        if (isset($filters['stade']) && $filters['stade']) {
            $demande->where('id_stade', $filters['stade']);
        }

        if (isset($filters['etat']) && $filters['etat']) {
            $demande->where('id_etat', $filters['etat']);
        }

        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $demande->where('id_saison', $filters['idSaison']);
        }

        if (isset($filters['autre']) && $filters['autre']) {
            $searchTerm = $filters['autre'];
            $demande->where(function($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }

        if (isset($filters['startEntree']) && isset($filters['endEntree']) && $filters['startEntree'] && $filters['endEntree']) {
            $demande->whereBetween('date_entree', [$filters['startEntree'], $filters['endEntree']]);
        }

        if (isset($filters['startLivre']) && isset($filters['endLivre']) && $filters['startLivre'] && $filters['endLivre']) {
            $demande->whereBetween('date_livraison', [$filters['startLivre'], $filters['endLivre']]);
        }

        $total = $demande->count();
        return $total;
    }
    public static function getCountProd($filters = []){
        $demande = FiltreDemande::query()
        ->where('etat', 0)
        ->where(function($query) {
            $query->where('type_stade', 'ILIKE', '%PROD%')
                  ->orWhere('type_stade', 'ILIKE', '%SHIPMENT_SAMPLE%');
        });

        $columns = ['taille_base', 'type_incontern', 'type_phase', 'taillemin', 'taillemax'];

        if (isset($filters['theme']) && $filters['theme']) {
            $demande->where('theme', 'ILIKE', '%' . $filters['theme'] . '%');
        }

        if (isset($filters['modele']) && $filters['modele']) {
            $demande->where('nom_modele', 'ILIKE', '%' . $filters['modele'] . '%');
        }

        if (isset($filters['idTiers']) && $filters['idTiers']) {
            $demande->where('id_tiers', $filters['idTiers']);
        }

        if (isset($filters['stade']) && $filters['stade']) {
            $demande->where('id_stade', $filters['stade']);
        }

        if (isset($filters['etat']) && $filters['etat']) {
            $demande->where('id_etat', $filters['etat']);
        }

        if (isset($filters['idSaison']) && $filters['idSaison']) {
            $demande->where('id_saison', $filters['idSaison']);
        }

        if (isset($filters['autre']) && $filters['autre']) {
            $searchTerm = $filters['autre'];
            $demande->where(function($query) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ILIKE', '%' . $searchTerm . '%');
                }
            });
        }

        if (isset($filters['startEntree']) && isset($filters['endEntree']) && $filters['startEntree'] && $filters['endEntree']) {
            $demande->whereBetween('date_entree', [$filters['startEntree'], $filters['endEntree']]);
        }

        if (isset($filters['startLivre']) && isset($filters['endLivre']) && $filters['startLivre'] && $filters['endLivre']) {
            $demande->whereBetween('date_livraison', [$filters['startLivre'], $filters['endLivre']]);
        }

        $total = $demande->count();
        return $total;
    }

    public static function qteconfirme($idsaison, $id_tiers)
    {
        $select = DB::select('SELECT
                                SUM(qte_commande_provisoire) AS total_qte_provisoire
                            FROM
                                demandeclient
                            WHERE
                                id_etat = 2
                            AND
                                id_saison = ?
                            AND
                                id_client = ?
                            GROUP BY
                                id_saison,
                                id_client', [$idsaison, $id_tiers]);

        return self::hydrate($select);
    }
    public static function findsumConfirmee()
    {
        $select = DB::select('SELECT
                                SUM(qte_commande_provisoire) AS total_qte_provisoire
                            FROM
                                demandeclient
                            WHERE
                                id_etat = 2');
        return self::hydrate($select);
    }


    public static function findQteEnCoursNego($idsaison, $id_tiers)
    {
        $select = DB::select('SELECT
                                SUM(qte_commande_provisoire) AS total_qte_provisoire
                            FROM
                                demandeclient
                            WHERE
                                id_etat = 1
                            AND
                                id_saison = ?
                            AND
                                id_client = ?
                            GROUP BY
                                id_saison,
                                id_client', [$idsaison, $id_tiers]);
        return self::hydrate($select);
    }

    // update pour MASTERPLAN
    public static function getDateentree($id)
    {
        $select = DB::select('SELECT DATE_ENTREE FROM V_DEMANDECLIENT WHERE ID=?', [$id]);
        return self::hydrate($select);
    }

    public static function getDate_Livraion($id)
    {
        $select = DB::select('SELECT DATE_LIVRAISON FROM V_DEMANDECLIENT WHERE ID=?', [$id]);
        return self::hydrate($select);
    }


}
