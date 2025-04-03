create table entreetissu(
    id serial PRIMARY KEY,
    modele VARCHAR(50)
);

create table fabricInspection(
    id serial PRIMARY KEY,
    id_entree_tissu int references entreetissu(id),
    date_inspection date,
    tolerance VARCHAR(255),
    speed_machine VARCHAR(255),
    choix VARCHAR(255),
    sens VARCHAR(255),
    id_type_tissu int references typetissus(id),
    grammage double precision,
    passed VARCHAR(10)
);

CREATE TABLE public.qualiterouleautissu (
	id serial4 NOT NULL,
	lot int4 NULL,
	identreetissu int4 NOT NULL,
	laize numeric(19, 3) NOT NULL,
	metrage numeric(19, 3) NULL,
	poids numeric(19, 3) NULL,
	etat int4 NOT NULL DEFAULT 0,
	reference varchar(100) NULL,
	CONSTRAINT qualiterouleautissu_pkey PRIMARY KEY (id),
	CONSTRAINT fkqualiterou252522 FOREIGN KEY (identreetissu) REFERENCES public.entreetissu(id)
);
create table inspectionRouleau(
    id serial PRIMARY KEY,
    id_entree_tissu int references entreetissu(id),
    id_rouleau int REFERENCES qualiterouleautissu(id),
    laize_utilisable DOUBLE precision,
    metrage double precision,
    poids double precision,
    longueur_inspection double precision
);

CREATE TABLE public.defectfabrictype (
	id serial4 NOT NULL,
	typedefaut varchar(100) NULL,
	etat int4 NOT NULL DEFAULT 0,
	CONSTRAINT defectfabrictype_pkey PRIMARY KEY (id)
);

INSERT INTO public.defectfabrictype (typedefaut,etat) VALUES
	 ('Gros fil',0),
	 ('Noeud',0),
	 ('Barre',0),
	 ('Fils flottant',0),
	 ('Casse en chaine',0),
	 ('Casse en trame',0),
	 ('Double duite',0),
	 ('Marque d arret',0),
	 ('Fibre etrangere',0),
	 ('Appuyure',0);
INSERT INTO public.defectfabrictype (typedefaut,etat) VALUES
	 ('Vrille et ebouillure',0),
	 ('Divers tissage',0),
	 ('Mal blanchi',0),
	 ('Pli',0),
	 ('Rappuyage',0),
	 ('Divers preparations',0),
	 ('Negation nuance',0),
	 ('Arret demarrage',0),
	 ('Strie',0),
	 ('Divers teinture',0);
INSERT INTO public.defectfabrictype (typedefaut,etat) VALUES
	 ('Dechirure',0),
	 ('Tache d huile',0),
	 ('Tache d appret',0),
	 ('Tache de colorant',0),
	 ('Mauvais grattage',0),
	 ('Craquelure pli',0),
	 ('Point blanc',0),
	 ('Divers points',0),
	 ('Trou',0),
	 ('Defaut de fabrication',0);
INSERT INTO public.defectfabrictype (typedefaut,etat) VALUES
	 ('Salisure',0),
	 ('Cerne d eau',0);


create table detailInspectionRouleau(
    id serial PRIMARY KEY,
    id_inspection_rouleau int references inspectionRouleau(id),
    metrage double precision,
    id_defaut int REFERENCES defectfabrictype(id),
    nombre_def_point int,
    nombre_dem_point int
);


-- kanto 18/02/25
create table testConformite(
    id serial PRIMARY KEY,
    id_entree_tissu int REFERENCES entreetissu(id),
    date_conformite date,
    photo_conformite text,
    passed VARCHAR(20)
);

create table testElongation(
    id serial PRIMARY KEY,
    id_entree_tissu int REFERENCES entreetissu(id),
    date_elongation date,
    date_preparation date,
    date_evaluation date,
    id_employe int REFERENCES listeemploye(id),
    id_type_lavage int REFERENCES lavage(id),
    temps_relaxation double precision,
    observation text,
    passed VARCHAR(20)
);

create table elongationRouleau(
    id serial PRIMARY KEY,
    id_rouleau int REFERENCES qualiterouleautissu(id),
    elongation_long DOUBLE precision,
    elongation_laize DOUBLE precision,
    retrait_long double precision,
    retrait_laize double precision,
    retrait_angulaire double precision
);

create or replace view v_elongationRouleau AS
select qualiterouleautissu.*,
    elongationrouleau.elongation_long,
    elongationrouleau.elongation_laize,
    elongationrouleau.retrait_long,
    elongationrouleau.retrait_laize,
    elongationrouleau.retrait_angulaire
    from qualiterouleautissu
    left join elongationrouleau on qualiterouleautissu.id = elongationrouleau.id_rouleau;

create table shadeTest(
    id serial PRIMARY KEY,
    id_entree_tissu int REFERENCES entreetissu(id),
    date_shade date,
    date_execution date,
    endroit VARCHAR(55),
    passed VARCHAR(20),
    nuance VARCHAR(20),
    observation text
);

CREATE TABLE public.shadetestrouleau (
	id serial4 NOT NULL,
	photo_shade text NULL,
	idqualiterouleau int4 NULL,
	CONSTRAINT shadetestrouleau_pkey PRIMARY KEY (id)
);
ALTER TABLE public.shadetestrouleau ADD CONSTRAINT shadetestrouleau_idqualiterouleau_fkey FOREIGN KEY (idqualiterouleau) REFERENCES public.qualiterouleautissu(id);

create or replace view v_shadeTestRouleau as
select qualiterouleautissu.*,
shadetestrouleau.photo_shade
from qualiterouleautissu
left join shadetestrouleau on shadetestrouleau.idqualiterouleau = qualiterouleautissu.id;

create table disgorging(
    id serial primary key,
    id_entree_tissu int REFERENCES entreetissu(id),
    date_disgorging date,
    date_preparation date,
    date_evaluation date,
    passed VARCHAR(20)
);

create table disgorgingLot(
    id serial PRIMARY KEY,
    id_entree_tissu int REFERENCES entreetissu(id),
    lot VARCHAR(50),
    image_disgorging text,
    type_frottement VARCHAR(55),
    echelle_gris VARCHAR(55) DEFAULT 0,
    duree VARCHAR(55) DEFAULT 0,
    validation_test VARCHAR(55),
    remarque text
);
