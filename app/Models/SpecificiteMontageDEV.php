<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SpecificiteMontageDEV extends Model
{
    use HasFactory;

    protected $table = 'specificitemontagedev';
    protected $fillable = [
        'iddclientsdcetapedev',
        'valeurcouture',
        'pointcm',
        'montagedevant',
        'montageenvers',
        'maille',
        'glissementcouture',
        'prerundemande',
        'demandelapdip',
        'demandetauxretrait',
        'tauxmesure',
        'conformitedossier',
        'autres'
    ];

    public static function getAllSpecificiteMontage($idDCSDCEtape)
    {
        $select = DB::select('select * from specificitemontagedev where iddclientsdcetapedev ='.$idDCSDCEtape);
        return self::hydrate($select);
    }

    public function insertSpecificiteMontage($data)
    {
        DB::table($this->table)->insert([
            'iddclientsdcetapedev' => $data['iddclientsdcetapedev'],
            'valeurcouture' =>$data['valeurcouture'],
            'pointcm' => $data['pointcm'],
            'montagedevant' => $data['montagedevant'],
            'montageenvers' => $data['montageenvers'],
            'glissementcouture' => $data['glissementcouture'],
            'maille' => $data['maille'],
            'prerundemande' => $data['preRunDemande'],
            'demandelapdipint' => $data['demandeLapdip'],
            'demandetauxretrait' => $data['demandeTauxRetrait'],
            'tauxmesure' => $data['tauxMesure'],
            'conformitedossier' => $data['conformiteDossier'],
            'autres' =>  $data['autres']
        ]);
    }

    public function updateSpecificiteMontage($data)
    {
        DB::table($this->table)
        ->where('iddclientsdcetapedev', $data['iddclientsdcetapedev'])
        ->update([
            'iddclientsdcetapedev' => $data['iddclientsdcetapedev'],
            'valeurcouture' =>$data['valeurcouture'],
            'pointcm' => $data['pointcm'],
            'montagedevant' => $data['montagedevant'],
            'montageenvers' => $data['montageenvers'],
            'glissementcouture' => $data['glissementcouture'],
            'maille' => $data['maille'],
            'prerundemande' => $data['preRunDemande'],
            'demandelapdipint' => $data['demandeLapdip'],
            'demandetauxretrait' => $data['demandeTauxRetrait'],
            'tauxmesure' => $data['tauxMesure'],
            'conformitedossier' => $data['conformiteDossier'],
            'autres' =>  $data['autres']
        ]);
    }
}
