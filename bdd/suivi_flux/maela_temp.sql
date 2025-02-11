--vue pour extraire les nombres de ppm par mois
CREATE VIEW v_nb_ppm_by_month AS
SELECT 
    TO_CHAR(dateppm, 'YYYY-MM') AS mois,
    COUNT(*) AS nbppm
FROM v_ppmeeting
WHERE dateppm IS NOT NULL
GROUP BY TO_CHAR(dateppm, 'YYYY-MM');
