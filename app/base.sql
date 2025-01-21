
-- tiers
create table acteurTiers(
    id serial primary key,
    acteur varchar(50),
    etat int default 0
);

create table pays(
    id int primary key,
    code int,
    alpha2 varchar(20),
    alpha3 varchar(20),
    nom_en_gb varchar(255),
    nom_fr_fr varchar(255)
);

create table uniteMonetaire(
    id serial primary key,
    unite varchar(25),
    etat int  default 0
);

create table qualiteTiers(
    id serial primary key,
    qualite varchar(25),
    etat int  default 0
);

create table etatTiers(
    id serial primary key,
    etatTiers varchar(25),
    etat int  default 0
);

create table tiers(
    id serial primary key,
    nomTier varchar(255),
    idActeur int,
    adresse varchar(255),
    ville varchar(255),
    codePostal varchar(255),
    idPays int,
    numPhone varchar(50),
    emailTier varchar(255),
    webSite varchar(255),
    idUnite int,
    idQualite int,
    idEtat int,
    merchSenior varchar(80),
    contactMerchSenior varchar(50),
    emailMerchSenior varchar(80),
    merchJunior varchar(80),
    contactMerchJunior varchar(80),
    emailMerchJunior varchar(50),
    assistant varchar(80),
    contactAssistant varchar(50),
    emailAssistant varchar(80),
    idUtilisateur int,
    logo text,
    dateentree date,
    etat int  default 0
);
alter table tiers add foreign key(idActeur) references acteurTiers(id);
alter table tiers add foreign key(idPays) references pays(id);
alter table tiers add foreign key(idUnite) references uniteMonetaire(id);
alter table tiers add foreign key(idQualite) references qualiteTiers(id);
alter table tiers add foreign key(idEtat) references etatTiers(id);

create table tiersInterlocateur(
    id serial primary key,
    idTiers int,
    nomInterlocateur varchar(55),
    emailInterlocateur varchar(55),
    contactInterlocateur varchar(55),
    etat int  default 0
);
alter table tiersInterlocateur add foreign key(idTiers) references tiers(id);

create table tiersCahierCharge(
    id serial primary key,
    idtiers int,
    cahiercharge text,
    etat int  default 0
);
alter table tiersCahierCharge add foreign key(idtiers) references tiers(id);

-- demande client
create table style(
    id serial primary key,
    nom_style varchar(55),
    pointDev double precision,
    etat int default 0
);

create table incontern(
    id serial primary key,
    type_incontern varchar(55),
    etat int default 0
);

create table phase(
    id serial primary key,
    type_phase varchar(55),
    etat int default 0
);


create table saison(
    id serial primary key,
    type_saison varchar(55),
    etat int default 0
);

create table lavage(
    id serial primary key,
    type_lavage varchar(55),
    etat int default 0
);

create table valeurAjoutee(
    id serial primary key,
    type_valeur_ajoutee varchar(55),
    etat int default 0
);

create table stadeDemandeClient(
    id serial primary key,
    type_stade varchar(55),
    quantite double precision,
    etat int default 0
);

create table etatDemandeClient(
    id serial primary key,
    type_etat varchar(55),
    etat int default 0
);

create table uniteTaille(
    id serial primary key,
    unite_taille varchar(55),
    rang int,
    etat int default 0
);

create table demandeClient(
    id serial primary key,
    date_entree date,
    date_livraison date,
    id_client int,
    id_style int,
    nom_modele varchar(100),
    id_incontern int,
    theme varchar(100),
    id_phase int,
    id_saison int,
    qte_commande_provisoire int,
    taille_min int,
    id_unite_taille_min int,
    id_unite_taille_max int,
    taille_base varchar(50),
    requete_client text,
    commentaire_merch text,
    id_stade int,
    id_etat int,
    photo_commande text,
    etat int default 0
);
alter table demandeClient add foreign key(id_client) references tiers(id);
alter table demandeClient add foreign key(id_style) references style(id);
alter table demandeClient add foreign key(id_incontern) references incontern(id);
alter table demandeClient add foreign key(id_phase) references phase(id);
alter table demandeClient add foreign key(id_saison) references saison(id);
alter table demandeClient add foreign key(id_unite_taille_min) references uniteTaille(id);
alter table demandeClient add foreign key(id_unite_taille_max) references uniteTaille(id);
alter table demandeClient add foreign key(id_stade) references stadeDemandeClient(id);
alter table demandeClient add foreign key(id_etat) references etatDemandeClient(id);

create table dossierTechniqueDemandeClient(
    id serial primary key,
    id_demande_client int,
    dossier_technique_demande text,
    nom_dossier_technique varchar(55),
    etat int default 0
);
alter table dossierTechniqueDemandeClient add foreign key(id_demande_client) references demandeClient(id);


create table lavageDemandeClient(
    id serial primary key,
    id_demande_client int,
    id_lavage int,
    etat int default 0
);
alter table lavageDemandeClient add foreign key(id_demande_client) references demandeClient(id);
alter table lavageDemandeClient add foreign key(id_lavage) references lavage(id);

create table valeurAjouteeDemande(
    id serial primary key,
    id_demande_client int,
    id_valeur_ajoutee int,
    etat int default 0
);
alter table valeurAjouteeDemande add foreign key(id_demande_client) references demandeClient(id);
alter table valeurAjouteeDemande add foreign key(id_valeur_ajoutee) references valeurAjoutee(id);

create table detailTailleDemandeClient(
    id serial primary key,
    id_demande_client int,
    id_unite_taille int,
    quantite int,
    conso double precision,
    etat int default 0
);
alter table detailTailleDemandeClient add foreign key(id_demande_client) references demandeClient(id);
alter table detailTailleDemandeClient add foreign key(id_unite_taille) references uniteTaille(id);

-- matiere premiere
create table typeTissus(
    id serial primary key,
    type_tissus varchar(250),
    etat int default 0
);

create table categorieTissus(
    id serial primary key,
    categorie varchar(250),
    etat int default 0
);

create table compositionTissus(
    id serial primary key,
    composition_tissus varchar(250),
    etat int default 0
);

create table familleTissus(
    id serial primary key,
    famille_tissus varchar(250),
    etat int default 0
);

create table uniteMesureMatierePremiere(
    id serial primary key,
    unite_mesure varchar(250),
    etat int default 0
);

create table classeMatierePremiere(
    id serial primary key,
    classe varchar(250),
    etat int default 0
);

create table tissus(
    id serial primary key,
    id_type_tissus int,
    id_demande_client int,
    id_categorie_tissus int,
    designation varchar(255),
    reference varchar(255),
    id_composition_tissus int,
    couleur varchar(50),
    quantite double precision default 0,
    id_unite_mesure_matiere int,
    prix_unitaire double precision default 0,
    frais double precision default 0,
    id_unite_monetaire int,
    grammage double precision,
    laize_utile double precision,
    id_famille_tissus int,
    l_retrait_lavage double precision default 0,
    w_retrait_lavage double precision default 0,
    l_retrait_teinture double precision default 0,
    w_retrait_teinture double precision default 0,
    nom_fiche_technique varchar(100),
    id_classe int,
    fiche_technique text,
    photo text,
    etat int default 0
);
alter table tissus add foreign key(id_type_tissus) references typeTissus(id);
alter table tissus add foreign key(id_demande_client) references demandeClient(id);
alter table tissus add foreign key(id_categorie_tissus) references categorieTissus(id);
alter table tissus add foreign key(id_composition_tissus) references compositionTissus(id);
alter table tissus add foreign key(id_unite_mesure_matiere) references uniteMesureMatierePremiere(id);
alter table tissus add foreign key(id_unite_monetaire) references uniteMonetaire(id);
alter table tissus add foreign key(id_famille_tissus) references familleTissus(id);
alter table tissus add foreign key(id_classe) references classeMatierePremiere(id);


create table typeAccessoire(
    id serial primary key,
    type_accessoire varchar(250),
    etat int default 0
);
create table familleAccessoire(
    id serial primary key,
    famille_accessoire varchar(250),
    etat int default 0
);

create table accessoire(
    id serial primary key,
    id_type_accessoire int,
    id_demande_client int,
    utilisation varchar(255),
    designation varchar(255),
    reference varchar(255),
    couleur varchar(50),
    quantite double precision default 0,
    id_unite_mesure_matiere int,
    prix_unitaire double precision default 0,
    frais double precision default 0,
    id_unite_monetaire int,
    id_famille_accessoire int,
    photo text,
    nom_fiche_technique varchar(50),
    fiche_technique text,
    id_classe int,
    etat int default 0
);
alter table accessoire add foreign key(id_type_accessoire) references typeAccessoire(id);
alter table accessoire add foreign key(id_unite_monetaire) references uniteMonetaire(id);
alter table accessoire add foreign key(id_demande_client) references demandeClient(id);
alter table accessoire add foreign key(id_unite_mesure_matiere) references uniteMesureMatierePremiere(id);
alter table accessoire add foreign key(id_famille_accessoire) references familleAccessoire(id);
alter table accessoire add foreign key(id_classe) references classeMatierePremiere(id);

create table sdc(
    id serial primary key,
    date_entree date,
    date_envoie date,
    id_demande_client int,
    id_stade_demande_client int,
    etat int default 0,
    quantite double precision default 5
);
alter table sdc add foreign key(id_demande_client) references demandeClient(id);
alter table sdc add foreign key(id_stade_demande_client) references stadeDemandeClient(id);

create table detailSdc(
    id serial primary key,
    id_sdc int,
    id_unite_taille_dc int,
    qte_total double precision,
    qte_client double precision,
    paquet double precision,
    keep double precision,
    etat int default 0
);
alter table detailSdc add foreign key(id_sdc) references sdc(id);
alter table detailSdc add foreign key(id_unite_taille_dc) references detailTailleDemandeClient(id);

create table dispositionMatierePremiere(
    id serial primary key,
    disposition varchar(255),
    etat int default 0
);

create table smv(
    id serial primary key,
    date_smv date,
    smv_prod double precision,
    smv_finition double precision,
    prix_print double precision,
    id_unite_monetaire int,
    nombre_points double precision,
    smv_brod_main double precision,
    id_demande_client int,
    id_stade_demande_client int,
    commentaire text,
    etat int default 0
);
alter table smv add foreign key(id_unite_monetaire) references uniteMonetaire(id);
alter table smv add foreign key(id_demande_client) references demandeClient(id);
alter table smv add foreign key(id_stade_demande_client) references stadeDemandeClient(id);


create table pri(
    id serial primary key,
    date_pri date,
    prix double precision,
    id_unite_monetaire int,
    id_demande_client int,
    commentaire text,
    etat int default 0
);
alter table pri add foreign key(id_demande_client) references demandeClient(id);
alter table pri add foreign key(id_unite_monetaire) references uniteMonetaire(id);

create table envoieEchantillon(
    id serial primary key,
    id_demande_client int,
    id_stade_demande_client int,
    date_creation date,
    date_envoie date,
    quantite double precision,
    lieu_destination varchar(255),
    mode_envoie varchar(255),
    commentaire text,
    awb VARCHAR(255),
    etat int default 0
);
alter table envoieEchantillon add foreign key(id_demande_client) references demandeClient(id);
alter table envoieEchantillon add foreign key(id_stade_demande_client) references stadeDemandeClient(id);

create table consoTissus(
    id serial primary key,
    id_tissus int,
    conso_tissus double precision default 0,
    efficience_tissus double precision default 0,
    id_demande_client int,
    etat int default 0
);
alter table consoTissus add foreign key(id_tissus) references tissus(id);
alter table consoTissus add foreign key(id_demande_client) references demandeClient(id);

create table consoAccessoire(
    id serial primary key,
    id_accessoire int,
    conso_accessoire double precision default 0,
    id_demande_client int,
    id_unite_taille int,
    taille varchar(255),
    qte double precision default 0,
    etat int default 0
);
alter table consoAccessoire add foreign key(id_accessoire) references accessoire(id);
alter table consoAccessoire add foreign key(id_demande_client) references demandeClient(id);
alter table consoAccessoire add foreign key(id_unite_taille) references uniteTaille(id);


create table ficheCoupe(
    id serial primary key,
    nomfichier varchar(255),
    fichier text,
    id_demande_client int,
    etat int default 0
);
alter table ficheCoupe add foreign key(id_demande_client) references demandeclient(id);

create table caracteristiqueTissu(
    id serial PRIMARY KEY,
    caracteristique VARCHAR(255),
    pointDev int,
    etat int DEFAULT 0
);

create table caractereTissu(
    id serial PRIMARY KEY,
    id_caracteristique_tissu int,
    id_tissu int
);
alter table caractereTissu add foreign key(id_caracteristique_tissu) references caracteristiqueTissu(id);
alter table caractereTissu add foreign key(id_tissu) references tissus(id);



create table type_bc(
    id serial primary key,
    type_bc varchar(100),
    etat int default 0
);
insert into type_bc values(default,'Tissu',0);
insert into type_bc values(default,'Accessoire',0);
insert into type_bc values(default,'CoupeType',0);
insert into type_bc values(default,'General',0);

create table bc(
    id serial primary key,
    date_bc date,
    numero_bc varchar(255),
    id_type_bc int,
    idtier int,
    echeance date,
    etat int default 0
);
alter table bc add foreign key(idtier) references tiers(id);
alter table bc add foreign key(id_type_bc) references type_bc(id);

create table detailBc(
    id serial primary key,
    id_bc int,
    id_demande_client int,
    etat int default 0,
    dateconfirmation date default null
);
alter table detailBc add foreign key(id_bc) references bc(id);
alter table detailBc add foreign key(id_demande_client) references demandeClient(id);

create table donneBc(
    id serial primary key,
    id_detail int,
    designation varchar(100),
    laize double precision,
    utilisation varchar(100),
    couleur varchar(100),
    quantite double precision,
    unite varchar(100),
    prix_unitaire double precision,
    devise varchar(100),
    etat int default 0,
    id_tissus int,
    id_accessoire int,
    numerobc varchar(255)
);
alter table donneBc add foreign key(id_detail) references detailBc(id);
alter table donneBc add foreign key(id_tissus) references tissus(id);
alter table donneBc add foreign key(id_accessoire) references accessoire(id);
/*------------------------------------------bc----------------------------------------------*/
/*------------------------------------------tscf-------------------------------------------*/

create table merch(
    id serial primary key,
    id_donne_bc int,
    dateex date,
    deadline date,
    transport varchar(100),
    dateemmission date,
    numerofacture varchar(100),
    montant double precision,
    detailfacture text,
    commentaire text
);
alter table merch add foreign key(id_donne_bc) references donneBc(id);

create table transit(
    id serial primary key,
    id_donne_bc int,
    transit varchar(100),
    transittime int,
    datedepart date,
    datearrive date,
    awb varchar(100)
);
alter table transit add foreign key(id_donne_bc) references donneBc(id);
create table magasin(
    id serial primary key,
    id_donne_bc int,
    datearrivereelle date,
    bl varchar(100),
    quantite double precision,
    reste double precision,
    numero varchar(100)
);
alter table magasin add foreign key(id_donne_bc) references donneBc(id);
create table reclamation(
    id serial primary key,
    id_donne_bc int,
    dateenvoie date,
    daterelance date,
    raison varchar(100),
    quantite double precision,
    remarque varchar(255),
    retour varchar(100),
    recompensation varchar(100),
    note varchar(100)
);
alter table reclamation add foreign key(id_donne_bc) references donneBc(id);
create table comptabilite(
    id serial primary key,
    id_donne_bc int,
    swift date,
    deposit double precision,
    pri double precision,
    payer double precision
);
alter table comptabilite add foreign key(id_donne_bc) references donneBc(id);

create table etatbc(
    id serial primary key,
    etatbc varchar(100),
    etat int default 0
);








-------------------------RETRO MERCH DEV------------------------------
create table etapeRetroMerch(
    id serial primary key,
    designation varchar(80),
    stade varchar(80),
    etat int default 0,
    nbJour int,
    etape_quantite double precision
);-- Insert for stage 'PROTO1' with etape_quantite as the last column
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DISPO TISS & ACCY', 'PROTO1', 0, 5, 10);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'ENVOI SDC', 'PROTO1', 0, 10, 10);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'FIN MONTAGE', 'PROTO1', 0, 2, 10);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'ENVOI PROTO', 'PROTO1', 0, 10, 10);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'COMMENTAIRE PROTO', 'PROTO1', 0, 7, 10);

-- Insert for stage 'PROTO2' with etape_quantite as the last column
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DISPO TISS & ACCY', 'PROTO2', 0, 5, 12);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'ENVOI SDC', 'PROTO2', 0, 10, 12);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'FIN MONTAGE', 'PROTO2', 0, 2, 12);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'ENVOI PROTO', 'PROTO2', 0, 10, 12);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'COMMENTAIRE PROTO', 'PROTO2', 0, 4, 12);

-- Insert for stage 'TDS1' with etape_quantite as the last column
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DISPO TISS & ACCY', 'TDS1', 0, 3, 15);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'ENVOI SDC', 'TDS1', 0, 10, 15);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'FIN MONTAGE', 'TDS1', 0, 2, 15);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'ENVOI PROTO', 'TDS1', 0, 10, 15);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'COMMENTAIRE PROTO', 'TDS1', 0, 4, 15);

-- Insert for stage 'TDS2' with etape_quantite as the last column
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DISPO TISS & ACCY', 'TDS2', 0, 5, 20);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'ENVOI SDC', 'TDS2', 0, 10, 20);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'FIN MONTAGE', 'TDS2', 0, 2, 20);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'ENVOI PROTO', 'TDS2', 0, 10, 20);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'COMMENTAIRE PROTO', 'TDS2', 0, 4, 20);

-- Insert for stage 'PPS1' with etape_quantite as the last column
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DISPO TISS & ACCY', 'PPS1', 0, 5, 18);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'ENVOI SDC', 'PPS1', 0, 10, 18);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'FIN MONTAGE', 'PPS1', 0, 2, 18);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'ENVOI PROTO', 'PPS1', 0, 10, 18);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'COMMENTAIRE PROTO', 'PPS1', 0, 4, 18);

-- Insert for stage 'PPS2' with etape_quantite as the last column
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DISPO TISS & ACCY', 'PPS2', 0, 5, 22);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'ENVOI SDC', 'PPS2', 0, 10, 22);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'FIN MONTAGE', 'PPS2', 0, 2, 22);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'ENVOI PROTO', 'PPS2', 0, 10, 22);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'COMMENTAIRE PROTO', 'PPS2', 0, 4, 22);

-- Insert for retro steps without specific stage, with etape_quantite as the last column
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DATE OK TECH', '', 0, 10, 25);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DATE LCMT TRACE', '', 0, 2, 25);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DATE OK PROD', '', 0, 10, 25);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DATE GARMENT', '', 0, 4, 25);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DATE SHIPMENT', '', 0, 10, 25);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DATE SHOOTING', '', 0, 2, 25);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DATE MOCK UP', '', 0, 10, 25);
INSERT INTO etapeRetroMerch VALUES (DEFAULT, 'DATE CONFORMITE', '', 0, 4, 25);


create table resultatCalcule(
    id serial primary key,
    id_etape int,
    id_demande_client int,
    datecalcul date,
    semaine int,
    annee int,
    etat int default 0
);
alter table resultatCalcule add foreign key(id_etape) references etapeRetroMerch(id);
alter table resultatCalcule add foreign key(id_demande_client) references demandeClient(id);

create table microMerchDev (
    id serial primary key,
    id_etape int,
    id_demande int,
    semaine int,
    realisation date,
    commentaires varchar(250),
    etat int default 0
);
alter table microMerchDev add foreign key(id_etape) references etapeRetroMerch(id);
alter table microMerchDev add foreign key(id_demande) references demandeClient(id);


create table parametremicromerchdev(
    id serial primary key,
    annee int,
    semaine int,
    nbJour int default 5,
    effectif int default 19,
    heureSupple int default 0,
    objectif double precision default 0.35,
    etat int default 0
);


CREATE VIEW v_etape_retro AS
    SELECT
        e.id AS id_etape,
        e.designation,
        e.nbJour,
        e.etat AS etat_etape,
        r.id AS id_resultat,
        r.id_demande_client,
        r.datecalcul,
        r.etat AS etat_resultat
    FROM
        etapeRetroMerch e
    JOIN
        resultatCalcule r
    ON
        e.id = r.id_etape
    WHERE
        e.etat = 0;




---------------------------------------------------------RECAP COMMANDE--------------------------------------------

create table recapCommande(
    id serial primary key,
    idDemandeClient int,
    etdRevise date,
    etdPropose date,
    receptionBC date,
    bcClient text,
    date_bc_tissu date default NULL,
    date_bc_access date default NULL,
    etat int default 0,
    podateprev date
);
alter table recapCommande add foreign key(idDemandeClient) references demandeClient(id);

create table destStd(
    id serial primary key,
    designation varchar(55),
    etat int default 0
);
insert into destStd values(default,'destignation1',0);
insert into destStd values(default,'destignation2',0);
insert into destStd values(default,'destignation3',0);
insert into destStd values(default,'destignation4',0);


create table destination(
    id serial primary key,
    idRecapCommande int,
    numeroCommande varchar(250),
    etdInitial date,
    dateLivraisonExacte date,
    dateInspection date,
    qteOF int,
    idDestStd int,
    etat int default 0
);
alter table destination add foreign key(idRecapCommande) references recapCommande(id);
alter table destination add foreign key(idDestStd) references destStd(id);



--------------------------etatretro
create table etatRetroMerch(
    id serial primary key,
    etatRetroMerch varchar(100),
    etat int default 0
);
insert into etatRetroMerch(etatRetroMerch) VALUES ('MP Non Dispo');
insert into etatRetroMerch(etatRetroMerch) VALUES ('Attente SDC');
insert into etatRetroMerch(etatRetroMerch) VALUES ('Retard');
insert into etatRetroMerch(etatRetroMerch) VALUES ('OK Prod');

----------------------------datepardefault ok prod par rapport id_demande
create table okprodinitial(
    id serial primary key,
    id_demande_client int,
    date_initial date
);
alter table okprodinitial add foreign key(id_demande_client) references demandeClient(id);

----------------------------datemodifier micro
create table dateModifierMicro(
    id serial primary key,
    id_etape int,
    id_demande_client int,
    date_depart date
);



-----------------------view retro merch


CREATE OR REPLACE VIEW v_retro_merch AS
    SELECT
        v_demandeClient.id AS demande_id,
        v_demandeClient.date_entree AS demande_date_entree,
        v_demandeClient.date_livraison AS demande_date_livraison,
        v_demandeClient.nom_modele,
        v_demandeClient.theme,
        v_demandeClient.qte_commande_provisoire,
        v_demandeClient.taille_base,
        v_demandeClient.requete_client,
        v_demandeClient.commentaire_merch,
        v_demandeClient.etat AS demande_etat,
        v_demandeClient.id_unite_taille_min,
        v_demandeClient.id_unite_taille_max,
        v_demandeClient.nomtier,
        v_demandeClient.id_tiers,
        v_demandeClient.nom_style,
        v_demandeClient.id_style,
        v_demandeClient.type_incontern,
        v_demandeClient.id_incontern,
        v_demandeClient.type_phase,
        v_demandeClient.id_phase,
        v_demandeClient.type_saison,
        v_demandeClient.id_saison,
        v_demandeClient.tailleMin,
        v_demandeClient.tailleMax,
        v_demandeClient.type_stade,
        v_demandeClient.id_stade,
        v_demandeClient.type_etat,
        v_demandeClient.id_etat,

        -- Ajout des informations du SDC (ou null si aucun SDC n'est associé)
        sdc.id AS sdc_id,
        sdc.date_entree AS sdc_date_entree,
        sdc.date_envoie AS sdc_date_envoie,
        sdc.quantite AS sdc_quantite,
        sdc.etat AS sdc_etat,

        -- Ajout de la somme de qte_total depuis detailsdc
        COALESCE(
            (SELECT SUM(qte_total)
            FROM detailsdc
            WHERE detailsdc.id_sdc = sdc.id)
        ) AS total_qte_detailsdc

    FROM v_demandeClient
    LEFT JOIN (
        -- Sous-requête pour obtenir le dernier SDC pour chaque demande client
        SELECT DISTINCT ON (id_demande_client) *
        FROM sdc
        ORDER BY id_demande_client, id DESC
    ) sdc ON v_demandeClient.id = sdc.id_demande_client;

---------get dateconfirmation par demande type
create or replace view v_date_bc_tissus as
    SELECT
        detailBc.id AS detailBc_id,
        detailBc.id_bc,
        detailBc.id_demande_client,
        detailBc.etat AS detailBc_etat,
        detailBc.dateconfirmation,
        bc.date_bc,
        bc.numero_bc,
        bc.id_type_bc,
        bc.idtier,
        bc.echeance,
        bc.etat AS bc_etat
    FROM
        detailBc
    JOIN
        bc ON detailBc.id_bc = bc.id
    WHERE
        detailBc.dateconfirmation = (
            SELECT MAX(dateconfirmation)
            FROM detailBc db
            JOIN bc b ON db.id_bc = b.id
            WHERE db.id_demande_client = detailBc.id_demande_client
            AND b.id_type_bc = 1
        );
create or replace view v_date_bc_accy as
    SELECT
        detailBc.id AS detailBc_id,
        detailBc.id_bc,
        detailBc.id_demande_client,
        detailBc.etat AS detailBc_etat,
        detailBc.dateconfirmation,
        bc.date_bc,
        bc.numero_bc,
        bc.id_type_bc,
        bc.idtier,
        bc.echeance,
        bc.etat AS bc_etat
    FROM
        detailBc
    JOIN
        bc ON detailBc.id_bc = bc.id
    WHERE
        detailBc.dateconfirmation = (
            SELECT MAX(dateconfirmation)
            FROM detailBc db
            JOIN bc b ON db.id_bc = b.id
            WHERE db.id_demande_client = detailBc.id_demande_client
            AND b.id_type_bc = 2
        );

CREATE OR REPLACE VIEW v_confirmation_bc AS
    SELECT
        t.detailBc_id AS tissus_detailBc_id,
        t.id_bc AS tissus_id_bc,
        t.id_demande_client AS tissus_id_demande_client,
        t.detailBc_etat AS tissus_etat,
        t.dateconfirmation AS tissus_dateconfirmation,
        t.date_bc AS tissus_date_bc,
        t.numero_bc AS tissus_numero_bc,
        t.id_type_bc AS tissus_id_type_bc,
        t.idtier AS tissus_idtier,
        t.echeance AS tissus_echeance,
        t.bc_etat AS tissus_bc_etat,

        a.detailBc_id AS accy_detailBc_id,
        a.id_bc AS accy_id_bc,
        a.detailBc_etat AS accy_etat,
        a.dateconfirmation AS accy_dateconfirmation,
        a.date_bc AS accy_date_bc,
        a.numero_bc AS accy_numero_bc,
        a.id_type_bc AS accy_id_type_bc,
        a.idtier AS accy_idtier,
        a.echeance AS accy_echeance,
        a.bc_etat AS accy_bc_etat
    FROM
        v_date_bc_tissus t
    FULL OUTER JOIN
        v_date_bc_accy a ON t.id_demande_client = a.id_demande_client;







------------v_recap commande total
CREATE OR REPLACE VIEW v_micro_merch AS (
    SELECT
        rc.id AS resultat_id,
        rc.id_etape,
        rc.id_demande_client,
        rc.datecalcul,
        rc.semaine,
        rc.annee,
        rc.etat AS resultat_etat,

        erm.designation AS etape_designation,
        erm.nbJour AS etape_nbjour,
        erm.etape_quantite,
        erm.stade AS etape_stade,
        erm.etat AS etape_etat,

        v.sdc_id,
        v.sdc_date_entree,
        v.sdc_date_envoie,
        v.sdc_quantite,
        v.sdc_etat,
        v.demande_id,
        v.demande_date_entree,
        v.demande_date_livraison,
        v.nom_modele,
        v.theme,
        v.qte_commande_provisoire,
        v.taille_base,
        v.requete_client,
        v.commentaire_merch,
        v.demande_etat,
        v.id_unite_taille_min,
        v.id_unite_taille_max,
        v.nomtier,
        v.id_tiers,
        v.nom_style,
        v.id_style,
        v.type_incontern,
        v.id_incontern,
        v.type_phase,
        v.id_phase,
        v.type_saison,
        v.id_saison,
        v.tailleMin,
        v.tailleMax,
        v.type_stade,
        v.id_stade,
        v.stade_quantite,
        v.type_etat,
        v.id_etat,
        v.total_qte_detailsdc,

        mmd.semaine AS micro_semaine,
        mmd.realisation AS micro_realisation,
        mmd.commentaires AS micro_commentaires,
        mmd.etat AS micro_etat,

        ok.date_initial AS ok_prod_initial

    FROM resultatCalcule rc
    JOIN etapeRetroMerch erm
        ON rc.id_etape = erm.id
    JOIN v_retro_merch v
        ON rc.id_demande_client = v.demande_id
    LEFT JOIN okprodinitial ok
        ON rc.id_demande_client = ok.id_demande_client
    LEFT JOIN (
        SELECT DISTINCT ON (id_etape, id_demande) *
        FROM microMerchDev
        ORDER BY id_etape, id_demande, id DESC
    ) mmd
        ON rc.id_etape = mmd.id_etape
        AND rc.id_demande_client = mmd.id_demande
);

CREATE OR REPLACE VIEW v_donne_bc_max_datearrivereelle_tissus AS (
    WITH ranked_data AS (
        SELECT
            v.*,  -- Inclut toutes les colonnes de v_donne_bc
            md.max_datearrivereelle,
            ROW_NUMBER() OVER (
                PARTITION BY v.id_demande_client, v.idtypebc  -- Partitionnement par id_demande_client et idtypebc
                ORDER BY
                    md.max_datearrivereelle DESC
            ) AS rn
        FROM
            v_donne_bc v
        JOIN
            (SELECT
                id_demande_client,
                idtypebc,
                MAX(datearrivereelle) AS max_datearrivereelle
            FROM
                v_donne_bc
            GROUP BY
                id_demande_client,
                idtypebc
            ) md
        ON v.id_demande_client = md.id_demande_client
        AND v.idtypebc = md.idtypebc
    )
    SELECT
        r.*,  -- Inclut toutes les colonnes de ranked_data
        r.max_datearrivereelle as max_datearrivereelle_tissus  -- Inclut la colonne max_datearrivereelle
    FROM
        ranked_data r
    WHERE
        r.rn = 1  -- Prend uniquement la première ligne pour chaque combinaison id_demande_client et idtypebc
        AND r.idtypebc = 1
);
CREATE OR REPLACE VIEW v_donne_bc_max_deadline_tissus AS (
    WITH ranked_data AS (
        SELECT
            v.*,
            md.max_datearrive,
            md.max_deadline,
            md.max_echeance,
            ROW_NUMBER() OVER (
                PARTITION BY v.id_demande_client, v.idtypebc  -- Partitionnement par id_demande_client et idtypebc
                ORDER BY
                    md.max_datearrive DESC,
                    md.max_deadline DESC,
                    md.max_echeance DESC
            ) AS rn
        FROM
            v_donne_bc v
        JOIN
            (SELECT
                id_demande_client,
                idtypebc,
                MAX(datearrive) AS max_datearrive,
                MAX(deadline) AS max_deadline,
                MAX(echeance) AS max_echeance
            FROM
                v_donne_bc
            GROUP BY
                id_demande_client,
                idtypebc
            ) md
        ON v.id_demande_client = md.id_demande_client
        AND v.idtypebc = md.idtypebc
    )
    SELECT
        r.*,
        CASE
            WHEN r.max_datearrive IS NOT NULL THEN r.max_datearrive
            WHEN r.max_deadline IS NOT NULL THEN r.max_deadline
            ELSE r.max_echeance
        END AS final_deadline
    FROM
        ranked_data r
    WHERE
        r.rn = 1  -- Prend uniquement la première ligne pour chaque combinaison id_demande_client et idtypebc
        AND r.idtypebc = 1  -- Condition pour n'inclure que idtypebc = 1

);
CREATE OR REPLACE VIEW v_donne_bc_max_deadline_accy AS (
    WITH ranked_data AS (
    SELECT
        v.*,
        md.max_datearrive,
        md.max_deadline,
        md.max_echeance,
        ROW_NUMBER() OVER (
            PARTITION BY v.id_demande_client, v.idtypebc  -- Partitionnement par id_demande_client et idtypebc
            ORDER BY
                md.max_datearrive DESC,
                md.max_deadline DESC,
                md.max_echeance DESC
        ) AS rn
    FROM
        v_donne_bc v
    JOIN
        (SELECT
            id_demande_client,
            idtypebc,
            MAX(datearrive) AS max_datearrive,
            MAX(deadline) AS max_deadline,
            MAX(echeance) AS max_echeance
         FROM
            v_donne_bc
         GROUP BY
            id_demande_client,
            idtypebc
        ) md
    ON v.id_demande_client = md.id_demande_client
       AND v.idtypebc = md.idtypebc
    )
    SELECT
        r.*,
        CASE
            WHEN r.max_datearrive IS NOT NULL THEN r.max_datearrive
            WHEN r.max_deadline IS NOT NULL THEN r.max_deadline
            ELSE r.max_echeance
        END AS final_deadline
    FROM
        ranked_data r
    WHERE
        r.rn = 1  -- Prend uniquement la première ligne pour chaque combinaison id_demande_client et idtypebc
        AND r.idtypebc = 2  -- Condition pour n'inclure que idtypebc = 1
);
CREATE OR REPLACE VIEW v_donne_bc_max_datearrivereelle_accy AS (
    WITH ranked_data AS (
        SELECT
            v.*,
            md.max_datearrivereelle,
            ROW_NUMBER() OVER (
                PARTITION BY v.id_demande_client, v.idtypebc  -- Partitionnement par id_demande_client et idtypebc
                ORDER BY
                    md.max_datearrivereelle DESC
            ) AS rn
        FROM
            v_donne_bc v
        JOIN
            (SELECT
                id_demande_client,
                idtypebc,
                MAX(datearrivereelle) AS max_datearrivereelle
            FROM
                v_donne_bc
            GROUP BY
                id_demande_client,
                idtypebc
            ) md
        ON v.id_demande_client = md.id_demande_client
        AND v.idtypebc = md.idtypebc
        )
        SELECT
            r.*,
            r.max_datearrivereelle as max_datearrivereelle_accy
        FROM
            ranked_data r
        WHERE
            r.rn = 1  -- Prend uniquement la première ligne pour chaque combinaison id_demande_client et idtypebc
            AND r.idtypebc = 2
);
CREATE OR REPLACE VIEW v_donne_bc_max_datearrivereelle AS (
    SELECT
        t.*,  -- Toutes les colonnes de la vue tissus
        a.max_datearrivereelle AS accy_max_datearrivereelle  -- Date maximale de la vue accy (pour les accessoires)
    FROM
        v_donne_bc_max_datearrivereelle_tissus t
    LEFT JOIN
        v_donne_bc_max_datearrivereelle_accy a
    ON
        t.id_demande_client = a.id_demande_client
);


CREATE OR REPLACE VIEW v_last_demande_client_with_micro AS (
    WITH last_smv AS (
        SELECT smv.*,
            ROW_NUMBER() OVER (PARTITION BY smv.id_demande_client ORDER BY smv.id DESC) AS rn
        FROM smv
    ),
    last_recap_commande AS (
            SELECT
            recapCommande.id AS recapCommande_id,
            recapCommande.idDemandeClient,
            recapCommande.etdRevise,
            recapCommande.etdPropose,
            recapCommande.receptionBC,
            recapCommande.bcClient,
            recapCommande.date_bc_tissu,
            recapCommande.date_bc_access,
            recapCommande.etat AS recap_etat,
            destination.id AS destination_id,
            destination.numeroCommande,
            destination.etdInitial,
            destination.dateLivraisonExacte,
            destination.dateInspection,
            destination.qteOF,
            destStd.id AS destStd_id,
            destStd.designation,
            destStd.etat AS destStd_etat
        FROM recapCommande
        LEFT JOIN (
            SELECT DISTINCT ON (idRecapCommande) *
            FROM destination
            ORDER BY idRecapCommande, id DESC
        ) AS destination ON destination.idRecapCommande = recapCommande.id
        LEFT JOIN destStd ON destination.idDestStd = destStd.id
        WHERE recapCommande.id IN (
            SELECT MAX(id)
            FROM recapCommande
            GROUP BY idDemandeClient
        )
    ),
    last_micro_merch AS (
        SELECT *
        FROM v_micro_merch
        WHERE etape_designation = 'DATE OK PROD'
    )
    SELECT
        dc.*,
        smv.smv_prod,
        smv.smv_finition,
        smv.prix_print,
        smv.nombre_points,
        smv.smv_brod_main,
        recap.recapCommande_id,
        recap.etdRevise,
        recap.etdPropose,
        recap.receptionBC,
        recap.bcClient,
        recap.date_bc_tissu,
        recap.date_bc_access,
        recap.recap_etat,
        recap.destination_id,
        recap.numeroCommande,
        recap.etdInitial,
        recap.dateLivraisonExacte,
        recap.dateInspection,
        recap.qteOF,
        recap.destStd_id,
        recap.designation,
        recap.destStd_etat,
        micro.resultat_id AS micro_resultat_id,
        micro.id_etape AS micro_id_etape,
        micro.datecalcul AS micro_datecalcul,
        micro.etape_nbjour AS micro_etape_nbjour,
        micro.micro_realisation,
        micro.micro_semaine,
        micro.micro_commentaires,
        micro.micro_etat
    FROM v_demandeClient dc
    LEFT JOIN last_smv smv ON smv.id_demande_client = dc.id AND smv.rn = 1
    LEFT JOIN last_recap_commande recap ON recap.idDemandeClient = dc.id
    LEFT JOIN last_micro_merch micro ON micro.id_demande_client = dc.id
);
CREATE OR REPLACE VIEW v_combined_confirmation_with_micro AS(
    SELECT
        m.*,

        c.tissus_detailBc_id,
        c.tissus_id_bc,
        c.tissus_etat AS tissus_etat,
        c.tissus_dateconfirmation,
        c.tissus_date_bc,
        c.tissus_numero_bc,
        c.tissus_id_type_bc,
        c.tissus_idtier,
        c.tissus_echeance,
        c.tissus_bc_etat,

        c.accy_detailBc_id,
        c.accy_id_bc,
        c.accy_etat AS accy_etat,
        c.accy_dateconfirmation AS accy_dateconfirmation,
        c.accy_date_bc AS accy_date_bc,
        c.accy_numero_bc AS accy_numero_bc,
        c.accy_id_type_bc AS accy_id_type_bc,
        c.accy_idtier AS accy_idtier,
        c.accy_echeance AS accy_echeance,
        c.accy_bc_etat AS accy_bc_etat
    FROM
        v_last_demande_client_with_micro m
    LEFT JOIN
        v_confirmation_bc c ON m.id = c.tissus_id_demande_client
);
CREATE OR REPLACE VIEW v_donne_bc_max_deadline_combined AS (
    SELECT
        t.*,  -- Colonnes de la vue tissus
        a.max_datearrive AS accy_max_datearrive,
        a.max_deadline AS accy_max_deadline,
        a.max_echeance AS accy_max_echeance,
        a.final_deadline AS accy_final_deadline  -- Colonnes de la vue accessoires
    FROM
        v_donne_bc_max_deadline_tissus t
    LEFT JOIN
        v_donne_bc_max_deadline_accy a
    ON
        t.id_demande_client = a.id_demande_client
);
---------------------------ALLL RECAP IN ONE---------------------------
CREATE OR REPLACE VIEW v_combined_full_info AS (
    SELECT
        m.*,
        a.max_datearrivereelle,
        d.final_deadline AS combined_final_deadline,
        d.accy_final_deadline AS combined_final_deadline_accy,
        a.accy_max_datearrivereelle
    FROM
        v_combined_confirmation_with_micro m
    LEFT JOIN
        v_donne_bc_max_deadline_combined d ON m.id = d.id_demande_client
    LEFT JOIN
        v_donne_bc_max_datearrivereelle a ON m.id = a.id_demande_client
);


----------------------------view destinatio
CREATE VIEW v_dest_recap AS(
    SELECT
        rc.id AS recap_id,
        rc.idDemandeClient,
        rc.etdRevise,
        rc.etdPropose,
        rc.receptionBC,
        rc.bcClient,
        rc.date_bc_tissu,
        rc.date_bc_access,
        rc.etat AS recap_etat,
        d.id AS destination_id,
        d.numeroCommande,
        d.etdInitial,
        d.dateLivraisonExacte,
        d.dateInspection,
        d.qteOF,
        d.etat AS destination_etat,
        ds.id AS destStd_id,
        ds.designation AS destStd_designation
    FROM
        recapCommande rc
    LEFT JOIN
        destination d ON rc.id = d.idRecapCommande
    LEFT JOIN
        destStd ds ON d.idDestStd = ds.id
);
------------------------------view pour filtre retro
create or replace view v_filtre_dispo as (
    WITH ranked_results AS (
        SELECT
            vm.*,
            ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) AS row_num,
            (ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) - 1) / 5 AS group_number
        FROM v_micro_merch vm
    ),
    group_completion AS (
        SELECT
            group_number,
            id_demande_client,
            COUNT(*) AS total_in_group,
            COUNT(CASE WHEN micro_realisation IS NOT NULL THEN 1 END) AS completed_in_group
        FROM ranked_results
        GROUP BY group_number, id_demande_client
    ),
    filtered_results AS (
        SELECT r.*,
            ROW_NUMBER() OVER (PARTITION BY r.id_demande_client ORDER BY r.group_number, r.row_num) AS client_row_num
        FROM ranked_results r
        JOIN group_completion gc
        ON r.group_number = gc.group_number
        AND r.id_demande_client = gc.id_demande_client
        WHERE gc.completed_in_group < 5
    )
    -- Sélectionne la première ligne par id_demande_client
    SELECT id_demande_client, id_etape, etape_designation,micro_realisation
    FROM filtered_results
    WHERE client_row_num = 1
    and id_etat =2
    ORDER BY id_demande_client, group_number, row_num
);

CREATE OR REPLACE VIEW v_filtre_envoie_sdc AS (
    WITH ranked_results AS (
        SELECT
            vm.*,
            ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) AS row_num,
            (ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) - 1) / 5 AS group_number
        FROM v_micro_merch vm
    ),
    group_completion AS (
        SELECT
            group_number,
            id_demande_client,
            COUNT(*) AS total_in_group,
            COUNT(CASE WHEN micro_realisation IS NOT NULL THEN 1 END) AS completed_in_group
        FROM ranked_results
        GROUP BY group_number, id_demande_client
    ),
    filtered_results AS (
        SELECT r.*,
            ROW_NUMBER() OVER (PARTITION BY r.id_demande_client ORDER BY r.group_number, r.row_num) AS client_row_num
        FROM ranked_results r
        JOIN group_completion gc
        ON r.group_number = gc.group_number
        AND r.id_demande_client = gc.id_demande_client
        WHERE gc.completed_in_group < 5
    )
    -- Sélectionne la deuxième ligne par id_demande_client
    SELECT id_demande_client, id_etape,etape_designation,micro_realisation
    FROM filtered_results
    WHERE client_row_num = 2
    and id_etat = 2
    ORDER BY id_demande_client, group_number, row_num
);

CREATE OR REPLACE VIEW v_filtre_retard AS (
    WITH ranked_results AS (
        SELECT
            vm.id_demande_client,
            vm.id_etape,
            vm.micro_realisation,
            vm.datecalcul,
            vm.id_etat,
            ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) AS row_num,
            (ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) - 1) / 5 AS group_number
        FROM v_micro_merch vm
        WHERE
            vm.micro_realisation IS NULL      -- Vérifie si micro_realisation est NULL
            AND vm.datecalcul < current_date         -- Comparaison avec la date actuelle
    ),
    group_completion AS (
        SELECT
            group_number,
            id_demande_client,
            COUNT(*) AS total_in_group,
            COUNT(CASE WHEN micro_realisation IS NOT NULL THEN 1 END) AS completed_in_group
        FROM ranked_results
        GROUP BY group_number, id_demande_client
    ),
    filtered_results AS (
        SELECT r.*,
            ROW_NUMBER() OVER (PARTITION BY r.id_demande_client ORDER BY r.group_number, r.row_num) AS client_row_num
        FROM ranked_results r
        JOIN group_completion gc
        ON r.group_number = gc.group_number
        AND r.id_demande_client = gc.id_demande_client
    )

    -- Sélectionne tous les id_demande_client
    -- Sélectionne tous les id_demande_client, datecalcul et micro_realisation
    SELECT DISTINCT id_demande_client
    FROM filtered_results
    where id_etat =2
    ORDER BY id_demande_client -- Tri par id_demande_client
);

create or replace view v_filtre_ok_prod as (
    WITH ranked_results AS (
        SELECT
            vm.*,
            ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) AS row_num,
            (ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) - 1) / 5 AS group_number
        FROM v_micro_merch vm
    ),
    group_completion AS (
        SELECT
            group_number,
            id_demande_client,
            COUNT(*) AS total_in_group,
            COUNT(CASE WHEN micro_realisation IS NOT NULL THEN 1 END) AS completed_in_group
        FROM ranked_results
        GROUP BY group_number, id_demande_client
    ),
    filtered_results AS (
        SELECT r.*,
            ROW_NUMBER() OVER (PARTITION BY r.id_demande_client ORDER BY r.group_number, r.row_num) AS client_row_num
        FROM ranked_results r
        JOIN group_completion gc
        ON r.group_number = gc.group_number
        AND r.id_demande_client = gc.id_demande_client
        WHERE gc.completed_in_group < 5
    )
    -- Sélectionne la première ligne par id_demande_client
    SELECT id_demande_client, id_etape,etape_designation,micro_realisation
    FROM filtered_results
    WHERE client_row_num = 3
    and id_etat =2
    ORDER BY id_demande_client, group_number, row_num
);

-------------------------------view pour filtre micro
create or replace view v_filtre_micro as (
    WITH ranked_results AS (
        SELECT
            vm.*,
            ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) AS row_num,
            (ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) - 1) / 5 AS group_number
        FROM v_micro_merch vm
        WHERE vm.resultat_etat = 0  -- Ajouter la condition pour exclure les étapes avec etape_etat != 0
    ),
    group_completion AS (
        SELECT
            group_number,
            id_demande_client,
            COUNT(*) AS total_in_group,
            COUNT(CASE WHEN micro_realisation IS NOT NULL THEN 1 END) AS completed_in_group
        FROM ranked_results
        GROUP BY group_number, id_demande_client
    ),
    filtered_results AS (
        SELECT r.*,
            ROW_NUMBER() OVER (PARTITION BY r.id_demande_client ORDER BY r.group_number, r.row_num) AS client_row_num
        FROM ranked_results r
        JOIN group_completion gc
        ON r.group_number = gc.group_number
        AND r.id_demande_client = gc.id_demande_client
        WHERE gc.completed_in_group < 5
    )
    SELECT *
    FROM filtered_results
    WHERE client_row_num <= 5
    ORDER BY id_demande_client, group_number, row_num

);

--------------------------------view pour couleur recap
CREATE VIEW v_recap_commande_livraison AS(
    SELECT
        rc.id AS idRecapCommande,
        CASE
            WHEN COUNT(d.qteOF) FILTER (WHERE d.dateLivraisonExacte IS NOT NULL) = COUNT(d.qteOF)
                AND COUNT(d.qteOF) > 0 THEN 'rgb(114, 250, 114)'
            WHEN COUNT(d.qteOF) FILTER (WHERE d.dateLivraisonExacte IS NOT NULL) > 0 THEN 'rgb(87, 87, 255)'
            ELSE 'white'
        END AS couleur
    FROM recapCommande rc
    LEFT JOIN destination d ON rc.id = d.idRecapCommande
    GROUP BY rc.id
);
---------------------------------lavage en une seule ligne par demande
create or replace view v_lavage_demande_ligne as (
    SELECT ldc.id_demande_client,
        STRING_AGG(l.type_lavage, ', ') AS types_lavage
    FROM lavageDemandeClient ldc
    JOIN lavage l ON ldc.id_lavage = l.id
    GROUP BY ldc.id_demande_client
);
---------------------------------va en une seule ligne par demande
create or replace view v_valeur_ajout_demande_ligne as (
    SELECT vdc.id_demande_client,
        STRING_AGG(l.type_valeur_ajoutee, ', ') AS types_valeur_ajout
    FROM valeurAjouteeDemande vdc
    JOIN valeurAjoutee l ON vdc.id_valeur_ajoutee = l.id
    GROUP BY vdc.id_demande_client
);
---------------------------------deuc V.A combiner
CREATE OR REPLACE VIEW v_lavage_valeur_ajout_demande_ligne AS (
    SELECT
        COALESCE(lavage.id_demande_client, valeur.id_demande_client) AS id_demande_client,
        lavage.types_lavage,
        valeur.types_valeur_ajout
    FROM v_lavage_demande_ligne lavage
    FULL OUTER JOIN v_valeur_ajout_demande_ligne valeur
    ON lavage.id_demande_client = valeur.id_demande_client
);

---------------------------------view final recap
CREATE OR REPLACE VIEW v_final_recap AS (
        SELECT
            last_demande.*,
            recap_livraison.couleur AS livraison_couleur
        FROM v_combined_full_info last_demande
        LEFT JOIN v_recap_commande_livraison recap_livraison
            ON last_demande.recapCommande_id = recap_livraison.idRecapCommande
);

-----------------------------------view vraiment last recap
CREATE OR REPLACE VIEW v_general_final_recap AS (
    SELECT
        recap.*,
        lavage_valeur.id_demande_client,
        lavage_valeur.types_lavage,
        lavage_valeur.types_valeur_ajout
    FROM v_final_recap recap
    LEFT JOIN v_lavage_valeur_ajout_demande_ligne lavage_valeur
        ON recap.id = lavage_valeur.id_demande_client
);

