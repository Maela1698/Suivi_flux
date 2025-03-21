<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VResponsableSection extends Model
{
    use HasFactory;

    protected $table = 'v_responsable_section';

    protected $fillable = [
        'id_employe',
        'nom_employe',
        'prenom_employe',
        'matricule'
    ];

    public function getIdEmployeAttribute($value){
        if(!$value){
            return "N/A";
        }
        return $value;
    }

    public function getNomEmployeAttribute($value){
        if(!$value){
            return "N/A";
        }
        return $value;
    }

    public function getPrenomEmployeAttribute($value) {
        if ($this->getNomEmployeAttribute($this->nom_employe) === "N/A") {
            return '';
        }
        return $value;
    }

    public function getMatriculeAttribute($value){
        if(!$value){
            return "N/A";
        }
        return $value;
    }
}
