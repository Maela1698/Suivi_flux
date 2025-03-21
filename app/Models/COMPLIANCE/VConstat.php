<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

class VConstat extends Model
{
    use HasFactory;

    protected $table = 'vue_constats';

    protected $primaryKey = 'constat_id';

    protected $fillable = [
        'dateconstat',
        'priorite',
        'constat_deadline'
    ];

    public function getPrioriteAttribute($value){
        $prioriteMap = [
            1 => "Faible",
            2 => "Moyenne",
            3 => "Élevée"
        ];
    
        return $prioriteMap[$value] ?? "";
    }

    public function getDateconstatAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('d-m-Y');
    }

    public function getConstatDeadlineAttribute($value){
        if($value){
            $date = Carbon::parse($value);
            return $date->format('d-m-Y');
        }
    }
}
