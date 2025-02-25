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