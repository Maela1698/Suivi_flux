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





------------------------------------------------------------------NOTIA----------------------------------------------------------------------



create or replace view v_bc_demande_distinct as(
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
        bc.etat AS etat_bc,
        demandeClient.id AS id_demande_client
    FROM tiers t
    JOIN pays p ON p.id = t.idpays
    JOIN acteurTiers a ON a.id = t.idacteur
    JOIN unitemonetaire u ON u.id = t.idunite
    JOIN qualiteTiers q ON q.id = t.idqualite
    JOIN etatTiers e ON e.id = t.idetat
    JOIN bc ON bc.idtier = t.id
    JOIN detailBc ON detailBc.id_bc = bc.id
    JOIN demandeClient ON demandeClient.id = detailBc.id_demande_client
);



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



-- CREATE VIEW v_etape_retro AS
--     SELECT
--         e.id AS id_etape,
--         e.designation,
--         e.nbJour,
--         e.etat AS etat_etape,
--         r.id AS id_resultat,
--         r.id_demande_client,
--         r.datecalcul,
--         r.etat AS etat_resultat
--     FROM
--         etapeRetroMerch e
--     JOIN
--         resultatCalcule r
--     ON
--         e.id = r.id_etape
--     WHERE
--         e.etat = 0;



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


------------------------------------------------------------V_LRP-----------------------------------------------
CREATE OR REPLACE VIEW v_micro_merch AS (
    SELECT
        rc.id AS resultat_id,
        rc.id_etape,
        rc.id_demande_client,
        rc.date_fin_prevue as datecalcul,
        rc.date_fin_reelle as micro_realisation,
        rc.semaine,
        rc.annee,
        rc.etat AS resultat_etat,
        rc.commentaires AS micro_commentaires,

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
        v.type_etat,
        v.id_etat,
        v.total_qte_detailsdc,

        mmd.semaine AS micro_semaine,
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

CREATE OR REPLACE VIEW v_final_recap AS (
        SELECT
            last_demande.*,
            recap_livraison.couleur AS livraison_couleur
        FROM v_combined_full_info last_demande
        LEFT JOIN v_recap_commande_livraison recap_livraison
            ON last_demande.recapCommande_id = recap_livraison.idRecapCommande
);

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

CREATE OR REPLACE VIEW v_recap_master_plan AS (
    WITH date_max AS(SELECT
        id,
        combined_final_deadline as date_bc_tissu_prev,
        max_datearrivereelle as date_bc_tissu_reelle,
        combined_final_deadline_accy as date_bc_accy_prev,
        accy_max_datearrivereelle as date_bc_accy_reelle,
        micro_datecalcul as ok_prod,

        -- Si combined_final_deadline est non null, prendre cette valeur, sinon prendre max_datearrivereelle
        COALESCE(combined_final_deadline, max_datearrivereelle) AS tissu_max,

        -- Si combined_final_deadline_accy est non null, prendre cette valeur, sinon prendre accy_max_datearrivereelle
        COALESCE(combined_final_deadline_accy, accy_max_datearrivereelle) AS accy_max,
        GREATEST(micro_datecalcul, max_datearrivereelle, combined_final_deadline, accy_max_datearrivereelle,
        combined_final_deadline_accy) AS disponibilite
    FROM
        v_combined_full_info)
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
        -- d.qteOF,
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
        STRING_AGG( ss.designation, ', ') AS designation_stade_specifique,
        -- ss.designation AS designation_stade_specifique,
        ss.niveau AS niveau_stade_specifique,
        smp.id AS id_stade_master_plan,
        smp.designation AS designation_stade_master_plan,
        smp.niveau AS niveau_stade_master_plan,

        -- Information sur les valeurs ajoutées, agrégation des valeurs ajoutées pour la même commande
        STRING_AGG(va.type_valeur_ajoutee, ', ') AS types_valeur_ajoutee,
        STRING_AGG(va.etat::text, ', ') AS etats_valeur_ajoutee,

        dm.tissu_max,
        dm.accy_max,
        dm.date_bc_tissu_prev,
        dm.date_bc_tissu_reelle,
        dm.date_bc_accy_prev,
        dm.date_bc_accy_reelle,
        dm.disponibilite,
        dm.ok_prod
    FROM
        v_demandeClient dc
    JOIN
        date_max dm ON dc.id = dm.id
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
        smp.niveau,
        dm.tissu_max,
        dm.accy_max,
        dm.date_bc_tissu_prev,
        dm.date_bc_tissu_reelle,
        dm.date_bc_accy_prev,
        dm.date_bc_accy_reelle,
        dm.disponibilite,
        dm.ok_prod
);

CREATE OR REPLACE VIEW v_data_all_details AS (
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

        mp.disponibilite,
        mp.tissu_max,
        mp.accy_max,
        mp.date_bc_tissu_prev,
        mp.date_bc_tissu_reelle,
        mp.date_bc_accy_prev,
        mp.date_bc_accy_reelle,
        mp.ok_prod,

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
        ON mp.demande_client_id = d.id
);

CREATE OR REPLACE VIEW v_data_details AS(
    WITH mois AS (
        SELECT
            demande_client_id,
            EXTRACT(MONTH FROM disponibilite) AS mois
        FROM v_data_all_details
    )
    SELECT
        v.demande_client_id,
        v.id_recap_commande,
        v.numerocommande,
        v.id_saison,
        v.type_saison,
        v.nom_client,
        v.nom_modele,
        v.id_style,
        v.nom_style,
        s.efficience,
        s.effectif,
        s.pointdev,
        v.theme,
        v.qte_commande_provisoire AS qte,
        v.photo_commande,
        v.etdrevise,
        v.etdinitial,
        v.etdpropose,
        v.podate,
        v.podateprev,
        v.bcclient,
        m.mois as mois_date_max,
        v.disponibilite,
        v.tissu_max,
        v.accy_max,
        v.date_bc_tissu_prev,
        v.date_bc_tissu_reelle,
        v.date_bc_accy_prev,
        v.date_bc_accy_reelle,
        v.ok_prod,
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
        v.type_phase,
        v.id_stade_specifique,
        v.designation_stade_specifique,
        -- Agrégation des types et états des valeurs ajoutées

        STRING_AGG(v.types_valeur_ajoutee, ', ') AS types_valeur_ajoutee,
        STRING_AGG(v.etats_valeur_ajoutee, ', ') AS etats_valeur_ajoutee

    FROM
        v_data_all_details v
    JOIN
        style s ON s.id = v.id_style
    JOIN
        mois m ON m.demande_client_id = v.demande_client_id
    GROUP BY
        v.demande_client_id,
        v.id_saison,
        v.id_recap_commande,
        v.numerocommande,
        v.photo_commande,
        v.type_saison,
        v.nom_client,
        v.nom_modele,
        v.id_style,
        v.nom_style,
        s.efficience,
        s.effectif,
        s.pointdev,
        v.theme,
        v.qte_commande_provisoire,
        v.etdrevise,
        v.etdinitial,
        v.etdpropose,
        v.podate,
        v.podateprev,
        v.bcclient,
        m.mois,
        v.disponibilite,
        v.tissu_max,
        v.accy_max,
        v.date_bc_tissu_prev,
        v.date_bc_tissu_reelle,
        v.date_bc_accy_prev,
        v.date_bc_accy_reelle,
        v.ok_prod,
        v.smv_prod,
        v.smv_finition,
        v.prix_print,
        v.smv_brod_main,
        v.nombre_points,
        v.dateinspection,
        v.designation_deststd,
        v.taillemin,
        v.taillemax,
        v.taille_base,
        v.type_incontern,
        v.type_phase,
        v.id_stade_specifique,
        v.designation_stade_specifique
);

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
);

create or replace view v_filtre_data_print as(
    WITH mois AS (
        SELECT
            v_data_all_details.demande_client_id,
            EXTRACT(MONTH FROM COALESCE(dp.inline, dp.propositioninline, v_data_all_details.disponibilite)) AS mois
        FROM
            v_data_all_details
        JOIN
            dataprint dp ON v_data_all_details.demande_client_id = dp.iddemandeclient
    )
    SELECT
        vdd.demande_client_id,
        vdd.id_recap_commande,
        vdd.numerocommande,
        vdd.photo_commande,
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
        m.mois AS mois_date_max,
        vdd.disponibilite as disponibilite_data,
        vdd.tissu_max,
        vdd.accy_max,
        vdd.date_bc_tissu_prev,
        vdd.date_bc_tissu_reelle,
        vdd.date_bc_accy_prev,
        vdd.date_bc_accy_reelle,
        vdd.ok_prod,
        vdd.smv_prod,
        vdd.smv_finition,
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
        dp.id,
        dp.tempsprint,
        dp.propositionInline,
        dp.inline,
        dp.outline,
        dp.effectif,
        dp.efficience,
        dp.capacite,
        dp.jourProd,
        dp.minuteGrmt,
        dp.besoinloading,
        dp.etatJourSpe,
        dp.commentaire,
        dp.heuresup
    FROM
        v_data_details vdd
    LEFT JOIN
        dataprint dp ON vdd.demande_client_id = dp.iddemandeclient
    -- LEFT JOIN
    --     tiers t ON vdd.nom_client = t.nomtier
    LEFT JOIN
        mois m ON vdd.demande_client_id = m.demande_client_id
);

CREATE OR REPLACE VIEW v_filtre_data AS(
    WITH mois AS (
        SELECT
            v_data_all_details.demande_client_id,
            EXTRACT(MONTH FROM COALESCE(dp.inline, dp.propositioninline, v_data_all_details.disponibilite)) AS mois
        FROM
            v_data_all_details
        JOIN
            dataprod dp ON v_data_all_details.demande_client_id = dp.iddemandeclient
    )
    SELECT
        vdd.demande_client_id,
        vdd.id_recap_commande,
        vdd.numerocommande,
        vdd.photo_commande,
        vdd.id_saison,
        vdd.type_saison,
        vdd.nom_client,
        vdd.nom_modele,
        vdd.id_style,
        vdd.nom_style,
        vdd.efficience,
        vdd.effectif,
        vdd.pointdev,
        vdd.theme,
        vdd.qte,
        vdd.etdrevise,
        vdd.etdinitial,
        vdd.etdpropose,
        vdd.podate,
        vdd.podateprev,
        vdd.bcclient,
        m.mois AS mois_date_max,
        vdd.disponibilite AS disponibilite_data,
        vdd.tissu_max,
        vdd.accy_max,
        vdd.date_bc_tissu_prev,
        vdd.date_bc_tissu_reelle,
        vdd.date_bc_accy_prev,
        vdd.date_bc_accy_reelle,
        vdd.ok_prod,
        vdd.smv_prod,
        vdd.smv_finition,
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
        dp.id,
        dp.disponibilite AS disponibilite_vrai,
        dp.propositionInline,
        dp.inline,
        dp.outline,
        dp.capacite,
        dp.jourProd,
        dp.minuteGrmt,
        dp.etatJourSpe,
        dp.commentaire,
        dp.qte_coupe,
        dp.heuresup,
        c.id_chaine,
        c.designation,
        c.idConformite
        -- vm.estdispo
    FROM
        v_data_details vdd
    LEFT JOIN
        dataprod dp ON vdd.demande_client_id = dp.iddemandeclient
    LEFT JOIN
        chaine c ON dp.id_chaine = c.id_chaine
    -- LEFT JOIN
    --     tiers t ON vdd.nom_client = t.nomtier
    LEFT JOIN
        mois m ON vdd.demande_client_id = m.demande_client_id
);

CREATE OR REPLACE VIEW v_date_tao_estdispo AS (
    SELECT
        demande_client_id,
        CASE
            WHEN tissu_max IS NOT NULL THEN 1
            ELSE 0
        END AS date_tissu,
        CASE
            WHEN accy_max IS NOT NULL THEN 1
            ELSE 0
        END AS date_accy,
        CASE
            WHEN ok_prod IS NOT NULL THEN 1
            ELSE 0
        END AS date_okp
    FROM
        v_filtre_data
);

CREATE OR REPLACE VIEW v_mois_annee_estdispo AS(
    SELECT
        v1.demande_client_id,
        (v1.date_tissu * v1.date_accy * v1.date_okp) AS estdispo,
        EXTRACT(MONTH FROM COALESCE(v2.disponibilite_data, v2.disponibilite_vrai)) AS mois_disponibilite,
        EXTRACT(YEAR FROM COALESCE(v2.disponibilite_data, v2.disponibilite_vrai)) AS annee_disponibilite
    FROM
        v_date_tao_estdispo v1
    JOIN
        v_filtre_data v2 ON v1.demande_client_id = v2.demande_client_id
);

CREATE OR REPLACE VIEW v_nombre_mois_annee_estdispo AS (
    Select
    mois_disponibilite,
    annee_disponibilite,
    estdispo,
    count(*) as nombre
    from v_mois_annee_estdispo
    group by
    mois_disponibilite,
    annee_disponibilite,
    estdispo
);

CREATE OR REPLACE VIEW v_nombre_demande_mois_annee AS(
    Select
    mois_disponibilite,
    annee_disponibilite,
    count(demande_client_id) as nb_demande_mois
    FROM v_mois_annee_estdispo
    GROUP BY
    mois_disponibilite,
    annee_disponibilite
);

CREATE OR REPLACE VIEW v_pourcentage_estdispo AS(
    SELECT
        v1.mois_disponibilite,
        v1.annee_disponibilite,
        v1.estdispo,
        v1.nombre AS nombre_estdispo,
        v2.nb_demande_mois,
        ROUND((v1.nombre::decimal / v2.nb_demande_mois) * 100, 2) AS pourcentage_estdispo
    FROM
        v_nombre_mois_annee_estdispo v1
    JOIN
        v_nombre_demande_mois_annee v2
    ON
        v1.mois_disponibilite = v2.mois_disponibilite
        AND v1.annee_disponibilite = v2.annee_disponibilite
);

create or replace view v_jour_ouvrable as(
    WITH jours_feries_dates AS (
        SELECT
            id,
            MAKE_DATE(annee, mois, jour) AS date
        FROM
            jours_feries
    )
    SELECT
        EXTRACT(YEAR FROM c.date) AS annee,
        EXTRACT(MONTH FROM c.date) AS mois,
        COUNT(*) AS jours_ouvrables
    FROM
        calendrier c
    LEFT JOIN
        jours_feries_dates j
    ON
        c.date = j.date
    WHERE
        EXTRACT(DOW FROM c.date) BETWEEN 1 AND 5 -- Lundi à Vendredi
        AND j.date IS NULL -- Exclure les jours fériés
    GROUP BY
        EXTRACT(YEAR FROM c.date),
        EXTRACT(MONTH FROM c.date)
    ORDER BY
        annee,mois
);

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
    and id_etat !=3 and demande_etat=0
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
    and id_etat != 3 and demande_etat=0
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
            vm.demande_etat,
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
    where id_etat !=3 and demande_etat=0
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
    and id_etat !=3 and demande_etat=0
    ORDER BY id_demande_client, group_number, row_num
);

create or replace view v_filtre_micro as (
    WITH ranked_results AS (
        SELECT
            vm.*,
            ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) AS row_num,
            (ROW_NUMBER() OVER (PARTITION BY vm.id_demande_client ORDER BY vm.id_etape ASC) - 1) / 5 AS group_number
        FROM v_micro_merch vm
        WHERE vm.resultat_etat = 0
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

CREATE OR REPLACE VIEW v_macrocharge_combine AS(
    SELECT
        m.id,
        tm.id_type_macro,
        tm.type_macro,
        m.mois,
        m.annee,
        vp.jours_ouvrables,
        m.absence,
        m.heureTravail,
        m.heureSup,
        md.effectif AS effectif_macro,
        md.efficience AS efficience_macro,
        md.besoin_effectif,
        m.etat,
        (vp.jours_ouvrables*md.effectif*md.efficience+( m.heureSup*md.effectif))as capacite_mois
        -- COALESCE(vp2.pourcentage_estdispo, 0) AS pourcentage_estdispo
    FROM
        type_macrocharge tm
    JOIN
        macrocharge2 m ON tm.id_type_macro = m.id_type_macro
    JOIN
        macrocharge_details md ON m.id = md.id
    JOIN v_jour_ouvrable vp ON m.mois = vp.mois
    AND m.annee = vp.annee
    -- LEFT JOIN
    --     v_pourcentage_estdispo vp2 ON m.mois = vp2.mois_disponibilite
    --                             AND m.annee = vp2.annee_disponibilite
);


CREATE OR REPLACE FUNCTION recalculate_dates(demande_id INTEGER) RETURNS VOID AS $$
    DECLARE
        r RECORD;
        previous_date DATE;
    BEGIN
        FOR r IN
            SELECT *
            FROM resultatcalcule
            WHERE id_demande_client = demande_id and etat = 0
            ORDER BY id_etape
        LOOP
            IF r.id_etape = 1 THEN
                -- Étape initiale, commence avec la date de commencement
                UPDATE resultatcalcule
                SET
                    date_fin_prevue = (SELECT date_entree FROM demandeclient WHERE id = demande_id) + INTERVAL '1 day' * (SELECT nbjour FROM etaperetromerch WHERE id = r.id_etape)
                WHERE id = r.id and r.date_fin_reelle is null and r.etatupdate = 0;
                previous_date := COALESCE(r.date_fin_reelle, (SELECT date_entree FROM demandeclient WHERE id = demande_id) + INTERVAL '1 day' * (SELECT nbjour FROM etaperetromerch WHERE id = r.id_etape));
            ELSE
                -- Étape suivante
                UPDATE resultatcalcule
                SET
                    date_fin_prevue = previous_date + INTERVAL '1 day' * (SELECT nbjour FROM etaperetromerch WHERE id = r.id_etape)
                WHERE id = r.id and r.date_fin_reelle is null and r.etatupdate = 0;
                previous_date := coalesce(r.date_fin_reelle, previous_date + INTERVAL '1 day' * (SELECT nbjour FROM etaperetromerch WHERE id = r.id_etape));
            END IF;
            IF r.etatupdate = 1 THEN
                previous_date := coalesce(r.date_fin_reelle, r.date_fin_prevue);
            end if;
        END LOOP;
    END;
$$ LANGUAGE plpgsql;
------------------------------------------------------------V_LRP-----------------------------------------------



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







-------------------------------view pour filtre mi

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




CREATE OR REPLACE VIEW v_kanban_retro_planning AS






-------------------------------------------------------------------------SAROBIDY---------------------------------------------------------
------------------- OBJECTIF SAISON -----------------
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

------------------- END OBJECTIF SAISON -----------------

-------------------------------------- MASTER PLAN -----------------
CREATE OR REPLACE VIEW v_recap_master_plan AS
WITH date_max AS(SELECT
    id,
    combined_final_deadline as date_bc_tissu_prev,
    max_datearrivereelle as date_bc_tissu_reelle,
    combined_final_deadline_accy as date_bc_accy_prev,
    accy_max_datearrivereelle as date_bc_accy_reelle,
    micro_datecalcul as ok_prod,

     -- Si combined_final_deadline est non null, prendre cette valeur, sinon prendre max_datearrivereelle
    COALESCE(combined_final_deadline, max_datearrivereelle) AS tissu_max,

    -- Si combined_final_deadline_accy est non null, prendre cette valeur, sinon prendre accy_max_datearrivereelle
    COALESCE(combined_final_deadline_accy, accy_max_datearrivereelle) AS accy_max,
    GREATEST(micro_datecalcul, max_datearrivereelle, combined_final_deadline, accy_max_datearrivereelle,
    combined_final_deadline_accy) AS disponibilite
FROM
    v_combined_full_info)
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
    -- d.qteOF,
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
    STRING_AGG( ss.designation, ', ') AS designation_stade_specifique,
    -- ss.designation AS designation_stade_specifique,
    ss.niveau AS niveau_stade_specifique,
    smp.id AS id_stade_master_plan,
    smp.designation AS designation_stade_master_plan,
    smp.niveau AS niveau_stade_master_plan,

    -- Information sur les valeurs ajoutées, agrégation des valeurs ajoutées pour la même commande
    STRING_AGG(va.type_valeur_ajoutee, ', ') AS types_valeur_ajoutee,
    STRING_AGG(va.etat::text, ', ') AS etats_valeur_ajoutee,

    dm.tissu_max,
    dm.accy_max,
    dm.date_bc_tissu_prev,
    dm.date_bc_tissu_reelle,
    dm.date_bc_accy_prev,
    dm.date_bc_accy_reelle,
    dm.disponibilite,
    dm.ok_prod
FROM
    v_demandeClient dc
JOIN
    date_max dm ON dc.id = dm.id
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
    smp.niveau,
    dm.tissu_max,
    dm.accy_max,
    dm.date_bc_tissu_prev,
    dm.date_bc_tissu_reelle,
    dm.date_bc_accy_prev,
    dm.date_bc_accy_reelle,
    dm.disponibilite,
    dm.ok_prod;
-------------------------------------------------END MASTER PLAN -----------------

-------------------------------------------DATA & MACRO -----------------
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

    mp.disponibilite,
    mp.tissu_max,
    mp.accy_max,
    mp.date_bc_tissu_prev,
    mp.date_bc_tissu_reelle,
    mp.date_bc_accy_prev,
    mp.date_bc_accy_reelle,
    mp.ok_prod,

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

CREATE OR REPLACE VIEW v_data_details AS
WITH mois AS (
    SELECT
        demande_client_id,
        EXTRACT(MONTH FROM disponibilite) AS mois
    FROM v_data_all_details
)
SELECT
    v.demande_client_id,
    v.id_recap_commande,
    v.numerocommande,
    v.id_saison,
    v.type_saison,
    v.nom_client,
    v.nom_modele,
    v.id_style,
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
    m.mois as mois_date_max,
    v.disponibilite,
    v.tissu_max,
    v.accy_max,
    v.date_bc_tissu_prev,
    v.date_bc_tissu_reelle,
    v.date_bc_accy_prev,
    v.date_bc_accy_reelle,
    v.ok_prod,
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
    v.type_phase,
    v.id_stade_specifique,
    v.designation_stade_specifique,
    -- Agrégation des types et états des valeurs ajoutées

    STRING_AGG(v.types_valeur_ajoutee, ', ') AS types_valeur_ajoutee,
    STRING_AGG(v.etats_valeur_ajoutee, ', ') AS etats_valeur_ajoutee

FROM
    v_data_all_details v
JOIN
    style s ON s.id = v.id_style
JOIN
    mois m ON m.demande_client_id = v.demande_client_id
GROUP BY
    v.demande_client_id,
    v.id_saison,
    v.id_recap_commande,
    v.numerocommande,
    v.type_saison,
    v.nom_client,
    v.nom_modele,
    v.id_style,
    v.nom_style,
    s.efficience,
    s.effectif,
    s.pointdev,
    v.theme,
    v.qte_commande_provisoire,
    v.etdrevise,
    v.etdinitial,
    v.etdpropose,
    v.podate,
    v.podateprev,
    v.bcclient,
    m.mois,
    v.disponibilite,
    v.tissu_max,
    v.accy_max,
    v.date_bc_tissu_prev,
    v.date_bc_tissu_reelle,
    v.date_bc_accy_prev,
    v.date_bc_accy_reelle,
    v.ok_prod,
    v.smv_prod,
    v.smv_finition,
    v.prix_print,
    v.smv_brod_main,
    v.nombre_points,
    v.dateinspection,
    v.designation_deststd,
    v.taillemin,
    v.taillemax,
    v.taille_base,
    v.type_incontern,
    v.type_phase,
    v.id_stade_specifique,
    v.designation_stade_specifique;

CREATE OR REPLACE VIEW v_filtre_data AS
WITH mois AS (
    SELECT
        v_data_all_details.demande_client_id,
        EXTRACT(MONTH FROM COALESCE(dp.inline, dp.propositioninline, v_data_all_details.disponibilite)) AS mois
    FROM
        v_data_all_details
    JOIN
        dataprod dp ON v_data_all_details.demande_client_id = dp.iddemandeclient
)
SELECT
    vdd.demande_client_id,
    vdd.id_recap_commande,
    vdd.numerocommande,
    vdd.id_saison,
    vdd.type_saison,
    vdd.nom_client,
    vdd.nom_modele,
    vdd.id_style,
    vdd.nom_style,
    vdd.efficience,
    vdd.effectif,
    vdd.pointdev,
    vdd.theme,
    vdd.qte,
    vdd.etdrevise,
    vdd.etdinitial,
    vdd.etdpropose,
    vdd.podate,
    vdd.podateprev,
    vdd.bcclient,
    m.mois AS mois_date_max,
    vdd.disponibilite AS disponibilite_data,
    vdd.tissu_max,
    vdd.accy_max,
    vdd.date_bc_tissu_prev,
    vdd.date_bc_tissu_reelle,
    vdd.date_bc_accy_prev,
    vdd.date_bc_accy_reelle,
    vdd.ok_prod,
    vdd.smv_prod,
    vdd.smv_finition,
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
    dp.id,
    dp.disponibilite AS disponibilite_vrai,
    dp.propositionInline,
    dp.inline,
    dp.outline,
    dp.capacite,
    dp.jourProd,
    dp.minuteGrmt,
    dp.etatJourSpe,
    dp.commentaire,
    dp.qte_coupe,
    dp.heuresup,
    c.id_chaine,
    c.designation,
    c.idConformite
FROM
    v_data_details vdd
LEFT JOIN
    dataprod dp ON vdd.demande_client_id = dp.iddemandeclient
LEFT JOIN
    chaine c ON dp.id_chaine = c.id_chaine
LEFT JOIN
    mois m ON vdd.demande_client_id = m.demande_client_id;




create or replace view v_filtre_data_print as
WITH mois AS (
    SELECT
        v_data_all_details.demande_client_id,
        EXTRACT(MONTH FROM COALESCE(dp.inline, dp.propositioninline, v_data_all_details.disponibilite)) AS mois
    FROM
        v_data_all_details
    JOIN
        dataprint dp ON v_data_all_details.demande_client_id = dp.iddemandeclient
)
SELECT
vdd.demande_client_id,
vdd.id_recap_commande,
vdd.numerocommande,
vdd.id_saison,
vdd.type_saison,
t.id AS id_tier,
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
m.mois AS mois_date_max,
vdd.disponibilite as disponibilite_data,
vdd.tissu_max,
vdd.accy_max,
vdd.date_bc_tissu_prev,
vdd.date_bc_tissu_reelle,
vdd.date_bc_accy_prev,
vdd.date_bc_accy_reelle,
vdd.ok_prod,
vdd.smv_prod,
vdd.smv_finition,
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
dp.id,
dp.tempsprint,
dp.propositionInline,
dp.inline,
dp.outline,
dp.effectif,
dp.efficience,
dp.capacite,
dp.jourProd,
dp.minuteGrmt,
dp.besoinloading,
dp.etatJourSpe,
dp.commentaire,
dp.heuresup
FROM
    v_data_details vdd
LEFT JOIN
    dataprint dp ON vdd.demande_client_id = dp.iddemandeclient
LEFT JOIN
    tiers t ON vdd.nom_client = t.nomtier
LEFT JOIN
    mois m ON vdd.demande_client_id = m.demande_client_id;
-------------------------------------------END DATA & MACRO -----------------

CREATE OR REPLACE VIEW v_macrocharge_combine AS
SELECT
    m.id,
    tm.id_type_macro,
    tm.type_macro,
    m.mois,
    m.annee,
    m.jourOuvrable,
    m.absence,
    m.heureTravail,
    m.heureSup,
    md.effectif as effectif_macro,
    md.efficience as efficience_macro,
    md.besoin_effectif,
    m.etat
FROM
    type_macrocharge tm
JOIN
    macrocharge2 m ON tm.id_type_macro = m.id_type_macro
JOIN
    macrocharge_details md ON m.id = md.id;



CREATE OR REPLACE VIEW v_recap_master_plan AS
WITH date_max AS(SELECT
    id,
    combined_final_deadline as date_bc_tissu_prev,
    max_datearrivereelle as date_bc_tissu_reelle,
    combined_final_deadline_accy as date_bc_accy_prev,
    accy_max_datearrivereelle as date_bc_accy_reelle,
    micro_datecalcul as ok_prod,

     -- Si combined_final_deadline est non null, prendre cette valeur, sinon prendre max_datearrivereelle
    COALESCE(combined_final_deadline, max_datearrivereelle) AS tissu_max,

    -- Si combined_final_deadline_accy est non null, prendre cette valeur, sinon prendre accy_max_datearrivereelle
    COALESCE(combined_final_deadline_accy, accy_max_datearrivereelle) AS accy_max,

    GREATEST(micro_datecalcul, max_datearrivereelle, combined_final_deadline, accy_max_datearrivereelle,
    combined_final_deadline_accy) AS disponibilite
FROM
    v_combined_full_info)
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
    -- d.qteOF,
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
    STRING_AGG( ss.designation, ', ') AS designation_stade_specifique,
    -- ss.designation AS designation_stade_specifique,
    ss.niveau AS niveau_stade_specifique,
    smp.id AS id_stade_master_plan,
    smp.designation AS designation_stade_master_plan,
    smp.niveau AS niveau_stade_master_plan,

    -- Information sur les valeurs ajoutées, agrégation des valeurs ajoutées pour la même commande
    STRING_AGG(va.type_valeur_ajoutee, ', ') AS types_valeur_ajoutee,
    STRING_AGG(va.etat::text, ', ') AS etats_valeur_ajoutee,

    dm.tissu_max,
    dm.accy_max,
    dm.date_bc_tissu_prev,
    dm.date_bc_tissu_reelle,
    dm.date_bc_accy_prev,
    dm.date_bc_accy_reelle,
    dm.disponibilite,
    dm.ok_prod
FROM
    v_demandeClient dc
LEFT JOIN
    date_max dm ON dc.id = dm.id
LEFT JOIN
    recapCommande rc ON rc.idDemandeClient = dc.id
JOIN
    destination d ON d.idRecapCommande = rc.id
LEFT JOIN
    destStd dst ON d.idDestStd=dst.id
JOIN
    masterPlan mp ON mp.idDemandeClient = dc.id
LEFT JOIN
    stadeSpecifique ss ON ss.id = mp.idStadeSpecifique
LEFT JOIN
    stadeMasterPlan smp ON smp.id = ss.idStadeMasterPlan
LEFT JOIN
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
    smp.niveau,
    dm.tissu_max,
    dm.accy_max,
    dm.date_bc_tissu_prev,
    dm.date_bc_tissu_reelle,
    dm.date_bc_accy_prev,
    dm.date_bc_accy_reelle,
    dm.disponibilite,
    dm.ok_prod;








/*function calcule date*/
CREATE OR REPLACE FUNCTION recalculate_dates(demande_id INTEGER) RETURNS VOID AS $$
DECLARE
    r RECORD;
    previous_date DATE;
BEGIN
    FOR r IN
        SELECT *
        FROM resultatcalcule
        WHERE id_demande_client = demande_id and etat = 0
        ORDER BY id_etape
    LOOP
        IF r.id_etape = 1 THEN
            -- Étape initiale, commence avec la date de commencement
            UPDATE resultatcalcule
            SET
                date_fin_prevue = (SELECT date_entree FROM demandeclient WHERE id = demande_id) + INTERVAL '1 day' * (SELECT nbjour FROM etaperetromerch WHERE id = r.id_etape)
            WHERE id = r.id and r.date_fin_reelle is null and r.etatupdate = 0;
            previous_date := COALESCE(r.date_fin_reelle, (SELECT date_entree FROM demandeclient WHERE id = demande_id) + INTERVAL '1 day' * (SELECT nbjour FROM etaperetromerch WHERE id = r.id_etape));
        ELSE
            -- Étape suivante
            UPDATE resultatcalcule
            SET
                date_fin_prevue = previous_date + INTERVAL '1 day' * (SELECT nbjour FROM etaperetromerch WHERE id = r.id_etape)
            WHERE id = r.id and r.date_fin_reelle is null and r.etatupdate = 0;
            previous_date := coalesce(r.date_fin_reelle, previous_date + INTERVAL '1 day' * (SELECT nbjour FROM etaperetromerch WHERE id = r.id_etape));
        END IF;
        IF r.etatupdate = 1 THEN
            previous_date := coalesce(r.date_fin_reelle, r.date_fin_prevue);
        end if;
    END LOOP;
END;
$$ LANGUAGE plpgsql;







INSERT INTO resultatcalcule (id_etape, id_demande_client, date_depart, date_fin_prevue, semaine, annee)
SELECT
    e.id,
    dc.id,
    CASE
        WHEN e.id = 1 THEN dc.date_entree
        ELSE NULL
    END AS date_depart,
    CASE
        WHEN e.id = 1 THEN dc.date_entree + INTERVAL '1 day' * e.nbjour
        ELSE NULL
    END AS date_fin_prevue,
    EXTRACT(WEEK FROM dc.date_entree) AS semaine,
    EXTRACT(YEAR FROM dc.date_entree) AS annee
FROM
    v_demandeclient dc where dc.id_etat!=3 and dc.etat=0
CROSS JOIN
    etaperetromerch e;


insert into recapcommande (iddemandeclient) select id from demandeclient where id_etat =2;

SELECT
    SETVAL(recapcommande_id_seq, (
        SELECT
            MAX(ID)
        FROM
            recapcommande
) + 1);




























































create table chaine(
    id_chaine serial primary key,
    designation varchar(250),
    idConformite int,
    etat int default 0
);

create table dataprod(
    id serial primary key,
    iddemandeclient int references demandeclient(id),
    capacite_theorique int,
    qte_coupe int,
    minuteproduite int,
    nbrJProd int,
    mois int,
    idchaine int references chaine(id_chaine),
    inline date,
    inline_propose date,
    outline date,
    heureSup int,
    efficience int,
    effectif int,
    commentaire text,
    etat int default 0
);

-- function avant sans les prise en compte des modif
-- CREATE OR REPLACE VIEW v_data_plan AS(
--     WITH date_data AS (
--         SELECT
--             *,
--             COALESCE(max_datearrivereelle, combined_final_deadline, date_livraison - INTERVAL '60 days') AS date_tissus_data,
--             COALESCE(accy_max_datearrivereelle, combined_final_deadline_accy, date_livraison - INTERVAL '60 days') AS date_accy_data,
--             COALESCE(micro_realisation, micro_datecalcul, date_livraison - INTERVAL '46 days') AS date_ok_prod_data,
--             GREATEST(
--                 COALESCE(max_datearrivereelle, combined_final_deadline, date_livraison - INTERVAL '60 days'),
--                 COALESCE(accy_max_datearrivereelle, combined_final_deadline_accy, date_livraison - INTERVAL '60 days'),
--                 COALESCE(micro_realisation, micro_datecalcul, date_livraison - INTERVAL '46 days')
--             ) AS date_dispo_data
--         FROM v_general_final_recap
--     )
--     SELECT
--         dd.*,
--         dp.id AS dataprod_id,
--         dp.iddemandeclient,
--         dp.idchaine,
--         dp.inline,
--         dp.heureSup,
--         dp.commentaire,
--         dp.qte_coupe,
--         COALESCE(dp.efficience,s.efficience) AS efficience,
--         COALESCE(dp.effectif,s.effectif) AS effectif,
--         c.designation AS chaine_designation,
--         dd.smv_prod*dd.qte_commande_provisoire AS minuteGrmt,
--         dd.date_dispo_data + INTERVAL '5 days' AS inline_propose,
--         COALESCE(EXTRACT(MONTH FROM dp.inline), EXTRACT(MONTH FROM dd.date_dispo_data + INTERVAL '5 days')) AS mois_data_prod,
--         CEIL(COALESCE(
--         (CASE WHEN (dd.smv_prod + dd.smv_finition) = 0 THEN 0
--             ELSE (COALESCE(dp.efficience,s.efficience) * COALESCE(dp.effectif,s.effectif) * (8+COALESCE(dp.heureSup,0)) * 60) / (dd.smv_prod + dd.smv_finition) END),
--             0
--         )) AS capacite_theorique,
--         CEIL(
--             COALESCE(
--                 dd.qte_commande_provisoire /
--                 (CASE WHEN (dd.smv_prod + dd.smv_finition) = 0 THEN 0
--                     ELSE (COALESCE(dp.efficience,s.efficience) * COALESCE(dp.effectif,s.effectif) * (8+COALESCE(dp.heureSup,0)) * 60) / (dd.smv_prod + dd.smv_finition) END),
--                 0
--                     )
--                 ) AS nbrJProd,
--                 COALESCE(
--             dp.inline,
--             dd.date_dispo_data + INTERVAL '5 days'
--         ) +
--         (CEIL(
--             COALESCE(
--                 dd.qte_commande_provisoire /
--                 (CASE WHEN (dd.smv_prod + dd.smv_finition) = 0 THEN 0
--                     ELSE (COALESCE(dp.efficience,s.efficience) * COALESCE(dp.effectif,s.effectif) * (8+COALESCE(dp.heureSup,0)) * 60) / (dd.smv_prod + dd.smv_finition) END),
--                 0
--             )
--         ) || ' days')::INTERVAL AS outline

--     FROM date_data dd
--     JOIN style s ON dd.id_style = s.id
--     LEFT JOIN dataprod dp ON dd.id = dp.iddemandeclient
--     LEFT JOIN chaine c ON dp.idchaine = c.id_chaine
-- );


CREATE OR REPLACE VIEW v_data_plan AS(
    WITH date_data AS (
        SELECT
            *,
            COALESCE(max_datearrivereelle, combined_final_deadline, date_livraison - INTERVAL '60 days') AS date_tissus_data,
            COALESCE(accy_max_datearrivereelle, combined_final_deadline_accy, date_livraison - INTERVAL '60 days') AS date_accy_data,
            COALESCE(micro_realisation, micro_datecalcul, date_livraison - INTERVAL '46 days') AS date_ok_prod_data,
            GREATEST(
                COALESCE(max_datearrivereelle, combined_final_deadline, date_livraison - INTERVAL '60 days'),
                COALESCE(accy_max_datearrivereelle, combined_final_deadline_accy, date_livraison - INTERVAL '60 days'),
                COALESCE(micro_realisation, micro_datecalcul, date_livraison - INTERVAL '46 days')
            ) AS date_dispo_data
        FROM v_general_final_recap
    )
    SELECT
        dd.*,
        dp.id AS dataprod_id,
        dp.iddemandeclient,
        dp.idchaine,
        dp.inline,
        dp.heureSup,
        dp.commentaire,
        dp.qte_coupe,
        COALESCE(dp.efficience,s.efficience) AS efficience,
        COALESCE(dp.effectif,s.effectif) AS effectif,
        c.designation AS chaine_designation,
        COALESCE(dp.minuteproduite,dd.smv_prod*dd.qte_commande_provisoire) AS minuteGrmt,
        COALESCE(dp.inline_propose,dd.date_dispo_data + INTERVAL '5 days') AS inline_propose,
        COALESCE(dp.mois,COALESCE(EXTRACT(MONTH FROM dp.inline), EXTRACT(MONTH FROM dd.date_dispo_data + INTERVAL '5 days'))) AS mois_data_prod,
        COALESCE(dp.capacite_theorique,CEIL(COALESCE(
        (CASE WHEN (dd.smv_prod + dd.smv_finition) = 0 THEN 0
            ELSE (COALESCE(dp.efficience,s.efficience) * COALESCE(dp.effectif,s.effectif) * (8+COALESCE(dp.heureSup,0)) * 60) / (dd.smv_prod + dd.smv_finition) END),
            0
        ))) AS capacite_theorique,
        CEIL(
            COALESCE(dp.nbrJProd,COALESCE(
                dd.qte_commande_provisoire /
                (CASE WHEN (dd.smv_prod + dd.smv_finition) = 0 THEN 0
                    ELSE (COALESCE(dp.efficience,s.efficience) * COALESCE(dp.effectif,s.effectif) * (8+COALESCE(dp.heureSup,0)) * 60) / (dd.smv_prod + dd.smv_finition) END),
                0
                    )
                )
                ) AS nbrJProd,
                COALESCE(dp.outline,COALESCE(
            dp.inline,
            dd.date_dispo_data + INTERVAL '5 days'
        ) +
        (CEIL(
            COALESCE(dp.nbrJProd,COALESCE(
                dd.qte_commande_provisoire /
                (CASE WHEN (dd.smv_prod + dd.smv_finition) = 0 THEN 0
                    ELSE (COALESCE(dp.efficience,s.efficience) * COALESCE(dp.effectif,s.effectif) * (8+COALESCE(dp.heureSup,0)) * 60) / (dd.smv_prod + dd.smv_finition) END),
                0
                    )
                )
        ) || ' days')::INTERVAL) AS outline

    FROM date_data dd
    JOIN style s ON dd.id_style = s.id
    LEFT JOIN dataprod dp ON dd.id = dp.iddemandeclient
    LEFT JOIN chaine c ON dp.idchaine = c.id_chaine
);


create or replace view v_kanban_retro_planing as(
        SELECT
        *,
        vdp.*,
        rp.*
        FROM
        chaine c
    LEFT JOIN
        v_data_plan vdp ON c.id_chaine = vdp.idchaine
    LEFT JOIN
        retro_planing rp ON rp.id_data_prod = vdp.dataprod_id
);















