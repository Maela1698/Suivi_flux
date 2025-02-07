CREATE TABLE public.datedisponibiliteforppmeeting (
	id serial4 NOT NULL,
	id_demande_client int4 NULL,
	tissus date NULL,
	accy date NULL,
	okprod date NULL,
	etat int4 DEFAULT 0 NULL,
	CONSTRAINT datedisponibiliteforppmeeting_pkey PRIMARY KEY (id),
	CONSTRAINT datedisponibiliteforppmeeting_id_demande_client_fkey FOREIGN KEY (id_demande_client) REFERENCES public.demandeclient(id)
);

CREATE TABLE public.meeting (
	"date" date NOT NULL,
	id serial4 NOT NULL,
	CONSTRAINT test_meeting_check CHECK ((date >= now())),
	CONSTRAINT test_meeting_pk PRIMARY KEY (id),
	CONSTRAINT test_meeting_unique UNIQUE (date)
);

CREATE TABLE public.details_meeting (
	id serial4 NOT NULL,
	id_meeting int4 NULL,
	heure_debut time NOT NULL,
	effectif_prevu int4 NULL,
	effectif_reel int4 NULL,
	id_demande int4 NULL,
	commentaire text NULL,
	etat bool DEFAULT false NOT NULL,
	id_chaine int4 NOT NULL,
	date_entree_chaine date NULL,
	date_entree_coupe date NULL,
	date_entree_finition date NULL,
	CONSTRAINT details_meeting_pk PRIMARY KEY (id),
	CONSTRAINT details_meeting_unique UNIQUE (heure_debut, id_meeting),
	CONSTRAINT details_meeting_chaine_fk FOREIGN KEY (id_chaine) REFERENCES public.chaine(id_chaine),
	CONSTRAINT details_meeting_demandeclient_fk FOREIGN KEY (id_demande) REFERENCES public.demandeclient(id),
	CONSTRAINT details_meeting_test_meeting_fk FOREIGN KEY (id_meeting) REFERENCES public.meeting(id)
);

create or replace view v_ppmeeting as(
    select vd.id,
    vd.nom_modele,
    vd.nomtier,
    vd.qte_commande_provisoire,
    vd.types_valeur_ajout,
    d.tissus,
    d.accy,
    d.okprod,
    m.date as dateppm,
    c.designation,
    dm.date_entree_chaine,
    dm.date_entree_coupe,
    dm.date_entree_finition,
    sv.ex_factory,
	dm.heure_debut,
	vd.etat,
	vd.id_etat,
	dm.etat as details_meeting_etat
    from v_general_final_recap vd
    left join datedisponibiliteforppmeeting d on vd.id = d.id_demande_client
    left join details_meeting dm on vd.id = dm.id_demande
    left join meeting m on dm.id_meeting = m.id
    left join chaine c on dm.id_chaine = c.id_chaine
    LEFT JOIN (
    SELECT DISTINCT ON (id_demande_client) id_demande_client, ex_factory
    FROM v_suivifluxmes
    ) sv ON vd.id = sv.id_demande_client
	where vd.etat = 0 and vd.id_etat = 2 
);

ALTER TABLE public.details_meeting ALTER COLUMN etat SET DEFAULT FALSE;
ALTER TABLE public.details_meeting ALTER COLUMN etat SET NOT NULL;



