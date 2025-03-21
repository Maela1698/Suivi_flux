<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsableSection extends Model
{
    use HasFactory;

    protected $table = 'responsable_section';

    public $timestamps = false;

    protected $primaryKey = null;

    public $incrementing = false; // Désactiver l'auto-incrémentation

    public function addResponsableSection($id_section,$id_employe) {
        $this->id_section = $id_section;
        $this->id_employe = $id_employe;
        $this->save();
    }
}
