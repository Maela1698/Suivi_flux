alter table reclamation add column unite  varchar(250);
alter table reclamation add column rapport  text;
alter table reclamation add column valeurreclame  double precision;
alter table reclamation add column valeurcompense  double precision;
alter table reclamation add column reste  double precision;


/*------------------------------------------------------view reclamation----------------------------------------------------------*/
------last and sum reclamation
create or replace view v_detail_reclamation as (
    SELECT
        donne.donne_bc_id,
        donne.donne_bc_id_detail,
        donne.donne_bc_designation,
        donne.donne_bc_laize,
        donne.donne_bc_utilisation,
        donne.donne_bc_couleur,
        donne.donne_bc_quantite,
        donne.donne_bc_unite,
        donne.donne_bc_prix_unitaire,
        donne.donne_bc_devise,
        donne.tissus_id,
        donne.tissus_designation,
        donne.tissus_couleur,
        donne.tissus_quantite,
        donne.tissus_prix_unitaire,
        donne.tissus_laize_utile,
        donne.accessoire_id,
        donne.accessoire_designation,
        donne.accessoire_couleur,
        donne.accessoire_quantite,
        donne.accessoire_prix_unitaire,
        detail_vbc.tiers_id,
        detail_vbc.nomtier,
        detail_vbc.pays,
        detail_vbc.ville,
        detail_vbc.numero_bc,
        detail_vbc.date_bc,
        detail_vbc.echeance,
        detail_vbc.etat_bc,
        detail_vbc.detail_id,
        detail_vbc.id_bc,
        detail_vbc.id_demande_client,
        detail_vbc.etat_detail,
        detail_vbc.dateconfirmation,
        reclamations.dateenvoie,
        reclamations.daterelance,
        reclamations.raison,
        reclamations.quantite AS reclamation_quantite,
        reclamations.remarque,
        reclamations.retour,
        reclamations.recompensation,
        reclamations.note,
        reclamations.unite AS reclamation_unite,
        reclamations.total_quantite,
        reclamations.total_recompensation,
        reclamations.total_valeurreclame,
        reclamations.total_valeurcompense,
        reclamations.total_reste,
        demandeClient.date_entree,
        demandeClient.date_livraison,
        demandeClient.nom_modele,
        demandeClient.theme,
        demandeClient.qte_commande_provisoire,
        demandeClient.taille_base,
        demandeClient.requete_client,
        demandeClient.commentaire_merch,
        demandeClient.etat,
        demandeClient.id_unite_taille_min,
        demandeClient.id_unite_taille_max,
        tiers.nomtier AS client_nomtier,
        tissus_ref,
        accessoire_ref,
        style.nom_style,
        incontern.type_incontern,
        phase.type_phase,
        saison.type_saison,
        ut_min.unite_taille AS tailleMin,
        ut_max.unite_taille AS tailleMax,
        stadedemandeclient.type_stade,
        etatdemandeclient.type_etat,
        periode.periode
    FROM
        (
            SELECT
                donneBc.id AS donne_bc_id,
                donneBc.id_detail AS donne_bc_id_detail,
                donneBc.designation AS donne_bc_designation,
                donneBc.laize AS donne_bc_laize,
                donneBc.utilisation AS donne_bc_utilisation,
                donneBc.couleur AS donne_bc_couleur,
                donneBc.quantite AS donne_bc_quantite,
                donneBc.unite AS donne_bc_unite,
                donneBc.prix_unitaire AS donne_bc_prix_unitaire,
                donneBc.devise AS donne_bc_devise,
                tissus.id AS tissus_id,
                tissus.designation AS tissus_designation,
                tissus.reference AS tissus_ref,
                tissus.couleur AS tissus_couleur,
                tissus.quantite AS tissus_quantite,
                tissus.prix_unitaire AS tissus_prix_unitaire,
                tissus.laize_utile AS tissus_laize_utile,
                accessoire.id AS accessoire_id,
                accessoire.designation AS accessoire_designation,
                accessoire.reference AS accessoire_ref,
                accessoire.couleur AS accessoire_couleur,
                accessoire.quantite AS accessoire_quantite,
                accessoire.prix_unitaire AS accessoire_prix_unitaire
            FROM
                donneBc
            LEFT JOIN
                tissus ON donneBc.id_tissus = tissus.id
            LEFT JOIN
                accessoire ON donneBc.id_accessoire = accessoire.id
        ) AS donne
    JOIN
        (
            SELECT
                v_bc.tiers_id,
                v_bc.nomtier,
                v_bc.pays,
                v_bc.ville,
                v_bc.numero_bc,
                v_bc.date_bc,
                v_bc.echeance,
                v_bc.etat_bc,
                detailBc.id AS detail_id,
                detailBc.id_bc,
                detailBc.id_demande_client,
                detailBc.etat AS etat_detail,
                detailBc.dateconfirmation
            FROM
                v_bc
            JOIN
                detailBc ON v_bc.bc_id = detailBc.id_bc
        ) AS detail_vbc
    ON
        donne.donne_bc_id_detail = detail_vbc.detail_id
    JOIN
        (
            SELECT
                r.id,
                r.id_donne_bc,
                r.dateenvoie,
                r.daterelance,
                r.raison,
                r.quantite,
                r.remarque,
                r.retour,
                r.recompensation,
                r.note,
                r.unite,
                totals.total_quantite,
                totals.total_recompensation,
                totals.total_valeurreclame,
                totals.total_valeurcompense,
                totals.total_reste
            FROM
                reclamation r
            JOIN (
                SELECT
                    id_donne_bc,
                    SUM(quantite) AS total_quantite,
                    SUM(CAST(recompensation AS DOUBLE PRECISION)) AS total_recompensation,
                    SUM(valeurreclame) AS total_valeurreclame,
                    SUM(valeurcompense) AS total_valeurcompense,
                    SUM(reste) AS total_reste,
                    MAX(id) AS latest_id
                FROM
                    reclamation
                GROUP BY
                    id_donne_bc
            ) totals ON r.id_donne_bc = totals.id_donne_bc AND r.id = totals.latest_id
        ) AS reclamations
    ON
        donne.donne_bc_id = reclamations.id_donne_bc
    JOIN
        v_demandeClient AS demandeClient
    ON
        detail_vbc.id_demande_client = demandeClient.id
    JOIN
        tiers ON tiers.id = demandeClient.id_tiers
    JOIN
        style ON style.id = demandeClient.id_style
    JOIN
        incontern ON incontern.id = demandeClient.id_incontern
    JOIN
        phase ON phase.id = demandeClient.id_phase
    JOIN
        saison ON saison.id = demandeClient.id_saison
    JOIN
        unitetaille ut_min ON ut_min.id = demandeClient.id_unite_taille_min
    JOIN
        unitetaille ut_max ON ut_max.id = demandeClient.id_unite_taille_max
    JOIN
        stadedemandeclient ON stadedemandeclient.id = demandeClient.id_stade
    JOIN
        etatdemandeclient ON etatdemandeclient.id = demandeClient.id_etat
    JOIN
        periode ON periode.id = demandeClient.id_periode
    ORDER BY
        donne.donne_bc_id
);

