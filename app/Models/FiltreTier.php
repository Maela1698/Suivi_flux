<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiltreTier extends Model
{
    use HasFactory;
       protected $table = 'v_filtretier';

       protected $fillable = [
           'id_tier',
           'nomtier',
           'idacteur',
           'acteur',
           'adresse',
           'ville',
           'codepostal',
           'idpays',
           'pays',
           'numphone',
           'emailtier',
           'website',
           'idunite',
           'unite_monetaire',
           'idqualite',
           'qualite',
           'idetat',
           'etat',
           'merchsenior',
           'contactmerchsenior',
           'emailmerchsenior',
           'merchjunior',
           'contactmerchjunior',
           'emailmerchjunior',
           'assistant',
           'contactassistant',
           'emailassistant',
           'logo',
           'dateentree',
           'etat_tier'
       ];
}
