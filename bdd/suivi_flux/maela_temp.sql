ALTER TABLE audit_interne 
ADD CONSTRAINT chk_avancement
CHECK (avancement <= 100);

-- public.v_audit_interne source

CREATE OR REPLACE VIEW public.v_audit_interne
AS SELECT ai.id,
    ai.date_detection,
    ai.id_section,
    s.nom_section AS section,
    ai.priorite,
    ai.constat,
    ai.action,
    ai.deadline,
    ai.avancement,
    ai.new_deadline,
    ai.numero_init,
    ai.date_realisation,
    CASE
        WHEN ai.avancement < 100 AND COALESCE(ai.new_deadline,ai.deadline) < CURRENT_DATE THEN 3
        WHEN ai.avancement = 100 THEN 1
        WHEN ai.avancement < 100 THEN 2
        ELSE NULL::integer
    END AS etat_constat,
    pai.photo_initial,
    pai.photo_final,
    pai.mime_type_initial,
    pai.mime_type_final,
    s.resp_id,
    l.id AS id_emp,
    l.nom AS nom_emp,
    l.matricule AS mlle_emp,
    s.resp_mail,
    l.prenom AS prenom_emp
   FROM audit_interne ai
    LEFT JOIN section_compliance s ON s.id = ai.id_section
    LEFT JOIN photo_audit_interne pai ON pai.id_audit_interne::text = ai.id::text
    LEFT JOIN listeemploye l ON l.id = s.resp_id;