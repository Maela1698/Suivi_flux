CREATE OR REPLACE VIEW public.v_ppmeeting
AS SELECT vd.id,
    vd.id_tiers,
    vd.nom_modele,
    vd.nomtier,
    vd.id_etat,
    vd.etat,
    vd.qte_commande_provisoire,
    vd.types_valeur_ajout,
    d.tissus,
    d.accy,
    d.okprod,
    m.date AS dateppm,
    dp.datetrace,
    c.designation,
    dm.date_entree_chaine,
    dm.date_entree_coupe,
    dm.date_entree_finition,
    dm.heure_debut,
    sv.ex_factory,
    dm.effectif_prevu,
    dm.effectif_reel,
    dm.id_demande,
    dm.commentaire,
    dm.id_chaine,
    dm.etat AS etat_detailmeeting,
    dp.etat AS etat_trace,
    vd.photo_commande,
    dm.etat AS details_meeting_etat,
    dm.id AS id_details_ppmeeting
   FROM v_general_final_recap vd
     LEFT JOIN datedisponibiliteforppmeeting d ON vd.id = d.id_demande_client
     LEFT JOIN dateprevisionfortrace dp ON vd.id = dp.id_demande_client
     LEFT JOIN details_meeting dm ON vd.id = dm.id_demande
     LEFT JOIN meeting m ON dm.id_meeting = m.id
     LEFT JOIN chaine c ON dm.id_chaine = c.id_chaine
     LEFT JOIN ( SELECT DISTINCT ON (v_suivifluxmes.id_demande_client) v_suivifluxmes.id_demande_client,
            v_suivifluxmes.ex_factory
           FROM v_suivifluxmes) sv ON vd.id = sv.id_demande_client
     JOIN v_demandeclient vdm ON vd.id = vdm.id
  WHERE vd.etat = 0 AND vd.id_etat = 2;

  CREATE OR REPLACE VIEW public.v_nb_ppm_by_month
AS SELECT to_char(v_ppmeeting.dateppm::timestamp with time zone, 'YYYY-MM'::text) AS mois,
    count(*) AS nbppm,
    count(
        CASE
            WHEN v_ppmeeting.details_meeting_etat = true THEN 1
            ELSE NULL::integer
        END) AS nbfini,
        CASE
            WHEN count(*) > 0 THEN count(
            CASE
                WHEN v_ppmeeting.details_meeting_etat = true THEN 1
                ELSE NULL::integer
            END)::double precision / count(*)::double precision
            ELSE 0::double precision
        END AS taux_achevement
   FROM v_ppmeeting
  WHERE v_ppmeeting.dateppm IS NOT NULL
  GROUP BY (to_char(v_ppmeeting.dateppm::timestamp with time zone, 'YYYY-MM'::text));

  CREATE TABLE public.dateprevisionfortrace (
	id serial4 NOT NULL,
	id_demande_client int4 NULL,
	datetrace date NULL,
	etat int4 NULL DEFAULT 0,
	CONSTRAINT dateprevisionfortrace_pkey PRIMARY KEY (id)
);


-- public.dateprevisionfortrace foreign keys

ALTER TABLE public.dateprevisionfortrace ADD CONSTRAINT dateprevisionfortrace_id_demande_client_fkey FOREIGN KEY (id_demande_client) REFERENCES public.demandeclient(id);