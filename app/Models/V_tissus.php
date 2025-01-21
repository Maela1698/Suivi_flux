<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class V_tissus extends Model
{
    use HasFactory;

    protected $table = 'v_tissus';
    protected $fillable = [
        'id_type_tissus',
        'id_demande_client',
        'id_categorie_tissus',
        'designation',
        'reference',
        'id_composition_tissus',
        'couleur',
        'quantite',
        'id_unite_mesure_matiere',
        'prix_unitaire',
        'frais',
        'id_unite_monetaire',
        'grammage',
        'laize_utile',
        'id_famille_tissus',
        'l_retrait_lavage',
        'w_retrait_lavage',
        'l_retrait_teinture',
        'w_retrait_teinture',
        'nom_fiche_technique',
        'id_classe',
        'fiche_technique',
        'photo',
        'etat',
        'type_tissus',
        'categorie',
        'composition_tissus',
        'unite_mesure',
        'unite',
        'famille_tissus',
        'classe'
    ];

    public static function getAllV_tissu($idDC)
    {
        $select = DB::select('select * from v_tissus where etat=0 and id_demande_client='.$idDC." order by id asc");
        return self::hydrate($select);
    }

    public static function getAllV_tissuById($id)
    {
        $select = DB::select('select * from v_tissus where id='.$id);
        return self::hydrate($select);
    }
}
