create or replace view v_tiers as
select
    tiers.id,
    tiers.etat,
    tiers.dateentree,
    tiers.nomtier,
    tiers.numphone,
    tiers.emailtier,
    pays.nom_fr_fr,
    pays.id as idpays,
    acteurtiers.acteur,
    acteurtiers.id as idacteurtiers,
    etattiers.etattiers,
    etattiers.id as idetattiers,
    qualiteTiers.qualite,
    qualiteTiers.id as idqualiteTiers,
    unitemonetaire.unite,
    unitemonetaire.id as idunitemonetaire
from
    tiers
    join pays on pays.id = tiers.idpays
    join acteurtiers on acteurtiers.id = tiers.idacteur
    join etattiers on etattiers.id = tiers.idetat
    join qualiteTiers on qualiteTiers.id = tiers.idqualite
    join unitemonetaire on unitemonetaire.id = tiers.idunite;
-- view filtre tiers
create or replace view v_filtreTier as (
    SELECT
        t.id AS id_tier,
        t.nomtier,
        t.idActeur,
        a.acteur,
        t.adresse,
        t.ville,
        t.codePostal,
        t.idPays,
        p.nom_fr_fr AS pays,
        t.numPhone,
        t.emailTier,
        t.webSite,
        t.idUnite,
        u.unite AS unite_monetaire,
        t.idQualite,
        q.qualite,
        t.idEtat,
        e.etatTiers AS etat,
        t.merchSenior,
        t.contactMerchSenior,
        t.emailMerchSenior,
        t.merchJunior,
        t.contactMerchJunior,
        t.emailMerchJunior,
        t.assistant,
        t.contactAssistant,
        t.emailAssistant,
        t.logo,
        t.dateentree,
        t.etat AS etat_tier
    FROM
        tiers t
        JOIN pays p ON t.idPays = p.id
        JOIN acteurTiers a ON t.idActeur = a.id
        JOIN uniteMonetaire u ON t.idUnite = u.id
        JOIN qualiteTiers q ON t.idQualite = q.id
        JOIN etatTiers e ON t.idEtat = e.id
);

-- v_demande client
create or replace view v_demandeClient as
select
    demandeClient.id,
    demandeClient.date_entree,
    demandeClient.date_livraison,
    demandeClient.nom_modele,
    demandeClient.theme,
    demandeClient.qte_commande_provisoire,
    demandeClient.taille_base,
    demandeClient.requete_client,
    demandeClient.commentaire_merch,
    demandeClient.photo_commande,
    demandeClient.etat,
    demandeClient.id_unite_taille_min,
    demandeClient.id_unite_taille_max,
    tiers.nomtier,
    tiers.id as id_tiers,
    style.nom_style,
    style.id as id_style,
    incontern.type_incontern,
    incontern.id as id_incontern,
    phase.type_phase,
    phase.id as id_phase,
    saison.type_saison,
    saison.id as id_saison,
    ut_min.unite_taille as tailleMin,
    ut_max.unite_taille as tailleMax,
    stadedemandeclient.type_stade,
    stadedemandeclient.id as id_stade,
    etatdemandeclient.type_etat,
    periode.periode,
    periode.id as id_periode,
    etatdemandeclient.id as id_etat
from
    demandeClient
    join tiers on tiers.id = demandeClient.id_client
    join periode on periode.id = demandeClient.id_periode
    join style on style.id = demandeClient.id_style
    join incontern on incontern.id = demandeClient.id_incontern
    join phase on phase.id = demandeClient.id_phase
    join saison on saison.id = demandeClient.id_saison
    join unitetaille ut_min on ut_min.id = demandeClient.id_unite_taille_min
    join unitetaille ut_max on ut_max.id = demandeClient.id_unite_taille_max
    join stadedemandeclient on stadedemandeclient.id = demandeClient.id_stade
    join etatdemandeclient on etatdemandeclient.id = demandeClient.id_etat;

-- view lavage demande client
create or replace view v_lavageDemandeClient as
select lavageDemandeClient.id, lavageDemandeClient.etat, lavageDemandeClient.id_demande_client, lavageDemandeClient.id_lavage, lavage.type_lavage
from
    lavageDemandeClient
    join lavage on lavage.id = lavageDemandeClient.id_lavage
    join demandeClient on demandeClient.id = lavageDemandeClient.id_demande_client;

-- view valeur ajoutee demande client
create or replace view v_valeurAjouteeDemande as
select valeurAjouteeDemande.id, valeurAjouteeDemande.etat, valeurAjouteeDemande.id_demande_client, valeurAjouteeDemande.id_valeur_ajoutee, valeurAjoutee.type_valeur_ajoutee
from
    valeurAjouteeDemande
    join valeurAjoutee on valeurAjoutee.id = valeurAjouteeDemande.id_valeur_ajoutee;

-- view detaille taille demande client
create or replace view v_detailTailleDemandeClient as
select detailTailleDemandeClient.id, detailTailleDemandeClient.id_demande_client, detailTailleDemandeClient.id_unite_taille, detailTailleDemandeClient.conso, detailTailleDemandeClient.quantite, detailTailleDemandeClient.etat, uniteTaille.unite_taille, uniteTaille.rang
from
    detailTailleDemandeClient
    join uniteTaille on uniteTaille.id = detailTailleDemandeClient.id_unite_taille;

-- view tissu
CREATE OR REPLACE VIEW v_tissus AS
SELECT tissus.*, typeTissus.type_tissus, categorieTissus.categorie, compositionTissus.composition_tissus, uniteMesureMatierePremiere.unite_mesure, uniteMonetaire.unite, familleTissus.famille_tissus, classeMatierePremiere.classe
FROM
    tissus
    left JOIN typeTissus ON typeTissus.id = tissus.id_type_tissus
    left JOIN categorieTissus ON categorieTissus.id = tissus.id_categorie_tissus
    left JOIN compositionTissus ON compositionTissus.id = tissus.id_composition_tissus
    left JOIN uniteMesureMatierePremiere ON uniteMesureMatierePremiere.id = tissus.id_unite_mesure_matiere
    left JOIN uniteMonetaire ON uniteMonetaire.id = tissus.id_unite_monetaire
    left JOIN familleTissus ON familleTissus.id = tissus.id_famille_tissus
    left JOIN classeMatierePremiere ON classeMatierePremiere.id = tissus.id_classe;

-- view accessoire

create or replace view v_accessoire as
select accessoire.*, typeAccessoire.type_accessoire, uniteMonetaire.unite, uniteMesureMatierePremiere.unite_mesure, familleAccessoire.famille_accessoire, classeMatierePremiere.classe
from
    accessoire
    left join typeAccessoire on typeAccessoire.id = accessoire.id_type_accessoire
    left join uniteMonetaire on uniteMonetaire.id = accessoire.id_unite_monetaire
    left join demandeClient on demandeClient.id = accessoire.id_demande_client
    left join uniteMesureMatierePremiere on uniteMesureMatierePremiere.id = accessoire.id_unite_mesure_matiere
    left join familleAccessoire on familleAccessoire.id = accessoire.id_famille_accessoire
    left join classeMatierePremiere on classeMatierePremiere.id = accessoire.id_classe;

--  view detail sdc
create or replace view v_detailSdc as
select detailSdc.*, v_detailtailledemandeclient.unite_taille, v_detailtailledemandeclient.rang
from
    detailSdc
    join v_detailtailledemandeclient on v_detailtailledemandeclient.id = detailSdc.id_unite_taille_dc;

-- view smv
create or replace view v_smv as
select smv.*, stadeDemandeClient.type_stade, uniteMonetaire.unite
from
    smv
    join stadeDemandeClient on stadeDemandeClient.id = smv.id_stade_demande_client
    join uniteMonetaire on uniteMonetaire.id = smv.id_unite_monetaire;

-- view pri
create or replace view v_pri as
select pri.*, uniteMonetaire.unite
from pri
    join uniteMonetaire on uniteMonetaire.id = pri.id_unite_monetaire;

-- view envoye echantillon
CREATE VIEW v_echantillon AS
SELECT envoieEchantillon.*,
 v_demandeclient.nom_modele,
    v_demandeclient.nomtier,
    v_demandeclient.id_tiers,
    v_demandeclient.qte_commande_provisoire,
    v_demandeclient.nom_style,
    v_demandeclient.id_style,
    v_demandeclient.theme,
     v_demandeclient.id_saison,
    v_demandeclient.type_saison,
    stadeDemandeClient.type_stade
FROM
    envoieEchantillon
    JOIN stadeDemandeClient ON envoieEchantillon.id_stade_demande_client = stadeDemandeClient.id
    join v_demandeclient on v_demandeclient.id = envoieEchantillon.id_demande_client ;

--  view kpi

create or replace view v_kpi as
SELECT
    id_tiers,
    nomtier,
    COUNT(*) AS total,
    SUM(
        CASE
            WHEN id_etat = 2 THEN 1
            ELSE 0
        END
    ) AS valide,
    (
        (
            100 * SUM(
                CASE
                    WHEN id_etat = 2 THEN 1
                    ELSE 0
                END
            )
        ) / COUNT(*)
    ) as pourcentage
FROM v_demandeclient
GROUP BY
    id_tiers,
    nomtier;

create or replace view v_detailTier as(
    SELECT
        t.id,
        t.dateentree,
        t.nomtier,
        p.nom_fr_fr AS pays,
        t.ville,
        t.codePostal,
        t.adresse,
        t.numPhone,
        t.emailtier,
        a.acteur,
        u.unite AS unite_monetaire,
        q.qualite,
        e.etattiers AS etat,
        t.webSite,
        t.logo,
        t.merchSenior,
        t.contactMerchSenior,
        t.emailMerchSenior,
        t.merchJunior,
        t.contactMerchJunior,
        t.emailMerchJunior,
        t.assistant,
        t.contactAssistant,
        t.emailAssistant
    FROM tiers t
    JOIN pays p ON p.id = t.idpays
    JOIN acteurTiers a ON a.id = t.idacteur
    JOIN unitemonetaire u ON u.id = t.idunite
    JOIN qualiteTiers q ON q.id = t.idqualite
    JOIN etatTiers e ON e.id = t.idetat
    );

create or replace view v_bureauetude as
select bureauEtude.*,
typePatronage.typePatron,
listeEmploye.nom,
listeEmploye.prenom
from bureauEtude
join typePatronage on typePatronage.id= bureauEtude.idTypePatronage
join listeEmploye on listeEmploye.id= bureauEtude.idListeEmploye;


create or replace view v_listeEmploye as
select listeEmploye.*,
fonctionEmploye.designation as designationFonction,
section.designation as designationSection,
classification.designation as designationClassification,
pays.nom_fr_fr,
role.role
from listeEmploye
left join fonctionEmploye on fonctionEmploye.id= listeEmploye.idFonction
left join section on section.id= listeEmploye.idSection
left join role on role.id= listeEmploye.idrole
left join classification on classification.id=listeEmploye.idClassification
left join pays on pays.id= listeEmploye.idPays;


-- DEV 11/09/2024
create or replace view v_sdc as
select  sdc.*,
stadeDemandeClient.type_stade as stadeSDC
from sdc
join stadeDemandeClient on stadeDemandeClient.id= sdc.id_stade_demande_client;



CREATE OR REPLACE VIEW v_demandeClientSDCEtapeDev AS
SELECT
    demandeClientSDCEtapeDev.*,
    sdc.date_envoie AS sdc_date_envoie,
    v_sdc.stadesdc,
    demandeclient.date_entree AS client_date_entree,
    v_demandeclient.nom_modele,
    v_demandeclient.nomtier,
    v_demandeclient.id_tiers,
    v_demandeclient.qte_commande_provisoire,
    v_demandeclient.nom_style,
    v_demandeclient.id_style,
    v_demandeclient.theme,
    v_demandeclient.id_saison,
    v_demandeclient.type_stade,
    v_demandeclient.id_stade,
    v_demandeclient.type_saison,
    etapedev.duree AS dureeDEV,
    etapedev.etape AS etapeDEV,
    v_bureauetude.nom as nom_patronier,
    v_bureauetude.prenom as prenom_patronier,
    v_bureauetude.idlisteemploye,
    -- Modification de la sous-requête pour ajouter la condition WHERE sur id_sdc
    (SELECT SUM(qte_client)
     FROM detailsdc
     WHERE detailsdc.id_sdc = demandeClientSDCEtapeDev.id_sdc) AS sommeQteClient,
    (SELECT dossier_technique_demande
     FROM dossiertechniquedemandeclient
     WHERE dossiertechniquedemandeclient.id_demande_client = demandeClientSDCEtapeDev.id_demande_client
     ORDER BY id DESC
     LIMIT 1) AS dernierDT,
    demandeClientSDCEtapeDev.date_entree_demande  + interval '1 day' * etapedev.duree AS deadlineDemandeClient
FROM demandeClientSDCEtapeDev
LEFT JOIN sdc ON sdc.id = demandeClientSDCEtapeDev.id_sdc
LEFT JOIN v_bureauetude on v_bureauetude.iddclientsdcetapedev = demandeClientSDCEtapeDev.id
LEFT JOIN etapedev ON etapedev.id = demandeClientSDCEtapeDev.id_etape_dev
LEFT JOIN detailsdc ON detailsdc.id = demandeClientSDCEtapeDev.id_sdc
LEFT JOIN v_sdc ON v_sdc.id = demandeClientSDCEtapeDev.id_sdc
LEFT JOIN demandeclient ON demandeclient.id = demandeClientSDCEtapeDev.id_demande_client
LEFT JOIN v_demandeclient ON v_demandeclient.id = demandeClientSDCEtapeDev.id_demande_client;


create or replace view v_transmissionMerch as
select
    demandeClientSDCEtapeDev.*,
    sdc.date_envoie AS sdc_date_envoie,
    v_sdc.stadesdc,
    demandeclient.date_entree AS client_date_entree,
    v_demandeclient.nom_modele,
    v_demandeclient.nomtier,
    v_demandeclient.id_tiers,
    v_demandeclient.qte_commande_provisoire,
    v_demandeclient.nom_style,
    v_demandeclient.id_style,
    v_demandeclient.theme,
     v_demandeclient.id_saison,
    v_demandeclient.type_stade,
    v_demandeclient.id_stade,
    v_demandeclient.type_saison,
    transmissiondev.dateenvoie,
    transmissiondev.qteenvoie,
    transmissiondev.commentaire
    from demandeClientSDCEtapeDev
     JOIN sdc ON sdc.id = demandeClientSDCEtapeDev.id_sdc
     JOIN v_sdc ON v_sdc.id = demandeClientSDCEtapeDev.id_sdc
     JOIN demandeclient ON demandeclient.id = demandeClientSDCEtapeDev.id_demande_client
     join v_demandeclient on v_demandeclient.id= demandeClientSDCEtapeDev.id_demande_client
     join transmissiondev on transmissiondev.iddclientsdcetapedev=demandeClientSDCEtapeDev.id;


create or replace view v_suivipatronage as
select
demandeclientsdcetapedev.*,
v_demandeclient.nom_modele,
v_demandeclient.theme,
v_demandeclient.nomtier,
v_demandeclient.nom_style,
v_demandeclient.id_tiers,
v_demandeclient.id_style,
v_demandeclient.type_saison,
v_demandeclient.id_saison,
v_demandeclient.type_stade,
v_demandeclient.id_stade,
v_bureauetude.typepatron,
v_bureauetude.idlisteemploye,
v_bureauetude,idtypepatronage,
v_bureauetude.nom as nom_patronier,
v_bureauetude.prenom as prenom_patronier,
suivipatronage.datedebut,
suivipatronage.datefin,
suivipatronage.deadline,
suivipatronage.pointpatronage,
suivipatronage.daterecepetion,
suivipatronage.commentaire
from demandeclientsdcetapedev
join v_demandeclient on v_demandeclient.id=demandeclientsdcetapedev.id_demande_client
join v_bureauetude on v_bureauetude.iddclientsdcetapedev =demandeclientsdcetapedev.id
join suivipatronage on suivipatronage.iddclientsdcetapedev =demandeclientsdcetapedev.id ;


create or replace view v_suiviDetailConso as
select
demandeclientsdcetapedev.*,
v_demandeclient.nom_modele,
v_demandeclient.theme,
v_demandeclient.nomtier,
v_demandeclient.nom_style,
v_demandeclient.id_tiers,
v_demandeclient.id_saison,
v_demandeclient.id_style,
v_demandeclient.type_saison,
v_demandeclient.type_stade,
v_demandeclient.id_stade,
suiviconso.daterecepetion,
suiviconso.datedebut,
suiviconso.deadline,
suiviconso.datefin,
suividetailconso.consocommande,
suividetailconso.efficiencecommande,
suividetailconso.consorecu,
suividetailconso.efficiencerecu,
suividetailconso.tauxrecoupe,
suividetailconso.pointplacement,
suividetailconso.commentaire,
suividetailconso.id_type_placement,
v_tissus.type_tissus,
v_tissus.laize_utile,
v_tissus.prix_unitaire,
(suividetailconso.consorecu-suividetailconso.consocommande) as varience,
typeplacement.typeplacement
from demandeclientsdcetapedev
join v_demandeclient on v_demandeclient.id = demandeclientsdcetapedev.id_demande_client
join suiviconso on suiviconso.iddclientsdcetapedev = demandeclientsdcetapedev.id
join suividetailconso on suividetailconso.idsuiviconso = suiviconso.id
join v_tissus on v_tissus.id = suividetailconso.idtissus
join typeplacement on typeplacement.id = suividetailconso.id_type_placement;


create or replace view v_suiviPlaceur as
select
demandeclientsdcetapedev.*,
v_demandeclient.nom_modele,
v_demandeclient.theme,
v_demandeclient.nomtier,
v_demandeclient.nom_style,
v_demandeclient.id_tiers,
v_demandeclient.id_style,
v_demandeclient.id_saison,
v_demandeclient.type_saison,
v_demandeclient.type_stade,
v_demandeclient.id_stade,
suiviplaceur.daterecepetion,
suiviplaceur.idlisteemploye,
suiviplaceur.datedebut,
suiviplaceur.datefin,
suiviplaceur.deadline,
detailsuiviplaceur.nbmarkeur,
detailsuiviplaceur.pointplacement,
detailsuiviplaceur.commentaire,
listeemploye.nom,
listeemploye.prenom,
v_tissus.type_tissus,
v_tissus.laize_utile,
typeplacement.typeplacement
from demandeclientsdcetapedev
join v_demandeclient on v_demandeclient.id = demandeclientsdcetapedev.id_demande_client
join suiviplaceur on suiviplaceur.iddclientsdcetapedev = demandeclientsdcetapedev.id
join detailsuiviplaceur on detailsuiviplaceur.id_suivi_placeur= suiviplaceur.id
join listeemploye on listeemploye.id= suiviplaceur.idlisteemploye
join v_tissus on v_tissus.id = detailsuiviplaceur.idtissus
join typeplacement on typeplacement.id = detailsuiviplaceur.id_type_placement;

create or replace view   v_controlePatronage as
select
demandeclientsdcetapedev.*,
v_demandeclient.nom_modele,
v_demandeclient.theme,
v_demandeclient.nomtier,
v_demandeclient.nom_style,
v_demandeclient.id_tiers,
v_demandeclient.id_style,
v_demandeclient.id_saison,
v_demandeclient.type_saison,
v_demandeclient.type_stade,
v_demandeclient.id_stade,
v_bureauetude.nom as nom_patronier,
v_bureauetude.prenom as prenom_patronier,
v_bureauetude.idlisteemploye,
controlepatronage.daterecepetion,
controlepatronage.datedebut,
controlepatronage.datefin,
controlepatronage.deadline,
controlepatronage.occurence,
controlepatronage.commentaire,
typeoccurencepatronage.occurence as type_occurence
from demandeclientsdcetapedev
left join v_demandeclient on v_demandeclient.id=demandeclientsdcetapedev.id_demande_client
left join controlepatronage on controlepatronage.iddclientsdcetapedev = demandeclientsdcetapedev.id
left join v_bureauetude on v_bureauetude.iddclientsdcetapedev =demandeclientsdcetapedev.id
left join typeoccurencepatronage on typeoccurencepatronage.id = controlepatronage.idtypeoccurencepatronage;

create or replace view  v_suiviconso as
select suiviConso.*,
demandeclientsdcetapedev.id_demande_client
from suiviConso
join demandeclientsdcetapedev on demandeclientsdcetapedev.id =  suiviConso.iddclientsdcetapedev;

create or replace view v_rapportMontageDev as
select
demandeclientsdcetapedev.*,
v_demandeclient.nom_modele,
v_demandeclient.theme,
v_demandeclient.nomtier,
v_demandeclient.nom_style,
v_demandeclient.id_tiers,
v_demandeclient.id_style,
v_demandeclient.id_saison,
v_demandeclient.type_saison,
v_demandeclient.type_stade,
v_demandeclient.id_stade,
rapportmontagedev.daterecepetion,
rapportmontagedev.datedebut,
rapportmontagedev.deadline,
detailrapportmontagedev.multiplicateur,
detailrapportmontagedev.datefin,
detailrapportmontagedev.qteproduite,
detailrapportmontagedev.idlisteemploye,
detailrapportmontagedev.commentaire,
detailrapportmontagedev.minuteproduite,
detailrapportmontagedev.minutepresence,
detailrapportmontagedev.efficiencedev,
listeemploye.nom,
listeemploye.prenom
from demandeclientsdcetapedev
join v_demandeclient on v_demandeclient.id=demandeclientsdcetapedev.id_demande_client
join rapportmontagedev on rapportmontagedev.iddclientsdcetapedev =demandeclientsdcetapedev.id
join detailrapportmontagedev on detailrapportmontagedev.idrapportmontagedev = rapportmontagedev.id
join listeemploye on listeemploye.id=detailrapportmontagedev.idlisteemploye;

create or replace view v_rapportFinition as
select
demandeclientsdcetapedev.*,
v_demandeclient.nom_modele,
v_demandeclient.theme,
v_demandeclient.nomtier,
v_demandeclient.nom_style,
v_demandeclient.id_tiers,
v_demandeclient.id_style,
v_demandeclient.id_saison,
v_demandeclient.type_saison,
v_demandeclient.type_stade,
v_demandeclient.id_stade,
rapportfinitiondev.daterecepetion,
rapportfinitiondev.datedebut,
rapportfinitiondev.deadline,
detailrapportfinitiondev.datefin,
detailrapportfinitiondev.qtefini,
detailrapportfinitiondev.commentaire,
detailrapportfinitiondev.minuteproduite,
detailrapportfinitiondev.minutepresence,
detailrapportfinitiondev.efficiencedev,
detailrapportfinitiondev.idlisteemploye,
listeemploye.nom,
listeemploye.prenom
from demandeclientsdcetapedev
join v_demandeclient on v_demandeclient.id = demandeclientsdcetapedev.id_demande_client
join rapportfinitiondev on rapportfinitiondev.iddclientsdcetapedev = demandeclientsdcetapedev.id
join detailrapportfinitiondev on detailrapportfinitiondev.idrapportfinitiondev = rapportfinitiondev.id
join listeemploye on listeemploye.id = detailrapportfinitiondev.idlisteemploye;

create or replace view v_controlefinal as
select
demandeclientsdcetapedev.*,
v_demandeclient.nom_modele,
v_demandeclient.theme,
v_demandeclient.nomtier,
v_demandeclient.nom_style,
v_demandeclient.id_tiers,
v_demandeclient.id_style,
v_demandeclient.id_saison,
v_demandeclient.type_saison,
v_demandeclient.type_stade,
v_demandeclient.id_stade,
controlefinaldev.daterecepetion,
controlefinaldev.datedebut,
controlefinaldev.deadline,
detailcontrolefinaldev.datefin,
detailcontrolefinaldev.retouche,
detailcontrolefinaldev.qtecontrole,
detailcontrolefinaldev.qteretouche,
detailcontrolefinaldev.qterejet,
detailcontrolefinaldev.commentaire,
detailcontrolefinaldev.idtyperetouche,
detailcontrolefinaldev.tauxretouche,
detailcontrolefinaldev.tauxrejet,
typeretouche.typeretouche
from demandeclientsdcetapedev
join v_demandeclient on v_demandeclient.id=demandeclientsdcetapedev.id_demande_client
join controlefinaldev on controlefinaldev.iddclientsdcetapedev = demandeclientsdcetapedev.id
join detailcontrolefinaldev on detailcontrolefinaldev.idrapportmontagedev= controlefinaldev.id
join typeretouche on typeretouche.id = detailcontrolefinaldev.idtyperetouche;



























create or replace view v_bc as(
    SELECT
        t.id AS tiers_id,
        t.dateentree,
        t.nomtier,
        p.nom_fr_fr AS pays,
        t.ville,
        t.codePostal,
        t.adresse,
        t.numPhone,
        t.emailtier,
        a.acteur,
        u.unite AS unite_monetaire,
        q.qualite,
        e.etattiers AS etat,
        t.webSite,
        t.logo,
        t.merchSenior,
        t.contactMerchSenior,
        t.emailMerchSenior,
        t.merchJunior,
        t.contactMerchJunior,
        t.emailMerchJunior,
        t.assistant,
        t.contactAssistant,
        t.emailAssistant,
        bc.id AS bc_id,
        bc.date_bc,
        bc.numero_bc,
        bc.echeance,
        bc.etat AS etat_bc
    FROM tiers t
    JOIN pays p ON p.id = t.idpays
    JOIN acteurTiers a ON a.id = t.idacteur
    JOIN unitemonetaire u ON u.id = t.idunite
    JOIN qualiteTiers q ON q.id = t.idqualite
    JOIN etatTiers e ON e.id = t.idetat
    JOIN bc ON bc.idtier = t.id
);



create or replace view v_table_suivis as (
    SELECT
        donneBc.id AS id_donne_bc,
        donneBc.designation,
        donneBc.laize,
        donneBc.utilisation,
        donneBc.couleur,
        donneBc.quantite,
        donneBc.unite,
        donneBc.prix_unitaire,
        (donneBc.quantite * donneBc.prix_unitaire) AS prix_total,
        donneBc.devise,
        donneBc.etat,
        donneBc.numerobc,
        ------tissus-------------------
        v_tissus.categorie,
        v_tissus.designation AS des_tissus,
        v_tissus.reference AS ref_tissus,
        v_tissus.composition_tissus,
        ------accessoire---------------
        v_accessoire.famille_accessoire,
        v_accessoire.designation AS des_accessoire,
        v_accessoire.reference AS ref_accessoire,
        ------demande------------------
        v_demandeClient.nom_modele,
        v_demandeClient.theme,
        v_demandeClient.date_livraison,
        v_demandeClient.type_saison,
        v_demandeClient.nomtier AS client,
        v_demandeClient.id AS id_demande_client,
        ------tier---------------------
        tiers.nomtier AS fournisseur,
        tiers.id AS id_tiers,
        ------pays---------------------
        pays.id AS idPays,
        pays.nom_fr_fr AS pays,
        ------bc-----------------------
        bc.id AS bcid,
        bc.date_bc,
        bc.echeance,
        ------type_bc------------------
        type_bc.type_bc,
        type_bc.id AS idtypebc

    FROM
        donneBc
    LEFT JOIN v_tissus ON donneBc.id_tissus = v_tissus.id
    LEFT JOIN v_accessoire ON donneBc.id_accessoire = v_accessoire.id
    JOIN detailBc ON donneBc.id_detail = detailBc.id
    JOIN bc ON detailBc.id_bc = bc.id
    JOIN type_bc ON bc.id_type_bc = type_bc.id
    JOIN v_demandeClient ON detailBc.id_demande_client = v_demandeClient.id
    JOIN tiers ON bc.idtier = tiers.id
    JOIN pays ON tiers.idPays = pays.id
);

create or replace view v_tscf as(
    SELECT
        donneBc.*,
        merch.dateex, merch.deadline, merch.transport, merch.dateemmission, merch.numerofacture, merch.montant, merch.detailfacture, merch.commentaire,
        transit.transit, transit.transittime, transit.datedepart, transit.datearrive, transit.awb,
        magasin.datearrivereelle, magasin.bl, magasin.quantite AS magasin_quantite, magasin.reste, magasin.numero,
        reclamation.dateenvoie, reclamation.daterelance, reclamation.raison, reclamation.quantite AS reclamation_quantite, reclamation.remarque, reclamation.retour, reclamation.recompensation, reclamation.note,
        comptabilite.swift, comptabilite.deposit, comptabilite.pri, comptabilite.payer
    FROM
        donneBc
    LEFT JOIN (
        SELECT DISTINCT ON (id_donne_bc) *
        FROM merch
        ORDER BY id_donne_bc, id DESC
    ) AS merch ON donneBc.id = merch.id_donne_bc
    LEFT JOIN (
        SELECT DISTINCT ON (id_donne_bc) *
        FROM transit
        ORDER BY id_donne_bc, id DESC
    ) AS transit ON donneBc.id = transit.id_donne_bc
    LEFT JOIN (
        SELECT DISTINCT ON (id_donne_bc) *
        FROM magasin
        ORDER BY id_donne_bc, id DESC
    ) AS magasin ON donneBc.id = magasin.id_donne_bc
    LEFT JOIN (
        SELECT DISTINCT ON (id_donne_bc) *
        FROM reclamation
        ORDER BY id_donne_bc, id DESC
    ) AS reclamation ON donneBc.id = reclamation.id_donne_bc
    LEFT JOIN (
        SELECT DISTINCT ON (id_donne_bc) *
        FROM comptabilite
        ORDER BY id_donne_bc, id DESC
    ) AS comptabilite ON donneBc.id = comptabilite.id_donne_bc
);
create or replace view v_donne_bc as (
    SELECT
        v_table_suivis.*,
        v_tscf.dateex,
        v_tscf.deadline,
        v_tscf.transport,
        v_tscf.dateemmission,
        v_tscf.numerofacture,
        v_tscf.montant,
        v_tscf.detailfacture,
        v_tscf.commentaire,
        v_tscf.transit,
        v_tscf.transittime,
        v_tscf.datedepart,
        v_tscf.datearrive,
        v_tscf.awb,
        v_tscf.datearrivereelle,
        v_tscf.bl,
        v_tscf.magasin_quantite,
        v_tscf.reste,
        v_tscf.numero,
        v_tscf.dateenvoie,
        v_tscf.daterelance,
        v_tscf.raison,
        v_tscf.reclamation_quantite,
        v_tscf.remarque,
        v_tscf.retour,
        v_tscf.recompensation,
        v_tscf.note,
        v_tscf.swift,
        v_tscf.deposit,
        v_tscf.pri,
        v_tscf.payer
    FROM
        v_table_suivis
    JOIN
        v_tscf ON v_table_suivis.id_donne_bc = v_tscf.id
);



/*---------------------------------------------------------RETRO MERCH------------------------------------------------------------*/






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

CREATE OR REPLACE VIEW v_micro_merch AS
    SELECT
        rc.id AS resultat_id,
        rc.id_etape,
        rc.id_demande_client,
        rc.datecalcul,
        rc.etat AS resultat_etat,

        erm.designation AS etape_designation,
        erm.nbJour AS etape_nbjour,
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
        v.type_etat,
        v.id_etat,
        v.total_qte_detailsdc,

        mmd.semaine AS micro_semaine,
        mmd.realisation AS micro_realisation,
        mmd.commentaires AS micro_commentaires,
        mmd.etat AS micro_etat

    FROM resultatCalcule rc
    JOIN etapeRetroMerch erm ON rc.id_etape = erm.id
    JOIN v_retro_merch v ON rc.id_demande_client = v.demande_id
    LEFT JOIN (
        SELECT DISTINCT ON (id_etape, id_demande) *
        FROM microMerchDev
        ORDER BY id_etape, id_demande, id DESC
    ) mmd ON rc.id_etape = mmd.id_etape AND rc.id_demande_client = mmd.id_demande;



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
        LEFT JOIN destination ON destination.idRecapCommande = recapCommande.id
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



CREATE OR REPLACE VIEW v_combined_confirmation_with_micro AS
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
        v_confirmation_bc c ON m.id = c.tissus_id_demande_client;



-------get deadline dans tscf

CREATE OR REPLACE VIEW v_donne_bc_max_deadline_tissus AS (
    WITH max_dates AS (
        SELECT
            id_demande_client,
            idtypebc,
            MAX(CASE
                WHEN datearrive IS NOT NULL THEN datearrive
                ELSE NULL
            END) AS max_datearrive,
            MAX(deadline) AS max_deadline
        FROM
            v_donne_bc
        GROUP BY
            id_demande_client,
            idtypebc
    )
    SELECT
        v.*,
        CASE
            WHEN md.max_datearrive IS NOT NULL THEN md.max_datearrive
            ELSE md.max_deadline
        END AS final_deadline
    FROM
        v_donne_bc v
    JOIN
        max_dates md ON v.id_demande_client = md.id_demande_client AND 1 = md.idtypebc
);


CREATE OR REPLACE VIEW v_donne_bc_max_deadline_accy AS (
    WITH max_dates AS (
        SELECT
            id_demande_client,
            idtypebc,
            MAX(CASE
                WHEN datearrive IS NOT NULL THEN datearrive
                ELSE NULL
            END) AS max_datearrive,
            MAX(deadline) AS max_deadline
        FROM
            v_donne_bc
        GROUP BY
            id_demande_client,
            idtypebc
    )
    SELECT
        v.*,
        CASE
            WHEN md.max_datearrive IS NOT NULL THEN md.max_datearrive
            ELSE md.max_deadline
        END AS final_deadline
    FROM
        v_donne_bc v
    JOIN
        max_dates md ON v.id_demande_client = md.id_demande_client AND 2 = md.idtypebc
);

CREATE OR REPLACE VIEW v_donne_bc_max_deadline_combined AS (
    SELECT
        t.*,
        a.final_deadline AS accy_final_deadline
    FROM
        v_donne_bc_max_deadline_tissus t
    FULL OUTER JOIN
        v_donne_bc_max_deadline_accy a ON t.id_demande_client = a.id_demande_client
);


-----get date reel dans tscf

CREATE OR REPLACE VIEW v_donne_bc_max_datearrivereelle_tissus AS (
    WITH max_dates AS (
        SELECT
            id_demande_client,
            idtypebc,
            MAX(datearrivereelle) AS max_datearrivereelle
        FROM
            v_donne_bc
        GROUP BY
            id_demande_client,
            idtypebc
    )
    SELECT
        v.*,
        md.max_datearrivereelle
    FROM
        v_donne_bc v
    JOIN
        max_dates md ON v.id_demande_client = md.id_demande_client AND 1 = md.idtypebc
);
CREATE OR REPLACE VIEW v_donne_bc_max_datearrivereelle_accy AS (
    WITH max_dates AS (
        SELECT
            id_demande_client,
            idtypebc,
            MAX(datearrivereelle) AS max_datearrivereelle
        FROM
            v_donne_bc
        GROUP BY
            id_demande_client,
            idtypebc
    )
    SELECT
        v.*,
        md.max_datearrivereelle
    FROM
        v_donne_bc v
    JOIN
        max_dates md ON v.id_demande_client = md.id_demande_client AND 2 = md.idtypebc
);

CREATE OR REPLACE VIEW v_donne_bc_max_datearrivereelle AS (
    SELECT
        t.*,
        a.max_datearrivereelle AS accy_max_datearrivereelle
    FROM
        v_donne_bc_max_datearrivereelle_tissus t
    FULL OUTER JOIN
        v_donne_bc_max_datearrivereelle_accy a ON t.id_demande_client = a.id_demande_client
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


-- sarobidy
------------------------------------------------------------------- OBJECTIF SAISON -----------------
CREATE VIEW vue_tiers_objectifsaison AS
SELECT
    os.id as id_obj,
    t.id AS id_tier,
    t.nomTier,
    t.idActeur,
    t.merchSenior,
    t.emailMerchSenior,
    t.merchJunior,
    t.dateentree,
    os.idsaison,
    s.type_saison,
    os.targetsaison,
    os.tauxconfirmation,
    os.etat AS etat_objectif
FROM
    tiers t
JOIN
    objectifsaison os
ON
    t.id = os.idtiers
JOIN
    saison s
ON
    os.idsaison = s.id;



CREATE OR REPLACE VIEW v_recap_objectif_saison AS
WITH nb_commandes AS (
    SELECT
        id_client,
        id_saison,
        COUNT(*) AS nb_commandes
    FROM
        demandeclient
    GROUP BY
        id_client,
        id_saison
),
qte_encours_nego AS (
    SELECT
        id_client,
        id_saison,
        SUM(qte_commande_provisoire) AS total_qte_encours_nego
    FROM
        demandeclient
    WHERE
        id_etat = 1
    GROUP BY
        id_client,
        id_saison
),
qte_confirmee AS (
    SELECT
        id_client,
        id_saison,
        SUM(qte_commande_provisoire) AS total_qte_confirmee
    FROM
        demandeclient
    WHERE
        id_etat = 2
    GROUP BY
        id_client,
        id_saison
)
SELECT
    v.id_obj,
    v.id_tier,
    v.nomTier,
    v.idActeur,
    v.merchSenior,
    v.emailMerchSenior,
    v.merchJunior,
    v.dateentree,
    v.idsaison,
    v.type_saison,
    nc.nb_commandes,
    v.targetsaison,
    qc.total_qte_confirmee,
    qn. total_qte_encours_nego,
    v.tauxconfirmation,
    v.etat_objectif

FROM
    vue_tiers_objectifsaison v
LEFT JOIN
    nb_commandes nc ON v.id_tier = nc.id_client AND v.idsaison = nc.id_saison
LEFT JOIN
    qte_encours_nego qn ON v.id_tier = qn.id_client AND v.idsaison = qn.id_saison
LEFT JOIN
    qte_confirmee qc ON v.id_tier = qc.id_client AND v.idsaison = qc.id_saison;


------------------------------------------------------------------- OBJECTIF SAISON -----------------

-------------------------------------------------------------------MASTER PLAN -----------------
CREATE OR REPLACE VIEW v_recap_master_plan AS
SELECT DISTINCT
    -- Informations de la demande client
    dc.id AS demande_client_id,
    dc.date_entree,
    dc.date_livraison,
    dc.nom_modele,
    dc.theme,
    dc.qte_commande_provisoire,
    dc.photo_commande,
    dc.etat AS etat_demande,
    dc.nomtier AS nom_client,
    dc.id_tiers AS id_client,
    dc.nom_style,
    dc.id_style,
    dc.type_phase,
    dc.id_phase,
    dc.type_saison,
    dc.id_saison,
    dc.type_stade,
    dc.id_stade,
    dc.type_etat,
    dc.id_etat,

    -- Informations de recapCommande
    rc.id AS id_recap_commande,
    rc.etdRevise,
    rc.etdPropose,
    rc.date_bc_tissu,
    rc.date_bc_access,
    rc.podateprev,
    rc.receptionbc AS podate,
    rc.bcClient,
    rc.etat AS etat_recap_commande,

    -- Informations de destination
    d.id AS id_destination,
    d.numeroCommande,
    d.etdInitial,
    d.dateLivraisonExacte,
    d.dateInspection,
    d.qteOF,
    d.etat AS etat_destination,

    -- Information de destStd
    dst.id as id_deststd,
    dst.designation as designation_destStd,
    dst.etat as etat_destStd,

    -- Informations de masterPlan
    mp.id AS id_master_plan,
    mp.date_MP_Initial,
    mp.date_MP_reel,
    mp.date_E_init,
    mp.date_E_reel,
    mp.date_Prod_Initial,
    mp.date_Prod_reel,
    mp.leadTimeReel,
    mp.nbrJProd,
    mp.statutCommande,
    mp.etat AS etat_master_plan,

    -- Informations du stade spécifique et du stade master plan
    ss.id AS id_stade_specifique,
    ss.designation AS designation_stade_specifique,
    ss.niveau AS niveau_stade_specifique,
    smp.id AS id_stade_master_plan,
    smp.designation AS designation_stade_master_plan,
    smp.niveau AS niveau_stade_master_plan,

    -- Information sur les valeurs ajoutées, agrégation des valeurs ajoutées pour la même commande
    STRING_AGG(va.type_valeur_ajoutee, ', ') AS types_valeur_ajoutee,
    STRING_AGG(va.etat::text, ', ') AS etats_valeur_ajoutee
FROM
    v_demandeClient dc
JOIN
    recapCommande rc ON rc.idDemandeClient = dc.id
JOIN
    destination d ON d.idRecapCommande = rc.id
JOIN
    destStd dst ON d.idDestStd=dst.id
JOIN
    masterPlan mp ON mp.idDemandeClient = dc.id
JOIN
    stadeSpecifique ss ON ss.id = mp.idStadeSpecifique
JOIN
    stadeMasterPlan smp ON smp.id = ss.idStadeMasterPlan
JOIN
    v_valeurAjouteeDemande va ON va.id_demande_client = dc.id
GROUP BY
    dc.id, rc.id, d.id, mp.id,ss.id, smp.id,dst.id,
    dc.date_entree,
    dc.date_livraison,
    dc.nom_modele,
    dc.theme,
    dc.qte_commande_provisoire,
    dc.photo_commande,
    dc.etat ,
    dc.nomtier,
    dc.id_tiers,
    dc.nom_style,
    dc.id_style,
    dc.type_phase,
    dc.id_phase,
    dc.type_saison,
    dc.id_saison,
    dc.type_stade,
    dc.id_stade,
    dc.type_etat,
    dc.id_etat,
    rc.etdRevise,
    rc.etdPropose,
    rc.date_bc_tissu,
    rc.date_bc_access,
    rc.podateprev,
    rc.receptionbc,
    rc.bcClient,
    rc.etat,
    d.numeroCommande,
    d.etdInitial,
    d.dateLivraisonExacte,
    d.dateInspection,
    d.qteOF,
    d.etat,
    dst.designation,
    dst.etat,
    mp.date_MP_Initial,
    mp.date_MP_reel,
    mp.date_E_init,
    mp.date_E_reel,
    mp.date_Prod_Initial,
    mp.date_Prod_reel,
    mp.leadTimeReel,
    mp.nbrJProd,
    mp.statutCommande,
    mp.etat,
    ss.designation,
    ss.niveau,
    smp.designation,
    smp.niveau;
-------------------------------------------------------------------MASTER PLAN -----------------
-------------------------------------------DATA & MACRO -----------------
-- smv+demandeclient
CREATE OR REPLACE VIEW v_detail_smv_demande AS
SELECT
    v_smv.smv_id,
    v_smv.date_smv,
    v_smv.smv_prod,
    v_smv.smv_finition,
    v_smv.prix_print,
    v_smv.id_unite_monetaire,
    v_smv.nombre_points,
    v_smv.smv_brod_main,
    v_smv.smv_commentaire,
    v_smv.smv_etat,
    v_smv.smv_type_stade,
    v_smv.smv_unite,
    v_demandeClient.id AS demande_client_id,
    v_demandeClient.date_entree,
    v_demandeClient.date_livraison,
    v_demandeClient.nom_modele,
    v_demandeClient.theme,
    v_demandeClient.qte_commande_provisoire,
    v_demandeClient.taille_base,
    v_demandeClient.requete_client,
    v_demandeClient.commentaire_merch,
    v_demandeClient.photo_commande,
    v_demandeClient.etat AS demande_client_etat,
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
    v_demandeClient.type_stade AS demande_client_type_stade,
    v_demandeClient.id_stade AS demande_client_id_stade,
    v_demandeClient.type_etat AS demande_client_type_etat,
    v_demandeClient.id_etat AS demande_client_id_etat
FROM
    v_demandeClient
LEFT JOIN (
    SELECT
        DISTINCT ON (id_demande_client) id AS smv_id,
        date_smv,
        smv_prod,
        smv_finition,
        prix_print,
        id_unite_monetaire,
        nombre_points,
        smv_brod_main,
        commentaire AS smv_commentaire,
        etat AS smv_etat,
        type_stade AS smv_type_stade,
        unite AS smv_unite,
        id_demande_client
    FROM v_smv
    ORDER BY id_demande_client, id DESC
) v_smv
ON v_demandeClient.id = v_smv.id_demande_client;

--
CREATE OR REPLACE VIEW v_data_all_details AS
SELECT DISTINCT
    mp.demande_client_id,
    mp.date_entree,
    mp.date_livraison,
    mp.nom_modele,
    mp.theme,
    mp.qte_commande_provisoire,
    mp.photo_commande,
    mp.etat_demande,
    mp.nom_client,
    mp.id_client,
    mp.nom_style,
    mp.id_style,
    d.id_phase,
    mp.type_phase,
    mp.type_saison,
    mp.id_saison,
    mp.type_stade,
    mp.id_stade,
    mp.type_etat,
    mp.id_etat,

    mp.id_recap_commande,
    mp.etdRevise,
    mp.etdPropose,
    mp.podateprev,
    mp.podate,
    mp.bcClient,
    mp.date_bc_tissu,
    mp.date_bc_access,
    mp.etat_recap_commande,

    dsmd.smv_id,
    dsmd.date_smv,
    dsmd.smv_prod,
    dsmd.smv_finition,
    dsmd.prix_print,
    dsmd.nombre_points,
    dsmd.smv_brod_main,
    dsmd.smv_commentaire,
    dsmd.date_entree as date_entree_smv,
    dsmd.date_livraison as date_livraison_smv,

    bc.pays,
    bc.adresse,
    bc.numPhone,
    bc.emailtier,
    bc.date_bc,
    bc.numero_bc,
    bc.echeance,
    bc.etat_bc,

    mp.id_master_plan,
    mp.date_E_init,
    mp.date_E_reel,
    mp.date_MP_Initial,
    mp.date_MP_reel,
    mp.date_Prod_Initial,
    mp.date_Prod_reel,
    mp.leadTimeReel,
    mp.nbrJProd,
    mp.statutCommande,
    mp.etat_master_plan,
    mp.numeroCommande,
    mp.etdInitial,
    mp.dateLivraisonExacte,
    mp.dateInspection,

    mp.id_deststd,
    mp.designation_destStd,
    mp.etat_destStd,

    mp.id_stade_specifique,
    mp.designation_stade_specifique,
    mp.niveau_stade_specifique,
    mp.id_stade_master_plan,
    mp.designation_stade_master_plan,
    mp.niveau_stade_master_plan,
    mp.types_valeur_ajoutee,
    mp.etats_valeur_ajoutee,

    d.id_unite_taille_min,
    d.taillemin,
    d.id_unite_taille_max,
    d.taillemax,
    d.taille_base,
    d.id_incontern,
    d.type_incontern
FROM
    v_recap_master_plan mp
LEFT JOIN v_detail_smv_demande dsmd
    ON mp.demande_client_id = dsmd.demande_client_id
LEFT JOIN v_bc bc
    ON mp.id_client = bc.tiers_id
LEFT JOIN v_demandeClient d
    ON mp.demande_client_id = d.id;

-------------------------------------------DATA & MACRO -----------------



-- MOIS MAX
-- liste data
create view v_data_details as
WITH details AS (
    SELECT
        demande_client_id,
        id_recap_commande,
        date_bc_tissu,
        date_bc_access,
        date_prod_initial,
        date_prod_reel,
        GREATEST(
            COALESCE(date_prod_reel, date_prod_initial),
            date_bc_tissu,
            date_bc_access
        ) AS date_max,
        TO_CHAR(GREATEST(
            COALESCE(date_prod_reel, date_prod_initial),
            date_bc_tissu,
            date_bc_access
        ), 'MM') AS mois_date_max
    FROM
        v_recap_master_plan
)
SELECT
    d.mois_date_max,
    v.demande_client_id,
    v.id_recap_commande,
    v.numerocommande,
    v.type_saison,
    v.nom_client,
    v.nom_modele,
    v.id_style ,
    v.nom_style,
    s.efficience,
    s.effectif,
    s.pointdev,
    v.theme,
    v.qte_commande_provisoire AS qte,
    v.etdrevise,
    v.etdinitial,
    v.etdpropose,
    v.podate,
    v.podateprev,
    v.bcclient,
    d.date_max AS date_disponibilite,
    d.date_bc_tissu,
    d.date_bc_access,
    COALESCE(d.date_prod_reel, d.date_prod_initial) AS date_ok_prod,
    v.smv_prod,
    v.smv_finition,
    v.prix_print,
    v.smv_brod_main,
    v.nombre_points,
    v.dateinspection,
    v.designation_deststd AS destination,
    v.taillemin,
    v.taillemax,
    v.taille_base,
    v.type_incontern,
    v.type_phase
FROM
    v_data_all_details v
JOIN
    details d ON v.demande_client_id = d.demande_client_id
    AND v.id_recap_commande = d.id_recap_commande
JOIN
    style s ON s.id=v.id_style ;

create or replace view v_tauxConfirmeClient as
SELECT SUM(qte_commande_provisoire) as quantiteTotal, id_tiers, objectifsaison.targetsaison,id_saison,nomtier,type_saison
FROM v_demandeclient
JOIN objectifsaison ON objectifsaison.idtiers = v_demandeclient.id_tiers
GROUP BY id_tiers, objectifsaison.targetsaison,id_saison,nomtier,type_saison;
