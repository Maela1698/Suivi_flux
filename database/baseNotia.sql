
/*PLANNING*/
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
    capacite_theorique double precision,
    capacitereel double precision default 0,
    qtereel double precision,
    commentaire text,
    charge double precision,
    etat int default 0
);
alter table retro_planing add foreign key(idDemandeClient) references demandeClient(id);
alter table retro_planing add foreign key(id_chaine) references chaine(id_chaine);
alter table  retro_planing add foreign key(id_data_prod) references dataProd(id);

/*---------------------------------------------------------------------VIEW RETRO PLANNING------------------------------------------------------------------*/
create or replace view v_kanban_retro_planing as(
    SELECT
        vdd.id_recap_commande,
        vdd.numerocommande,
        vdd.id_saison,
        vdd.type_saison,
        vdd.nom_client,
        vdd.nom_modele,
        vdd.id_style,
        vdd.nom_style,
        vdd.pointdev,
        vdd.theme,
        vdd.qte,
        vdd.etdrevise,
        vdd.etdinitial,
        vdd.etdpropose,
        vdd.podate,
        vdd.podateprev,
        vdd.bcclient,
        vdd.disponibilite AS disponibilite_data,
        vdd.tissu_max,
        vdd.accy_max,
        vdd.date_bc_tissu_prev,
        vdd.date_bc_tissu_reelle,
        vdd.date_bc_accy_prev,
        vdd.date_bc_accy_reelle,
        vdd.ok_prod,
        COALESCE(vdd.smv_prod,0) as smv_prod,
        COALESCE(vdd.smv_finition,0) as smv_finition,
        vdd.prix_print,
        vdd.smv_brod_main,
        vdd.nombre_points,
        vdd.dateinspection,
        vdd.destination,
        vdd.taillemin,
        vdd.taillemax,
        vdd.taille_base,
        vdd.type_incontern,
        vdd.type_phase,
        vdd.id_stade_specifique,
        vdd.designation_stade_specifique,
        vdd.types_valeur_ajoutee,
        vdd.etats_valeur_ajoutee,
        rp.id,
        rp.idDemandeClient,
        rp.id_chaine,
        rp.id_data_prod,
        rp.inlinechacun,
        rp.heuretravail,
        rp.efficience,
        rp.efficiencereel,
        rp.effectif,
        rp.capacitereel,
        COALESCE(rp.qtereel,0) AS qtereel,
        rp.commentaire,
        rp.etat,
        dp.id AS dataProdId,
        dp.disponibilite,
        dp.propositionInline,
        dp.inline,
        dp.outline,
        dp.capacite,
        dp.jourProd,
        dp.minuteGrmt,
        dp.etat AS dataProdEtat,
        dp.etatJourSpe,
        dp.commentaire AS dataProdCommentaire,
        dp.qte_coupe,
        dp.heuresup,
        c.designation AS chaineDesignation,
        c.id_chaine AS chaine_id,
        c.idConformite,
        c.etat AS chaineEtat
        FROM
        chaine c
    LEFT JOIN
        dataprod dp ON c.id_chaine = dp.id_chaine
    LEFT JOIN
        v_data_details vdd ON dp.idDemandeClient = vdd.demande_client_id
    LEFT JOIN
        retro_planing rp ON dp.id = rp.id_data_prod
);  -- Ajout de retro_planing


create table dateNonTravail(
    id serial PRIMARY KEY,
    date_changement TIMESTAMP,
    date_non_travail DATE,
    id_chaine int
);
alter table dateNonTravail add foreign key (id_chaine) references chaine(id_chaine);



/*----------------------------------------------------------------------MICRO PLANNING TABLE----------------------------------------------------------------*/
create table print_planning(
    id serial primary key,
    idDemandeClient int,
    id_data_print int,
    inlinechacun date,
    capacitetheorique double precision,
    capacitereel double precision,
    effectif double precision,
    efficience double precision default 70,
    heuretravail double precision,
    qtereel double precision,
    charge double precision,
    etat int default 0
);

create table bmc_planning(
    id serial primary key,
    idDemandeClient int,
    id_data_bmc int,
    inlinechacun date,
    capacitetheorique double precision,
    capacitereel double precision,
    capacite_par_jour double precision default 4000000,
    qtereel double precision,
    charge double precision,
    etat int default 0
);

create table bm_planning(
    id serial primary key,
    idDemandeClient int,
    id_data_bm int,
    inlinechacun date,
    capacitetheorique double precision,
    capacitereel double precision,
    effectif double precision,
    efficience double precision default 100,
    heuretravail double precision,
    qtereel double precision,
    charge double precision,
    etat int default 0
);


-- Créer une vue qui joint les tables print_planning, v_demandeClient et dataPrint
CREATE OR REPLACE VIEW v_kanban_print_planing as (
    SELECT
        pp.id AS print_planning_id,
        pp.idDemandeClient,
        pp.inlinechacun,
        pp.capacitetheorique,
        pp.capacitereel,
        pp.effectif AS print_effectif,
        pp.efficience AS print_efficience,
        pp.heuretravail,
        pp.qtereel,
        pp.charge,
        pp.etat AS print_etat,
        vdc.nom_modele,
        vdc.date_entree,
        vdc.date_livraison,
        vdc.nomtier,
        vdc.type_etat,
        dp.id AS dataPrint_id,
        dp.disponibilite,
        dp.tempsPrint,
        dp.propositionInline,
        dp.inline,
        dp.outline,
        dp.effectif AS dataPrint_effectif,
        dp.efficience AS dataPrint_efficience,
        dp.capacite,
        dp.jourProd,
        dp.minuteGrmt,
        dp.besoinLoading,
        dp.etat AS dataPrint_etat,
        dp.etatJourSpe,
        dp.commentaire,
        sm.smv_prod
    FROM
        print_planning pp
    JOIN
        v_demandeClient vdc
    ON
        pp.idDemandeClient = vdc.id
    JOIN
        dataPrint dp
    ON
        pp.idDemandeClient = dp.idDemandeClient
    JOIN
        smv sm
    ON
        pp.idDemandeClient = sm.id_demande_client
);
-- Créer une vue qui joint les tables bmc_planning, v_demandeClient et dataBrodMachine
create or replace view v_kanban_bmc_planing AS (
    select
        bmc.id as bmc_id,
        bmc.idDemandeClient,
        bmc.inlinechacun,
        bmc.capacitetheorique,
        bmc.capacitereel,
        bmc.capacite_par_jour,
        bmc.qtereel,
        bmc.charge,
        bmc.etat as bmc_etat,

        -- Colonnes de la vue v_demandeClient
        vd.id as demandeClient_id,
        vd.date_entree,
        vd.date_livraison,
        vd.nom_modele,
        vd.theme,
        vd.qte_commande_provisoire,
        vd.taille_base,
        vd.requete_client,
        vd.commentaire_merch,
        vd.photo_commande,
        vd.etat as demandeClient_etat,
        vd.id_unite_taille_min,
        vd.id_unite_taille_max,
        vd.nomtier,
        vd.id_tiers,
        vd.nom_style,
        vd.id_style,
        vd.type_incontern,
        vd.id_incontern,
        vd.type_phase,
        vd.id_phase,
        vd.type_saison,
        vd.id_saison,
        vd.tailleMin,
        vd.tailleMax,
        vd.type_stade,
        vd.id_stade,
        vd.type_etat,
        vd.periode,
        vd.id_periode,
        vd.id_etat as vd_etat,

        -- Colonnes de la table dataBrodMachine
        dbm.id as dbm_id,
        dbm.disponibilite,
        dbm.propositionInline,
        dbm.inline,
        dbm.outline,
        dbm.effectif_bmc,
        dbm.efficience,
        dbm.capacite,
        dbm.jourProd,
        dbm.heureGrmt,
        dbm.besoinLoading,
        dbm.idListeMachine,
        dbm.etat as dbm_etat,
        dbm.etatJourSpe,
        dbm.commentaire as dbm_commentaire,
        sm.nombre_points

    from
        bmc_planning bmc
        -- Joindre la vue v_demandeClient par idDemandeClient
        join v_demandeClient vd on vd.id = bmc.idDemandeClient
        -- Joindre la table dataBrodMachine par idDemandeClient
        join dataBrodMachine dbm on dbm.idDemandeClient = bmc.idDemandeClient
        -- Joindre la table smv par idDemandeClient
        join smv sm on sm.id_demande_client = bmc.idDemandeClient
);
-- Créer une vue qui joint bm_planning, v_demandeClient et dataBrodMain
create or replace view v_kanban_bm_planing AS (
    select
        -- Colonnes de la table bm_planning
        bm.id as bm_id,
        bm.idDemandeClient,
        bm.id_data_bm,
        bm.inlinechacun,
        bm.capacitetheorique,
        bm.capacitereel,
        bm.effectif,
        bm.efficience as bm_efficience,
        bm.heuretravail,
        bm.qtereel,
        bm.charge,
        bm.etat as bm_etat,

        -- Colonnes de la vue v_demandeClient
        vd.id as demandeClient_id,
        vd.date_entree,
        vd.date_livraison,
        vd.nom_modele,
        vd.theme,
        vd.qte_commande_provisoire,
        vd.taille_base,
        vd.requete_client,
        vd.commentaire_merch,
        vd.photo_commande,
        vd.etat as demandeClient_etat,
        vd.id_unite_taille_min,
        vd.id_unite_taille_max,
        vd.nomtier,
        vd.id_tiers,
        vd.nom_style,
        vd.id_style,
        vd.type_incontern,
        vd.id_incontern,
        vd.type_phase,
        vd.id_phase,
        vd.type_saison,
        vd.id_saison,
        vd.tailleMin,
        vd.tailleMax,
        vd.type_stade,
        vd.id_stade,
        vd.type_etat,
        vd.periode,
        vd.id_periode,
        vd.id_etat as vd_etat,

        -- Colonnes de la table dataBrodMain
        db.id as dbm_id,
        db.disponibilite,
        db.tempsBrod,
        db.propositionInline,
        db.inline,
        db.outline,
        db.effectif_bm,
        db.efficience as dbm_efficience,
        db.capacite,
        db.jourProd,
        db.heureGrmt,
        db.besoinLoading,
        db.etat as dbm_etat,
        db.etatJourSpe,
        db.commentaire as dbm_commentaire,
        sm.smv_brod_main

    from
        bm_planning bm
        -- Joindre la vue v_demandeClient par idDemandeClient
        join v_demandeClient vd on vd.id = bm.idDemandeClient
        -- Joindre la table dataBrodMain par idDemandeClient
        join dataBrodMain db on db.idDemandeClient = bm.idDemandeClient
        -- Joindre la table smv par idDemandeClient
        join smv sm on sm.id_demande_client = bm.idDemandeClient
);





/*------------------------------------------------------------------TRANSIT------------------------------------------------------------------*/
-- Table categorie_impexp
CREATE TABLE categorie_impexp (
    id SERIAL PRIMARY KEY,
    valeur VARCHAR(100),
    description VARCHAR(100)
);

-- Valeurs initiales
INSERT INTO categorie_impexp (valeur, description) VALUES
('import', 'import'),
('export', 'export'),
('standard', 'standard');

-- Table mode_envoi
CREATE TABLE mode_envoi (
    id SERIAL PRIMARY KEY,
    valeur VARCHAR(100),
    description VARCHAR(100)
);

-- Valeurs initiales
INSERT INTO mode_envoi (valeur, description) VALUES
('air', 'air'),
('mer', 'mer');

-- Table type_frais
CREATE TABLE type_frais (
    id SERIAL PRIMARY KEY,
    valeur VARCHAR(100),
    description VARCHAR(100)
);

-- Valeurs initiales
INSERT INTO type_frais (valeur, description) VALUES
('Charge dédouanement', 'Charge dédouanement'),
('Frais douane', 'Frais douane'),
('Frais arrivage', 'Frais arrivage');

-- Table devises
CREATE TABLE devises (
    id SERIAL PRIMARY KEY,
    valeur VARCHAR(100),
    description VARCHAR(100)
);

-- Table cours_devises
CREATE TABLE cours_devises (
    id SERIAL PRIMARY KEY,
    iddevises INTEGER REFERENCES devises(id),
    montant DOUBLE PRECISION,
    datedevise DATE
);

-- Table frais_divers
CREATE TABLE frais_divers (
    id SERIAL PRIMARY KEY,
    valeur varchar(100),
    description TEXT,
    idcoursdevises INTEGER REFERENCES cours_devises(id),
    idtypefrais INTEGER REFERENCES type_frais(id),
    idcategorie_impexp INTEGER REFERENCES categorie_impexp(id),
    idmodeenvoi INTEGER REFERENCES mode_envoi(id)
);

CREATE TABLE frais_divers_impexp (
    id SERIAL PRIMARY KEY,
    idfradivers integer references frais_divers(id),
    idimpexp integer,
    montant double precision,
    daty date
);

-- Table transitaire
CREATE TABLE transitaire (
    id SERIAL PRIMARY KEY,
    valeur VARCHAR(100),
    description VARCHAR(100)
);

-- Table origine_destination
CREATE TABLE origine_destination (
    id SERIAL PRIMARY KEY,
    valeur VARCHAR(100),
    description VARCHAR(100)
);

-- Table import
CREATE TABLE import (
    id SERIAL PRIMARY KEY,
    idbc INTEGER,
    idfournisseur INTEGER REFERENCES tiers(id),
    idtransitaire INTEGER REFERENCES transitaire(id),
    idmodeenvoi INTEGER REFERENCES mode_envoi(id),
    iddemandeclient INTEGER REFERENCES demandeclient(id),
    designation VARCHAR(100),
    etat INTEGER,
    nbre_prev DOUBLE PRECISION,
    nbre_reel DOUBLE PRECISION,
    qte_tissu_prev DOUBLE PRECISION,
    qte_tissu_reel DOUBLE PRECISION,
    poids_prev DOUBLE PRECISION,
    poids_reel DOUBLE PRECISION,
    volume_prev DOUBLE PRECISION,
    volume_reel DOUBLE PRECISION,
    idorigine INTEGER REFERENCES origine_destination(id),
    incote_rm VARCHAR(50),
    edt_prev DATE,
    edt_reel DATE,
    transit_time DOUBLE PRECISION,
    eta_tmm_prev DATE,
    eta_tmm_reel DATE,
    temps_dedouanement DOUBLE PRECISION,
    eta_usine_prev DATE,
    eta_usine_reel DATE,
    deadline_usine DATE,
    observation TEXT
);

-- Table facturation_import
CREATE TABLE facturation_import (
    id SERIAL PRIMARY KEY,
    idimport INTEGER REFERENCES import(id),
    designation VARCHAR(100),
    numero_facture_transitaires VARCHAR(100),
    date_de_factures DATE,
    montant_facture_htva DOUBLE PRECISION,
    tva DOUBLE PRECISION
);

-- Table import_details
CREATE TABLE import_details (
    id SERIAL PRIMARY KEY,
    idimport INTEGER REFERENCES import(id),
    idmatierepremiere INTEGER,
    quantite DOUBLE PRECISION,
    unite VARCHAR(50)
);

-- Table export
CREATE TABLE export (
    id SERIAL PRIMARY KEY,
    id_demandeclient INTEGER REFERENCES demandeclient(id),
    id_origine INTEGER REFERENCES origine_destination(id),
    idtransitaire INTEGER REFERENCES transitaire(id),
    idmodeenvoi INTEGER REFERENCES mode_envoi(id),
    rayon VARCHAR(50),
    quantite_pcs_reelle INTEGER,
    date_ot_merch DATE,
    date_booking DATE,
    date_booking_final DATE,
    ex_usine_prev DATE,
    ex_usine_revisee DATE,
    ex_usine_reel DATE,
    pl_prev DATE,
    pl_final DATE,
    dom DATE,
    envoi_doc_client DATE,
    envoi_doc_compta DATE,
    num_declaration VARCHAR(50),
    date_declaration DATE,
    num_facture VARCHAR(50),
    date_facture DATE,
    nombre_de_colis INTEGER,
    volume_en_cbm DOUBLE PRECISION,
    poids_en_kg DOUBLE PRECISION,
    tc_lta VARCHAR(50),
    vessel_vol_name VARCHAR(50),
    hbl_flb_hawb VARCHAR(50),
    reception_bl_original DATE,
    reception_facture DATE,
    reception_paiement DATE,
    date_telex_release DATE,
    envoi_telex_client DATE,
    customer_ref VARCHAR(50),
    observations VARCHAR(255),
    etat INTEGER
);

-- Table facturation_export
CREATE TABLE facturation_export (
    id SERIAL PRIMARY KEY,
    idexport INTEGER REFERENCES export(id),
    designation VARCHAR(100),
    numero_facture_transitaires VARCHAR(100),
    date_de_factures DATE,
    montant_facture_htva DOUBLE PRECISION,
    tva DOUBLE PRECISION
);

-- Table export_details
CREATE TABLE export_details (
    id SERIAL PRIMARY KEY,
    idexport INTEGER REFERENCES export(id),
    designation VARCHAR(100),
    quantite DOUBLE PRECISION,
    unite VARCHAR(50)
);

-- Table etatsituationimpexp
CREATE TABLE etatsituationimpexp (
    id SERIAL PRIMARY KEY,
    idcategorie_impexp INTEGER REFERENCES categorie_impexp(id),
    rang INTEGER,
    designation VARCHAR(100),
    etat INTEGER
);

-- Table historiquesuiviimpexp
CREATE TABLE historiquesuiviimpexp (
    id SERIAL PRIMARY KEY,
    idimpexp INTEGER,
    designation VARCHAR(100),
    etat INTEGER,
    daty DATE
);

-- Table apurement
CREATE TABLE apurement (
    id SERIAL PRIMARY KEY,
    idimportdetails INTEGER REFERENCES import_details(id),
    im8_num VARCHAR(100),
    im8_date DATE,
    im5_num VARCHAR(100),
    im5_date DATE,
    designation VARCHAR(100),
    nomenclature VARCHAR(100),
    valeurfobunitaire DOUBLE PRECISION
);

-- Table apurement_details
CREATE TABLE apurement_details (
    id SERIAL PRIMARY KEY,
    idapurement INTEGER REFERENCES apurement(id),
    designation VARCHAR(100),
    imputees DOUBLE PRECISION,
    unite VARCHAR(10),
    quantite_restante DOUBLE PRECISION,
    date_qr DATE,
    xts_finis INTEGER,
    xts_finis_annexe VARCHAR(10),
    nomenclature VARCHAR(100),
    production_numero VARCHAR(100),
    production_date DATE,
    observations TEXT
);
