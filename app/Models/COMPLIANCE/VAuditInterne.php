<?php

namespace App\Models\COMPLIANCE;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VAuditInterne extends Model{
    use HasFactory;

    protected $table = 'v_audit_interne';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    protected $fillable = [
        'date_detection',
        'priorite',
        'deadline'
    ];

    public function getPrioriteAttribute($value){
        $prioriteMap = [
            1 => "Faible",
            2 => "Moyenne",
            3 => "Élevée"
        ];
    
        return $prioriteMap[$value] ?? "";
    }

    public function getDateDetectionAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('d-m-Y');
    }

    public function getDeadlineAttribute($value){
        if($value){
            $date = Carbon::parse($value);
            return $date->format('d-m-Y');
        }
    }
}
