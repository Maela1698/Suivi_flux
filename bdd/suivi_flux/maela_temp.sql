-- public.v_suivifluxmes source

ALTER TABLE suivifluxmes ADD COLUMN etat_exp BOOLEAN DEFAULT FALSE;

CREATE OR REPLACE VIEW public.v_suivifluxmes
AS SELECT suivifluxmes.id,
    suivifluxmes.date_operaton,
    suivifluxmes.id_demande_client,
    suivifluxmes.numero_commande,
    COALESCE(suivifluxmes.qte_coupe, 0::double precision) AS qte_coupe,
    COALESCE(suivifluxmes.qte_entree_chaine, 0::double precision) AS qte_entree_chaine,
    COALESCE(suivifluxmes.qte_transfere, 0::double precision) AS qte_transfere,
    COALESCE(suivifluxmes.qte_pret_livrer, 0::double precision) AS qte_pret_livrer,
    COALESCE(suivifluxmes.qte_deja_livrer, 0::double precision) AS qte_deja_livrer,
    suivifluxmes.id_taille,
    COALESCE(suivifluxmes.qte_po, 0::double precision) AS qte_po,
        CASE
            WHEN COALESCE(suivifluxmes.qte_po, 0::double precision) = 0::double precision THEN 0::double precision
            ELSE COALESCE(suivifluxmes.qte_coupe, 0::double precision) / COALESCE(suivifluxmes.qte_po, 0::double precision) * 100::double precision
        END AS pourcentagecoupe,
        CASE
            WHEN COALESCE(suivifluxmes.qte_coupe, 0::double precision) = 0::double precision THEN 0::double precision
            ELSE COALESCE(suivifluxmes.qte_transfere, 0::double precision) / COALESCE(suivifluxmes.qte_coupe, 0::double precision) * 100::double precision
        END AS pourcentagetransferer,
        CASE
            WHEN COALESCE(suivifluxmes.qte_coupe, 0::double precision) = 0::double precision THEN 0::double precision
            ELSE COALESCE(suivifluxmes.qte_rejet_chaine, 0::double precision) / COALESCE(suivifluxmes.qte_coupe, 0::double precision) * 100::double precision
        END AS pourcentagerejetchaine,
        CASE
            WHEN COALESCE(suivifluxmes.qte_coupe, 0::double precision) = 0::double precision THEN 0::double precision
            ELSE COALESCE(suivifluxmes.qte_rejet_coupe, 0::double precision) / COALESCE(suivifluxmes.qte_coupe, 0::double precision) * 100::double precision
        END AS pourcentagerejetcoupe,
    suivifluxmes.couleur,
    COALESCE(suivifluxmes.entree_repassage, 0::double precision) AS entree_repassage,
    COALESCE(suivifluxmes.sortie_repassage, 0::double precision) AS sortie_repassage,
    suivifluxmes.commentaire,
    suivifluxmes.id_destination,
    suivifluxmes.qte_rejet_chaine,
    suivifluxmes.qte_rejet_coupe,
    suivifluxmes.etat,
    v_demandeclient.nomtier,
    v_demandeclient.id_tiers,
    v_demandeclient.nom_style,
    v_demandeclient.id_style,
    v_demandeclient.nom_modele,
    unitetaille.unite_taille,
    COALESCE(suivifluxmes.qte_transfere, 0::double precision) - COALESCE(suivifluxmes.qte_coupe, 0::double precision) AS balanceatransferer,
    COALESCE(suivifluxmes.qte_deja_livrer, 0::double precision) - COALESCE(suivifluxmes.qte_coupe, 0::double precision) AS balancealivrer,
    COALESCE(suivifluxmes.sortie_repassage, 0::double precision) - COALESCE(suivifluxmes.qte_coupe, 0::double precision) AS balancerepassage,
    v_destinationrecap.datelivraisonexacte,
    v_destinationrecap.etdrevise,
    v_destinationrecap.etdpropose,
    v_destinationrecap.etdinitial,
    v_demandeclient.date_livraison,
    COALESCE(v_destinationrecap.datelivraisonexacte, v_destinationrecap.etdrevise, v_destinationrecap.etdpropose, v_destinationrecap.etdinitial, v_demandeclient.date_livraison) AS ex_factory,
    suivifluxmes.etat_exp
   FROM suivifluxmes
     JOIN v_demandeclient ON suivifluxmes.id_demande_client = v_demandeclient.id
     JOIN unitetaille ON unitetaille.id = suivifluxmes.id_taille
     LEFT JOIN v_destinationrecap ON v_destinationrecap.id = suivifluxmes.id_destination;