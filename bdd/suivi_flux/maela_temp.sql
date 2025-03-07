-- public.vue_plans_action source

CREATE OR REPLACE VIEW public.vue_plans_action
AS WITH latest_avancement AS (
         SELECT DISTINCT ON (avancementplanaction.planaction_id) avancementplanaction.planaction_id,
            avancementplanaction.dateavancement,
            avancementplanaction.designation,
            avancementplanaction.avancement
           FROM avancementplanaction
          ORDER BY avancementplanaction.planaction_id, avancementplanaction.dateavancement DESC
        )
 SELECT pa.id AS planaction_id,
    pa.numero,
    c.description AS constat,
    a.description AS audit,
    pa.datedebut,
    pa.moyens,
    pa.priorite,
    r.nom AS responsable,
    pa.deadline,
    pa.commentaires,
    COALESCE(c.section, a.section) AS section,
    c.procede,
    c.departement,
    a.typeaudit,
    a.dateaudit,
    a.norme,
    c.constat_id,
    r.prenom AS prenom_responsable,
    lav.dateavancement,
    lav.designation AS designation_avancement,
    lav.avancement,
    pa.audit_id,
    pa.responsable_id,
    COALESCE(c.section_id, a.section_id) AS id_section,
    r.prenom
   FROM planaction pa
     LEFT JOIN vue_constats c ON pa.constat_id = c.constat_id
     LEFT JOIN vue_audits a ON pa.audit_id = a.audit_id
     LEFT JOIN listeemploye r ON pa.responsable_id = r.id
     LEFT JOIN latest_avancement lav ON pa.id = lav.planaction_id;