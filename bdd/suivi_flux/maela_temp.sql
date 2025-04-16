--section_compliance

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
                WHEN ai.avancement = 100 THEN 1
                WHEN ai.avancement < 100 AND ai.deadline < CURRENT_DATE THEN 3
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
        LEFT JOIN listeemploye l ON l.id = s.resp_id ;

CREATE OR REPLACE VIEW public.v_section_compliance
AS SELECT s.id,
    s.nom_section,
    s.etat,
    s.resp_id,
    l.nom AS nom_emp,
    l.prenom AS prenom_emp 
FROM section_compliance s
    LEFT JOIN listeemploye l ON l.id = s.resp_id;

ALTER TABLE public.audit_interne DROP CONSTRAINT audit_interne_check_date_realisation;
ALTER TABLE public.audit_interne ADD CONSTRAINT audit_interne_date_realisation_check CHECK (date_realisation <= deadline);




ALTER TABLE public.audit_interne ALTER COLUMN deadline DROP NOT NULL;