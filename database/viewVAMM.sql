CREATE OR REPLACE VIEW v_valeurAjouteeDemandeVamm AS
SELECT
    valeurAjouteeDemande.id,
    valeurAjouteeDemande.etat,
    valeurAjouteeDemande.id_demande_client,
    valeurAjouteeDemande.id_valeur_ajoutee,
    valeurAjoutee.type_valeur_ajoutee,
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
    v_demandeclient.id_etat,
    v_demandeclient.periode,
    v_demandeclient.taillemin,
    v_demandeclient.taillemax,
    v_demandeclient.taille_base,
    v_demandeclient.type_incontern,
    COALESCE(SUM(inspectionVamm.nombre_inspecter), 0) AS total_nombre_inspecter
FROM
    valeurAjouteeDemande
    JOIN valeurAjoutee ON valeurAjoutee.id = valeurAjouteeDemande.id_valeur_ajoutee
    JOIN v_demandeclient ON v_demandeclient.id = valeurAjouteeDemande.id_demande_client
    LEFT JOIN inspectionVamm ON inspectionVamm.id_demande_client = valeurAjouteeDemande.id_demande_client
GROUP BY
    valeurAjouteeDemande.id,
    valeurAjouteeDemande.etat,
    valeurAjouteeDemande.id_demande_client,
    valeurAjouteeDemande.id_valeur_ajoutee,
    valeurAjoutee.type_valeur_ajoutee,
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
    v_demandeclient.id_etat,
    v_demandeclient.periode,
    v_demandeclient.taillemin,
    v_demandeclient.taillemax,
    v_demandeclient.taille_base,
    v_demandeclient.type_incontern;


create or replace view v_demandeSerigraphie as
select
    demandeclientSerigraphie.*,
    v_demandeclient.nom_modele,
    v_demandeclient.theme,
    v_demandeclient.nomtier,
    v_demandeclient.id_tiers,
    v_demandeclient.nom_style,
    v_demandeclient.id_style,
    v_sdc.stadesdc,
    v_sdc.id_stade_demande_client,
    v_demandeclient.type_saison,
    v_demandeclient.id_saison,
    v_demandeclient.type_stade as stade_demande,
    v_demandeclient.id_stade as stade_sansSDC,
    v_demandeclient.qte_commande_provisoire,
    v_demandeclient.id_stade as id_etat,
    v_demandeclient.type_etat,
    parametreSer.smv_print,
    parametreSer.qte_coupe,
    parametreSer.prix_print,
    planningDemandeSer.fin,
    planningDemandeSer.deadline
from
    demandeclientSerigraphie
    join v_demandeclient on v_demandeclient.id = demandeclientSerigraphie.id_demande_client
    left join v_sdc on v_sdc.id = demandeclientSerigraphie.id_sdc
    left join parametreSer on parametreSer.id_demande_client = demandeclientSerigraphie.id_demande_client
    left join planningDemandeSer on planningDemandeSer.id_demande_ser = demandeclientSerigraphie.id;

CREATE OR REPLACE VIEW v_demandeSerigraphie AS
SELECT
    demandeclientSerigraphie.*,
    v_demandeclient.nom_modele,
    v_demandeclient.theme,
    v_demandeclient.nomtier,
    v_demandeclient.id_tiers,
    v_demandeclient.nom_style,
    v_demandeclient.id_style,
    v_sdc.stadesdc,
    v_sdc.id_stade_demande_client,
    v_demandeclient.type_saison,
    v_demandeclient.id_saison,
    v_demandeclient.type_stade AS stade_demande,
    v_demandeclient.id_stade AS stade_sansSDC,
    v_demandeclient.qte_commande_provisoire,
    v_demandeclient.id_stade AS id_etat,
    v_demandeclient.type_etat,
    parametreSer.smv_print,
    parametreSer.qte_coupe,
    parametreSer.prix_print,
    planningDemandeSer.fin,
    planningDemandeSer.deadline
FROM
    demandeclientSerigraphie
    JOIN v_demandeclient ON v_demandeclient.id = demandeclientSerigraphie.id_demande_client
    LEFT JOIN (
        SELECT DISTINCT ON (id) * FROM v_sdc
    ) AS v_sdc ON v_sdc.id = demandeclientSerigraphie.id_sdc
    LEFT JOIN (
        SELECT DISTINCT ON (id_demande_client) * FROM parametreSer
    ) AS parametreSer ON parametreSer.id_demande_client = demandeclientSerigraphie.id_demande_client
    LEFT JOIN (
        SELECT DISTINCT ON (id_demande_ser) * FROM planningDemandeSer
    ) AS planningDemandeSer ON planningDemandeSer.id_demande_ser = demandeclientSerigraphie.id;


-- heure travail 16/10/2024
create or replace view v_heureTravailEmploye as
select v_listeemploye.*,
heuretravailemployee.dateentree as dateentreeHeureTravail,
heuretravailemployee.datesortie as datesortieHeureTravail,
 (heuretravailemployee.datesortie::time - '16:00:00'::time) as heuresupplementaire
from v_listeemploye
join heuretravailemployee on heuretravailemployee.idlisteemploye = v_listeemploye.id;



create or replace view v_suiviFluxSerigraphie as select
suivifluxserigraphie.*,
v_demandeClient.nom_modele ,
v_demandeClient.nomtier ,
v_demandeClient.id_tiers ,
v_demandeClient.nom_style ,
v_demandeClient.id_style ,
v_demandeClient.type_stade,
v_demandeClient.id_stade,
v_demandeClient.type_saison,
v_demandeClient.id_saison,
v_demandeClient.qte_commande_provisoire,
v_demandeClient.theme,
COALESCE(SUM(detailSuiviFluxSerigraphie.qte), 0) AS qte,
COALESCE(SUM(detailSuiviFluxSerigraphie.recoupe), 0) AS recoupe
from suivifluxserigraphie
join v_demandeClient on v_demandeClient.id=suivifluxserigraphie.id_demande_client
join detailSuiviFluxSerigraphie on detailSuiviFluxSerigraphie.id_suivi_flux = suiviFluxSerigraphie.id
group by suivifluxserigraphie.id,suivifluxserigraphie.id_demande_client,suivifluxserigraphie.date_operation,
suivifluxserigraphie.type_flux,suivifluxserigraphie.etat,
v_demandeClient.nom_modele,v_demandeClient.nomtier,v_demandeClient.id_tiers,v_demandeClient.nom_style,v_demandeClient.id_style,
v_demandeClient.type_stade,v_demandeClient.id_stade,v_demandeClient.type_saison,v_demandeClient.id_saison,
v_demandeClient.qte_commande_provisoire,v_demandeClient.theme;

create or REPLACE view v_detailParametreSer as
select detailParametreSer.*, parametreSer.smv_print, parametreSer.qte_coupe, typeEncre.type_encre, encre.encre, parametreSer.id_demande_client, parametreSer.prix_print
from
    detailParametreSer
    join parametreSer on parametreSer.id = detailParametreSer.id_parametre_ser
    join typeEncre on typeEncre.id = detailParametreSer.id_type_encre
    join encre on encre.id = detailParametreSer.id_encre;

CREATE OR REPLACE VIEW v_rapportJournalierSer AS
SELECT rapportJournalier.*,
SUM(detailrapportjournalier.qte) AS total_qte,
COUNT(detailrapportjournalier.heure) AS max_heure,
v_demandeClient.nom_modele,
v_demandeClient.nomtier,
v_demandeClient.theme,
v_demandeClient.type_stade,
v_demandeClient.id_stade,
parametreser.smv_print,
(((SUM(detailrapportjournalier.qte)*parametreser.smv_print)/(COUNT(detailrapportjournalier.heure)*rapportJournalier.nb_operateur*60)))*100 as efficience,
v_demandeClient.type_saison,
pri.prix,
pri.prix*SUM(detailrapportjournalier.qte) as chiffre_affaire
FROM
    rapportJournalier
    JOIN detailrapportjournalier ON rapportJournalier.id = detailrapportjournalier.id_rapport_journalier
    join v_demandeClient on v_demandeClient.id = rapportJournalier.id_demande_client
    left join parametreser on parametreser.id_demande_client =  rapportJournalier.id_demande_client
    left join pri on pri.id_demande_client = v_demandeClient.id
GROUP BY
    v_demandeClient.nom_modele,
    v_demandeClient.nomtier,
    v_demandeClient.theme,
    v_demandeClient.type_stade,
    v_demandeClient.id_stade,
    rapportJournalier.id,
    parametreser.smv_print,
    detailrapportjournalier.id_rapport_journalier,
    pri.prix,
    v_demandeClient.type_saison;


-- Broad machine
create or replace view v_demandeClientBroadMachine as
select demandeClientBroadMachine.*,
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
from demandeClientBroadMachine
left join v_sdc on v_sdc.id = demandeClientBroadMachine.id_sdc
join v_demandeclient on v_demandeclient.id = demandeClientBroadMachine.id_demande_client;


create or replace view v_demandeClientBroadMain as
select demandeClientBrodMain.*,
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
v_demandeclient.id_etat,
v_demandeclient.periode,
v_demandeclient.type_incontern,
v_demandeclient.photo_commande,
planningDemandeBrodMain.deadline,
planningDemandeBrodMain.fin
from demandeClientBrodMain
left join v_sdc on v_sdc.id = demandeClientBrodMain.id_sdc
left join planningDemandeBrodMain on planningDemandeBrodMain.id_demande_client =  demandeClientBrodMain.id
join v_demandeclient on v_demandeclient.id = demandeClientBrodMain.id_demande_client;

create or replace view v_consoFilBrodMain as
select detailConsoFilBrodMain.*,
consoFilBrodMain.nb_heure,
consoFilBrodMain.prix,
unitemonetaire.unite,
consoFilBrodMain.id_demande_client,
consoFilBrodMain.id_unite_monetaire
from detailConsoFilBrodMain
join consoFilBrodMain on consoFilBrodMain.id= detailConsoFilBrodMain.id_conso
join unitemonetaire on unitemonetaire.id= consoFilBrodMain.id_unite_monetaire;


create or replace view v_suiviFluxBrodMain as select
v_demandeclient.*,
suiviFluxBrodMain.date_operation,
suiviFluxBrodMain.type_flux,
suiviFluxBrodMain.qte,
suiviFluxBrodMain.recoupe,
suiviFluxBrodMain.etat as etatFlux,
suiviFluxBrodMain.id as id_suivi
from v_demandeclient
join suiviFluxBrodMain on suiviFluxBrodMain.id_demande_client=v_demandeclient.id;

CREATE OR REPLACE VIEW v_rapportJournalierSer AS
SELECT rapportJournalier.*,
SUM(detailrapportjournalier.qte) AS total_qte,
COUNT(detailrapportjournalier.heure) AS max_heure,
v_demandeClient.nom_modele,
v_demandeClient.nomtier,
v_demandeClient.theme,
v_demandeClient.type_stade,
v_demandeClient.id_stade,
((SUM(detailrapportjournalier.qte)*parametreser.smv_print)/(COUNT(detailrapportjournalier.heure)*rapportJournalier.nb_operateur*60)) as efficience,
v_demandeClient.type_saison,
pri.prix,8
pri.prix*SUM(detailrapportjournalier.qte) as chiffre_affaire
FROM
    rapportJournalier
    JOIN detailrapportjournalier ON rapportJournalier.id = detailrapportjournalier.id_rapport_journalier
    join v_demandeClient on v_demandeClient.id = rapportJournalier.id_demande_client
    left join parametreser on parametreser.id_demande_client =  rapportJournalier.id_demande_client
    left join pri on pri.id_demande_client = v_demandeClient.id
GROUP BY
    v_demandeClient.nom_modele,
    v_demandeClient.nomtier,
    v_demandeClient.theme,
    v_demandeClient.type_stade,
    v_demandeClient.id_stade,
    rapportJournalier.id,
    parametreser.smv_print,
    detailrapportjournalier.id_rapport_journalier,
    pri.prix,
    v_demandeClient.type_saison;

CREATE OR REPLACE VIEW v_rapportJournalierBrodMain AS
SELECT rapportJournalierBrodMain.*,
v_demandeclient.nom_modele,
v_demandeclient.nomtier,
v_demandeclient.theme,
v_demandeclient.type_stade,
parametreser.smv_print,
SUM(detailRapportJournalierBrodMain.qte) AS total_qte,
COUNT(detailRapportJournalierBrodMain.heure) AS max_heure,
(((SUM(detailRapportJournalierBrodMain.qte)*parametreser.smv_print)/(COUNT(detailRapportJournalierBrodMain.heure)*rapportJournalierBrodMain.nb_operateur*60)))*100 as efficience
FROM
    rapportJournalierBrodMain
    JOIN detailRapportJournalierBrodMain ON rapportJournalierBrodMain.id = detailRapportJournalierBrodMain.id_rapport_journalier_brodmain
    join v_demandeclient on v_demandeclient.id = rapportJournalierBrodMain.id_demande_client
    left join parametreser on parametreser.id_demande_client =  rapportJournalierBrodMain.id_demande_client
GROUP BY
    v_demandeclient.nom_modele,
    v_demandeclient.nomtier,
    v_demandeclient.theme,
    v_demandeclient.type_stade,
    v_demandeclient.type_stade,
    rapportJournalierBrodMain.id,
    parametreser.smv_print,
    detailRapportJournalierBrodMain.id_rapport_journalier_brodmain;


-- LBT
create or replace view v_lavageDemande as
select valeurAjouteeDemande.id, valeurAjouteeDemande.etat, valeurAjouteeDemande.id_demande_client,
valeurAjouteeDemande.id_valeur_ajoutee, valeurAjoutee.type_valeur_ajoutee,
v_demandeclient.date_entree,
v_demandeclient.date_livraison,
v_demandeclient.nom_modele,
v_demandeclient.theme,
v_demandeclient.qte_commande_provisoire,
v_demandeclient.nomtier,
v_demandeclient.id_tiers,
v_demandeclient.nom_style,
v_demandeclient.id_style,v_demandeclient.type_phase,
v_demandeclient.id_phase,
v_demandeclient.type_saison,
v_demandeclient.id_saison,
v_demandeclient.type_stade,
v_demandeclient.id_stade,
v_demandeclient.type_etat,
v_demandeclient.id_etat
from
    valeurAjouteeDemande
    join valeurAjoutee on valeurAjoutee.id = valeurAjouteeDemande.id_valeur_ajoutee
    join v_demandeclient on v_demandeclient.id = valeurAjouteeDemande.id_demande_client;


create or replace view  v_lavageValeurDemande as select
v_lavage_valeur_ajout_demande_ligne.*,
v_demandeclient.date_entree,
v_demandeclient.date_livraison,
v_demandeclient.nom_modele,
v_demandeclient.theme,
v_demandeclient.qte_commande_provisoire,
v_demandeclient.nomtier,
v_demandeclient.id_tiers,
v_demandeclient.nom_style,
v_demandeclient.id_style,v_demandeclient.type_phase,
v_demandeclient.id_phase,
v_demandeclient.type_saison,
v_demandeclient.id_saison,
v_demandeclient.type_stade,
v_demandeclient.id_stade,
v_demandeclient.type_etat,
v_demandeclient.id_etat
from v_lavage_valeur_ajout_demande_ligne
join v_demandeclient on v_demandeclient.id= v_lavage_valeur_ajout_demande_ligne.id_demande_client;


create or replace view v_parametreLavage AS
select parametreLavage.*,
parametreLavage.poids_unitaire*v_demandeclient.qte_commande_provisoire as poids_total,
(parametreLavage.poids_unitaire*v_demandeclient.qte_commande_provisoire)/parametreLavage.poids_passe as nb_passe,
parametreLavage.temps_passe_reel*((parametreLavage.poids_unitaire*v_demandeclient.qte_commande_provisoire)/parametreLavage.poids_passe) as temps_total
from parametreLavage
join v_demandeclient on v_demandeclient.id = parametreLavage.id_demande_client;


CREATE OR REPLACE VIEW v_parametreBlanchissement AS
SELECT
    parametreBlanchissement.*,
    CASE
        WHEN parametreBlanchissement.nb_panneaux = 0
        THEN v_demandeclient.qte_commande_provisoire
        ELSE parametreBlanchissement.nb_panneaux
    END AS nb_panneaux_effectif,
    parametreBlanchissement.poids_unitaire *
    CASE
        WHEN parametreBlanchissement.nb_panneaux = 0
        THEN v_demandeclient.qte_commande_provisoire
        ELSE parametreBlanchissement.nb_panneaux
    END AS poids_total,
    (parametreBlanchissement.poids_unitaire *
    CASE
        WHEN parametreBlanchissement.nb_panneaux = 0
        THEN v_demandeclient.qte_commande_provisoire
        ELSE parametreBlanchissement.nb_panneaux
    END) / parametreBlanchissement.poids_passe AS nb_passe
FROM
    parametreBlanchissement
JOIN
    v_demandeclient ON parametreBlanchissement.id_demande_client = v_demandeclient.id;


create or replace view v_parametreTeinture as
select parametreTeinture.*,
parametreTeinture.poids_unitaire*parametreTeinture.nb_panneaux as poids_total,
(parametreTeinture.poids_unitaire*parametreTeinture.nb_panneaux)/parametreTeinture.poids_passe as nb_passe
from parametreTeinture;


create or replace view v_suiviFluxLBT as
select suiviFluxLBT.*,
v_demandeclient.date_entree,
v_demandeclient.date_livraison,
v_demandeclient.nom_modele,
v_demandeclient.theme,
v_demandeclient.qte_commande_provisoire,
v_demandeclient.nomtier,
v_demandeclient.id_tiers,
v_demandeclient.nom_style,
v_demandeclient.id_style,v_demandeclient.type_phase,
v_demandeclient.id_phase,
v_demandeclient.type_saison,
v_demandeclient.id_saison,
v_demandeclient.type_stade,
v_demandeclient.id_stade,
v_demandeclient.type_etat,
v_demandeclient.id_etat
from suiviFluxLBT
join v_demandeclient on v_demandeclient.id = suiviFluxLBT.id_demande_client;



 create or replace view v_suiviFluxBrodMachine as
select v_demandeclient.*,
suiviFluxBrodMachine.date_operation,
suiviFluxBrodMachine.type_flux,
suiviFluxBrodMachine.quantite,
suiviFluxBrodMachine.recoupe,
suiviFluxBrodMachine.etat as etatFlux,
suiviFluxBrodMachine.id as id_suivi_flux
from v_demandeclient
join suiviFluxBrodMachine on suiviFluxBrodMachine.id_demande_client = v_demandeclient.id;

create or replace view v_rapportJournalierLBT as
select
