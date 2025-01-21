create table etapeSerigraphie (
    id serial PRIMARY KEY,
    etapeSer VARCHAR(55),
    dureeEtape int,
    dureeChangementProd int,
    dureeOkProd int,
    niveauEtape int,
    etat int DEFAULT 0
);

CREATE TABLE valeurajouteedemande
(
    id serial PRIMARY KEY,
    id_demande_client int,
    id_valeur_ajoutee int,
    etat int DEFAULT 0
);
alter table valeurajouteedemande add foreign key (id_demande_client) references demandeclient (id);
alter table valeurajouteedemande add foreign key (id_valeur_ajoutee) references valeurajoutee (id);



create table demandeclientSerigraphie (
    id serial PRIMARY KEY,
    id_demande_client int,
    id_sdc int,
    date_entree TIMESTAMP,
    etat int DEFAULT 0,
    etat_achat_encre_echan int DEFAULT 0,
    etat_apro_produit_chimique int DEFAULT 0,
    etat_pri int DEFAULT 0,
    etat_impression_dession int DEFAULT 0,
    etat_recher_coloris_validaint int DEFAULT 0,
    etat_insolacadre int DEFAULT 0,
    etat_raclage int DEFAULT 0,
    etat_achat_encre_prod int DEFAULT 0,
    etat_gabarits int DEFAULT 0,
    etat_prepa_table int DEFAULT 0,
    etat_prepa_encre_prod int DEFAULT 0
);

alter table demandeclientSerigraphie
add foreign key (id_demande_client) references demandeclient (id);

alter table demandeclientSerigraphie
add foreign key (id_sdc) references sdc (id);


create table suiviFluxSerigraphie (
    id serial PRIMARY KEY,
    id_demande_client int,
    date_operation TIMESTAMP,
    type_flux int,
    etat int DEFAULT 0
);
alter table suiviFluxSerigraphie
add foreign key (id_demande_client) references demandeclient (id);

create table detailSuiviFluxSerigraphie(
    id serial PRIMARY KEY,
    id_suivi_flux int,
    unite_taille VARCHAR(255),
    qte int,
    recoupe double precision,
    etat int DEFAULT 0
);

alter table detailSuiviFluxSerigraphie
add foreign key (id_suivi_flux) references suiviFluxSerigraphie (id);

create table rapportJournalier (
    id serial primary KEY,
    date_pro TIMESTAMP,
    taux_retouche DOUBLE precision,
    taux_rejet DOUBLE precision,
    produit_chmique double precision,
    valeur double precision,
    electricite double precision,
    reclam_loading double precision,
    nc_traite double precision,
    absenteisme double precision,
    commentaire text,
    nb_operateur int,
    id_demande_client int,
    etat int DEFAULT 0
);

alter table rapportJournalier
add foreign key (id_demande_client) references demandeclient (id);

create table detailRapportJournalier (
    id serial PRIMARY KEY,
    id_rapport_journalier int,
    heure int,
    qte int,
    etat int
);

alter table detailRapportJournalier
add foreign key (id_rapport_journalier) references rapportJournalier (id);



create table typeEncre (
    id serial PRIMARY KEY,
    type_encre VARCHAR(255),
    etat int DEFAULT 0
);

create table encre (
    id serial PRIMARY KEY,
    encre VARCHAR(255),
    etat int DEFAULT 0
);

create table parametreSer (
    id serial PRIMARY KEY,
    smv_print double precision,
    qte_coupe double precision,
    etat int DEFAULT 0,
    prix_print double precision default 0,
    id_demande_client int
);

alter table parametreSer
add foreign key (id_demande_client) references demandeclient (id);

create table detailParametreSer (
    id serial PRIMARY KEY,
    id_parametre_ser int,
    id_type_encre int,
    id_encre int,
    grammage double precision,
    couche VARCHAR(255),
    etat int DEFAULT 0
);

alter table detailParametreSer
add foreign key (id_type_encre) references typeEncre (id);

alter table detailParametreSer
add foreign key (id_encre) references encre (id);

alter table detailParametreSer
add foreign key (id_parametre_ser) references parametreSer (id);

create table planningDemandeSer(
    id serial PRIMARY KEY,
    id_demande_ser int,
    deadline TIMESTAMP,
    fin TIMESTAMP,
    id_etape int
);
alter table planningDemandeSer add foreign key (id_demande_ser) references demandeclientSerigraphie (id);
alter table planningDemandeSer add foreign key (id_etape) references etapeSerigraphie (id);



-- Broad machine 22/10
create table etapeBroadMachine(
    id serial PRIMARY KEY,
    etape_broad_machine VARCHAR(255),
    duree_etape int,
    duree_change_stade int,
    duree_ok_prod int,
    etat int DEFAULT 0
);
insert into etapeBroadMachine(etape_broad_machine,duree) VALUES ('',);
create table demandeClientBroadMachine(
    id serial PRIMARY KEY,
    id_demande_client int,
    id_sdc int,
    dateentree_broadmachine TIMESTAMP,
    etat_apro_produit_chimique int default 0,
    etat_pesage int default 0,
    etat_lavage_blanc_teint int default 0,
    etat_test_shrinkage int default 0,
    etat_pri int default 0,
    etat int DEFAULT 0
);
alter table demandeClientBroadMachine add foreign key (id_demande_client) references demandeclient (id);
alter table demandeClientBroadMachine add foreign key (id_sdc) references sdc (id);

create table etapeBrodMain(
    id serial PRIMARY KEY,
    etape_brod_main VARCHAR(255),
    etat int DEFAULT 0,
    duree int,
    duree_change_sdc int,
    duree_prod int
);


create table demandeClientBrodMain(
    id serial PRIMARY key,
    id_demande_client int,
    id_sdc int,
    dateentree_broadmain TIMESTAMP,
    type int DEFAULT 0,
    etat_appro_mp int DEFAULT 0,
    etat_plis_tissu int DEFAULT 0,
    etat_dessin int DEFAULT 0,
    etat_poncage int DEFAULT 0,
    etat_developpement int DEFAULT 0,
    etat int DEFAULT 0
);
alter table demandeClientBrodMain add foreign key (id_demande_client) references demandeclient (id);

create table consoFilBrodMain(
    id serial PRIMARY KEY,
    nb_heure double precision,
    prix double precision,
    id_unite_monetaire int,
    id_demande_client int,
    etat int DEFAULT 0
);
alter table consoFilBrodMain add foreign key (id_demande_client) references demandeclient (id);
alter table consoFilBrodMain add foreign key (id_unite_monetaire) references unitemonetaire (id);

create table detailConsoFilBrodMain(
    id serial PRIMARY KEY,
    id_conso int,
    couleur VARCHAR(255),
    conso double precision,
    etat int DEFAULT 0
);
alter table detailConsoFilBrodMain add foreign key (id_conso) references consoFilBrodMain (id);

create table suiviFluxBrodMain(
    id serial PRIMARY KEY,
    id_demande_client int,
    date_operation TIMESTAMP,
    type_flux int,
    qte double precision,
    recoupe double precision,
    etat int DEFAULT 0
);
alter table suiviFluxBrodMain add foreign key (id_demande_client) references demandeclient (id);

create table rapportJournalierBrodMain(
    id serial PRIMARY KEY,
    id_demande_client int,
    date_rapport TIMESTAMP,
    conso_electricite double precision,
    valeur_electricite double precision,
    nb_lancement double precision,
    nc_traite double precision,
    taux_rejet double precision,
    taux_retouche double precision,
    absenteisme int,
    nb_operateur int,
    commentaire text,
    etat int DEFAULT 0
);
alter table rapportJournalierBrodMain add foreign key (id_demande_client) references demandeclient (id);

create table detailRapportJournalierBrodMain (
    id serial PRIMARY KEY,
    id_rapport_journalier_brodmain int,
    heure int,
    qte int,
    etat int
);
alter table detailRapportJournalierBrodMain add foreign key (id_rapport_journalier_brodmain) references rapportJournalierBrodMain (id);




create table planningDemandeBrodMain(
    id serial PRIMARY KEY,
    id_demande_client  int,
    deadline TIMESTAMP,
    fin TIMESTAMP,
    id_etape int
);
alter table planningDemandeBrodMain add foreign key (id_demande_client ) references demandeClient(id);
alter table planningDemandeBrodMain add foreign key (id_etape) references etapeBrodMain (id);

create table notification(
    id serial PRIMARY key,
    id_demande int,
    dateentree TIMESTAMP,
    etat int DEFAULT 0,
    message text
);
alter table notification add foreign key (id_demande) references demandeclient (id);
create or replace view v_notification as
select notification.*,
v_demandeclient.nom_modele,
v_demandeclient.nomtier,
v_demandeclient.id_tiers,
v_demandeclient.qte_commande_provisoire,
v_demandeclient.nom_style,
v_demandeclient.id_style,
v_demandeclient.theme,
v_demandeclient.id_saison,
v_demandeclient.type_saison
from notification
join v_demandeclient on v_demandeclient.id = notification.id_demande;


-- LBT
create table parametreLavage(
    id serial PRIMARY KEY,
    date_parametre TIMESTAMP,
    id_demande_client int,
    poids_passe double precision,
    poids_unitaire double precision,
    temps_passe_estime double precision,
    temps_passe_reel double precision,
    conso_total_eau double precision,
    commentaire text,
    prix_lavage double precision,
    etat int DEFAULT 0
);
alter table parametreLavage add foreign key (id_demande_client) references demandeclient (id);



create table fichierParametreLavage(
    id serial PRIMARY key,
    id_parametre_lavage int,
    nom_fichier VARCHAR(255),
    fichier text,
    etat int
);
alter table fichierParametreLavage add foreign key (id_parametre_lavage) references parametreLavage (id);

create table parametreBlanchissement(
    id serial PRIMARY KEY,
    date_parametre TIMESTAMP,
    id_demande_client int,
    nb_panneaux double precision,
    poids_unitaire double precision,
    poids_passe double precision,
    option_valeur int,
    prix_blanchissement double precision,
    commentaire text,
    etat int DEFAULT 0
);
alter table parametreBlanchissement add foreign key (id_demande_client) references demandeclient (id);




create table fichierParametreBlanchissement(
    id serial PRIMARY KEY,
    id_parametre_blanchissement int,
    nom_fichier VARCHAR(255),
    fichier text,
    etat int DEFAULT 0
);
alter table fichierParametreBlanchissement add foreign key (id_parametre_blanchissement) references parametreBlanchissement (id);

create table parametreTeinture(
    id serial primary key,
    date_parametre TIMESTAMP,
    id_demande_client int,
    couleur VARCHAR(255),
    nb_panneaux double precision,
    poids_unitaire double precision,
    poids_passe double precision,
    prix_teinture double precision,
    commentaire text,
    etat int DEFAULT 0
);
alter table parametreTeinture add foreign key (id_demande_client) references demandeclient (id);




create table fichierParametreTeinture(
    id serial PRIMARY KEY,
    id_parametre_teinture int,
    nom_fichier VARCHAR(255),
    fichier text,
    etat int DEFAULT 0
);
alter table fichierParametreTeinture add foreign key (id_parametre_teinture) references parametreTeinture (id);

create table suiviFluxLBT(
    id serial primary key,
    date_operation TIMESTAMP,
    id_demande_client int,
    type_piece int,
    type_action int,
    quantite double precision,
    type_lbt int,
    recoupe double precision,
    etat int DEFAULT 0
);
alter table suiviFluxLBT add foreign key (id_demande_client) references demandeclient (id);




create table smvBmc(
    id serial PRIMARY KEY,
    titre VARCHAR(255),
    temps double precision,
    etat int DEFAULT 0
);

insert into smvBmc(titre,temps) values ('POSE SCOTCH',5);
insert into smvBmc(titre,temps) values ('TROUAGE',10);
insert into smvBmc(titre,temps) values ('TRACAGE GABARIT',10);
insert into smvBmc(titre,temps) values ('ENFILAGE (CANETTE)',10);
insert into smvBmc(titre,temps) values ('POSE VISELINE',0.08);
insert into smvBmc(titre,temps) values ('POSE PIECE SUR MACHINE',0.13);
insert into smvBmc(titre,temps) values ('BRODER (TEMPS MACHINE)',0.25);
insert into smvBmc(titre,temps) values ('ENLEVER PIECES',0.04);
insert into smvBmc(titre,temps) values ('TEMPS NETTOYAGE',0.5);
insert into smvBmc(titre,temps) values ('TEMPS GARNISSAGE',0.5);

create table nombrePoints(
    id serial PRIMARY KEY,
    id_demande_client int,
    smv double precision,
    temps_machine double precision,
    temps_nettoyage double precision,
    temps_garnissage double precision,
    somme_nb_points double precision,
    etat int DEFAULT 0
);
alter table nombrePoints add foreign key (id_demande_client) references demandeclient (id);

create table detailNombrePoints(
    id serial PRIMARY KEY,
    id_nb_points int,
    taille VARCHAR(50),
    quantite double precision,
    nombre_points double precision,
    etat int DEFAULT 0
);
alter table detailNombrePoints add foreign key (id_nb_points) references nombrePoints (id);

create table suiviFluxBrodMachine(
    id serial PRIMARY KEY,
    id_demande_client int,
    date_operation TIMESTAMP,
    quantite DOUBLE precision,
    recoupe double precision,
    type_flux int,
    etat int default 0
);
alter table nombrePoints add foreign key (id_demande_client) references demandeclient (id);

create table rapportJournalierLavage(
    id serial primary key,
    date_rapport TIMESTAMP,
    prix_unitaire_gasoil double precision,
    conso_gasoil double precision,
    conso_produit_chimique double precision,
    valeur_produit_chimique double precision,
    conso_electrique double precision,
    prix_kwh double precision,
    taux_retouche double precision,
    taux_rejet double precision,
    nc_traites double precision,
    absenteisme double precision,
    commentaire text,
    nb_piece_lave int,
    type_lavage VARCHAR(50),
    etat int DEFAULT 0
);

create table rapportJournalierTeintureProd(
    id serial primary key,
    dateRapport TIMESTAMP,
    teinte int,
    nombre_panneau int,
    nb_rejet_panneau int,
    nb_retouche_panneau int,
    conso_gasoil DOUBLE precision,
    prix_unitaire_gasoil double precision,
    conso_produit_chimique double precision,
    prix_unitaire_produit_chimique double precision,
    conso_electrique double precision,
    prix_kwh double precision,
    etat int DEFAULT 0,
    type_teinture_prod int,
    commentaire text,
    type_lbt VARCHAR(50)
);

create table rapportJournalierTeintureDev(
    id serial PRIMARY KEY,
    dateRapport TIMESTAMP,
    nb_couleur_recherche int,
    nb_couleur_realise int,
    nb_tentative int,
    conso_produit_chimique double precision,
    valeur_produit_chimique double precision,
    taux_rejet double precision,
    taux_retouche double precision,
    etat int DEFAULT 0,
    type_lbt VARCHAR(50),
    type_teinture_dev int,
    commentaire text
);

create or replace view v_rapportJournalierLavage as
select rapportJournalierLavage.*,
rapportJournalierLavage.conso_gasoil*rapportJournalierLavage.prix_unitaire_gasoil as valeur_gasoil,
rapportJournalierLavage.conso_electrique*rapportJournalierLavage.prix_kwh as valeur_electricite
from rapportJournalierLavage;
CREATE VIEW v_rapportJournalierLavage AS
SELECT
    r.id,
    r.date_rapport,
    r.prix_unitaire_gasoil,
    r.conso_gasoil,
    r.conso_produit_chimique,
    r.valeur_produit_chimique,
    r.conso_electrique,
    r.prix_kwh,
    r.taux_retouche,
    r.taux_rejet,
    r.nc_traites,
    r.absenteisme,
    r.commentaire,
    r.nb_piece_lave,
    r.type_lavage,
    r.etat,
    CASE
        WHEN r.type_lavage = 'Lavage' THEN COALESCE(sum(pl.poids_unitaire), 0) * r.nb_piece_lave
        WHEN r.type_lavage = 'Blanchissement' THEN COALESCE(sum(pb.poids_unitaire), 0) * r.nb_piece_lave
        ELSE 0
    END AS PoidsProduite
FROM
    rapportjournalierlavage r
LEFT JOIN
    parametrelavage pl
ON
    DATE(r.date_rapport) = DATE(pl.date_parametre)
LEFT JOIN
    parametreblanchissement pb
ON
    DATE(r.date_rapport) = DATE(pb.date_parametre)
    GROUP BY
    r.id, r.date_rapport, r.prix_unitaire_gasoil, r.conso_gasoil, r.conso_produit_chimique,
    r.valeur_produit_chimique, r.conso_electrique, r.prix_kwh, r.taux_retouche, r.taux_rejet,
    r.nc_traites, r.absenteisme, r.commentaire, r.nb_piece_lave, r.type_lavage, r.etat;



create or replace view v_rapportJournalierTeintureProd as
select rapportJournalierTeintureProd.*,
rapportJournalierTeintureProd.conso_gasoil*rapportJournalierTeintureProd.prix_unitaire_gasoil as valeur_gasoil,
rapportJournalierTeintureProd.conso_produit_chimique*rapportJournalierTeintureProd.prix_unitaire_produit_chimique as valeur_produit_chimique,
rapportJournalierTeintureProd.conso_electrique*rapportJournalierTeintureProd.prix_kwh as valeur_electricite,
(rapportJournalierTeintureProd.nb_retouche_panneau/rapportJournalierTeintureProd.nombre_panneau )/100 as taux_retouche,
(rapportJournalierTeintureProd.nb_rejet_panneau*rapportJournalierTeintureProd.nombre_panneau)/100 as taux_rejet,
COALESCE(sum(parametreteinture.poids_unitaire),0) *rapportJournalierTeintureProd.nombre_panneau as PoidsProduite
from rapportJournalierTeintureProd
left join parametreteinture
on DATE(parametreteinture.date_parametre) = DATE(rapportJournalierTeintureProd.daterapport)
group by rapportJournalierTeintureProd.id,rapportJournalierTeintureProd.daterapport,rapportJournalierTeintureProd.teinte,rapportJournalierTeintureProd.nombre_panneau,rapportJournalierTeintureProd.nb_rejet_panneau,
rapportJournalierTeintureProd.nb_retouche_panneau,rapportJournalierTeintureProd.conso_gasoil,rapportJournalierTeintureProd.prix_unitaire_gasoil,rapportJournalierTeintureProd.conso_produit_chimique,
rapportJournalierTeintureProd.prix_unitaire_produit_chimique,rapportJournalierTeintureProd.conso_electrique,rapportJournalierTeintureProd.prix_kwh,rapportJournalierTeintureProd.etat,
rapportJournalierTeintureProd.type_teinture_prod,rapportJournalierTeintureProd.commentaire,rapportJournalierTeintureProd.type_lbt;


create or replace view v_rapportJournalierTeintureDev as
select rapportJournalierTeintureDev.*,
((rapportJournalierTeintureDev.nb_tentative-rapportJournalierTeintureDev.nb_couleur_realise)/rapportJournalierTeintureDev.nb_couleur_realise) * 100 as taux_echec
from rapportJournalierTeintureDev;



create table demandeClientLBT(
    id serial PRIMARY KEY,
    id_demande_client int,
    id_sdc int,
    dateentree_lbt TIMESTAMP,
    qte double precision,
    type_lbt VARCHAR(55),
    etat_apro_produit_chimique int default 0,
    etat_pesage int default 0,
    etat_lavage_blanc_teint int default 0,
    etat_test_shrinkage int default 0,
    etat_pri int default 0,
    etat int DEFAULT 0
);
alter table demandeClientLBT add foreign key (id_demande_client) references demandeclient (id);
alter table demandeClientLBT add foreign key (id_sdc) references sdc (id);


create or replace view v_demandeClientLBT as
select demandeClientLBT.*,
v_sdc.stadesdc,
v_sdc.id_stade_demande_client,
v_demandeclient.date_entree,
v_demandeclient.date_livraison,
v_demandeclient.nom_modele,
v_demandeclient.theme,
v_demandeclient.qte_commande_provisoire,
v_demandeclient.nomtier,
v_demandeclient.id_tiers,
v_demandeclient.nom_style,
v_demandeclient.id_style,
v_demandeclient.type_phase,
v_demandeclient.id_phase,
v_demandeclient.type_saison,
v_demandeclient.id_saison,
v_demandeclient.type_stade,
v_demandeclient.id_stade,
v_demandeclient.type_etat,
v_demandeclient.id_etat
from demandeClientLBT
left join v_sdc on v_sdc.id = demandeClientLBT.id_sdc
join v_demandeclient on v_demandeclient.id = demandeClientLBT.id_demande_client;




 SELECT DISTINCT ON (id_demande_client) id_demande_client, id_sdc,stadesdc,etat,date_entree,id,
        nom_modele,theme,nomtier,id_tiers,nom_style,id_style,type_saison,id_saison,type_stade,
        etat_apro_produit_chimique,etat_pesage,etat_lavage_blanc_teint,etat_test_shrinkage,etat_pri,qte,type_lbt
        FROM v_demandeClientLBT
        ORDER BY id_demande_client,id_sdc,etat,date_entree,nom_modele,
        theme,nomtier,id_tiers,nom_style,id_style,type_saison,id_saison,type_stade,
         etat_apro_produit_chimique,etat_pesage,etat_lavage_blanc_teint,etat_test_shrinkage,etat_pri,qte,type_lbt,
        id asc


-- create table modal(
--     id serial primary key,
--     designation VARCHAR(255),
--     modal text
-- );
-- insert into modal(designation,modal) VALUES('des1',
-- '
--  <div class="modal fade" id="finMontage" tabindex="-1" role="dialog"
--             aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
--             <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
--                 <div class="modal-content">
--                     <div class="modal-header">
--                         <h5 class="modal-title" id="choixEtapeModalLabel">Rapport montage</h5>
--                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
--                             <span aria-hidden="true">&times;</span>
--                         </button>
--                     </div>
--                     <div class="modal-body">
--                       <form action=""{{ route(''DEV.acheverMontage'') }}"" method=""POST"" autocomplete=""off"">
--                             @csrf
--                             <div class="row">
--                                 <div class="col-6">
--                                     <div class="row no-gutters">
--                                         <div class="col-12">
--                                             <input type="hidden" id="etapeIdMontage" name="idDCSdcEtapeDev">
--                                             <label class="col-form-label texte">Date fin</label>
--                                         </div>
--                                         <div class="col-12">
--                                             <input type="datetime-local" name="dateFin" class="form-control"
--                                                 required>
--                                         </div>
--                                     </div>
--                                 </div>

--                                 <div class="col-6">
--                                     <div class="row no-gutters">
--                                         <div class="col-12">
--                                             <label class="col-form-label texte">Multiplicateur</label>
--                                         </div>
--                                         <div class="col-12">
--                                             <input type="text" name="multiplicateur" class="form-control"
--                                                 required>
--                                         </div>
--                                     </div>
--                                 </div>
--                             </div>


--                             <div class="row no-gutters mt-3">
--                                 <div class="col-12">
--                                     <label class="col-form-label texte">Commentaire</label>
--                                 </div>
--                                 <div class="col-12">
--                                     <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
--                                 </div>
--                             </div>

--                             <div class="row no-gutters">
--                                 <div class="col-12">
--                                     <label class="col-form-label texte">Employé</label>
--                                 </div>
--                                 <div class="col-7 mr-1">
--                                     <select name="employe[]" class="form-control" required>
--                                         @for ($empMont = 0; $empMont < count($employeMontage); $empMont++)
--                                             <option value="{{ $employeMontage[$empMont]->id }}">
--                                                 {{ $employeMontage[$empMont]->nom }}
--                                                 {{ $employeMontage[$empMont]->prenom }}</option>
--                                         @endfor
--                                     </select>
--                                 </div>
--                                 <div class="col-2 mr-1">
--                                     <input type="number" class="form-control" name="quantite[]"
--                                         placeholder="quantite" required>
--                                 </div>
--                                 <div class="col-2">
--                                     <button type="button" class="btn btn-success"
--                                         onclick="addSelect()">+</button>
--                                 </div>
--                             </div>

--                             <div id="select-container"></div>

--                             <div class="row no-gutters mt-4">
--                                 <div class="col-12">
--                                     <label class="col-form-label texte">Choix etape suivante</label>
--                                 </div>
--                                 <div class="col-12">
--                                     <select class="form-control" name="etapeDEV" required>
--                                         <option value="">Etape suivante</option>
--                                         @for ($etM = 0; $etM < count($etapeAfterMontage); $etM++)
--                                             <option value="{{ $etapeAfterMontage[$etM]->id }}">
--                                                 {{ $etapeAfterMontage[$etM]->etape }}
--                                             </option>
--                                         @endfor
--                                     </select>
--                                 </div>
--                             </div>

--                             <div class="modal-footer mt-3">
--                                 <button type="button" class="btn btn-secondary"
--                                     data-dismiss="modal">Annuler</button>
--                                 <button type="submit" class="btn btn-success">Achever</button>
--                             </div>
--                         </form>
--                     </div>
--                 </div>
--             </div>
--         </div>
-- ');


create table typeVamm(
    id serial PRIMARY key,
    type_vamm VARCHAR(30),
    etat int DEFAULT 0
);

insert into typeVamm(type_vamm) VALUES ('Serigraphie');
insert into typeVamm(type_vamm) VALUES ('LBT');
insert into typeVamm(type_vamm) VALUES ('Broderie main');
insert into typeVamm(type_vamm) VALUES ('Broderie machine');

create table typeDefautVamm(
    id serial primary KEY,
    id_type_vamm int,
    valeur VARCHAR(100),
    etat int DEFAULT 0
);
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (1,'Tache');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (1,'Decalage');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (1,'Decadrage');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (1,'Defaut de presse');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (1,'Autres');

insert into typeDefautVamm(id_type_vamm,valeur) VALUES (2,'Couture saute');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (2,'Couture casse');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (2,'Couture echappee');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (2,'Tache');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (2,'Trous');

insert into typeDefautVamm(id_type_vamm,valeur) VALUES (3,'Dimension ecriture');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (3,'Ecriture irregulier');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (3,'Dimension bande');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (3,'Manque point');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (3,'Fausse mesure');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (3,'Dimension zig zag');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (3,'Dimension carreaux');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (3,'Fixation oublie');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (4,'Point saute');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (4,'Point casse');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (4,'Decalage');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (4,'Point de manque');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (4,'Point apparent');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (4,'Bourage');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (4,'Tirayure');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (4,'Point lache');
insert into typeDefautVamm(id_type_vamm,valeur) VALUES (4,'Faux plis');


create table inspectionVamm(
    id serial primary key,
    id_demande_client int,
    date_inspection DATE,
    nombre_inspecter int,
    etat int DEFAULT 0
);
alter table inspectionVamm add foreign key (id_demande_client) references demandeclient (id);

create table detailInspectionVamm(
    id serial primary key,
    id_inspection_vamm int,
    id_type_defaut int,
    nombre_defaut int,
    etat int DEFAULT 0
);
alter table detailInspectionVamm add foreign key (id_inspection_vamm) references inspectionVamm (id);
alter table detailInspectionVamm add foreign key (id_type_defaut) references typeDefautVamm (id);

create or replace view v_inspectionVammDetail as
select inspectionVamm.*,
detailInspectionVamm.id_type_defaut,
typeDefautVamm.id_type_vamm,
v_demandeclient.nom_modele,
v_demandeclient.nomtier,
v_demandeclient.id_tiers,
v_demandeclient.id_saison
from inspectionVamm
join detailInspectionVamm on detailInspectionVamm.id_inspection_vamm = inspectionVamm.id
join v_demandeclient on v_demandeclient.id = inspectionVamm.id_demande_client
join typeDefautVamm on typeDefautVamm.id = detailInspectionVamm.id_type_defaut;

create or replace view v_inspectionVammByTypeVamm as
select distinct(id_type_vamm),id,id_demande_client,nombre_inspecter,date_inspection,nom_modele,id_tiers,id_saison
from v_inspectionVammDetail;

create or replace view calculNombreInspectionVamm as
select  sum(nombre_inspecter) as nombreInspection, id_demande_client, id_type_vamm,date_inspection,nom_modele,id_tiers,id_saison
from v_inspectionVammByTypeVamm
GROUP BY id_demande_client, id_type_vamm,date_inspection,nom_modele,id_tiers,id_saison;

CREATE OR REPLACE VIEW v_inspectionVamm AS
SELECT
    inspectionVamm.*,
    typeDefautVamm.id_type_vamm,
    v_demandeclient.nom_modele,
    v_demandeclient.nomtier,
    v_demandeclient.id_tiers,
    v_demandeclient.qte_commande_provisoire,
    v_demandeclient.nom_style,
    v_demandeclient.id_style,
    v_demandeclient.theme,
    v_demandeclient.id_saison,
    v_demandeclient.type_saison,
    v_demandeclient.type_stade,
    v_demandeclient.id_stade
    SUM((detailInspectionVamm.nombre_defaut * 100.0) / inspectionVamm.nombre_inspecter) AS taux_retouche
FROM
    inspectionVamm
JOIN
    detailInspectionVamm ON detailInspectionVamm.id_inspection_vamm = inspectionVamm.id
JOIN
    typeDefautVamm ON typeDefautVamm.id = detailInspectionVamm.id_type_defaut
JOIN
    v_demandeclient ON v_demandeclient.id = inspectionVamm.id_demande_client
GROUP BY
    inspectionVamm.id,
    inspectionVamm.id_demande_client,
    inspectionVamm.nombre_inspecter,
    inspectionVamm.etat,
    typeDefautVamm.id_type_vamm,
    v_demandeclient.nom_modele,
    v_demandeclient.nomtier,
    v_demandeclient.id_tiers,
    v_demandeclient.qte_commande_provisoire,
    v_demandeclient.nom_style,
    v_demandeclient.id_style,
    v_demandeclient.theme,
    v_demandeclient.id_saison,
    v_demandeclient.type_saison,
    v_demandeclient.type_stade,
    v_demandeclient.id_stade;

create or replace view v_detailInspectionVamm as
select detailinspectionvamm.*,
typeDefautVamm.valeur,
typeVamm.type_vamm,
typeVamm.id as id_type_vamm
from detailinspectionvamm
join typeDefautVamm on typeDefautVamm.id = detailinspectionvamm.id_type_defaut
join typeVamm on typeVamm.id = typeDefautVamm.id_type_vamm;




create table dateNonTravail(
    id serial PRIMARY KEY,
    date_changement TIMESTAMP,
    date_non_travail DATE,
    id_chaine int
);
alter table dateNonTravail add foreign key (id_chaine) references chaine (id_chaine);
