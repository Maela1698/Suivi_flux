<?php

namespace App\Models\DATA_MACRO;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataBm extends Model
{
    use HasFactory;

    protected $table = 'databrodmain';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iddemandeclient',
        'disponibilite',
        'tempsbrod',
        'propositioninline',
        'inline',
        'outline',
        // 'effectif',
        'efficience',
        'capacite',
        'jourprod',
        'heuregrmt',
        'besoinloading',
        'etat',
        'etatjourspe',
        'commentaire'
    ];

    public static function insertDataBm($data)
    {
        return self::create([
            'iddemandeclient' => $data['demande_client_id'],
            'disponibilite' => $data['propositionInline'],
            'tempsbrod' => $data['tempsbrod'],
            'propositioninline' => $data['propositionInline'],
            'inline' => $data['inline'],
            'outline' => $data['outline'],
            'effectif_bm' => $data['effectif_bm'],
            'efficience' => $data['efficience'],
            'capacite' => $data['capacite'],
            'jourprod' => $data['jourprod'],
            'heuregrmt' => $data['heuregrmt'],
            'besoinloading' => $data['besoin_loading'],
            'etat' => 0, // Par défaut
            'etatjourspe' => $data['etatjourspe'] ?? null,
            'commentaire' => $data['commentaire'] ?? null,
            'heuresup' => $data['heuresup'],
        ]);
    }

    public static function findDataBmByIdDmd($demande_client_id)
    {
        $select = DB::select('select * from databrodmain where iddemandeclient=?', [$demande_client_id]);
        return self::hydrate($select);
    }

    public static function updateDataBm($id, $data)
    {
        $dataProd = self::findOrFail($id);

        return self::where('id', $id)->update([
            'iddemandeclient' => $data['demande_client_id'],
            'disponibilite' => $data['propositionInline'],
            'tempsbrod' => $data['tempsbrod'],
            'propositioninline' => $data['propositionInline'],
            'inline' => $data['inline'],
            'outline' => $data['outline'],
            'effectif_bm' => $data['effectif_bm'],
            'efficience' => $data['efficience'],
            'capacite' => $data['capacite'],
            'jourprod' => $data['jourprod'],
            'heuregrmt' => $data['heuregrmt'],
            'besoinloading' => $data['besoin_loading'],
            'etatjourspe' => $data['etatjourspe'] ?? null,
            'commentaire' => $data['commentaire'] ?? null,
            'heuresup' => $data['heuresup'],

        ]);
    }
}
