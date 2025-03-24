
CREATE OR REPLACE VIEW public.vue_constats
AS SELECT c.id AS constat_id,
    c.dateconstat,
    s.designation AS section,
    c.priorite,
    c.description,
    t.valeur AS typeaudit,
    c.typeaudit_id,
    q.questionnaire_id,
    q.question,
    q.procede,
    q.departement,
    q.score,
    q.criticite,
    p.deadline,
    c.section_id,
    c.action,
    c.deadline AS constat_deadline,
    c.avancement AS constat_avancement,
    c.numero AS constat_numero,
    r.id_employe AS matricule,
    e.nom,
    e.prenom,
    f.chemin
   FROM constat c
     LEFT JOIN section s ON c.section_id = s.id
     LEFT JOIN typeaudit t ON c.typeaudit_id = t.id
     LEFT JOIN vue_questionnaires q ON c.id = c.question_id
     LEFT JOIN planaction p ON p.constat_id = c.id
     LEFT JOIN responsable_section r ON r.id_section = c.section_id
     LEFT JOIN listeemploye e ON e.id = r.id_employe
     LEFT JOIN fichier f ON c.id = f.constat_id;

CREATE OR REPLACE FUNCTION public.f_stat_constat(ids integer[], id_typeaudit integer)
RETURNS TABLE(
    nb_constat bigint,
    resolu bigint,
    a_traiter bigint,
    retard bigint,
    taux_resolu numeric,
    taux_a_traiter numeric,
    taux_retard numeric
)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT
        COUNT(*) AS nb_constat,
        SUM(CASE WHEN v.constat_avancement = 100 THEN 1 ELSE 0 END) AS resolu,
        SUM(CASE WHEN v.constat_avancement < 100 THEN 1 ELSE 0 END) AS a_traiter,
        SUM(CASE WHEN v.constat_deadline < CURRENT_DATE AND v.constat_avancement < 100 THEN 1 ELSE 0 END) AS retard,
        CASE
            WHEN COUNT(*) > 0 THEN
                SUM(CASE WHEN v.constat_avancement = 100 THEN 1 ELSE 0 END) / COUNT(*)::DECIMAL
            ELSE 0::DECIMAL
        END AS taux_resolu,
        CASE
            WHEN COUNT(*) > 0 THEN
                SUM(CASE WHEN v.constat_avancement < 100 THEN 1 ELSE 0 END) / COUNT(*)::DECIMAL
            ELSE 0::DECIMAL
        END AS taux_a_traiter,
        CASE
            WHEN COUNT(*) > 0 THEN
                SUM(CASE WHEN v.constat_deadline < CURRENT_DATE AND v.constat_avancement < 100 THEN 1 ELSE 0 END) / COUNT(*)::DECIMAL
            ELSE 0::DECIMAL
        END AS taux_retard
    FROM vue_constats v
    WHERE v.typeaudit_id = id_typeaudit AND v.constat_id = ANY(ids);
END;
$$;