ALTER TABLE public.details_meeting ADD is_deleted bool DEFAULT false NOT NULL;

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
    dm.id AS id_details_ppmeeting,
    dp.id AS trace_id,
     dm.id_meeting,
    CASE
        WHEN tr.id IS NOT NULL THEN true
        ELSE false
    END AS isretard,
    CASE
        WHEN t.id IS NOT NULL THEN true
        ELSE false
    END AS isretardtrace,
    CASE 
        WHEN dm.effectif_prevu - dm.effectif_reel > 0 THEN
            dm.effectif_prevu - dm.effectif_reel
        ELSE 0
    END AS total_abs,
    dm.is_deleted
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
  WHERE vd.etat = 0 AND vd.id_etat = 2 AND dm.is_deleted = false;

CREATE OR REPLACE VIEW public.v_stat_ppmeeting AS
    SELECT 
        to_char(v_ppmeeting.dateppm::timestamp with time zone, 'YYYY-MM'::text) AS mois,
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
        SUM(CASE WHEN v_ppmeeting.details_meeting_etat = true THEN v_ppmeeting.effectif_prevu ELSE 0 END) AS total_eff_prev,
        SUM(CASE WHEN v_ppmeeting.details_meeting_etat = true THEN v_ppmeeting.effectif_reel ELSE 0 END) AS total_eff_reel,
        SUM(CASE WHEN v_ppmeeting.details_meeting_etat = true THEN v_ppmeeting.total_abs ELSE 0 END) AS total_abs,
        CASE 
            WHEN SUM(CASE WHEN v_ppmeeting.details_meeting_etat = true THEN v_ppmeeting.effectif_prevu ELSE 0 END) > 0 THEN
                SUM(CASE WHEN v_ppmeeting.details_meeting_etat = true THEN v_ppmeeting.total_abs ELSE 0 END) / SUM(CASE WHEN v_ppmeeting.details_meeting_etat = true THEN v_ppmeeting.effectif_prevu ELSE 0 END)::double precision 
            ELSE 0::double precision
        END AS taux_abs
    FROM v_ppmeeting
        LEFT JOIN ( SELECT to_char(v_retard_ppmeeting.dateppm::timestamp with time zone, 'YYYY-MM'::text) AS mois,
                count(*) AS nb_retard
            FROM v_retard_ppmeeting
            GROUP BY (to_char(v_retard_ppmeeting.dateppm::timestamp with time zone, 'YYYY-MM'::text))) retard ON to_char(v_ppmeeting.dateppm::timestamp with time zone, 'YYYY-MM'::text) = retard.mois
    WHERE v_ppmeeting.dateppm IS NOT NULL
    GROUP BY (to_char(v_ppmeeting.dateppm::timestamp with time zone, 'YYYY-MM'::text)), retard.nb_retard;

DROP FUNCTION f_stat_week_ppm(date,date);

CREATE OR REPLACE FUNCTION public.f_stat_week_ppm(date_debut date, date_fin date)
 RETURNS TABLE(
    date_debut_return date, 
    date_fin_return date, 
    nbppm bigint, 
    nb_fini bigint, 
    taux_fini numeric, 
    nb_retard bigint, 
    taux_retard numeric, 
    total_eff_prev bigint,
    total_eff_reel bigint,
    total_abs bigint,
    taux_abs numeric
)
 LANGUAGE plpgsql
AS $function$
BEGIN
    RETURN QUERY
    SELECT
        date_debut,
        date_fin,
        COUNT(*) AS nbppm,
        SUM(CASE WHEN vp.details_meeting_etat THEN 1 ELSE 0 END) AS nb_fini,
        CASE
            WHEN COUNT(*) > 0 THEN
                (SUM(CASE WHEN vp.details_meeting_etat THEN 1 ELSE 0 END)::DECIMAL / COUNT(*))
            ELSE 0
        END AS taux_fini,
        SUM(CASE WHEN vp.isretard THEN 1 ELSE 0 END) AS nb_retard,
        CASE
            WHEN COUNT(*) > 0 THEN
                (SUM(CASE WHEN vp.isretard THEN 1 ELSE 0 END)::DECIMAL / COUNT(*))
            ELSE 0
        END AS taux_retard,
        SUM(CASE WHEN vp.details_meeting_etat = true THEN vp.effectif_prevu ELSE 0 END) AS total_eff_prev,
        SUM(CASE WHEN vp.details_meeting_etat = true THEN vp.effectif_reel ELSE 0 END) AS total_eff_reel,
        SUM(CASE WHEN vp.details_meeting_etat = true THEN vp.total_abs ELSE 0 END) AS total_abs,
        CASE 
            WHEN SUM(CASE WHEN vp.details_meeting_etat = true THEN vp.effectif_prevu ELSE 0 END) > 0 THEN
                SUM(CASE WHEN vp.details_meeting_etat = true THEN vp.total_abs ELSE 0 END) / SUM(CASE WHEN vp.details_meeting_etat = true THEN vp.effectif_prevu ELSE 0 END)::DECIMAL
            ELSE 0::DECIMAL
        END AS taux_abs
    FROM
        v_ppmeeting vp
    WHERE
        vp.dateppm BETWEEN date_debut AND date_fin;
END; 
$function$
;