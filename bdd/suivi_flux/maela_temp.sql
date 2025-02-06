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
	etat bool NULL,
	id_chaine int4 NOT NULL,
	date_entree_chaine date NULL,
	date_entree_coupe date NULL,
	date_entree_finition date NULL,
	CONSTRAINT test_details_meeting_pk PRIMARY KEY (id),
	CONSTRAINT test_details_meeting_unique UNIQUE (heure_debut, id_meeting),
	CONSTRAINT test_details_meeting_chaine_fk FOREIGN KEY (id_chaine) REFERENCES public.chaine(id_chaine),
	CONSTRAINT test_details_meeting_demandeclient_fk FOREIGN KEY (id_demande) REFERENCES public.demandeclient(id),
	CONSTRAINT test_details_meeting_test_meeting_fk FOREIGN KEY (id_meeting) REFERENCES public.meeting(id)
);