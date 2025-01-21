<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ListeEmploye extends Model
{
    use HasFactory;
    protected $table = 'listeemploye';
    protected $fillable = [
        'nom',
        'prenom',
        'datenaissance',
        'matricule',
        'idfonction',
        'idsection',
        'statut',
        'categorie',
        'idclassification',
        'dateembauche',
        'datedebauche',
        'etatcivil',
        'numerocnaps',
        'civilite',
        'idpays',
        'salairebase',
        'contact',
        'photo',
        'mail',
        'nomutilisateur',
        'motdepasse',
        'etat'
    ];

    public static function getAllListeEmploye()
    {
        $select = DB::select('select * from v_listeEmploye');
        return self::hydrate($select);
    }
    public static function getAllListeEmployePatronier()
    {
        $select = DB::select("select * from v_listeEmploye where lower(designationfonction) = lower('patronage')");
        return self::hydrate($select);
    }


    public static function getAllListeEmployePlaceur()
    {
        // $select = DB::select("select * from v_listeEmploye where lower(designationfonction) = lower('placeur')");
        $select = DB::select("select * from v_listeEmploye");
        return self::hydrate($select);
    }

    public static function getAllListeEmployeMontage()
    {
        $select = DB::select("select * from v_listeEmploye where lower(designationfonction) = lower('montage')");
        return self::hydrate($select);
    }

    public static function getHeureTravailByDateEntreeEmploye($dateEntree, $idEmploye)
{
    $result = DB::select("SELECT EXTRACT(EPOCH FROM (dateSortie - dateEntree)) / 60 AS heuretravail_en_minutes FROM heureTravailEmployee WHERE DATE(dateEntree) = ? AND idlisteemploye = ?", [$dateEntree, $idEmploye]);

    return !empty($result) ? $result[0]->heuretravail_en_minutes : 480;
}


    public static function getMinuteTravailEmploye($dateEntree, $idEmploye)
    {
        $select = DB::select("select * from  heureTravailEmployee where DATE(dateEntree)=? and idlisteemploye=?",[$dateEntree,$idEmploye]);
        return self::hydrate($select);
    }

    public static function getAllListeEmployeDeveloppement()
    {
        $select = DB::select("select * from v_listeEmploye where lower(designationsection) = lower('developpement')");
        return self::hydrate($select);
    }


    public static function getAllListeEmployeRecherche($nom)
    {
        $select = DB::select("select * from v_listeEmploye where nom ILIKE '%".$nom."%' or prenom ILIKE '%".$nom."%' and lower(designationsection) = lower('developpement')");
        return self::hydrate($select);
    }

    public static function loginEmploye($pseudo, $mpd)
    {
        $select = DB::select("select * from v_listeEmploye where pseudo='".$pseudo."' and motdepasse='".$mpd."'");
        return self::hydrate($select);
    }




}
