<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Machine extends Model
{
    use HasFactory;
    protected $table = 'listemachine';
    public $timestamps = false;
    protected $fillable = [
        'dateentreemachine',
        'id_from_fournisseur',
        'codemachine',
        'idmarquemachine',
        'idcategoriemachine',
        'id_fournisseur_machine',
        'reference',
        'capacite',
        'proprietee',
        'idtaillemachine',
        'prixu',
        'photo',
        'etat',
        'idunitemonetaire',
    ];

    public static function insertdossierMachine($idmachine, $dossier, $nomdossier)
    {
        DB::insert('insert into dossiermachine (idlistemachine,dossier,nomdossier) values(?,?,?)', [$idmachine, $dossier, $nomdossier]);
    }

    public static function updateEtatMachine2($idmachine, $etat)
    {
        return DB::update('update listemachine set etat=? where id=?', [$etat, $idmachine]);
    }
}
