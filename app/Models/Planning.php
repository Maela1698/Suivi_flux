<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Planning extends Model
{
    use HasFactory;

    public static function getAllDemandeClientSDCEtapeDevLimit()
    {
        $select = DB::select('select * from v_demandeClientSDCEtapeDev order by id asc limit 100');
        return self::hydrate($select);
    }

    public static function nombreCommande()
    {
        $select = DB::select('select count(*) as nombre from v_demandeClientSDCEtapeDev');
        return self::hydrate($select);
    }

    public static function getAllDemandeClientSDCEtapeDevRecherche($condition)
    {
        $select = DB::select('select * from v_demandeClientSDCEtapeDev where 1=1 '.$condition);
        return self::hydrate($select);
    }

    public static function getAllEtapeDEV()
    {
        $select = DB::select('select *from etapeDev order by niveau');
        return self::hydrate($select);
    }






}
