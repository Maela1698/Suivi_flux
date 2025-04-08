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
        'deadline',
        'avancement'
    ];

    public function getPrioriteAttribute($value){
        $prioriteMap = [
            1 => ["classe" => "faible", "valeur" => "Faible"],
            2 => ["classe" => "moyenne", "valeur" => "Moyenne"],
            3 => ["classe" => "elevee", "valeur" => "Élevée"]
        ];
    
        return $prioriteMap[$value] ?? ["classe" => "", "valeur" => ""];
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

    public function getAvancementAttribute($value) {
        // Vérifie si la valeur est entre 50 et 99 (inclus)
        if ($value >= 50 && $value < 100) {
            return [
                "classe" => "moyenne",
                "valeur" => $value
            ];
        }
    
        // Vérifie si la valeur est exactement 100
        if ($value == 100) {
            return [
                "classe" => "faible",
                "valeur" => $value
            ];
        }
        
        // Pour toutes les autres valeurs (inférieures à 50), retourne "moyenne"
        return [
            "classe" => "elevee",
            "valeur" => $value // Correction de la clé "value" en "valeur"
        ];
    }
    
}