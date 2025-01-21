<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BonCommande extends Model
{
    use HasFactory;
    public static function getNumeroBcById($id){
        $results = DB::select('select count(*)+1 as numero from bc where etat=0 and id_type_bc=?',[$id]);
        $numero = null;
        if (!empty($results)) {
            $numero = $results[0]->numero;
        }
        return $numero;
    }
    public static function getNumeroGeneral(){
        $results = DB::select('select count(*)+1 as numero from bcGeneral where etat=0');
        $numero = null;
        if (!empty($results)) {
            $numero = $results[0]->numero;
        }
        return $numero;
    }
    public static function getClient($idDemande)
    {
        $select = DB::select('select * from demandeclient where etat=0 and id='.$idDemande);
        return self::hydrate($select);
    }
    public static function getAllTypeBc(){
        $select = DB::select("select * from type_bc where etat=0 and type_bc NOT ILIKE '%GENERAL%'");
        return self::hydrate($select);
    }
    public static function getAllDonneBc(){
        $select = DB::select("select * from v_bc");
        return self::hydrate($select);
    }
    public static function getAllDonneBcById($iddemande){
        $select = DB::select("select * from v_bc_demande_distinct where id_demande_client=?",[$iddemande]);
        return self::hydrate($select);
    }
    public static function getAllDonneBcValide(){
        $select = DB::select("select * from v_donne_bc where etat=10 and idtypebc!=3");
        return self::hydrate($select);
    }
    public static function getAllDonneTscfBcValide(){
        $select = DB::select("select * from v_donne_bc where etat=10 and idtypebc=3");
        return self::hydrate($select);
    }
    public static function getAllTscfCoupeType(){
        $select = DB::select("select * from v_table_suivis where etat=10 and idtypebc=3");
        return self::hydrate($select);
    }
    public static function getTypeBcById($id){
        $select = DB::select('select * from type_bc where id=?',[$id]);
        return self::hydrate($select);
    }
    public static function getDetailByIdBc(){
        $idbc = BonCommande::getLastIdBc();
        $select = DB::select('select * from detailBc where id_bc=?',[$idbc]);
        return self::hydrate($select);
    }
    public static function getTscf(){
        $select = DB::select('select * from v_tscf');
        return self::hydrate($select);
    }
    public static function getDonne(){
        $idbc = BonCommande::getLastIdDetail();
        $select = DB::select('select * from donnebc where id_detail=?',[$idbc]);
        return self::hydrate($select);
    }
    public static function getProduitById($idbc){
        $select = DB::select('select * from v_table_suivis where etat=10 and id_donne_bc=?',[$idbc]);
        return self::hydrate($select);
    }
    public static function insertBc($date,$numero,$idtype,$fournisseur,$echeance){
        DB::insert('insert into bc values (default, ?, ?, ?, ?, ?, ?)', [$date,$numero,$idtype,$fournisseur,$echeance,0]);
    }
    public static function insertDonneBcTissus($id_detail,$designation,$laize,$utilisation,$couleur,$quantite,$unite,$prix,$devise,$idtissus,$numero){
        DB::insert('insert into donneBc values (default, ?, ?, ?, ?, ?, ? ,? ,? ,?, ?, ? ,? ,?)', [$id_detail,$designation,$laize,$utilisation,$couleur,$quantite,$unite,$prix,$devise,0,$idtissus,null,$numero]);
    }
    public static function insertDonneBcAccessoire($id_detail,$designation,$laize,$utilisation,$couleur,$quantite,$unite,$prix,$devise,$idaccessoire,$numero){
        DB::insert('insert into donneBc values (default, ?, ?, ?, ?, ?, ? ,? ,? ,?, ?, ?, ?, ?)', [$id_detail,$designation,$laize,$utilisation,$couleur,$quantite,$unite,$prix,$devise,0,null,$idaccessoire,$numero]);
    }
    public static function getLastIdDetail(){
        $results = DB::select('select id from detailbc ORDER BY id DESC LIMIT 1');
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->id;
        }
        return $tiers;
    }
    public static function getLastIdBc(){
        $results = DB::select('select id from bc ORDER BY id DESC LIMIT 1');
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->id;
        }
        return $tiers;
    }
    public static function getLastIdTier(){
        $results = DB::select('select idtier from bc ORDER BY id DESC LIMIT 1');
        $tiers = null;
        if (!empty($results)) {
            $tiers = $results[0]->idtier;
        }
        return $tiers;
    }
    public static function getLastIdDemande(){
        $idbc = BonCommande::getLastIdBc();
        $select = DB::select('select id_demande_client from detailbc where id_bc=?',[$idbc]);
        return self::hydrate($select);
    }

    public static function insertDetailBc($id_demande_client){
        $idbc = BonCommande::getLastIdBc();
        DB::insert('insert into detailBc values (default,?, ?, ?)', [$idbc,$id_demande_client,0]);
    }
    public static function getAllBc(){
        $idtype = BonCommande::getLastIdBc();
        $select = DB::select("select * from v_bc where etat_bc=0 and bc_id=?",[$idtype]);
        return self::hydrate($select);
    }
    public static function getClientByDetail($idtype) {
        $select = DB::select('SELECT * FROM v_demandeclient WHERE id = ?', [$idtype]);
        return self::hydrate($select);
    }
    public static function getInterlocateurFournisseur() {
        $idtype = BonCommande::getLastIdTier();
        $select = DB::select('SELECT * FROM tiersInterlocateur WHERE idtiers = ?', bindings: [$idtype]);
        return self::hydrate($select);
    }

    public static function deleteDonne($designation){
        DB::delete('DELETE FROM donnebc WHERE id=? ', [$designation]);
    }

    public static function revisiterTissus($designation,$couleur,$laize,$quantite,$unite,$pri,$devise,$idbc){
        DB::update('update donnebc set designation=?,couleur=?,laize=?,quantite=?,unite=?,prix_unitaire=?,devise=? where id=?',[$designation,$couleur,$laize,$quantite,$unite,$pri,$devise,$idbc]);
    }
    public static function revisiterAccessoire($designation,$couleur,$utilisation,$quantite,$unite,$pri,$devise,$idbc){
        DB::update('update donnebc set designation=?,couleur=?,utilisation=?,quantite=?,unite=?,prix_unitaire=?,devise=? where id=?',[$designation,$couleur,$utilisation,$quantite,$unite,$pri,$devise,$idbc]);
    }
    public static function revisiterNumero($numero,$bcid){
        DB::update('update donnebc set numerobc=? where id=?',[$numero,$bcid]);
    }

    public static function insertMerch($id_donne_bc,$dateex,$deadline,$transport,$dateemission,$numerofacture,$montant,$detailfacture,$commentaire){
        DB::insert('insert into merch values (default, ?, ?, ?, ?, ?, ? ,? ,? ,?)', [$id_donne_bc,$dateex,$deadline,$transport,$dateemission,$numerofacture,$montant,$detailfacture,$commentaire]);
    }
    public static function insertTransit($id_donne_bc,$transit,$transittime,$datedepart,$datearrive,$awb){
        DB::insert('insert into transit values (default, ?, ?, ?, ?, ?, ?)', [$id_donne_bc,$transit,$transittime,$datedepart,$datearrive,$awb]);
    }
    public static function insertMagasin($id_donne_bc,$datearrivereel,$bl,$quantite,$reste,$numero){
        DB::insert('insert into magasin values (default, ?, ?, ?, ?, ?, ?)', [$id_donne_bc,$datearrivereel,$bl,$quantite,$reste,$numero]);
    }
    public static function insertReclamation($id_donne_bc,$dateenvoie,$daterelance,$raison,$quantite,$remarque,$retour,$recomppensation,$note,$unite,$rapport,$valeurreclame,$valeurcompense,$reste){
        DB::insert('insert into reclamation values (default, ?, ?, ?, ?, ?, ? ,? ,? ,?,?,?,?,?,?)', [$id_donne_bc,$dateenvoie,$daterelance,$raison,$quantite,$remarque,$retour,$recomppensation,$note,$unite,$rapport,$valeurreclame,$valeurcompense,$reste]);
    }
    public static function insertComptabilite($id_donne_bc,$swift,$deposit,$pri,$payer){
        DB::insert('insert into comptabilite values (default, ?, ?, ?, ?, ?)', [$id_donne_bc,$swift,$deposit,$pri,$payer]);
    }

    public static function getMerch($idbc){
        $select = DB::select('select * from merch where id_donne_bc=? order by id desc limit 1',[$idbc]);
        return self::hydrate($select);
    }
    public static function getTransit($idbc){
        $select = DB::select('select * from transit where id_donne_bc=? order by id desc limit 1',[$idbc]);
        return self::hydrate($select);
    }
    public static function getMagasin($idbc){
        $select = DB::select('select * from magasin where id_donne_bc=? order by id desc limit 1',[$idbc]);
        return self::hydrate($select);
    }
    public static function getReclamation($idbc){
        $select = DB::select('select * from reclamation where id_donne_bc=? order by id desc limit 1',[$idbc]);
        return self::hydrate($select);
    }
    public static function getCompta($idbc){
        $select = DB::select('select * from comptabilite where id_donne_bc=? order by id desc limit 1',[$idbc]);
        return self::hydrate($select);
    }
    public static function getDonneByIdBc($idbc){
        $select = DB::select('select * from v_donne_bc where bcid=?',[$idbc]);
        return self::hydrate($select);
    }
    public static function valideBc($idbc){
        DB::update('update donnebc set etat=10 where id_detail=?',[$idbc]);
    }
    public static function dateconfirmation($idbc){
        DB::update('update detailbc set dateconfirmation=? where id=?',[now(),$idbc]);
    }
    public static function getIdDetail($idbc){
        $select = DB::select('select * from detailbc where id_bc=?',[$idbc]);
        return self::hydrate($select);
    }
    public static function getAllEtatBc(){
        $select = DB::select('select * from etatbc where etat=0');
        return self::hydrate($select);
    }

    public static function getAllDonneDetailReclamation(){
        $select = DB::select('select * from v_detail_reclamation order by  desc limit 1');
        return self::hydrate($select);
    }
}
