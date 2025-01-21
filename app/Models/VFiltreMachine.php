<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VFiltreMachine extends Model
{
    use HasFactory;
    protected $table = 'v_filtre_machine';
    protected $fillable = [
        'id_machine',
        'dateEntreeMachine',
        'id_from_fournisseur',
        'codeMachine',
        'idMarqueMachine',
        'marque',
        'idCategorieMachine',
        'categorie',
        'id_fournisseur_machine',
        'nom_fournisseur',
        'adresse',
        'idPays',
        'nom_fr_fr',
        'ville',
        'codePostal',
        'numPhone',
        'emailFournisseur',
        'webSite',
        'idUnite',
        'NIF',
        'STAT',
        'assujettis',
        'reference',
        'capacite',
        'idUnitemesure',
        'proprietee',
        'idTailleMachine',
        'taille',
        'PrixU',
        'photo',
        'machine_etat',

        'dossier',
        'nomdossier',
        'dossier_etat',

        'dateFinContrat',
        'cout_prestation',
        'idUniteMonetaire',
        'emprunt_id',
        'etat_emprunt',

        'id_localisation',
        'localisation',
        'etat_localisation',
        'id_secteur',
        'secteur',
        'etat_secteur',
        'date_affectation_machine',
        'etat_secteur_machine',
        'com_jm'
    ];


    public static function findLocal($filters = [])
    {
        $machines_all = VFiltreMachine::query()
            ->where('proprietee', '100')
            ->whereNotIn('machine_etat', [300, 400]);

        // Filtrage par fournisseur
        if (!empty($filters['fournisseur'])) {
            $machines_all->whereRaw('lower(id_from_fournisseur) LIKE ?', ['%' . strtolower($filters['fournisseur']) . '%']);
        }

        // Filtrage par marque
        if (!empty($filters['marque'])) {
            $machines_all->whereRaw('lower(marque) LIKE ?', ['%' . strtolower($filters['marque']) . '%']);
        }

        // Filtrage par code ou code scanné
        if (!empty($filters['code']) || !empty($filters['scanned_code'])) {
            $codeFilter = !empty($filters['code']) ? $filters['code'] : $filters['scanned_code'];
            $machines_all->whereRaw('lower(codemachine) LIKE ?', ['%' . strtolower($codeFilter) . '%']);
        }

        // Filtrage par catégorie
        if (!empty($filters['categorie'])) {
            $machines_all->whereRaw('lower(categorie) LIKE ?', ['%' . strtolower($filters['categorie']) . '%']);
        }

        // Filtrage par date de début et de fin de service
        if (!empty($filters['start_fin_service']) && !empty($filters['end_fin_service'])) {
            $machines_all->whereBetween('dateentreemachine', [$filters['start_fin_service'], $filters['end_fin_service']]);
        }

        // Filtrage par date de début et de fin de contrat
        if (!empty($filters['start_fin_contrat']) && !empty($filters['end_fin_contrat'])) {
            $machines_all->whereBetween('datefincontrat', [$filters['start_fin_contrat'], $filters['end_fin_contrat']]);
        }

        return $machines_all->get(); // Récupérer les résultats
    }
    public static function findEmprunt($filters = [])
    {
        $machines_all = VFiltreMachine::query()
            ->where('proprietee', '200')
            ->whereNotIn('machine_etat', [300, 400]);

        // Filtrage par fournisseur
        if (!empty($filters['fournisseur'])) {
            $machines_all->whereRaw('lower(id_from_fournisseur) LIKE ?', ['%' . strtolower($filters['fournisseur']) . '%']);
        }

        // Filtrage par marque
        if (!empty($filters['marque'])) {
            $machines_all->whereRaw('lower(marque) LIKE ?', ['%' . strtolower($filters['marque']) . '%']);
        }

        // Filtrage par code ou code scanné
        if (!empty($filters['code']) || !empty($filters['scanned_code'])) {
            $codeFilter = !empty($filters['code']) ? $filters['code'] : $filters['scanned_code'];
            $machines_all->whereRaw('lower(codemachine) LIKE ?', ['%' . strtolower($codeFilter) . '%']);
        }

        // Filtrage par catégorie
        if (!empty($filters['categorie'])) {
            $machines_all->whereRaw('lower(categorie) LIKE ?', ['%' . strtolower($filters['categorie']) . '%']);
        }

        // Filtrage par date de début et de fin de service
        if (!empty($filters['start_fin_service']) && !empty($filters['end_fin_service'])) {
            $machines_all->whereBetween('dateentreemachine', [$filters['start_fin_service'], $filters['end_fin_service']]);
        }

        // Filtrage par date de début et de fin de contrat
        if (!empty($filters['start_fin_contrat']) && !empty($filters['end_fin_contrat'])) {
            $machines_all->whereBetween('datefincontrat', [$filters['start_fin_contrat'], $filters['end_fin_contrat']]);
        }

        return $machines_all->get();
    }
    public static function sumCoutEmprunt($filters = [])
    {
        $machines_all = VFiltreMachine::query()
            ->whereNotIn('machine_etat', [300, 400])
            ->where('etat_emprunt', 0);

        if (!empty($filters['fournisseur'])) {
            $machines_all->where('id_from_fournisseur', 'ILIKE', '%' . $filters['fournisseur'] . '%');
        }

        if (!empty($filters['marque'])) {
            $machines_all->where('marque', 'ILIKE', '%' . $filters['marque'] . '%');
        }

        if (!empty($filters['code'])) {
            $machines_all->where('codemachine', 'ILIKE', '%' . $filters['code'] . '%');
        }

        if (!empty($filters['scanned_code'])) {
            $machines_all->where('codemachine', 'ILIKE', '%' . $filters['scanned_code'] . '%');
        }

        if (!empty($filters['categorie'])) {
            $machines_all->where('categorie', 'ILIKE', '%' . $filters['categorie'] . '%');
        }

        if (!empty($filters['start_fin_service']) && !empty($filters['end_fin_service'])) {
            $machines_all->whereBetween('dateentreemachine', [$filters['start_fin_service'], $filters['end_fin_service']]);
        }

        if (!empty($filters['start_fin_contrat']) && !empty($filters['end_fin_contrat'])) {
            $machines_all->whereBetween('datefincontrat', [$filters['start_fin_contrat'], $filters['end_fin_contrat']]);
        }

        // Calculer la somme de cout_prestation avec les filtres appliqués
        return $machines_all->sum('cout_prestation');
    }


    // KPI SIMPLE
    public static function findnbrMachines($filters = [])
    {
        $machines_all = VFiltreMachine::query()
            ->whereNotIn('machine_etat', [300, 400]);

        if (!empty($filters['fournisseur'])) {
            $machines_all->where('id_from_fournisseur', 'ILIKE', '%' . $filters['fournisseur'] . '%');
        }

        if (!empty($filters['marque'])) {
            $machines_all->where('marque', 'ILIKE', '%' . $filters['marque'] . '%');
        }

        if (!empty($filters['code'])) {
            $machines_all->where('codemachine', 'ILIKE', '%' . $filters['code'] . '%');
        }

        if (!empty($filters['scanned_code'])) {
            $machines_all->where('codemachine', 'ILIKE', '%' . $filters['scanned_code'] . '%');
        }

        if (!empty($filters['categorie'])) {
            $machines_all->where('categorie', 'ILIKE', '%' . $filters['categorie'] . '%');
        }

        if (!empty($filters['start_fin_service']) && !empty($filters['end_fin_service'])) {
            $machines_all->whereBetween('dateentreemachine', [$filters['start_fin_service'], $filters['end_fin_service']]);
        }

        if (!empty($filters['start_fin_contrat']) && !empty($filters['end_fin_contrat'])) {
            $machines_all->whereBetween('datefincontrat', [$filters['start_fin_contrat'], $filters['end_fin_contrat']]);
        }

        // Utilisez count() pour obtenir le nombre de machines filtrées
        return $machines_all->count();
    }
    public static function findnbrMachineLocales($filters = [])
    {
        $machines_all = VFiltreMachine::query()
            ->where('proprietee', 100)
            ->whereNotIn('machine_etat', [300, 400]);

        if (!empty($filters['fournisseur'])) {
            $machines_all->where('id_from_fournisseur', 'ILIKE', '%' . $filters['fournisseur'] . '%');
        }

        if (!empty($filters['marque'])) {
            $machines_all->where('marque', 'ILIKE', '%' . $filters['marque'] . '%');
        }

        if (!empty($filters['code'])) {
            $machines_all->where('codemachine', 'ILIKE', '%' . $filters['code'] . '%');
        }

        if (!empty($filters['scanned_code'])) {
            $machines_all->where('codemachine', 'ILIKE', '%' . $filters['scanned_code'] . '%');
        }

        if (!empty($filters['categorie'])) {
            $machines_all->where('categorie', 'ILIKE', '%' . $filters['categorie'] . '%');
        }

        if (!empty($filters['start_fin_service']) && !empty($filters['end_fin_service'])) {
            $machines_all->whereBetween('dateentreemachine', [$filters['start_fin_service'], $filters['end_fin_service']]);
        }

        if (!empty($filters['start_fin_contrat']) && !empty($filters['end_fin_contrat'])) {
            $machines_all->whereBetween('datefincontrat', [$filters['start_fin_contrat'], $filters['end_fin_contrat']]);
        }

        // Retourner le nombre total de machines correspondant aux filtres
        return $machines_all->count();
    }
    public static function findnbrMachineEmprunt($filters = [])
    {
        $machines_all = VFiltreMachine::query()
            ->where('proprietee', 200)
            ->whereNotIn('machine_etat', [300, 400]);

        if (!empty($filters['fournisseur'])) {
            $machines_all->where('id_from_fournisseur', 'ILIKE', '%' . $filters['fournisseur'] . '%');
        }

        if (!empty($filters['marque'])) {
            $machines_all->where('marque', 'ILIKE', '%' . $filters['marque'] . '%');
        }

        if (!empty($filters['code'])) {
            $machines_all->where('codemachine', 'ILIKE', '%' . $filters['code'] . '%');
        }

        if (!empty($filters['scanned_code'])) {
            $machines_all->where('codemachine', 'ILIKE', '%' . $filters['scanned_code'] . '%');
        }

        if (!empty($filters['categorie'])) {
            $machines_all->where('categorie', 'ILIKE', '%' . $filters['categorie'] . '%');
        }

        if (!empty($filters['start_fin_service']) && !empty($filters['end_fin_service'])) {
            $machines_all->whereBetween('dateentreemachine', [$filters['start_fin_service'], $filters['end_fin_service']]);
        }

        if (!empty($filters['start_fin_contrat']) && !empty($filters['end_fin_contrat'])) {
            $machines_all->whereBetween('datefincontrat', [$filters['start_fin_contrat'], $filters['end_fin_contrat']]);
        }

        // Retourner le nombre total de machines correspondant aux filtres
        return $machines_all->count();
    }
    // KPI SIMPLE

    // DAO
    public static function findMachineById($id_machine)
    {
        $select = DB::select('select * from v_filtre_machine where id_machine=?', [$id_machine]);
        return self::hydrate($select);
    }

    public static function insertElement($id_machine, $nom_element)
    {
        return DB::insert('insert into elementmachine (idmachine, element) values (?, ?)', [$id_machine, $nom_element]);
    }

    public static function findElementByIdMachine($id_machine)
    {
        $select = DB::select('select * from elementmachine where idmachine =?', [$id_machine]);
        return self::hydrate($select);
    }

    // END DAO
}
