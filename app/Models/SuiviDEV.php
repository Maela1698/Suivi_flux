<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SuiviDEV extends Model
{
    use HasFactory;

    public static function getAllSuiviPatronage()
    {
        $select = DB::select('select * from v_suivipatronage');
        return self::hydrate($select);
    }

    public static function getAllSuiviConso()
    {
        $select = DB::select('select * from v_suividetailconso');
        return self::hydrate($select);
    }

    public static function getAllSuiviPlaceur()
    {
        $select = DB::select('select * from v_suiviPlaceur');
        return self::hydrate($select);
    }

    public static function getAllControlePatronage()
    {
        $select = DB::select('select * from v_controlePatronage');
        return self::hydrate($select);
    }

    public static function getSuiviPatronageRecherche($condition)
    {
        $select = DB::select('select * from v_suivipatronage where '.$condition);
        return self::hydrate($select);
    }

    public static function getSuiviPlaceurRecherche($condition)
    {
        $select = DB::select('select * from v_suiviplaceur where  1=1 '.$condition);
        return self::hydrate($select);
    }

    public static function getSuiviConsoRecherche($condition)
    {
        $select = DB::select('select * from v_suiviDetailConso where 1=1 '.$condition);
        return self::hydrate($select);
    }

    public static function getAllRapportMontageDev()
    {
        $select = DB::select('select * from v_rapportMontageDev');
        return self::hydrate($select);
    }

    public static function getAllRapportFinitionDev()
    {
        $select = DB::select('select * from v_rapportFinition');
        return self::hydrate($select);
    }

    public static function getControlFinalDev()
    {
        $select = DB::select('select * from v_controlefinal');
        return self::hydrate($select);
    }

    public static function getRapportMontageRecherche($condition)
    {
        $select = DB::select('select * from v_rapportMontageDev where 1=1 '.$condition);
        // dd('select * from v_rapportMontageDev where 1=1 '.$condition);
        return self::hydrate($select);
    }

    public static function getRapportFinitionRecherche($condition)
    {
        $select = DB::select('select * from v_rapportFinition where 1=1 '.$condition);
        // dd('select * from v_rapportFinition where 1=1 '.$condition);
        return self::hydrate($select);
    }

    public static function getControlePatronageRecherche($condition)
    {
        $select = DB::select(query: 'select * from v_controlePatronage where 1=1 '.$condition);
        return self::hydrate($select);
    }

    public static function getControlFinalDevRecherche($condition)
    {
        $select = DB::select('select * from v_controlefinal  where 1=1 '.$condition);
        return self::hydrate($select);
    }

    public static function getAllTransmissionMerch()
    {
        $select = DB::select('select * from v_transmissionMerch ');
        return self::hydrate($select);
    }


    public static function getAllTransmissionMerchRecherche($condition)
    {
        $select = DB::select('select * from v_transmissionMerch where 1=1 '.$condition);
        return self::hydrate($select);
    }

    public static function getAllTransmissionClient()
    {
        $select = DB::select('select * from v_echantillon ');
        return self::hydrate($select);
    }

    public static function getAllTransmissionClientRecherche($condition)
    {
        $select = DB::select('select * from v_echantillon where 1=1 '.$condition);
        return self::hydrate($select);
    }

}
