alter table destination add column idtaille int;

alter table destination add foreign key(idtaille) references unitetaille(id);

--view pour lister par destinations(OF) les destinations d'une commande
CREATE OR REPLACE VIEW public.v_liste_of
AS SELECT vdr.recap_id,
    vdr.iddemandeclient,
    vdr.numerocommande,
    vd.nomtier,
    vd.nom_style,
    vd.nom_modele,
    sum(vdr.qteof) AS qteof
   FROM v_dest_recap vdr
     JOIN v_demandeclient vd ON vd.id = vdr.iddemandeclient
GROUP BY vdr.recap_id, vdr.iddemandeclient, vdr.numerocommande, vd.nomtier, vd.nom_style, vd.nom_modele;

CREATE OR REPLACE VIEW public.v_dest_recap
AS SELECT rc.id AS recap_id,
    rc.iddemandeclient,
    rc.etdrevise,
    rc.etdpropose,
    rc.receptionbc,
    rc.bcclient,
    rc.date_bc_tissu,
    rc.date_bc_access,
    rc.etat AS recap_etat,
    d.id AS destination_id,
    d.numerocommande,
    d.etdinitial,
    d.datelivraisonexacte,
    d.dateinspection,
    d.qteof,
    d.etat AS destination_etat,
    ds.id AS deststd_id,
    ds.designation AS deststd_designation,
    ut.unite_taille,
    ut.id AS unitetailleid,
    vd.nomtier,
    vd.id_tiers,
    vd.nom_modele,
    vd.nom_style,
    vd.id_style
   FROM recapcommande rc
     LEFT JOIN destination d ON rc.id = d.idrecapcommande
     LEFT JOIN deststd ds ON d.iddeststd = ds.id
     LEFT JOIN unitetaille ut ON d.idtaille = ut.id
     JOIN v_demandeclient vd ON rc.iddemandeclient = vd.id;

--27/01/2025
--ajout colonne isTracked sur la table destination pour savoir si celui ci est deja tracke dans le suivi de flux
alter table destination  add column isTracked boolean default false;

--ajout des colonne destination(id,isTracked) de dans le view afin d'avoir l'id de la destination en question qui a ete envoye dans le suivi
CREATE OR REPLACE VIEW public.v_dest_recap
AS SELECT rc.id AS recap_id,
    rc.iddemandeclient,
    rc.etdrevise,
    rc.etdpropose,
    rc.receptionbc,
    rc.bcclient,
    rc.date_bc_tissu,
    rc.date_bc_access,
    rc.etat AS recap_etat,
    d.id AS destination_id,
    d.numerocommande,
    d.etdinitial,
    d.datelivraisonexacte,
    d.dateinspection,
    d.qteof,
    d.etat AS destination_etat,
    ds.id AS deststd_id,
    ds.designation AS deststd_designation,
    ut.unite_taille,
    ut.id AS unitetailleid,
    vd.nomtier,
    vd.id_tiers,
    vd.nom_modele,
    vd.nom_style,
    vd.id_style,
    d.id as id_destination,
    d.isTracked
   FROM recapcommande rc
     LEFT JOIN destination d ON rc.id = d.idrecapcommande
     LEFT JOIN deststd ds ON d.iddeststd = ds.id
     LEFT JOIN unitetaille ut ON d.idtaille = ut.id
     LEFT JOIN v_demandeclient vd ON rc.iddemandeclient = vd.id;


--ajout colonne id_destination dans la table suivi flux pour anticiper les evenements dans le cas ou on a besoin de l'id_destination au futur
ALTER TABLE suivifluxmes 
ADD COLUMN id_destination INTEGER REFERENCES destination(id);

--28/01/2025
ALTER TABLE tiers ADD CONSTRAINT unique_nom_tier UNIQUE (nomtier);

--30/01/2025

CREATE OR REPLACE VIEW public.v_dest_recap
AS SELECT rc.id AS recap_id,
    rc.iddemandeclient,
    rc.etdrevise,
    rc.etdpropose,
    rc.receptionbc,
    rc.bcclient,
    rc.date_bc_tissu,
    rc.date_bc_access,
    rc.etat AS recap_etat,
    d.id AS destination_id,
    d.numerocommande,
    d.etdinitial,
    d.datelivraisonexacte,
    d.dateinspection,
    d.qteof,
    d.etat AS destination_etat,
    ds.id AS deststd_id,
    ds.designation AS deststd_designation,
    ut.unite_taille,
    ut.id AS unitetailleid,
    vd.nomtier,
    vd.id_tiers,
    vd.nom_modele,
    vd.nom_style,
    vd.id_style,
    d.id as id_destination,
    d.isTracked,
    COALESCE(vgfr.receptionbc, vgfr.date_entree) AS date_livraison_confirme
   FROM recapcommande rc
     LEFT JOIN destination d ON rc.id = d.idrecapcommande
     LEFT JOIN deststd ds ON d.iddeststd = ds.id
     LEFT JOIN unitetaille ut ON d.idtaille = ut.id
     LEFT JOIN v_demandeclient vd ON rc.iddemandeclient = vd.id
     LEFT JOIN v_general_final_recap vgfr ON vgfr.id = rc.iddemandeclient;

ALTER TABLE suivifluxmes ADD COLUMN date_livraison_confirme DATE NOT NULL;
