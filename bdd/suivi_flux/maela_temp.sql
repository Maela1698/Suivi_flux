CREATE OR REPLACE VIEW v_stat_trace AS 
SELECT to_char(v_ppmeeting.datetrace::timestamp with time zone, 'YYYY-MM'::text) AS mois,
    count(*) AS nbtrace,
    count(
        CASE
            WHEN v_ppmeeting.etat_trace  = 1 THEN 1
            ELSE NULL::integer
        END) AS nbfini,
        CASE
            WHEN count(*) > 0 THEN count(
            CASE
                WHEN v_ppmeeting.etat_trace  = 1 THEN 1
                ELSE NULL::integer
            END)::double precision / count(*)::double precision
            ELSE 0::double precision
        END AS taux_achevement
   FROM v_ppmeeting
  WHERE v_ppmeeting.datetrace IS NOT NULL
  GROUP BY (to_char(v_ppmeeting.datetrace::timestamp with time zone, 'YYYY-MM'::text));

CREATE OR REPLACE VIEW v_retard_ppmeeting AS
SELECT 
    trp.id,
    dm.id AS id_detail_meeting,
    m.date AS dateppm
FROM tauxretarppmeeting trp 
    JOIN details_meeting dm 
        ON dm.id = trp.id_detail_meeting
    JOIN meeting m 
        ON m.id = dm.id_meeting;

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
    COALESCE(retard.nb_retard, 0) AS nb_retard,
    CASE
        WHEN count(*) > 0 THEN COALESCE(retard.nb_retard, 0)::double precision / count(*)::double precision
        ELSE 0::double precision
    END AS taux_retard
FROM
    v_ppmeeting
    LEFT JOIN (
        SELECT
            to_char(dateppm::timestamp with time zone, 'YYYY-MM'::text) AS mois,
            count(*) AS nb_retard
        FROM
            v_retard_ppmeeting
        GROUP BY
            to_char(dateppm::timestamp with time zone, 'YYYY-MM'::text)
    ) retard ON to_char(v_ppmeeting.dateppm::timestamp with time zone, 'YYYY-MM'::text) = retard.mois
WHERE
    v_ppmeeting.dateppm IS NOT NULL
GROUP BY
    to_char(v_ppmeeting.dateppm::timestamp with time zone, 'YYYY-MM'::text),
    retard.nb_retard;

drop view v_nb_ppm_by_month;