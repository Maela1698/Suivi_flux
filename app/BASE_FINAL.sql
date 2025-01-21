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

create table etapeDev (
    id serial primary key,
    etape varchar(250),
    niveau int,
    duree int,
    etat int default 0
);

create table demandeClientSDCEtapeDev (
    id serial PRIMARY KEY,
    id_demande_client int,
    id_sdc int,
    id_etape_dev int,
    date_entree_demande TIMESTAMP,
    quantitesdc int default 0,
    etat int DEFAULT 0
);

alter table demandeClientSDCEtapeDev add foreign key (id_demande_client) references demandeClient (id);

alter table demandeClientSDCEtapeDev add foreign key (id_sdc) references sdc (id);

alter table demandeClientSDCEtapeDev add foreign key (id_etape_dev) references etapeDev (id);


-- 12/09/2024
create table typePatronage (
    id serial primary key,
    typePatron varchar(250),
    pointDev double precision default 0
);

create table fonctionEmploye (
    id serial primary key,
    designation varchar(250),
    etat int default 0
);

create table section (
    id serial primary key,
    designation varchar(250),
    etat int default 0
);

create table classification (
    id serial primary key,
    designation varchar(250),
    etat int default 0
);

create table role(
    id serial primary key,
    role VARCHAR(255),
    etat int default 0
);

create table listeEmploye (
    id serial primary key,
    nom varchar(250) not null,
    prenom varchar(250) not null,
    dateNaissance date,
    matricule varchar(50) not null unique,
    idFonction int not null,
    idSection int not null,
    statut varchar(80),
    categorie varchar(80),
    idClassification int,
    dateEmbauche date,
    dateDebauche date,
    etatCivil varchar(80),
    numeroCnaps varchar(250),
    civilite varchar(50),
    idPays int,
    salaireBase double precision,
    contact varchar(250),
    photo text,
    mail varchar(250),
    nomUtilisateur varchar(80),
    motDePasse varchar(80),
    pseudo varchar(80),
    etat int default 0,
    idrole int
);

alter table listeEmploye add foreign key (idFonction) references fonctionEmploye (id);
alter table listeEmploye add foreign key (idSection) references section (id);
alter table listeEmploye add foreign key (idClassification) references classification (id);
alter table listeEmploye add foreign key (idPays) references pays (id);
alter table listeEmploye add foreign key (idrole) references role (id);
-- alter table listeEmploye add column mdp varchar(250);

create table dossierEmploye (
    id serial primary key,
    dossierEmploye text,
    nomDossierEmploye varchar(55),
    idEmployee int,
    etat int default 0
);

alter table dossierEmploye
add foreign key (idEmployee) references listeEmploye (id);

create table bureauEtude (
    id serial primary key,
    dateDebut timestamp,
    idTypePatronage int,
    idListeEmploye int,
    idDClientSDCEtapeDev int,
    dateFin timestamp,
    commentaire text,
    deadline timestamp,
    etat int default 0
);

alter table bureauEtude add foreign key (idTypePatronage) references typePatronage (id);

alter table bureauEtude add foreign key (idListeEmploye) references listeEmploye (id);

alter table bureauEtude add foreign key (idDClientSDCEtapeDev) references demandeClientSDCEtapeDev (id);

create table specificiteMontageDEV (
    id serial PRIMARY KEY,
    idDClientSDCEtapeDev int,
    valeurCouture VARCHAR(255),
    pointCM VARCHAR(255),
    montageDevant VARCHAR(255),
    montageEnvers VARCHAR(255),
    maille VARCHAR(255),
    glissementCouture VARCHAR(255),
    autres TEXT,
    preRunDemande int DEFAULT 0,
    demandeLapdipint int DEFAULT 0,
    demandeTauxRetrait int DEFAULT 0,
    tauxMesure int DEFAULT 0,
    conformiteDossier int DEFAULT 0
);

alter table specificiteMontageDEV add foreign key (idDClientSDCEtapeDev) references demandeClientSDCEtapeDev (id);

create table suiviPatronage (
    id serial primary key,
    dateDebut timestamp,
    dateRecepetion timestamp,
    idDClientSDCEtapeDev int,
    dateFin timestamp,
    pointPatronage double precision,
    commentaire text,
    deadline timestamp,
    etat int default 0
);
alter table suiviPatronage add foreign key (idDClientSDCEtapeDev) references demandeClientSDCEtapeDev (id);



create table typeOccurencePatronage (
    id serial primary key,
    occurence varchar(250),
    etat int default 0
);

create table controlePatronage (
    id serial primary key,
    dateRecepetion timestamp,
    dateDebut timestamp,
    dateFin timestamp,
    deadline timestamp,
    occurence int DEFAULT 0,
    idDClientSDCEtapeDev int,
    idTypeOccurencePatronage int,
    commentaire text,
    etat int default 0
);
alter table controlePatronage add foreign key (idDClientSDCEtapeDev) references demandeClientSDCEtapeDev (id);
alter table controlePatronage add foreign key (idTypeOccurencePatronage) references typeOccurencePatronage (id);

create table typePlacement (
    id serial primary key,
    typePlacement VARCHAR(50),
    pointPlacement double precision,
    etat int default 0
);


create table suiviPlaceur (
    id serial primary key,
    dateRecepetion timestamp,
    dateDebut timestamp,
    dateFin timestamp,
    deadline timestamp,
    idDClientSDCEtapeDev int,
    idListeEmploye int,
    etat int default 0
);

alter table suiviPlaceur add foreign key (idDClientSDCEtapeDev) references demandeClientSDCEtapeDev (id);
alter table suiviPlaceur add foreign key (idListeEmploye) references listeEmploye (id);
create table detailSuiviPlaceur (
    id serial primary key,
    id_suivi_placeur int,
    idTissus int,
    nbMarkeur int default 0,
    pointPlacement double precision,
    commentaire text,
    id_type_placement int,
    etat int default 0
);
alter table detailSuiviPlaceur add foreign key (id_suivi_placeur) references suiviPlaceur (id);
alter table detailSuiviPlaceur add foreign key (id_type_placement) references typeplacement (id);
alter table detailSuiviPlaceur add foreign key (idTissus) references tissus (id);


create table suiviConso (
    id serial primary key,
    dateRecepetion timestamp,
    dateDebut timestamp,
    dateFin timestamp,
    deadline timestamp,
    idDClientSDCEtapeDev int,
    etat int default 0
);
alter table suiviConso add foreign key (idDClientSDCEtapeDev) references demandeClientSDCEtapeDev (id);



create table suiviDetailConso (
    id serial primary key,
    idSuiviConso int,
    idTissus int,
    laizeUtile double precision,
    consoCommande double precision,
    efficienceCommande double precision,
    consoRecu double precision,
    efficienceRecu double precision,
    varience double precision,
    tauxRecoupe double precision,
    pointPlacement double precision,
    id_type_placement int,
    commentaire text,
    etat int default 0
);
alter table suiviDetailConso add foreign key (idSuiviConso) references suiviConso (id);
alter table suiviDetailConso add foreign key (id_type_placement) references typeplacement (id);
alter table suiviDetailConso add foreign key (idTissus) references tissus (id);

create table etapeIntermediaire (
    id serial primary key,
    dateDebut timestamp,
    dateRecepetion timestamp,
    dateFin timestamp,
    commentaire text,
    idDClientSDCEtapeDev int,
    deadline timestamp,
    idEtapeDev int,
    etat int default 0
);
alter table etapeIntermediaire add foreign key (idDClientSDCEtapeDev) references demandeClientSDCEtapeDev (id);
create table heureTravailEmployee (
    id serial primary key,
    idListeEmploye int,
    dateEntree timestamp,
    dateSortie timestamp
);
alter table heureTravailEmployee add foreign key (idListeEmploye) references listeEmploye (id);

create table rapportMontageDev (
    id serial primary key,
    dateRecepetion timestamp,
    dateDebut timestamp,
    deadline timestamp,
    multiplicateur double precision DEFAULT 0,
    idDClientSDCEtapeDev int,
    etat int default 0
);
alter table rapportMontageDev add foreign key (idDClientSDCEtapeDev) references demandeClientSDCEtapeDev (id);

create table detailRapportMontageDev (
    id serial primary key,
    idRapportMontageDev int,
    dateFin timestamp,
    qteProduite int,
    idListeEmploye int,
    commentaire text,
    minuteProduite double precision,
    minutePresence double precision,
    efficienceDev double precision,
    multiplicateur int,
    etat int default 0
);
alter table detailRapportMontageDev add foreign key (idRapportMontageDev) references rapportMontageDev (id);
alter table detailRapportMontageDev add foreign key (idListeEmploye) references listeEmploye (id);

create table typeRetouche (
    id serial primary key,
    typeRetouche varchar(250),
    etat int default 0
);

create table controleFinalDev (
    id serial primary key,
    dateRecepetion timestamp,
    dateDebut timestamp,
    deadline timestamp,
    idDClientSDCEtapeDev int,
    etat int default 0
);
alter table controleFinalDev add foreign key (idDClientSDCEtapeDev) references demandeClientSDCEtapeDev (id);

create table detailControleFinalDev(
    id serial primary key,
    idrapportmontagedev int,
    dateFin timestamp,
    retouche boolean,
    qteControle int,
    qteRetouche int,
    qteRejet int,
    idTypeRetouche int,
    commentaire text,
    tauxRetouche double precision,
    tauxRejet double precision,
    etat int default 0
);
alter table detailControleFinalDev add foreign key (idrapportmontagedev) references controleFinalDev (id);
alter table detailControleFinalDev add foreign key (idTypeRetouche) references typeRetouche (id);


create table primePatronier(
    id serial PRIMARY key,
    point_min int DEFAULT 0,
    point_max int DEFAULT 0,
    prime double precision default 0,
    etat int DEFAULT 0
);

create table rapportFinitionDev(
    id serial primary key,
    dateRecepetion timestamp,
    dateDebut timestamp,
    deadline timestamp,
   iddclientsdcetapedev int,
    etat int default 0
);
alter table rapportFinitionDev add foreign key (iddclientsdcetapedev) references demandeClientSDCEtapeDev (id);

create table detailRapportFinitionDev(
    id serial primary key,
    idRapportFinitionDev int,
    dateFin timestamp,
    qteFini int,
    idListeEmploye int,
    commentaire text,
    minuteProduite double precision,
    minutePresence double precision,
    efficienceDev double precision,
    etat int default 0
);

alter table detailRapportFinitionDev add foreign key (idRapportFinitionDev) references rapportFinitionDev (id);
alter table detailRapportFinitionDev add foreign key (idRapportFinitionDev) references rapportFinitionDev (id);

create table transmissionDev(
    id serial primary key,
   iddclientsdcetapedev int,
    dateEnvoie timestamp,
    qteEnvoie int,
    commentaire text,
    etat int default 0
);
alter table transmissionDev add foreign key (iddclientsdcetapedev) references demandeClientSDCEtapeDev (id);

create table traceProdDev(
    id serial primary key,
    planDeCoupe text,
    etat int default 0
);

create table listeCommandeDev(
    id serial primary key,
    idDemandeClient int,
    idEtapeDev int,
    etat int default 0
);
alter table listeCommandeDev add foreign key(idDemandeClient) references demandeClient(id);
alter table listeCommandeDev add foreign key(idEtapeDev) references etapeDev(id);

-- sarobidy
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


-------------------GESTION DES EQUIPEMENTS---------------------
create table localisationMachine(
    id serial primary key,
    localisation varchar(250),
    etat int default 0
);

create table secteurMachine(
    id serial primary key,
    idLocalisationMachine int,
    secteur varchar(250),
    etat int default 0
);

create table marqueMachine(
    id serial primary key,
    marque varchar(250),
    etat int default 0
);

create table categorieMachine(
    id serial primary key,
    categorie varchar(250),
    etat int default 0
);

create table etatMachine(
    id serial primary key,
    etatMachine varchar(250),
    etat int default 0
);

create table listeMachine(
    id serial primary key,
    idMarqueMachine int,
    dateEntreeMachine date,
    codeMachine varchar(80),
    idCategorieMachine int,
    photoMachine text,
    id_Tiers_f_machine int,
    PrixU double precision,
    idUniteMonetaire int,
    idEtatMachine int,
    reference varchar(250),
    proprietee boolean,
    prixPrestation double precision default 0,
    dateSortie date default '2024-01-01',
    idUnitemesure int,
    capacite double precision,
    etat int default 0
);
alter table listeMachine add foreign key(id_Tiers_f_machine) references tiers(id);
alter table listeMachine add foreign key(idMarqueMachine) references marqueMachine(id);
alter table listeMachine add foreign key(idCategorieMachine) references categorieMachine(id);
alter table listeMachine add foreign key(idEtatMachine) references etatMachine(id);
alter table listeMachine add foreign key(idUnitemesure) references uniteMesureMatierePremiere(id);
-------------------FIN GESTION DES EQUIPEMENTS---------------------

-------------------DATA ET MACRO---------------------
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
    commentaire text
);
alter table dataProd add foreign key(idDemandeClient) references demandeClient(id);
alter table  dataProd add foreign key(id_Chaine) references chaine(id_chaine);

-- etatJourSpe int : 10,20,30
-- 100=ferié,20=dimanche,30=shift nuit

-- idListeMachine ve tena necessaire dans dataProd?


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
    etatJourSpe int,
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
    inline date,
    outline date,
    effectif int,
    efficience double precision,
    capacite double precision,
    jourProd double precision,
    heureGrmt double precision,
    besoinLoading double precision,
    idListeMachine int,
    etat int default 0,
    etatJourSpe int,
    commentaire text
);
alter table dataProd add foreign key(idDemandeClient) references demandeClient(id);
alter table dataLbt add foreign key(idListeMachine) references listeMachine(id);
--  poidsTotal double precision, = poids*qte_commande_client


create table absence(
    id serial primary key,
    dateEntree date,
    absence double precision,
    etat int default 0
);

create table macroCharge(
    id serial primary key,
    mois date,
    jourOuvrable int,
    effectif int,
    idAbsence int,
    heureTravail int default 8,
    rendement double precision,
    heureSup int,
    etat int default 0
);

CREATE TABLE jours_feries (
    id SERIAL PRIMARY KEY,
    jour SMALLINT CHECK (jour >= 1 AND jour <= 31),
    mois SMALLINT CHECK (mois >= 1 AND mois <= 12)
);

-------------------FIN DATA ET MACRO---------------------

-- NOTIA BC
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
    nbJour int,
    etat int default 0,
    etape_quantite double precision
);


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

---------------------------------------------------------RECAP COMMANDE--------------------------------------------

create table recapCommande(
    id serial primary key,
    idDemandeClient int,
    podateprev date,
    etdRevise date,
    etdPropose date,
    receptionBC date,
    bcClient text,
    date_bc_tissu date default NULL,
    date_bc_access date default NULL,
    etat int default 0
);
alter table recapCommande add foreign key(idDemandeClient) references demandeClient(id);
--alter table recapCommande add column podateprev date;

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

--------------------------etatretro
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
















