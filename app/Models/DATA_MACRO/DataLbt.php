<?php

namespace App\Models\DATA_MACRO;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataLbt extends Model
{
    use HasFactory;

    protected $table = 'datalbt';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iddemandeclient',
        'disponibilite',
        'poids',
        'propositioninline',
        'inline',
        'outline',
        // 'effectif',
        'heure',
        'efficience',
        'capacite',
        'jourprod',
        'heuregrmt',
        'besoinloading',
        'idlistemachine',
        'etat',
        'etatjourspe',
        'commentaire',
        'valeurajoutee'
    ];

    public static function findDataLbtByIdDmd($demande_client_id)
    {
        $select = DB::select('select * from datalbt where iddemandeclient=?', [$demande_client_id]);
        if (empty($select)) {
            // Retourner null ou une autre valeur par défaut si aucune donnée n'est trouvée
            return []; // ou return []; si vous voulez retourner un tableau vide
        }
        return self::hydrate($select);
    }

    public static function findoidsDataLbtByIdDmd($demande_client_id)
    {
        $select = DB::select('
            WITH poids AS (
                SELECT demande_client_id, qte
                FROM v_data_details
                WHERE demande_client_id = ?
            )
            SELECT d.iddemandeclient, d.poids, (d.poids * p.qte) AS poids_total
            FROM datalbt d
            JOIN poids p ON p.demande_client_id = d.iddemandeclient
            WHERE d.iddemandeclient = ?
        ', [$demande_client_id, $demande_client_id]);

        if (empty($select)) {
            // Retourner un tableau vide si aucune donnée n'est trouvée
            return []; // ou return null; si vous voulez retourner null
        }

        return self::hydrate($select);
    }




    public static function insertDataLbt($data)
    {
        return self::create([
            'iddemandeclient' => $data['iddemandeClient'],
            'disponibilite' => $data['propositioninline'],
            'poids' => $data['poids'],
            'propositioninline' => $data['propositioninline'],
            'inline' => $data['inline'],
            'outline' => $data['outline'],
            // 'effectif' => $data['effectif'],
            'heure' => $data['heure'],
            'efficience' => $data['efficience'],
            'capacite' => $data['capacite'],
            'jourprod' => $data['jourprod'],
            'heuregrmt' => $data['heuregrmt'],
            'besoinloading' => $data['besoin_loading'],
            'idlistemachine' => $data['idlistemachine'],
            'etat' => 0,
            'etatjourspe' => $data['etatjourspe'] ?? null,
            'commentaire' => $data['commentaire'] ?? null,
            'valeurajoutee' => $data['valeurajoutee'] ?? null,
        ]);
    }

    public static function updateDataLbt($id, $data)
    {
        $dataLbt = self::findOrFail($id);

        $dataLbt->iddemandeclient = $data['iddemandeclient'];
        $dataLbt->disponibilite = $data['disponibilite'] ?? null;
        $dataLbt->poids = $data['poids'];
        $dataLbt->propositioninline = $data['propositioninline'];
        $dataLbt->inline = $data['inline'];
        $dataLbt->outline = $data['outline'];
        // $dataLbt->effectif = $data['effectif'];
        $dataLbt->heure = $data['heure'];
        $dataLbt->efficience = $data['efficience'];
        $dataLbt->capacite = $data['capacite'];
        $dataLbt->jourprod = $data['jourprod'];
        $dataLbt->heuregrmt = $data['heuregrmt'];
        $dataLbt->besoinloading = $data['besoin_loading'];
        $dataLbt->idlistemachine = $data['idlistemachine'];
        $dataLbt->etatjourspe = $data['etatJourSpe'] ?? null;
        $dataLbt->commentaire = $data['commentaire'] ?? null;
        $dataLbt->valeurajoutee = $data['valeurajoutee'] ?? null;

        $dataLbt->save();

        return $dataLbt;
    }
}
