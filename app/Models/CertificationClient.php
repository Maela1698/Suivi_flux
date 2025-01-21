<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CertificationClient extends Model
{
    use HasFactory;
    protected $table = 'certificationclient';
    protected $fillable = [
        'certification',
        'etat',
    ];

    public static function getAllCertification(){
        $select=DB::select('select * from certificationclient where etat=0');
        return self::hydrate($select);
    }
}
