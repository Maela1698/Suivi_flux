create table acteurTiers (
    id serial primary key,
    acteur varchar(50),
    etat int default 0
);

create table pays (
    id int primary key,
    code int,
    alpha2 varchar(20),
    alpha3 varchar(20),
    nom_en_gb varchar(255),
    nom_fr_fr varchar(255)
);

create table uniteMonetaire (
    id serial primary key,
    unite varchar(25),
    etat int default 0
);

create table qualiteTiers (
    id serial primary key,
    qualite varchar(25),
    etat int default 0
);

create table etatTiers (
    id serial primary key,
    etatTiers varchar(25),
    etat int default 0
);

create table tiers (
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
    etat int default 0
);

alter table tiers
add foreign key (idActeur) references acteurTiers (id);

alter table tiers add foreign key (idPays) references pays (id);

alter table tiers
add foreign key (idUnite) references uniteMonetaire (id);

alter table tiers
add foreign key (idQualite) references qualiteTiers (id);

alter table tiers add foreign key (idEtat) references etatTiers (id);

create table tiersInterlocateur (
    id serial primary key,
    idTiers int,
    nomInterlocateur varchar(55),
    emailInterlocateur varchar(55),
    contactInterlocateur varchar(55),
    etat int default 0
);

alter table tiersInterlocateur
add foreign key (idTiers) references tiers (id);

create table tiersCahierCharge (
    id serial primary key,
    idtiers int,
    cahiercharge text,
    etat int default 0
);

alter table tiersCahierCharge
add foreign key (idtiers) references tiers (id);

-- demande client
create table certificationClient(
    id serial primary key,
    certification varchar(80),
    etat int default 0
);


create table style (
    id serial primary key,
    nom_style varchar(55),
    effectif int,
    efficience double precision,
    pointDev double precision,
    etat int default 0
);

create table incontern (
    id serial primary key,
    type_incontern varchar(55),
    etat int default 0
);

create table phase (
    id serial primary key,
    type_phase varchar(55),
    etat int default 0
);

create table saison (
    id serial primary key,
    type_saison varchar(55),
    etat int default 0
);

create table lavage (
    id serial primary key,
    type_lavage varchar(55),
    etat int default 0
);

create table valeurAjoutee (
    id serial primary key,
    type_valeur_ajoutee varchar(55),
    etat int default 0
);

create table stadeDemandeClient (
    id serial primary key,
    type_stade varchar(55),
    etat int default 0
);

create table etatDemandeClient (
    id serial primary key,
    type_etat varchar(55),
    etat int default 0
);

create table uniteTaille (
    id serial primary key,
    unite_taille varchar(55),
    rang int,
    etat int default 0
);

create table periode (
    id serial primary key,
    periode varchar(55),
    etat int default 0
);

create table demandeClient (
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
    id_periode int,
    photo_commande text,
    etat int default 0
);

alter table demandeClient
add foreign key (id_client) references tiers (id);


alter table demandeClient
add foreign key (id_periode) references periode (id);

alter table demandeClient
add foreign key (id_style) references style (id);

alter table demandeClient
add foreign key (id_incontern) references incontern (id);

alter table demandeClient
add foreign key (id_phase) references phase (id);

alter table demandeClient
add foreign key (id_saison) references saison (id);

alter table demandeClient
add foreign key (id_unite_taille_min) references uniteTaille (id);

alter table demandeClient
add foreign key (id_unite_taille_max) references uniteTaille (id);

alter table demandeClient
add foreign key (id_stade) references stadeDemandeClient (id);

alter table demandeClient
add foreign key (id_etat) references etatDemandeClient (id);

create table dossierTechniqueDemandeClient (
    id serial primary key,
    id_demande_client int,
    dossier_technique_demande text,
    nom_dossier_technique varchar(55),
    etat int default 0
);

alter table dossierTechniqueDemandeClient
add foreign key (id_demande_client) references demandeClient (id);

create table lavageDemandeClient (
    id serial primary key,
    id_demande_client int,
    id_lavage int,
    etat int default 0
);

alter table lavageDemandeClient
add foreign key (id_demande_client) references demandeClient (id);

alter table lavageDemandeClient
add foreign key (id_lavage) references lavage (id);

create table valeurAjouteeDemande (
    id serial primary key,
    id_demande_client int,
    id_valeur_ajoutee int,
    etat int default 0
);

alter table valeurAjouteeDemande
add foreign key (id_demande_client) references demandeClient (id);

alter table valeurAjouteeDemande
add foreign key (id_valeur_ajoutee) references valeurAjoutee (id);

create table detailTailleDemandeClient (
    id serial primary key,
    id_demande_client int,
    id_unite_taille int,
    quantite int,
    conso double precision,
    etat int default 0
);

alter table detailTailleDemandeClient
add foreign key (id_demande_client) references demandeClient (id);

alter table detailTailleDemandeClient
add foreign key (id_unite_taille) references uniteTaille (id);

-- matiere premiere
create table typeTissus (
    id serial primary key,
    type_tissus varchar(250),
    etat int default 0
);

create table categorieTissus (
    id serial primary key,
    categorie varchar(250),
    etat int default 0
);

create table compositionTissus (
    id serial primary key,
    composition_tissus varchar(250),
    etat int default 0
);

create table familleTissus (
    id serial primary key,
    famille_tissus varchar(250),
    etat int default 0
);

create table uniteMesureMatierePremiere (
    id serial primary key,
    unite_mesure varchar(250),
    etat int default 0
);

create table classeMatierePremiere (
    id serial primary key,
    classe varchar(250),
    etat int default 0
);

create table tissus (
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

alter table tissus
add foreign key (id_type_tissus) references typeTissus (id);

alter table tissus
add foreign key (id_demande_client) references demandeClient (id);

alter table tissus
add foreign key (id_categorie_tissus) references categorieTissus (id);

alter table tissus
add foreign key (id_composition_tissus) references compositionTissus (id);

alter table tissus
add foreign key (id_unite_mesure_matiere) references uniteMesureMatierePremiere (id);

alter table tissus
add foreign key (id_unite_monetaire) references uniteMonetaire (id);

alter table tissus
add foreign key (id_famille_tissus) references familleTissus (id);

alter table tissus
add foreign key (id_classe) references classeMatierePremiere (id);

create table typeAccessoire (
    id serial primary key,
    type_accessoire varchar(250),
    etat int default 0
);

create table familleAccessoire (
    id serial primary key,
    famille_accessoire varchar(250),
    etat int default 0
);

create table accessoire (
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

alter table accessoire
add foreign key (id_type_accessoire) references typeAccessoire (id);

alter table accessoire
add foreign key (id_unite_monetaire) references uniteMonetaire (id);

alter table accessoire
add foreign key (id_demande_client) references demandeClient (id);

alter table accessoire
add foreign key (id_unite_mesure_matiere) references uniteMesureMatierePremiere (id);

alter table accessoire
add foreign key (id_famille_accessoire) references familleAccessoire (id);

alter table accessoire
add foreign key (id_classe) references classeMatierePremiere (id);

create table sdc (
    id serial primary key,
    date_entree date,
    date_envoie date,
    id_demande_client int,
    id_stade_demande_client int,
    quantite double precision default 5,
    etat int default 0
);

alter table sdc
add foreign key (id_demande_client) references demandeClient (id);

alter table sdc
add foreign key (id_stade_demande_client) references stadeDemandeClient (id);

create table detailSdc (
    id serial primary key,
    id_sdc int,
    id_unite_taille_dc int,
    qte_total double precision,
    qte_client double precision,
    paquet double precision,
    keep double precision,
    etat int default 0
);

alter table detailSdc add foreign key (id_sdc) references sdc (id);

alter table detailSdc
add foreign key (id_unite_taille_dc) references detailTailleDemandeClient (id);

create table dispositionMatierePremiere (
    id serial primary key,
    disposition varchar(255),
    etat int default 0
);

create table smv (
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

alter table smv
add foreign key (id_unite_monetaire) references uniteMonetaire (id);

alter table smv
add foreign key (id_demande_client) references demandeClient (id);

alter table smv
add foreign key (id_stade_demande_client) references stadeDemandeClient (id);

create table pri (
    id serial primary key,
    date_pri date,
    prix double precision,
    id_unite_monetaire int,
    id_demande_client int,
    commentaire text,
    etat int default 0
);

alter table pri
add foreign key (id_demande_client) references demandeClient (id);

alter table pri
add foreign key (id_unite_monetaire) references uniteMonetaire (id);

create table envoieEchantillon (
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

alter table envoieEchantillon
add foreign key (id_demande_client) references demandeClient (id);

alter table envoieEchantillon
add foreign key (id_stade_demande_client) references stadeDemandeClient (id);

create table consoTissus (
    id serial primary key,
    id_tissus int,
    conso_tissus double precision default 0,
    efficience_tissus double precision default 0,
    id_demande_client int,
    etat int default 0
);

alter table consoTissus
add foreign key (id_tissus) references tissus (id);

alter table consoTissus
add foreign key (id_demande_client) references demandeClient (id);

create table consoAccessoire (
    id serial primary key,
    id_accessoire int,
    conso_accessoire double precision default 0,
    id_demande_client int,
    id_unite_taille int,
    taille varchar(255),
    qte double precision default 0,
    etat int default 0
);

alter table consoAccessoire
add foreign key (id_accessoire) references accessoire (id);

alter table consoAccessoire
add foreign key (id_demande_client) references demandeClient (id);

alter table consoAccessoire
add foreign key (id_unite_taille) references uniteTaille (id);

create table ficheCoupe (
    id serial primary key,
    nomfichier varchar(255),
    fichier text,
    id_demande_client int,
    etat int default 0
);

alter table ficheCoupe
add foreign key (id_demande_client) references demandeclient (id);

create table caracteristiqueTissu (
    id serial PRIMARY KEY,
    caracteristique VARCHAR(255),
    pointDev int,
    etat int DEFAULT 0
);

create table caractereTissu (
    id serial PRIMARY KEY,
    id_caracteristique_tissu int,
    id_tissu int
);

alter table caractereTissu
add foreign key (id_caracteristique_tissu) references caracteristiqueTissu (id);

alter table caractereTissu
add foreign key (id_tissu) references tissus (id);






create table type_bc(
    id serial primary key,
    type_bc varchar(100),
    etat int default 0
);

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

create table etatRetroMerch(
    id serial primary key,
    etatRetroMerch varchar(100),
    etat int default 0
);

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


--------------------------------------------------------------------SAROBIDY-----------------------------------------------------------
-------------------RAD---------------------
create table objectifSaison(
    id serial primary key,
    idTiers int,
    idSaison int,
    targetSaison int,
    tauxConfirmation double precision,
    etat int default 0
);
alter table objectifSaison add foreign key(idTiers) references tiers(id);
alter table objectifSaison add foreign key(idSaison) references saison(id);


create table stadeMasterPlan(
    id serial primary key,
    designation varchar(80),
    niveau int,
    etat int default 0
);

create table stadeSpecifique(
    id serial primary key,
    idStadeMasterPlan int,
    designation varchar(250),
    niveau int,
    etat int default 0
);

create table leadtime(
    id serial primary key,
    designation varchar(80),
    leadtime int,
    etat int default 0
);

create table masterPlan(
    id serial primary key,
    idDemandeClient int,
    date_E_init date,
    date_E_reel date,
    date_MP_Initial date,
    date_MP_reel date,
    date_Prod_Initial date,
    date_Prod_reel date,
    leadTimeReel int,
    nbrJProd int,
    statutCommande varchar(250),
    idStadeSpecifique int,
    etat int default 0
);
alter table masterPlan add foreign key(idDemandeClient) references demandeClient(id);
alter table masterPlan add foreign key(idStadeSpecifique) references stadeSpecifique(id);



create table conformite(
    id_conformite serial primary key,
    designation varchar(250),
    etat int default 0
);
-- ex designation : BIO,NON-BIO,etc...

create table chaine(
    id_chaine serial primary key,
    designation varchar(250),
    idConformite int,
    etat int default 0
);
-- il y a 16 chaînes , mais pas de chaîne 13
alter table chaine add foreign key(idConformite) references conformite(id_conformite);

create table specialiteChaine(
    id serial primary key,
    id_chaine int,
    id_style int,
    etat int default 0
);
alter table specialiteChaine add foreign key(id_chaine) references chaine(id_chaine);
alter table specialiteChaine add foreign key(id_style) references style(id);



-- DATA
create table dataProd(
    id serial primary key,
    idDemandeClient int,
    disponibilite date,
    id_Chaine int,
    propositionInline date,
    inline date,
    outline date,
    capacite double precision,
    jourProd double precision,
    minuteGrmt double precision,
    etat int default 0,
    etatJourSpe int,
    commentaire text,
    qte_coupe double precision
);
alter table dataProd add foreign key(idDemandeClient) references demandeClient(id);
alter table  dataProd add foreign key(id_Chaine) references chaine(id_chaine);
ALTER TABLE dataProd ALTER COLUMN etatJourSpe TYPE varchar(10);
ALTER TABLE dataProd ADD COLUMN heuresup double precision;

create table dataPrint(
    id serial primary key,
    idDemandeClient int,
    disponibilite date,
    tempsPrint double precision,
    propositionInline date,
    inline date,
    outline date,
    effectif int,
    efficience double precision,
    capacite double precision,
    jourProd double precision,
    minuteGrmt double precision,
    besoinLoading double precision,
    etat int default 0 ,
    etatJourSpe int,
    commentaire text
);
alter table dataPrint add foreign key(idDemandeClient) references demandeClient(id);
ALTER TABLE dataPrint
ALTER COLUMN etatJourSpe TYPE varchar(50);

create table dataBrodMain(
    id serial primary key,
    idDemandeClient int,
    disponibilite date,
    tempsBrod double precision,
    propositionInline date,
    inline date,
    outline date,
    effectif_bm double precision,
    efficience double precision,
    capacite double precision,
    jourProd double precision,
    heureGrmt double precision,
    besoinLoading double precision,
    etat int default 0,
    etatJourSpe int,
    commentaire text
);
alter table dataBrodMain add foreign key(idDemandeClient) references demandeClient(id);
ALTER TABLE dataBrodMain
ALTER COLUMN etatJourSpe TYPE varchar(50);

create table dataBrodMachine(
    id serial primary key,
    idDemandeClient int,
    disponibilite date,
    propositionInline date,
    inline date,
    outline date,
    effectif_bmc int,
    efficience double precision,
    capacite double precision,
    jourProd double precision,
    heureGrmt double precision,
    besoinLoading double precision,
    idListeMachine int,
    etat int default 0,
    etatJourSpe varchar(50),
    commentaire text
);
alter table dataBrodMachine add foreign key(idDemandeClient) references demandeClient(id);
alter table dataBrodMachine add foreign key(idListeMachine) references listeMachine(id);


create table dataLbt(
    id serial primary key,
    idDemandeClient int,
    disponibilite date,
    poids double precision,
    propositionInline date,
    heure double precision,
    inline date,
    outline date,
    efficience double precision,
    capacite double precision,
    jourProd double precision,
    heureGrmt double precision,
    besoinLoading double precision,
    idListeMachine int,
    etat int default 0,
    etatJourSpe int,
    commentaire text,
    valeurAjoutee varchar(50)
);
alter table dataLbt add foreign key(idDemandeClient) references demandeClient(id);
alter table dataLbt add foreign key(idListeMachine) references listeMachine(id);

create table type_macrocharge(
    id_type_macro serial primary key,
    type_macro varchar(50)
);


CREATE TABLE macrocharge2 (
    id serial PRIMARY KEY,
    id_type_macro int,
    mois int,
    annee int,
    jourOuvrable int,
    absence double precision DEFAULT 0.036,
    heureTravail int DEFAULT 8,
    heureSup int DEFAULT 0,
    etat int DEFAULT 0,
    CONSTRAINT fk_type_macro FOREIGN KEY (id_type_macro) REFERENCES macrocharge2(id)

);

CREATE TABLE macrocharge_details (
    id serial PRIMARY KEY,
    macrocharge2_id int REFERENCES macrocharge2(id)
,
    effectif int DEFAULT 0,
    efficience double precision DEFAULT 0,
    besoin_effectif int default 0
);


create table retro_planing(
    id serial primary key,
    idDemandeClient int,
    id_chaine int,
    id_data_prod int,
    inlinechacun date,
    heuretravail int,
    efficience double precision,
    efficiencereel double precision,
    effectif int,
    capacitereel double precision,
    qtereel double precision,
    commentaire text,
    etat int default 0
);
alter table retro_planing add foreign key(idDemandeClient) references demandeClient(id);
alter table retro_planing add foreign key(id_chaine) references chaine(id_chaine);
alter table  retro_planing add foreign key(id_data_prod) references dataProd(id);
