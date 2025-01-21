<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class V_accessoire extends Model
{
    use HasFactory;

    protected $table = 'v_accessoire';
    protected $fillable = [
        'id_type_accessoire',
        'id_demande_client',
        'utilisation',
        'designation',
        'reference',
        'couleur',
        'quantite',
        'id_unite_mesure_matiere',
        'prix_unitaire',
        'frais',
        'id_unite_monetaire',
        'id_famille_accessoire',
        'photo',
        'nom_fiche_technique',
        'fiche_technique',
        'id_classe',
        'etat',
        'type_accessoire',
        'unite',
        'unite_mesure',
        'famille_accessoire',
        'classe'
    ];

    public static function getAllV_accessoireByDC($idDC)
    {
        $select = DB::select('select * from v_accessoire where etat=0 and id_demande_client='.$idDC.' order by id asc');
        return self::hydrate($select);
    }

    public static function getAllV_accessoireById($id)
    {
        $select = DB::select('select * from v_accessoire where id='.$id);
        return self::hydrate($select);
    }

    public static function getAllV_accessoireSansFinition($idDC)
    {
        // $select = DB::select("SELECT * FROM v_accessoire WHERE etat = 0 AND id_demande_client = ? AND type_accessoire NOT ILIKE '%FINITION%' ORDER BY id ASC", [$idDC]);
        $select = DB::select("SELECT * FROM v_accessoire WHERE etat = 0 AND id_demande_client = ?  ORDER BY id ASC", [$idDC]);
        return self::hydrate($select);
    }

}
