create table suiviFluxMes(
    id serial PRIMARY KEY,
    date_operaton date,
    id_demande_client int,
    numero_commande VARCHAR(255),
    qte_coupe double precision,
    qte_entree_chaine double precision,
    qte_transfere double precision,
    qte_pret_livrer double precision,
    qte_deja_livrer double precision,
    id_taille int,
    qte_po double precision
);
alter table suiviFluxMes add foreign key(id_demande_client) references demandeclient(id);
alter table suiviFluxMes add foreign key(id_taille) references unitetaille(id);
