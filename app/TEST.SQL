-- compter le nombre de jours par mois
SELECT mois, COUNT(*) AS nombre_jours_feries
FROM jours_feries
GROUP BY mois
ORDER BY mois;


-- prendre le max de ces quatres dates, avec la condition suivante
-- si date_prod_reel existe alors prendre date_prod_reel pour voir le max avec date_bc_tissu et date_bc_access
-- sinon prendre date_prod_initial pour voir le max avec date_bc_tissu et date_bc_access
SELECT
    date_bc_tissu,
    date_bc_access,
    date_prod_initial,
    date_prod_reel,

SELECT
    GREATEST(
        COALESCE(date_prod_reel, date_prod_initial),
        date_bc_tissu,
        date_bc_access
    ) AS date_max
FROM
    v_recap_master_plan;

-- select maxdate
SELECT
demande_client_id,
id_recap_commande,
date_bc_tissu,
    date_bc_access,
    date_prod_initial,
    date_prod_reel,
    GREATEST(
        COALESCE(date_prod_reel, date_prod_initial),
        date_bc_tissu,
        date_bc_access
    ) AS date_max
FROM
    v_recap_master_plan
where
    demande_client_id=1
and
    id_recap_commande=1;
