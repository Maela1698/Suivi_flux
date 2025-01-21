<?php

namespace App\Models\DATA_MACRO;

use Dompdf\FrameDecorator\Inline;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataPro extends Model
{
    use HasFactory;

    protected $table = 'dataprod';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'iddemandeclient',
        'disponibilite',
        'id_chaine',
        'propositioninline',
        'inline',
        'outline',
        'capacite',
        'jourprod',
        'minutegrmt',
        'etat',
        'etatjourspe',
        'commentaire',
        'qte_coupe',
        'heuresup'
    ];

    public static function findDataProdByIdDmd($demande_client_id)
    {
        $select = DB::select('select * from dataprod where iddemandeclient=?', [$demande_client_id]);
        return self::hydrate($select);
    }

    public static function insertDataProd($data)
    {
        return self::create([
            'iddemandeclient' => $data['demande_client_id'],
            'disponibilite' => $data['propositionInline'],
            'id_chaine' => $data['id_chaine'],
            'propositioninline' => $data['propositionInline'],
            'inline' => $data['inline'],
            'outline' => $data['outline'],
            'capacite' => $data['capacite'],
            'jourprod' => $data['jourprod'],
            'minutegrmt' => $data['minuteGrmt'],
            'etat' => 0, // Par défaut
            'etatjourspe' => $data['etatjourspestr'] ?? null,
            'commentaire' => $data['commentaire'] ?? null,
            'qte_coupe' => $data['qte_coupe'],
            'heuresup' => $data['heuresup'],

        ]);
    }

    public static function updateDataProd($id, $data)
    {
        $dataProd = self::findOrFail($id);

        $dataProd->iddemandeclient = $data['demande_client_id'];
        $dataProd->disponibilite = $data['propositionInline'];
        $dataProd->id_chaine = $data['id_chaine'];
        $dataProd->propositioninline = $data['propositionInline'];
        $dataProd->inline = $data['inline'];
        $dataProd->outline = $data['outline'];
        $dataProd->capacite = $data['capacite'];
        $dataProd->jourprod = $data['jourprod'];
        $dataProd->minutegrmt = $data['minuteGrmt'];
        $dataProd->etatjourspe = $data['etatjourspestr'] ?? null;
        $dataProd->commentaire = $data['commentaire'] ?? null;
        $dataProd->qte_coupe = $data['qte_coupe'];
        $dataProd->heuresup = $data['heuresup'];


        return $dataProd->save();
    }

    public static function getInlineRMaxAndNbj($idchaine)
    {
        $result = DB::table('dataprod')
            ->select('inline', 'jourprod')
            ->where('id_chaine', $idchaine)
            ->orderBy('inline', 'desc')
            ->first();

        if ($result) {
            $inlineMax = $result->inline;
            $jourprod = $result->jourprod;

            $newDate = \Carbon\Carbon::parse($inlineMax)->addDays($jourprod);

            return $newDate->format('Y-m-d');
        }

        return null;
    }
}
