<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ppmeeting extends Model
{
    use HasFactory;
    public static function insertDisponibilite($iddemande, $tissus, $accy, $okprod)
    {
        DB::insert('insert into datedisponibiliteforppmeeting (id_demande_client,tissus, accy, okprod) values (?,?, ?, ?)', [$iddemande, $tissus, $accy, $okprod]);
    }
    public static function updateDisponibilite($iddemande, $tissus, $accy, $okprod)
    {
        DB::update('update datedisponibiliteforppmeeting set tissus = ?, accy = ?, okprod = ? where id_demande_client = ?', [$tissus, $accy, $okprod, $iddemande]);
    }
    public static function getDispoByIdDemandeForPpmeeting($iddemande)
    {
        $select = DB::select('select * from datedisponibiliteforppmeeting where id_demande_client = ?', [$iddemande]);
        return self::hydrate($select);
    }

    public static function insertPPMeeting($date)
    {
        return DB::table('meeting')->insertGetId([
            'date' => $date
        ]);
    }


    public static function insertDetailMeeting($id_meeting, $heure_debut, $effectif_prevu, $effectif_reel, $id_demande, $commentaire, $id_chaine, $date_entree_chaine, $date_entree_coupe, $date_entree_finition)
    {
        DB::table('details_meeting')->insert([
            'id_meeting' => $id_meeting,
            'heure_debut' => $heure_debut,
            'effectif_prevu' => $effectif_prevu,
            'effectif_reel' => $effectif_reel,
            'id_demande' => $id_demande,
            'commentaire' => $commentaire,
            'id_chaine' => $id_chaine,
            'date_entree_chaine' => $date_entree_chaine,
            'date_entree_coupe' => $date_entree_coupe,
            'date_entree_finition' => $date_entree_finition
        ]);
    }

    public static function updateDetailMeeting($id_meeting, $heure_debut, $effectif_prevu, $effectif_reel,$commentaire,$id_chaine,$date_entree_chaine,$date_entree_coupe,$date_entree_finition,$etat,$id_demande)
    {
        DB::update('update details_meeting set id_meeting = ?, heure_debut = ?, effectif_prevu = ?, effectif_reel=?, commentaire=?, id_chaine=?, date_entree_chaine=?, date_entree_coupe=?, date_entree_finition=?, etat=? where id_demande = ?', [$id_meeting, $heure_debut, $effectif_prevu, $effectif_reel,$commentaire,$id_chaine,$date_entree_chaine,$date_entree_coupe,$date_entree_finition,$etat,$id_demande]);
    }

    public static function isMeetingExiste($date)
    {
        $select = DB::select("select id from meeting where date='" . $date . "'");
        return $select[0]->id ?? 0;
    }

    public static function isDetailMeetingExiste($id_demande)
    {
        $select = DB::select("select id from details_meeting where id_demande=" . $id_demande);
        return $select[0]->id ?? 0;
    }

    public static function compteModeleInMeeting($id_meeting)
    {
        $select = DB::select("select count(*) as somme from details_meeting where id_meeting=" . $id_meeting);
        return $select[0]->somme ?? 0;
    }

    public static function getAllChaine()
    {
        $select = DB::select("select * from chaine");
        return self::hydrate($select);
    }
}
