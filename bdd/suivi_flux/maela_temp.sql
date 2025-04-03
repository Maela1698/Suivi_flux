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
    f.chemin,
    CASE
        WHEN c.avancement = 100 THEN 1 
        WHEN c.avancement < 100 AND c.deadline < CURRENT_DATE THEN 3
        WHEN c.avancement < 100 THEN 2
    END AS etat_constat
   FROM constat c
     LEFT JOIN section s ON c.section_id = s.id
     LEFT JOIN typeaudit t ON c.typeaudit_id = t.id
     LEFT JOIN vue_questionnaires q ON c.id = c.question_id
     LEFT JOIN planaction p ON p.constat_id = c.id
     LEFT JOIN responsable_section r ON r.id_section = c.section_id
     LEFT JOIN listeemploye e ON e.id = r.id_employe
     LEFT JOIN fichier f ON c.id = f.constat_id;