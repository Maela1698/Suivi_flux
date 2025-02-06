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
}
