<?php

namespace App\Models\COMPLIANCE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoAuditInterne extends Model{
    use HasFactory;

    protected $table = 'photo_audit_interne';

    public $incrementing = false; // Désactive l'auto-incrémentation
    
    public $timestamps = false;   // Désactive les colonnes timestamps si elles ne sont pas utilisées

    protected $primaryKey = 'id'; // Indique qu'il n'y a pas de clé primaire

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_audit_interne',
        'photo_initial',
        'photo_final',
        'mime_type_initial',
        'mime_type_final'
    ];
}
