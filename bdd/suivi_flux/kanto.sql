create table suiviFluxMes(
    id serial PRIMARY KEY,
    date_operaton date,
    id_demande_client int,
    id_destination int,
    numero_commande VARCHAR(255),
    qte_coupe double precision,
    qte_entree_chaine double precision,
    qte_transfere double precision,
    qte_pret_livrer double precision,
    qte_deja_livrer double precision,
    id_taille int,
    qte_po double precision,
    couleur VARCHAR(255),
    entree_repassage double precision,
    sortie_repassage double precision,
    commentaire text
);
alter table suiviFluxMes add foreign key(id_demande_client) references demandeclient(id);
alter table suiviFluxMes add foreign key(id_taille) references unitetaille(id);
alter table suiviFluxMes add foreign key(id_destination) references destination(id);

insert into suiviFluxMes(id_demande_client,numero_commande,id_taille,qte_po,couleur) values
(1087,'1234',2,5,'rouge'),
(1087,'1234',4,5,'rouge'),
(1087,'1234',7,5,'rouge')
;


CREATE OR REPLACE VIEW v_suiviFluxMes AS
SELECT
    suiviFluxMes.*,
    v_demandeclient.nomtier,
    v_demandeclient.id_tiers,
    v_demandeclient.nom_style,
    v_demandeclient.id_style,
    v_demandeclient.nom_modele,
    unitetaille.unite_taille,
    suiviFluxMes.qte_coupe - suiviFluxMes.qte_transfere AS balanceATransferer,
    suiviFluxMes.qte_coupe - suiviFluxMes.qte_deja_livrer AS balanceALivrer,
    suiviFluxMes.qte_coupe - suiviFluxMes.sortie_repassage AS balanceRepassage,
    v_dest_recap.datelivraisonexacte,
    v_dest_recap.etdrevise,
    v_dest_recap.etdpropose,
    v_dest_recap.etdinitial,
    v_demandeclient.date_livraison,
    COALESCE(v_dest_recap.datelivraisonexacte,v_dest_recap.etdrevise,v_dest_recap.etdpropose,v_dest_recap.etdinitial,v_demandeclient.date_livraison) as ex_factory

FROM
    suiviFluxMes
JOIN
    v_demandeclient ON suiviFluxMes.id_demande_client = v_demandeclient.id
JOIN
    unitetaille ON unitetaille.id = suiviFluxMes.id_taille
JOIN
    recapcommande ON recapcommande.iddemandeclient = suiviFluxMes.id_demande_client
 JOIN v_dest_recap ON v_dest_recap.deststd_id = suiviFluxMes.id_destination;


