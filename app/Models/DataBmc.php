<?php

namespace App\Models\DATA_MACRO;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataBmc extends Model
{
    use HasFactory;

    protected $table = 'databrodmachine';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iddemandeclient',
        'disponibilite',
        'propositioninline',
        'inline',
        'outline',
        'effectif_bmc',
        'efficience',
        'capacite',
        'jourprod',
        'heuregrmt',
        'besoinloading',
        'idlistemachine',
        'etat',
        'etatjourspe',
        'commentaire'
    ];

    public static function insertDataBmc($data)
    {
        return self::create([
            'iddemandeclient' => $data['demande_client_id'],
            'disponibilite' => $data['propositionInline'],
            'propositioninline' => $data['propositionInline'],
            'inline' => $data['inline'],
            'outline' => $data['outline'],
            'effectif_bmc' => $data['effectif_bm'],
            'efficience' => $data['efficience'],
            'capacite' => $data['capacite'],
            'jourprod' => $data['jourprod'],
            'heuregrmt' => $data['heuregrmt'],
            'besoinloading' => $data['besoin_loading'],
            'etat' => 0, // Par défaut
            'etatjourspe' => $data['etatjourspe'] ?? null,
            'commentaire' => $data['commentaire'] ?? null,
            'idlistemachine' => $data['idlistemachine'],
        ]);
    }
    public static function findDataBmcByIdDmd($demande_client_id)
    {
        $select = DB::select('select * from databrodmachine where iddemandeclient=?', [$demande_client_id]);
        return self::hydrate($select);
    }
    public static function updateDataBmc($id, $data)
    {
        $dataToUpdate = [
            'iddemandeclient' => $data['demande_client_id'],
            'disponibilite' => $data['propositionInline'],
            'propositioninline' => $data['propositionInline'],
            'inline' => $data['inline'],
            'outline' => $data['outline'],
            'effectif_bmc' => $data['effectif_bm'],
            'efficience' => $data['efficience'],
            'capacite' => $data['capacite'],
            'jourprod' => $data['jourprod'],
            'heuregrmt' => $data['heuregrmt'],
            'besoinloading' => $data['besoin_loading'],
            'etat' => 0, // Par défaut
            'etatjourspe' => $data['etatjourspe'] ?? null,
            'commentaire' => $data['commentaire'] ?? null,
            'idlistemachine' => $data['idlistemachine'],
        ];

        // Trouver l'enregistrement par ID et le mettre à jour
        $dataBmc = self::find($id);
        if ($dataBmc) {
            $dataBmc->update($dataToUpdate);
            return $dataBmc;
        }

        return null; // ou gérer l'erreur comme vous le souhaitez
    }
}
