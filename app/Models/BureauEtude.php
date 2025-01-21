<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BureauEtude extends Model
{
    use HasFactory;
    protected $table = 'bureauetude';
    protected $fillable = [
        'datedebut',
        'idtypepatronage',
        'idlisteemploye',
        'iddclientsdcetapedev',
        'datefin',
        'commentaire',
        'deadline',
        'etat'
    ];

    public function insertBureauEtude($data)
    {
        DB::table($this->table)->insert([
            'datedebut' => $data['datedebut'],
            'idtypepatronage' =>$data['idtypepatronage'],
            'idlisteemploye' => $data['idlisteemploye'],
            'iddclientsdcetapedev' => $data['iddclientsdcetapedev'],
            'datefin' => $data['datefin'],
            'commentaire' => $data['commentaire'],
            'deadline' => $data['deadline'],
            'etat' =>  0
        ]);
    }

    public function updateBureauEtude($data)
    {
        DB::table($this->table)
        ->where('iddclientsdcetapedev', $data['iddclientsdcetapedev'])
        ->update([
            'datedebut' => $data['datedebut'],
            'idtypepatronage' =>$data['idtypepatronage'],
            'idlisteemploye' => $data['idlisteemploye'],
            'iddclientsdcetapedev' => $data['iddclientsdcetapedev'],
            'datefin' => $data['datefin'],
            'commentaire' => $data['commentaire'],
            'deadline' => $data['deadline'],
            'etat' =>  0
        ]);
    }

    public static function getAllTypePatronage()
    {
        $select = DB::select('select * from typepatronage');
        return self::hydrate($select);
    }

     public static function getBureauEtudeByIdDcDSCEtape($idDCSdcEtape)
    {
        $select = DB::select('select * from v_bureauetude where iddclientsdcetapedev='.$idDCSdcEtape);
        return self::hydrate($select);
    }

    public static function updateBEAchever($commentaire, $dateFin, $idDCSdcEtape){
        DB::select('update bureauetude set commentaire=?, datefin=?  where iddclientsdcetapedev=?',[$commentaire,$dateFin,$idDCSdcEtape]);
    }


    public static function insertSuiviPatronage($data)
    {
        DB::table('suivipatronage')->insert([
            'datedebut' => $data['datedebut'],
            'daterecepetion' => $data['daterecepetion'],
            'iddclientsdcetapedev' => $data['iddclientsdcetapedev'],
            'datefin' => $data['datefin'],
            'pointpatronage' => $data['pointpatronage'],
            'commentaire' => $data['commentaire'],
            'deadline' => $data['deadline'],
            'etat' => 0
        ]);
    }

    public static function updateSuiviPatronage($iddclientsdcetapedev,$datefin, $commentaire)
    {
        DB::table('suivipatronage')
        ->where('iddclientsdcetapedev', $iddclientsdcetapedev)
        ->update([
            'datefin' => $datefin,
            'commentaire' => $commentaire
        ]);
    }


    public static function getAllTypeOccurencePatronage()
    {
        $select = DB::select('select * from typeoccurencepatronage where etat=0');
        return self::hydrate($select);
    }

    public static function insertControlePatronage($data)
    {
        DB::table('controlepatronage')->insert([
            'daterecepetion' => $data['daterecepetion'],
            'datedebut' => $data['datedebut'],
            'deadline' => $data['deadline'],
            'datefin' => $data['datefin'],
            'iddclientsdcetapedev' => $data['iddclientsdcetapedev'],
            'commentaire' => $data['commentaire'],
            'etat' => 0
        ]);
    }

    public static function updateControlePatronage($iddclientsdcetapedev,$datefin,$commentaire,$idtypeoccurencepatronage,$occurence)
    {
        DB::table('controlepatronage')
        ->where('iddclientsdcetapedev', $iddclientsdcetapedev)
        ->update([
            'datefin' => $datefin,
            'occurence' => $occurence,
            'idtypeoccurencepatronage' => $idtypeoccurencepatronage,
            'commentaire' => $commentaire
        ]);
    }

    public static function insertSuiviPlaceur($data)
    {
        DB::table('suiviplaceur')->insert([
            'daterecepetion' => $data['daterecepetion'],
            'datedebut' => $data['datedebut'],
            'datefin' => $data['datefin'],
            'deadline' => $data['deadline'],
            'iddclientsdcetapedev' => $data['iddclientsdcetapedev'],
            'idlisteemploye' => $data['idlisteemploye'],
            'etat' => 0
        ]);
    }

    public static function insertDetailSuiviPlaceur($data)
    {
        DB::table('detailsuiviplaceur')->insert([
            'id_suivi_placeur' => $data['id_suivi_placeur'],
            'idtissus' => $data['idtissus'],
            'nbmarkeur' => $data['nbmarkeur'],
            'pointplacement' => $data['pointplacement'],
            'id_type_placement' => $data['id_type_placement'],
            'commentaire' => $data['commentaire'],
            'etat' => 0
        ]);
    }

    public static function insertSuiviConso($data)
    {
        DB::table('suiviconso')->insert([
            'daterecepetion' => $data['daterecepetion'],
            'datedebut' => $data['datedebut'],
            'datefin' => $data['datefin'],
            'deadline' => $data['deadline'],
            'iddclientsdcetapedev' => $data['iddclientsdcetapedev'],
            'etat' => 0
        ]);
    }

    public static function insertDetailSuiviConso($data)
    {
        DB::table('suividetailconso')->insert([
            'idsuiviconso' => $data['idsuiviconso'],
            'idtissus' => $data['idtissus'],
            'laizeutile' => $data['laizeutile'],
            'consocommande' => $data['consocommande'],
            'efficiencecommande' => $data['efficiencecommande'],
            'varience' => $data['varience'],
            'tauxrecoupe' => $data['tauxrecoupe'],
            'pointplacement' => $data['pointplacement'],
            'commentaire' => $data['commentaire'],
            'id_type_placement' => $data['id_type_placement'],
            'etat' => 0
        ]);
    }

    public static function insertDetailSuiviConsoProd($data)
    {
        DB::table('suividetailconso')->insert([
            'idsuiviconso' => $data['idsuiviconso'],
            'idtissus' => $data['idtissus'],
            'laizeutile' => $data['laizeutile'],
            'consorecu' => $data['consorecu'],
            'efficiencerecu' => $data['efficiencerecu'],
            'varience' => $data['varience'],
            'tauxrecoupe' => $data['tauxrecoupe'],
            'pointplacement' => $data['pointplacement'],
            'commentaire' => $data['commentaire'],
            'id_type_placement' => $data['id_type_placement'],
            'etat' => 0
        ]);
    }

    public static function getAllTypePlacement()
    {
        $select = DB::select('select * from typeplacement where etat=0');
        return self::hydrate($select);
    }

    public static function getSuiviConsoByIdDCSDCEtapedev($iddclientsdcetapedev)
    {
        $select = DB::select('select * from suiviconso where  iddclientsdcetapedev='.$iddclientsdcetapedev);
        return self::hydrate($select);
    }

    public static function getAllTypePlacementById($id)
    {
        $select = DB::select('select * from typeplacement where id='.$id);
        return self::hydrate($select);
    }

    public static function getSuiviPlaceurByIdDCSDCEtapeDev($iddclientsdcetapedev)
    {
        $select = DB::select('select * from suiviplaceur where  iddclientsdcetapedev='.$iddclientsdcetapedev);
        return self::hydrate($select);
    }

    public static function insertEtapeIntermediaire($data)
    {
        DB::table('etapeintermediaire')->insert([
            'datedebut' => $data['datedebut'],
            'daterecepetion' => $data['daterecepetion'],
            'datefin' => $data['datefin'],
            'commentaire' => $data['commentaire'],
            'iddclientsdcetapedev' => $data['iddclientsdcetapedev'],
            'deadline' => $data['deadline'],
            'idetapedev' => $data['idetapedev'],
            'etat' => 0
        ]);
    }

    public static function updateSuiviConso($data)
    {
        DB::table('suiviconso')
        ->where('iddclientsdcetapedev', $data['iddclientsdcetapedev'])
        ->update([
            'daterecepetion' => $data['daterecepetion'],
            'datedebut' => $data['datedebut'],
            'datefin' => $data['datefin'],
            'deadline' => $data['deadline'],
            'etat' => 0
        ]);
    }

    public static function updateDetailSuiviConso($data)
    {
        DB::table('suividetailconso')
        ->where('idsuiviconso', $data['idsuiviconso'])
        ->where('idtissus', $data['idtissus'])
        ->update([
            'laizeutile' => $data['laizeutile'],
            'consocommande' => $data['consocommande'],
            'efficiencecommande' => $data['efficiencecommande'],
            'varience' => $data['varience'],
            'tauxrecoupe' => $data['tauxrecoupe'],
            'pointplacement' => $data['pointplacement'],
            'commentaire' => $data['commentaire'],
            'id_type_placement' => $data['id_type_placement'],
            'etat' => 0
        ]);
    }

    public static function updateDetailSuiviConsoProd($data)
    {
        DB::table('suividetailconso')
        ->where('idsuiviconso', $data['idsuiviconso'])
        ->where('idtissus', $data['idtissus'])
        ->update([
            'laizeutile' => $data['laizeutile'],
            'consorecu' => $data['consorecu'],
            'efficiencerecu' => $data['efficiencerecu'],
            'varience' => $data['varience'],
            'tauxrecoupe' => $data['tauxrecoupe'],
            'pointplacement' => $data['pointplacement'],
            'commentaire' => $data['commentaire'],
            'id_type_placement' => $data['id_type_placement'],
            'etat' => 0
        ]);
    }

    public static function isExisteSuiviConso($demandeClient)
    {
        $select = DB::table('v_suiviconso')
            ->where('id_demande_client', $demandeClient)
            ->count();
        return $select;
    }

    public static function getSuiviConsoByIdDemandeClient($idDemande)
    {
        $select = DB::select('select * from v_suiviconso where  id_demande_client='.$idDemande);
        return self::hydrate($select);
    }

    public static function isExisteDetailSuiviConso($suiviConso)
    {
        $select = DB::table('suividetailconso')
            ->where('idsuiviconso', $suiviConso)
            ->count();
        return $select;
    }

    public static function updateInterAchever($commentaire, $dateFin, $idDCSdcEtape){
        DB::select('update etapeintermediaire set commentaire=?, datefin=?  where iddclientsdcetapedev=?',[$commentaire,$dateFin,$idDCSdcEtape]);
    }

    public static function insertRapportMontage($data)
    {
        DB::table('rapportmontagedev')->insert([
            'daterecepetion' => $data['daterecepetion'],
            'datedebut' => $data['datedebut'],
            'deadline' => $data['deadline'],
            'multiplicateur' => $data['multiplicateur'],
            'iddclientsdcetapedev' => $data['iddclientsdcetapedev'],
            'etat' => 0
        ]);
    }


    public static function insertDetailRapportMontageDev($data)
    {
        DB::table('detailrapportmontagedev')->insert([
            'idrapportmontagedev' => $data['idrapportmontagedev'],
            'datefin' => $data['datefin'],
            'qteproduite' => $data['qteproduite'],
            'idlisteemploye' => $data['idlisteemploye'],
            'commentaire' => $data['commentaire'],
            'minuteproduite' => $data['minuteproduite'],
            'minutepresence' => $data['minutepresence'],
            'efficiencedev' => $data['efficiencedev'],
            'multiplicateur' => $data['multiplicateur'],
            'etat' => 0
        ]);
    }

    public static function getRapportMontageByIdDcSDCEtape($idDCSDCEtape)
    {
        $select = DB::select('select * from rapportMontageDev where  iddclientsdcetapedev='.$idDCSDCEtape);
        return self::hydrate($select);
    }

    public static function insertControleFinalDev($data)
    {
        DB::table('controlefinaldev')->insert([
            'daterecepetion' => $data['daterecepetion'],
            'datedebut' => $data['datedebut'],
            'deadline' => $data['deadline'],
            'iddclientsdcetapedev' => $data['iddclientsdcetapedev'],
            'etat' => 0
        ]);
    }

    public static function getAllRetouche()
    {
        $select = DB::select('select * from typeretouche where etat=0');
        return self::hydrate($select);
    }


    public static function isExisteControleFinal($idDCSDC)
    {
        $select = DB::table('controlefinaldev')
            ->where('iddclientsdcetapedev', $idDCSDC)
            ->count();
        return $select;
    }

    public static function insertDetailControleFinalDev($data)
    {
        DB::table('detailcontrolefinaldev')->insert([
            'datefin' => $data['datefin'],
            'retouche' => $data['retouche'],
            'qtecontrole' => $data['qtecontrole'],
            'qteretouche' => $data['qteretouche'],
            'qterejet' => $data['qterejet'],
            'idtyperetouche' => $data['idtyperetouche'],
            'commentaire' => $data['commentaire'],
            'tauxretouche' => $data['tauxretouche'],
            'tauxrejet' => $data['tauxrejet'],
            'idrapportmontagedev' => $data['idrapportmontagedev'],
            'etat' => 0
        ]);
    }

    public static function getControleFinalByIdDCSDC($idDCSDC)
    {
        $select = DB::select('select * from controlefinaldev where iddclientsdcetapedev='.$idDCSDC);
        return self::hydrate($select);
    }

    public static function insertFinitionDev($data)
    {
        DB::table('rapportfinitiondev')->insert([
            'daterecepetion' => $data['daterecepetion'],
            'datedebut' => $data['datedebut'],
            'deadline' => $data['deadline'],
            'iddclientsdcetapedev' => $data['iddclientsdcetapedev'],
            'etat' => 0
        ]);
    }

    public static function insertDetailFinitionDev($data)
    {
        DB::table('detailrapportfinitiondev')->insert([
            'idrapportfinitiondev' => $data['idrapportfinitiondev'],
            'datefin' => $data['datefin'],
            'qtefini' => $data['qtefini'],
            'idlisteemploye' => $data['idlisteemploye'],
            'commentaire' => $data['commentaire'],
            'minuteproduite' => $data['minuteproduite'],
            'minutepresence' => $data['minutepresence'],
            'efficiencedev' => $data['efficiencedev'],
            'etat' => 0
        ]);
    }


    public static function isExisteRapportFinition($idDCSDC)
    {
        $select = DB::table('rapportfinitiondev')
            ->where('iddclientsdcetapedev', $idDCSDC)
            ->count();
        return $select;
    }

    public static function getRapportFinitionByIdDCSDC($idDCSDC)
    {
        $select = DB::select('select * from rapportFinitionDev where iddclientsdcetapedev='.$idDCSDC);
        return self::hydrate($select);
    }

    public static function insertTransmission($data)
    {
        DB::table('transmissiondev')->insert([
            'dateenvoie' => $data['dateenvoie'],
            'qteenvoie' => $data['qteenvoie'],
            'commentaire' => $data['commentaire'],
            'iddclientsdcetapedev' => $data['iddclientsdcetapedev'],
            'etat' => 0
        ]);
    }

    public static function getAllPrimePatronier()
    {
        $select = DB::select('select * from primepatronier where etat=0');
        return self::hydrate($select);
    }

    public static function getPrimePatronierByPoints($nbrPoints)
    {
        $select = DB::select('select * from primepatronier where ?  between point_min and point_max',[$nbrPoints]);
        return self::hydrate($select);
    }


}
