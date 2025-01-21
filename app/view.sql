-- v_tiers
create or replace view v_tiers as select
tiers.id,
tiers.etat,
tiers.dateentree, tiers.nomtier, tiers.numphone, tiers.emailtier,
pays.nom_fr_fr,pays.id as idpays,
acteurtiers.acteur, acteurtiers.id as idacteurtiers,
etattiers.etattiers,etattiers.id as idetattiers,
qualiteTiers.qualite,qualiteTiers.id as idqualiteTiers,
unitemonetaire.unite,unitemonetaire.id as idunitemonetaire
from tiers
join pays on pays.id=tiers.idpays
join acteurtiers on acteurtiers.id=tiers.idacteur
join etattiers on etattiers.id= tiers.idetat
join qualiteTiers on qualiteTiers.id = tiers.idqualite
join unitemonetaire on unitemonetaire.id=tiers.idunite;
-- view filtre tiers
create or replace view v_filtreTier as(
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
JOIN
    pays p ON t.idPays = p.id
JOIN
    acteurTiers a ON t.idActeur = a.id
JOIN
    uniteMonetaire u ON t.idUnite = u.id
JOIN
    qualiteTiers q ON t.idQualite = q.id
JOIN
    etatTiers e ON t.idEtat = e.id
);

-- v_demande client
create or replace view v_demandeClient as
select demandeClient.id,
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
stadedemandeclient.quantite as stade_quantite,
etatdemandeclient.type_etat,
etatdemandeclient.id as id_etat
from demandeClient
join tiers on tiers.id = demandeClient.id_client
join style on style.id = demandeClient.id_style
join incontern on incontern.id = demandeClient.id_incontern
join phase on phase.id = demandeClient.id_phase
join saison on saison.id = demandeClient.id_saison
join unitetaille ut_min on ut_min.id = demandeClient.id_unite_taille_min
join unitetaille ut_max on  ut_max.id = demandeClient.id_unite_taille_max
join stadedemandeclient on stadedemandeclient.id = demandeClient.id_stade
join etatdemandeclient on etatdemandeclient.id = demandeClient.id_etat;

-- view lavage demande client
create or replace view v_lavageDemandeClient as
select lavageDemandeClient.id,lavageDemandeClient.etat,lavageDemandeClient.id_demande_client,lavageDemandeClient.id_lavage,
lavage.type_lavage
from lavageDemandeClient
join lavage on lavage.id=lavageDemandeClient.id_lavage
join demandeClient on demandeClient.id= lavageDemandeClient.id_demande_client;

-- view valeur ajoutee demande client
create or replace view v_valeurAjouteeDemande as
select valeurAjouteeDemande.id,valeurAjouteeDemande.etat,valeurAjouteeDemande.id_demande_client,valeurAjouteeDemande.id_valeur_ajoutee,
valeurAjoutee.type_valeur_ajoutee
from valeurAjouteeDemande
join valeurAjoutee on valeurAjoutee.id = valeurAjouteeDemande.id_valeur_ajoutee;

-- view detaille taille demande client
create or replace view v_detailTailleDemandeClient as
select detailTailleDemandeClient.id, detailTailleDemandeClient.id_demande_client,detailTailleDemandeClient.id_unite_taille,detailTailleDemandeClient.conso,
detailTailleDemandeClient.quantite, detailTailleDemandeClient.etat,
uniteTaille.unite_taille,uniteTaille.rang
from detailTailleDemandeClient
join uniteTaille on uniteTaille.id=detailTailleDemandeClient.id_unite_taille;

-- view tissu
CREATE OR REPLACE VIEW v_tissus AS
SELECT
    tissus.*,
    typeTissus.type_tissus,
    categorieTissus.categorie,
    compositionTissus.composition_tissus,
    uniteMesureMatierePremiere.unite_mesure,
    uniteMonetaire.unite,
    familleTissus.famille_tissus,
    classeMatierePremiere.classe
FROM
    tissus
left JOIN
    typeTissus ON typeTissus.id = tissus.id_type_tissus
left JOIN
    categorieTissus ON categorieTissus.id = tissus.id_categorie_tissus
left JOIN
    compositionTissus ON compositionTissus.id = tissus.id_composition_tissus
left JOIN
    uniteMesureMatierePremiere ON uniteMesureMatierePremiere.id = tissus.id_unite_mesure_matiere
left JOIN
    uniteMonetaire ON uniteMonetaire.id = tissus.id_unite_monetaire
left JOIN
    familleTissus ON familleTissus.id = tissus.id_famille_tissus
left JOIN
    classeMatierePremiere ON classeMatierePremiere.id = tissus.id_classe;

-- view accessoire

create or replace view v_accessoire as
select accessoire.*,
typeAccessoire.type_accessoire,
uniteMonetaire.unite,
uniteMesureMatierePremiere.unite_mesure,
familleAccessoire.famille_accessoire,
classeMatierePremiere.classe
from accessoire
left join typeAccessoire on typeAccessoire.id= accessoire.id_type_accessoire
left join uniteMonetaire on uniteMonetaire.id = accessoire.id_unite_monetaire
left join demandeClient on demandeClient.id = accessoire.id_demande_client
left join uniteMesureMatierePremiere on uniteMesureMatierePremiere.id = accessoire.id_unite_mesure_matiere
left join familleAccessoire on familleAccessoire.id= accessoire.id_famille_accessoire
left join classeMatierePremiere on classeMatierePremiere.id = accessoire.id_classe;

--  view detail sdc
create or replace view v_detailSdc as
select detailSdc.*,
v_detailtailledemandeclient.unite_taille,
v_detailtailledemandeclient.rang
from detailSdc
join v_detailtailledemandeclient on v_detailtailledemandeclient.id = detailSdc.id_unite_taille_dc;

-- view smv
create or replace view v_smv as
select smv.*,
stadeDemandeClient.type_stade,
uniteMonetaire.unite
from smv
join stadeDemandeClient on stadeDemandeClient.id=smv.id_stade_demande_client
join uniteMonetaire on uniteMonetaire.id= smv.id_unite_monetaire;

-- view pri
create or replace view v_pri as
select pri.*,
uniteMonetaire.unite
from pri
join uniteMonetaire on uniteMonetaire.id = pri.id_unite_monetaire;

-- view envoye echantillon
CREATE VIEW v_echantillon AS
SELECT
    envoieEchantillon.*,
    stadeDemandeClient.type_stade
FROM
    envoieEchantillon
JOIN
    stadeDemandeClient
ON
    envoieEchantillon.id_stade_demande_client = stadeDemandeClient.id;

--  view kpi
create or replace view v_kpi as
SELECT id_tiers,nomtier,COUNT(*) AS total,SUM(CASE WHEN etat = 2 THEN 1 ELSE 0 END) AS valide,
((100*SUM(CASE WHEN etat = 2 THEN 1 ELSE 0 END))/ COUNT(*)) as pourcentage
FROM v_demandeclient GROUP BY id_tiers,nomtier;



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
create or replace view v_kpi as
SELECT id_tiers,nomtier,COUNT(*) AS total,SUM(CASE WHEN id_etat = 2 THEN 1 ELSE 0 END) AS valide,
((100*SUM(CASE WHEN id_etat = 2 THEN 1 ELSE 0 END))/ COUNT(*)) as pourcentage
FROM v_demandeclient GROUP BY id_tiers,nomtier;



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
