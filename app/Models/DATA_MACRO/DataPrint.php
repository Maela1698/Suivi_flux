<?php

namespace App\Models\DATA_MACRO;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataPrint extends Model
{
    use HasFactory;

    protected $table = 'dataprint';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iddemandeclient',
        'disponibilite',
        'tempsprint',
        'propositioninline',
        'inline',
        'outline',
        'effectif',
        'efficience',
        'capacite',
        'jourprod',
        'minutegrmt',
        'besoinloading',
        'etat',
        'etatjourspe',
        'commentaire',
        'heuresup'
    ];

    public static function insertDataPrint($data)
    {
        return self::create([
            'iddemandeclient' => $data['demande_client_id'],
            'disponibilite' => $data['propositionInline'],
            'tempsprint' => $data['temps_print'],
            'propositioninline' => $data['propositionInline'],
            'inline' => $data['inline'],
            'outline' => $data['outline'],
            'effectif' => $data['effectif'],
            'efficience' => $data['efficience'],
            'capacite' => $data['capacite'],
            'jourprod' => $data['jourprod'],
            'minutegrmt' => $data['minuteGrmt'],
            'besoinloading' => $data['besoin_loading'],
            'etat' => 0,
            'etatjourspe' => $data['etatjourspe'] ?? null,
            'commentaire' => $data['commentaire'] ?? null,
            'heuresup' => $data['heuresup'] ?? 0,
        ]);
    }

    public static function findDataPrintByIdDmd($demande_client_id)
    {
        $select = DB::select('select * from dataPrint where iddemandeclient=?', [$demande_client_id]);
        return self::hydrate($select);
    }


    public static function updateDataPrint($id, $data)
    {
        // Trouver l'enregistrement par son ID
        $dataPrint = self::findOrFail($id);

        $dataPrint->iddemandeclient = $data['demande_client_id'];
        $dataPrint->disponibilite = $data['propositioninline'];
        $dataPrint->tempsprint = $data['temps_print'];
        $dataPrint->propositioninline = $data['propositioninline'];
        $dataPrint->inline = $data['inline'];
        $dataPrint->outline = $data['outline'];
        $dataPrint->effectif = $data['effectif'];
        $dataPrint->efficience = $data['efficience'];
        $dataPrint->capacite = $data['capacite'];
        $dataPrint->jourprod = $data['jourprod'];
        $dataPrint->minutegrmt = $data['minuteGrmt'];
        $dataPrint->besoinloading = $data['besoin_loading'];
        $dataPrint->etat = $data['etat'] ?? 0;
        $dataPrint->etatjourspe = $data['etatjourspe'] ?? null;
        $dataPrint->commentaire = $data['commentaire'] ?? null;
        $dataPrint->heuresup = $data['heuresup'] ?? 0;

        return $dataPrint->save();
    }
}
