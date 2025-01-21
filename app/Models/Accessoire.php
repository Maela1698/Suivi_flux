<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Accessoire extends Model
{
    use HasFactory;

    protected $table = 'accessoire';
    protected $fillable = [
        'id',
        'id_type_accessoire',
        'id_demande_client',
        'utilisation',
        'designation',
        'reference',
        'couleur',
        'quantite',
        'id_unite_mesure_matiere',
        'prix_unitaire',
        'frais',
        'id_unite_monetaire',
        'id_famille_accessoire',
        'photo',
        'nom_fiche_technique',
        'fiche_technique',
        'id_classe',
        'etat'
    ];

    public static function getAllAccessoireByDC($idDC){
        $select=DB::select('select * from accessoire where id_demande_client='.$idDC);
        return self::hydrate($select);
    }

    public function insertAccessoire($data, $photo, $pdf, $quantite,$idDemande)
    {
        DB::table($this->table)->insert([
            'id_type_accessoire' => $data['id_type_accessoire'],
            'id_demande_client' =>$idDemande,
            'utilisation' => $data['utilisation'],
            'designation' => $data['designation'],
            'reference' => $data['reference'],
            'couleur' => $data['couleur'],
            'quantite' => $quantite,
            'id_unite_mesure_matiere' =>  $data['id_unite_mesure_matiere'],
            'prix_unitaire' => $data['prix_unitaire'],
            'frais' => $data['frais'],
            'id_unite_monetaire' => $data['id_unite_monetaire'],
            'id_famille_accessoire' => $data['id_famille_accessoire'],
            'nom_fiche_technique' => $data['nom_fiche_technique'] ?? 'fiche_technique_accessoire_'.$data['reference'],
            'id_classe' => $data['id_classe'],
            'fiche_technique' => $pdf ?? '',
            'photo' => $photo ?? '',
            'etat' => $data['etat'] ?? 0
        ]);
    }

    public static function isExisteAccessoire($typeAcc, $demandeClient)
    {
        $select = DB::table('accessoire')
            ->where('id_type_accessoire', $typeAcc)
            ->where('id_demande_client', $demandeClient)
            ->where('etat', 0)
            ->count(); // Compte directement les enregistrements

        return $select; // Retourne un entier
    }

    public function updateAccessoire($data, $photo, $pdf, $quantite,$idDemande)
    {
        DB::table($this->table)
        ->where('id', $data['id'])
        ->update([
            'id_type_accessoire' => $data['id_type_accessoire'],
            'id_demande_client' =>$idDemande,
            'utilisation' => $data['utilisation'],
            'designation' => $data['designation'],
            'reference' => $data['reference'],
            'couleur' => $data['couleur'],
            'quantite' => $quantite,
            'id_unite_mesure_matiere' =>  $data['id_unite_mesure_matiere'],
            'prix_unitaire' => $data['prix_unitaire'],
            'frais' => $data['frais'],
            'id_unite_monetaire' => $data['id_unite_monetaire'],
            'id_famille_accessoire' => $data['id_famille_accessoire'],
            'nom_fiche_technique' => $data['nom_fiche_technique'] ?? 'fiche_technique_accessoire_'.$data['reference'],
            'id_classe' => $data['id_classe'],
            'fiche_technique' => $pdf ?? '',
            'photo' => $photo ?? '',
            'etat' => $data['etat'] ?? 0
        ]);
    }

    public static function modifQteAccy($qte, $id){
        DB::select('update accessoire set quantite=? where id=?',[$qte, $id]);
    }

    public static function deleteAccessoire($id){
        DB::select('update accessoire set etat=1  where id=?',[$id]);
    }

}
