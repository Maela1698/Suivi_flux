CREATE OR REPLACE VIEW public.v_retard_trace
AS SELECT trt.id,
    d.id as id_trace,
    d.datetrace
   FROM tauxretartrace trt
     JOIN dateprevisionfortrace d ON d.id = trt.id_trace;

CREATE OR REPLACE VIEW public.v_stat_trace AS
SELECT
    to_char(v_ppmeeting.datetrace::timestamp with time zone, 'YYYY-MM'::text) AS mois,
    count(*) AS nbtrace,
    count(
        CASE
            WHEN v_ppmeeting.etat_trace = 1 THEN 1
            ELSE NULL::integer
        END
    ) AS nbfini,
    CASE
        WHEN count(*) > 0 THEN
            count(
                CASE
                    WHEN v_ppmeeting.etat_trace = 1 THEN 1
                    ELSE NULL::integer
                END
            )::double precision / count(*)::double precision
        ELSE 0::double precision
    END AS taux_achevement,
    COALESCE(retard.nb_retard, 0) AS nb_retard,
    CASE
        WHEN count(*) > 0 THEN
            COALESCE(retard.nb_retard, 0)::double precision / count(*)::double precision
        ELSE 0::double precision
    END AS taux_retard
FROM
    v_ppmeeting
    LEFT JOIN (
        SELECT
            to_char(datetrace::timestamp with time zone, 'YYYY-MM'::text) AS mois,
            count(*) AS nb_retard
        FROM
            v_retard_trace
        GROUP BY
            to_char(datetrace::timestamp with time zone, 'YYYY-MM'::text)
    ) retard ON to_char(v_ppmeeting.datetrace::timestamp with time zone, 'YYYY-MM'::text) = retard.mois
WHERE
    v_ppmeeting.datetrace IS NOT NULL
GROUP BY
    to_char(v_ppmeeting.datetrace::timestamp with time zone, 'YYYY-MM'::text),
    retard.nb_retard;

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
    dm.id_meeting,
    dp.id AS trace_id,
        CASE
            WHEN tr.id IS NOT NULL THEN true
            ELSE false
        END AS isretard,
        CASE
            WHEN t.id IS NOT NULL THEN true
            ELSE false
        END AS isretardtrace
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
  WHERE vd.etat = 0 AND vd.id_etat = 2;

--
CREATE OR REPLACE FUNCTION public.f_stat_week_ppm(date_debut DATE, date_fin DATE)
RETURNS TABLE(
    date_debut_return DATE,
    date_fin_return DATE,
    nbppm BIGINT,
    nb_fini BIGINT,
    taux_fini DECIMAL,
    nb_retard BIGINT,
    taux_retard DECIMAL
)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT
        date_debut AS date_debut_return,
        date_fin AS date_fin_return,
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
        END AS taux_retard
    FROM
        v_ppmeeting vp
    WHERE
        vp.dateppm BETWEEN date_debut AND date_fin;
END; $$;


CREATE OR REPLACE FUNCTION public.f_stat_week_trace(date_debut DATE, date_fin DATE)
RETURNS TABLE(
    date_debut_return DATE,
    date_fin_return DATE,
    nb_trace BIGINT,
    nb_fini BIGINT,
    taux_fini DECIMAL,
    nb_retard BIGINT,
    taux_retard DECIMAL
)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT
        date_debut,
        date_fin,
        COUNT(*) AS nb_trace,
        SUM(CASE WHEN vp.etat_trace = 1 THEN 1 ELSE 0 END) AS nb_fini,
        CASE
            WHEN COUNT(*) > 0 THEN
                (SUM(CASE WHEN vp.etat_trace = 1 THEN 1 ELSE 0 END)::DECIMAL / COUNT(*))
            ELSE 0
        END AS taux_fini,
        SUM(CASE WHEN vp.isretardtrace THEN 1 ELSE 0 END) AS nb_retard,
        CASE
            WHEN COUNT(*) > 0 THEN
                (SUM(CASE WHEN vp.isretardtrace THEN 1 ELSE 0 END)::DECIMAL / COUNT(*))
            ELSE 0
        END AS taux_retard
    FROM
        v_ppmeeting vp
    where vp.datetrace BETWEEN date_debut AND date_fin;
END; $$;


ALTER TABLE details_meeting
ALTER COLUMN effectif_reel SET DEFAULT 0;

UPDATE details_meeting SET effectif_reel = 0 WHERE effectif_reel=NULL;