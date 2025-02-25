CREATE OR REPLACE FUNCTION f_stat_liste_ppm(ids INT[])
RETURNS TABLE(
    nb_ppm BIGINT, 
    nb_fini BIGINT, 
    taux_fini DECIMAL, 
    nb_retard BIGINT, 
    taux_retard DECIMAL, 
    eff_prev BIGINT, 
    eff_reel BIGINT,
    abs BIGINT,
    taux_abs DECIMAL
)
LANGUAGE plpgsql
AS $function$
BEGIN
    RETURN QUERY
    SELECT
        COUNT(*) AS nb_ppm,
        SUM(CASE WHEN vp.details_meeting_etat THEN 1 ELSE 0 END) AS nb_fini,
        CASE
            WHEN COUNT(*) > 0 THEN 
                SUM(CASE WHEN vp.details_meeting_etat THEN 1 ELSE 0 END) / COUNT(*)::DECIMAL
            ELSE 0::DECIMAL 
        END AS taux_fini,
        SUM(CASE WHEN vp.isretard THEN 1 ELSE 0 END) AS nb_retard,
        CASE
            WHEN COUNT(*) > 0 THEN 
                SUM(CASE WHEN vp.isretard THEN 1 ELSE 0 END) / COUNT(*)::DECIMAL
            ELSE 0::DECIMAL 
        END AS  taux_retard,
        SUM(CASE WHEN vp.details_meeting_etat = true THEN vp.effectif_prevu ELSE 0 END) AS eff_prev,
        SUM(CASE WHEN vp.details_meeting_etat = true THEN vp.effectif_reel ELSE 0 END) AS eff_reel,
        SUM(CASE WHEN vp.details_meeting_etat = true THEN vp.total_abs ELSE 0 END) AS abs,
        CASE 
            WHEN SUM(CASE WHEN vp.details_meeting_etat = true THEN vp.effectif_prevu ELSE 0 END) > 0 THEN
                SUM(CASE WHEN vp.details_meeting_etat = true THEN vp.total_abs ELSE 0 END) / SUM(CASE WHEN vp.details_meeting_etat = true THEN vp.effectif_prevu ELSE 0 END)::DECIMAL
            ELSE 0::DECIMAL
        END AS taux_abs 
    FROM v_ppmeeting vp
    WHERE vp.id = ANY(ids)
      AND vp.dateppm IS NOT NULL;
END;
$function$;

CREATE OR REPLACE FUNCTION f_stat_liste_trace(ids INT[])
RETURNS TABLE(
    nb_trace BIGINT, 
    nb_fini BIGINT, 
    taux_fini DECIMAL, 
    nb_retard BIGINT, 
    taux_retard DECIMAL
)
LANGUAGE plpgsql
AS $function$
BEGIN
    RETURN QUERY
    SELECT
        COUNT(*) AS nb_trace,
        SUM(CASE WHEN vp.etat_trace = 1 THEN 1 ELSE 0 END) AS nb_fini,
        CASE
            WHEN COUNT(*) > 0 THEN 
                SUM(CASE WHEN vp.etat_trace = 1 THEN 1 ELSE 0 END) / COUNT(*)::DECIMAL
            ELSE 0::DECIMAL 
        END AS taux_fini,
        SUM(CASE WHEN vp.isretardtrace THEN 1 ELSE 0 END) AS nb_retard,
        CASE
            WHEN COUNT(*) > 0 THEN 
                SUM(CASE WHEN vp.isretardtrace THEN 1 ELSE 0 END) / COUNT(*)::DECIMAL
            ELSE 0::DECIMAL 
        END AS  taux_retard
    FROM v_ppmeeting vp
    WHERE vp.id = ANY(ids)
      AND vp.datetrace IS NOT NULL;
END;
$function$;

CREATE OR REPLACE VIEW public.v_ppmeeting AS
SELECT vd.id,
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
    dm.id AS id_details_ppmeeting,
    dm.id_meeting,
    dp.id AS trace_id,
        CASE
            WHEN tr.id IS NOT NULL THEN true
            ELSE false
        END AS isretard,
        CASE
            WHEN t.id IS NOT NULL THEN true
            ELSE false
        END AS isretardtrace,
        CASE
            WHEN (dm.effectif_prevu - dm.effectif_reel) > 0 THEN dm.effectif_prevu - dm.effectif_reel
            ELSE 0
        END AS total_abs,
   		coalesce (dm.is_deleted,false) as is_deleted
   FROM v_general_final_recap vd
     LEFT JOIN datedisponibiliteforppmeeting d ON vd.id = d.id_demande_client
     LEFT JOIN dateprevisionfortrace dp ON vd.id = dp.id_demande_client
     LEFT JOIN details_meeting dm ON vd.id = dm.id_demande
     LEFT JOIN meeting m ON dm.id_meeting = m.id
     LEFT JOIN chaine c ON dm.id_chaine = c.id_chaine
     LEFT JOIN ( SELECT DISTINCT ON (v_suivifluxmes.id_demande_client) v_suivifluxmes.id_demande_client,
            v_suivifluxmes.ex_factory
           FROM v_suivifluxmes) sv ON vd.id = sv.id_demande_client
     LEFT JOIN tauxretarppmeeting tr ON dm.id = tr.id_detail_meeting
     LEFT JOIN tauxretartrace t ON dp.id = t.id_trace
     JOIN v_demandeclient vdm ON vd.id = vdm.id
  WHERE vd.etat = 0 AND vd.id_etat = 2 ;


  -- public.v_stat_ppmeeting source

CREATE OR REPLACE VIEW public.v_stat_ppmeeting
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
        END AS taux_achevement,
    COALESCE(retard.nb_retard, 0::bigint) AS nb_retard,
        CASE
            WHEN count(*) > 0 THEN COALESCE(retard.nb_retard, 0::bigint)::double precision / count(*)::double precision
            ELSE 0::double precision
        END AS taux_retard,
    sum(
        CASE
            WHEN v_ppmeeting.details_meeting_etat = true THEN v_ppmeeting.effectif_prevu
            ELSE 0
        END) AS total_eff_prev,
    sum(
        CASE
            WHEN v_ppmeeting.details_meeting_etat = true THEN v_ppmeeting.effectif_reel
            ELSE 0
        END) AS total_eff_reel,
    sum(
        CASE
            WHEN v_ppmeeting.details_meeting_etat = true THEN v_ppmeeting.total_abs
            ELSE 0
        END) AS total_abs,
        CASE
            WHEN sum(
            CASE
                WHEN v_ppmeeting.details_meeting_etat = true THEN v_ppmeeting.effectif_prevu
                ELSE 0
            END) > 0 THEN sum(
            CASE
                WHEN v_ppmeeting.details_meeting_etat = true THEN v_ppmeeting.total_abs
                ELSE 0
            END)::double precision / sum(
            CASE
                WHEN v_ppmeeting.details_meeting_etat = true THEN v_ppmeeting.effectif_prevu
                ELSE 0
            END)::double precision
            ELSE 0::double precision
        END AS taux_abs
   FROM v_ppmeeting
     LEFT JOIN ( SELECT to_char(v_retard_ppmeeting.dateppm::timestamp with time zone, 'YYYY-MM'::text) AS mois,
            count(*) AS nb_retard
           FROM v_retard_ppmeeting
          GROUP BY (to_char(v_retard_ppmeeting.dateppm::timestamp with time zone, 'YYYY-MM'::text))) retard ON to_char(v_ppmeeting.dateppm::timestamp with time zone, 'YYYY-MM'::text) = retard.mois
  WHERE v_ppmeeting.dateppm IS NOT null AND v_ppmeeting.is_deleted = false
  GROUP BY (to_char(v_ppmeeting.dateppm::timestamp with time zone, 'YYYY-MM'::text)), retard.nb_retard;