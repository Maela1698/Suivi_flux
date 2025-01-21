<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tissus extends Model
{
    use HasFactory;

    protected $table = 'tissus';
    protected $fillable = [
        'id_type_tissus',
        'id_demande_client',
        'id_categorie_tissus',
        'designation',
        'reference',
        'id_composition_tissus',
        'couleur',
        'quantite',
        'id_unite_mesure_matiere',
        'prix_unitaire',
        'frais',
        'id_unite_monetaire',
        'grammage',
        'laize_utile',
        'id_famille_tissus',
        'l_retrait_lavage',
        'w_retrait_lavage',
        'l_retrait_teinture',
        'w_retrait_teinture',
        'nom_fiche_technique',
        'id_classe',
        'fiche_technique',
        'photo',
        'etat'
    ];

    public static function getAllTissus()
    {
        $select = DB::select('select * from tissus where etat=0 order by id desc');
        return self::hydrate($select);
    }


    public static function getTissusById($id)
    {
        $select = DB::select('select * from tissus where etat=0 and id='.$id);
        return self::hydrate($select);
    }


    public function insertTissus($data, $photo, $pdf, $quantite,$demandeDC)
    {
        DB::table($this->table)->insert([
            'id_type_tissus' => $data['id_type_tissus'],
            'id_demande_client' => $demandeDC,
            'id_categorie_tissus' => $data['id_categorie_tissus'],
            'designation' => $data['designation'],
            'reference' => $data['reference'],
            'id_composition_tissus' => $data['id_composition_tissus'],
            'couleur' => $data['couleur'],
            'quantite' => $quantite,
            'id_unite_mesure_matiere' => $data['id_unite_mesure_matiere'],
            'prix_unitaire' => $data['prix_unitaire'],
            'frais' => $data['frais'],
            'id_unite_monetaire' => $data['id_unite_monetaire'],
            'grammage' => $data['grammage'],
            'laize_utile' => $data['laize_utile'],
            'id_famille_tissus' => $data['id_famille_tissus'],
            'l_retrait_lavage' => $data['l_retrait_lavage'],
            'w_retrait_lavage' => $data['w_retrait_lavage'],
            'l_retrait_teinture' => $data['l_retrait_teinture'],
            'w_retrait_teinture' => $data['w_retrait_teinture'],
            'nom_fiche_technique' => $data['nom_fiche_technique'] ?? 'fiche_technique_tissu_' . $data['reference'],
            'id_classe' => $data['id_classe'],
            'fiche_technique' => $pdf ?? '',
            'photo' => $photo ?? '',
            'etat' => $data['etat'] ?? 0
        ]);
    }

    public static function isExisteTissu($typeTissu, $demandeClient)
    {
        $select = DB::table('tissus')
            ->where('id_type_tissus', $typeTissu)
            ->where('id_demande_client', $demandeClient)
            ->where('etat', 0)
            ->count();

        return $select; // Retourne un entier
    }

    public static function lastInsertTissusByDC($idDemandeClient)
    {
        try {
            $result = DB::table('tissus')
                ->where('id_demande_client', $idDemandeClient)
                ->orderBy('id', 'desc')
                ->limit(1)
                ->value('id');

            return $result ?: 0; // Retourne 0 si aucun résultat n'est trouvé
        } catch (\Exception $e) {
            // Gérer l'exception ici (par exemple, en enregistrant l'erreur ou en la lançant de nouveau)
            throw $e;
        }
    }
     public static function modifQuantiteTissu($qte, $id){
        DB::select('update tissus set quantite=?  where id=?',[$qte,$id]);
    }

    public function updateTissus($data, $photo, $pdf, $quantite,$demandeDC)
    {
        DB::table($this->table)
        ->where('id', $data['id'])
        ->update([
            'id_type_tissus' => $data['id_type_tissus'],
            'id_demande_client' => $demandeDC,
            'id_categorie_tissus' => $data['id_categorie_tissus'],
            'designation' => $data['designation'],
            'reference' => $data['reference'],
            'id_composition_tissus' => $data['id_composition_tissus'],
            'couleur' => $data['couleur'],
            'quantite' => $quantite,
            'id_unite_mesure_matiere' => $data['id_unite_mesure_matiere'],
            'prix_unitaire' => $data['prix_unitaire'],
            'frais' => $data['frais'],
            'id_unite_monetaire' => $data['id_unite_monetaire'],
            'grammage' => $data['grammage'],
            'laize_utile' => $data['laize_utile'],
            'id_famille_tissus' => $data['id_famille_tissus'],
            'l_retrait_lavage' => $data['l_retrait_lavage'],
            'w_retrait_lavage' => $data['w_retrait_lavage'],
            'l_retrait_teinture' => $data['l_retrait_teinture'],
            'w_retrait_teinture' => $data['w_retrait_teinture'],
            'nom_fiche_technique' => $data['nom_fiche_technique'] ?? 'fiche_technique_tissu_' . $data['reference'],
            'id_classe' => $data['id_classe'],
            'fiche_technique' => $pdf ?? '',
            'photo' => $photo ?? '',
            'etat' => $data['etat'] ?? 0
        ]);
    }

    public static function deleteTissu($id){
        DB::select('update tissus set etat=1  where id=?',[$id]);
    }

}
