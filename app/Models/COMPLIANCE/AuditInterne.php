<?php

namespace App\Models\COMPLIANCE;

use App\Models\Objet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditInterne extends Objet{
    use HasFactory;

    protected $table = 'audit_interne';

    public $incrementing = false; // Désactive l'auto-incrémentation
    
    public $timestamps = false;   // Désactive les colonnes timestamps si elles ne sont pas utilisées

    protected $primaryKey = 'id'; // Indique qu'il n'y a pas de clé primaire

    protected $keyType = 'string';

    public static $prefixe;

    public function __construct() {
        self::$prefixe = 'AI' . substr(date('Y'), -2) . '-';
    }

    public static $nomSequence = 'audit_interne_seq';

    protected $fillable = [
        'id',
        'date_detection',
        'id_section',
        'priorite',
        'constat',
        'action',
        'deadline',
    ];

    

    public function store(array $data){
        //generer l'id grace au fonction generateObjectId dans le model Objet
        $id = AuditInterne::generateId();
        $this->fill([
            'id' => $id,
            'date_detection' => $data['date_detection'],
            'id_section' => $data['id_section'],
            'priorite' => $data['priorite'],
            'constat' => $data['constat'],
            'action' => $data['action'],
            'deadline' => $data['deadline'],
        ]);
        $this->save();
    }  
}