-- public.vue_plans_action source
ALTER TABLE public.constat ADD avancement integer DEFAULT 0 NOT NULL;
ALTER TABLE public.constat ADD numero varchar NULL;
ALTER TABLE public.constat ADD CONSTRAINT constat_unique UNIQUE (numero);
ALTER TABLE public.constat ADD action text NULL;
ALTER TABLE public.constat ADD COLUMN deadline DATE NULL;
ALTER TABLE public.constat ADD CONSTRAINT chk_deadline CHECK (deadline > dateconstat);

CREATE TABLE public.responsable_section (
	matricule int4 NOT NULL,
	id_section int4 NULL,
	CONSTRAINT responsable_section_unique UNIQUE (matricule),
	CONSTRAINT responsable_section_unique_1 UNIQUE (id_section),
	CONSTRAINT responsable_section_id_section_fk FOREIGN KEY (id_section) REFERENCES public."section"(id),
	CONSTRAINT responsable_section_matricule_fk FOREIGN KEY (matricule) REFERENCES public.listeemploye(id)
);    

ALTER TABLE public.responsable_section RENAME COLUMN matricule TO id_employe;

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
    r.matricule,
    e.nom,
    e.prenom
   FROM constat c
     LEFT JOIN section s ON c.section_id = s.id
     LEFT JOIN typeaudit t ON c.typeaudit_id = t.id
     LEFT JOIN vue_questionnaires q ON c.id = c.question_id
     LEFT JOIN planaction p ON p.constat_id = c.id
     LEFT JOIN responsable_section r ON r.id_section = c.section_id
     LEFT JOIN listeemploye e ON e.id = r.matricule;


CREATE OR REPLACE VIEW public.v_responsable_section
AS SELECT s.id AS id_section,
    rs.id_employe,
    s.designation AS nom_section,
    l.nom AS nom_employe,
    l.prenom AS prenom_employe,
    l.matricule,
    s.etat
FROM section s
    LEFT JOIN responsable_section rs ON s.id = rs.id_section
    LEFT JOIN listeemploye l ON l.id = rs.id_employe;

CREATE OR REPLACE VIEW v_responsable_libre
AS SELECT
    e.id as id_employe,
    e.nom AS nom_employe,
    e.prenom AS prenom_employe
FROM listeemploye e
    LEFT JOIN responsable_section rs ON e.id = rs.id_employe
WHERE e.id NOT IN (SELECT id_employe FROM responsable_section);

ALTER TABLE public."section" ADD CONSTRAINT section_unique UNIQUE (designation);
ALTER TABLE public.constat ADD CONSTRAINT constat_check CHECK (avancement <= 100);


