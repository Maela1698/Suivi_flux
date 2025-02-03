CREATE OR REPLACE VIEW public.v_dest_recap
AS SELECT rc.id AS recap_id,
    rc.iddemandeclient,
    rc.etdrevise,
    rc.etdpropose,
    rc.receptionbc,
    rc.bcclient,
    rc.date_bc_tissu,
    rc.date_bc_access,
    rc.etat AS recap_etat,
    d.id AS destination_id,
    d.numerocommande,
    d.etdinitial,
    d.datelivraisonexacte,
    d.dateinspection,
    d.qteof,
    d.etat AS destination_etat,
    ds.id AS deststd_id,
    ds.designation AS deststd_designation,
    ut.unite_taille,
    ut.id AS unitetailleid,
    vd.nomtier,
    vd.id_tiers,
    vd.nom_modele,
    vd.nom_style,
    vd.id_style,
    d.id as id_destination,
    d.isTracked,
    COALESCE(vgfr.receptionbc, vgfr.date_entree) AS date_livraison_confirme
   FROM recapcommande rc
     LEFT JOIN destination d ON rc.id = d.idrecapcommande
     LEFT JOIN deststd ds ON d.iddeststd = ds.id
     LEFT JOIN unitetaille ut ON d.idtaille = ut.id
     LEFT JOIN v_demandeclient vd ON rc.iddemandeclient = vd.id
     LEFT JOIN v_general_final_recap vgfr ON vgfr.id = rc.iddemandeclient;

CREATE OR REPLACE VIEW v_demandeclient_confirmees
AS SELECT demandeclient.id,
    demandeclient.date_entree,
    demandeclient.date_livraison,
    demandeclient.nom_modele,
    demandeclient.theme,
    demandeclient.qte_commande_provisoire,
    demandeclient.taille_base,
    demandeclient.requete_client,
    demandeclient.commentaire_merch,
    demandeclient.photo_commande,
    demandeclient.etat,
    demandeclient.id_unite_taille_min,
    demandeclient.id_unite_taille_max,
    tiers.nomtier,
    tiers.id AS id_tiers,
    style.nom_style,
    style.id AS id_style,
    incontern.type_incontern,
    incontern.id AS id_incontern,
    phase.type_phase,
    phase.id AS id_phase,
    saison.type_saison,
    saison.id AS id_saison,
    ut_min.unite_taille AS taillemin,
    ut_max.unite_taille AS taillemax,
    stadedemandeclient.type_stade,
    stadedemandeclient.id AS id_stade,
    etatdemandeclient.type_etat,
    periode.periode,
    periode.id AS id_periode,
    etatdemandeclient.id AS id_etat,
    ( SELECT count(*) AS count
           FROM generate_series(demandeclient.date_entree::timestamp with time zone, demandeclient.date_livraison::timestamp with time zone, '1 day'::interval) jours(date_jour)
          WHERE date_part('isodow'::text, jours.date_jour) <> 7::double precision AND NOT (EXISTS ( SELECT 1
                   FROM jours_feries
                  WHERE jours_feries.jour = date_part('day'::text, jours.date_jour)::smallint AND jours_feries.mois = date_part('month'::text, jours.date_jour)::smallint AND (jours_feries.annee IS NULL OR jours_feries.annee = date_part('year'::text, jours.date_jour)::integer)))) AS leadtimereel,
    EXISTS (
        SELECT 1
        FROM v_liste_of
        WHERE v_liste_of.iddemandeclient = demandeclient.id
        AND v_liste_of.qteof IS NOT NULL
    ) AS hasOF
   FROM demandeclient
     JOIN tiers ON tiers.id = demandeclient.id_client
     JOIN periode ON periode.id = demandeclient.id_periode
     JOIN style ON style.id = demandeclient.id_style
     JOIN incontern ON incontern.id = demandeclient.id_incontern
     JOIN phase ON phase.id = demandeclient.id_phase
     JOIN saison ON saison.id = demandeclient.id_saison
     JOIN unitetaille ut_min ON ut_min.id = demandeclient.id_unite_taille_min
     JOIN unitetaille ut_max ON ut_max.id = demandeclient.id_unite_taille_max
     JOIN stadedemandeclient ON stadedemandeclient.id = demandeclient.id_stade
     JOIN etatdemandeclient ON etatdemandeclient.id = demandeclient.id_etat
    WHERE id_etat = 2 AND demandeclient.etat = 0;



