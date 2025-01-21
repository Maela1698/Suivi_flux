insert into listeEmploye(nom,prenom,matricule,idFonction,idSection,idClassification,idPays,idrole,pseudo,motDePasse) values ('RAKOTOBE','Santatra','29069',4,2,3,1,1,'Santatra','santatra');

insert into typeEncre(type_encre) VALUES ('A l eau');
insert into typeEncre(type_encre) VALUES ('Plastisol');
insert into typeEncre(type_encre) VALUES ('Foil print');
insert into typeEncre(type_encre) VALUES ('Flock print');
insert into typeEncre(type_encre) VALUES ('Heat transfert');

insert into encre(encre) VALUES ('Encre1');
insert into encre(encre) VALUES ('Encre2');
insert into encre(encre) VALUES ('Encre3');
insert into encre(encre) VALUES ('Encre4');


insert into
    etapeSerigraphie (
        etapeSer,
        dureeEtape,
        dureeChangementProd,
        dureeOkProd,
        niveauEtape
    )
VALUES (
        'Achat encre echantillon',
        0,
        0,
        0,
        1
    );

insert into
    etapeSerigraphie (
        etapeSer,
        dureeEtape,
        dureeChangementProd,
        dureeOkProd,
        niveauEtape
    )
VALUES ('PAO', 1, 0, 0, 2);

insert into
    etapeSerigraphie (
        etapeSer,
        dureeEtape,
        dureeChangementProd,
        dureeOkProd,
        niveauEtape
    )
VALUES ('PRI', 2, 0, 0, 3);

insert into
    etapeSerigraphie (
        etapeSer,
        dureeEtape,
        dureeChangementProd,
        dureeOkProd,
        niveauEtape
    )
VALUES (
        'IMPRESSION DESSIN',
        1,
        0,
        0,
        4
    );

insert into
    etapeSerigraphie (
        etapeSer,
        dureeEtape,
        dureeChangementProd,
        dureeOkProd,
        niveauEtape
    )
VALUES (
        'RECHERCHE COLORIS ET VALIDATION',
        3,
        1,
        0,
        5
    );

insert into
    etapeSerigraphie (
        etapeSer,
        dureeEtape,
        dureeChangementProd,
        dureeOkProd,
        niveauEtape
    )
VALUES (
        'INSOLATION CADRE',
        3,
        1,
        0,
        6
    );

insert into
    etapeSerigraphie (
        etapeSer,
        dureeEtape,
        dureeChangementProd,
        dureeOkProd,
        niveauEtape
    )
VALUES ('RACLAGE', 5, 2, 0, 7);

insert into
    etapeSerigraphie (
        etapeSer,
        dureeEtape,
        dureeChangementProd,
        dureeOkProd,
        niveauEtape
    )
VALUES (
        'ACHAT ENCRE PROD',
        0,
        0,
        0,
        8
    );

insert into
    etapeSerigraphie (
        etapeSer,
        dureeEtape,
        dureeChangementProd,
        dureeOkProd,
        niveauEtape
    )
VALUES ('GABARITS', 0, 0, 1, 9);

insert into
    etapeSerigraphie (
        etapeSer,
        dureeEtape,
        dureeChangementProd,
        dureeOkProd,
        niveauEtape
    )
VALUES (
        'PREPARATION TABLE',
        0,
        0,
        2,
        10
    );

insert into
    etapeSerigraphie (
        etapeSer,
        dureeEtape,
        dureeChangementProd,
        dureeOkProd,
        niveauEtape
    )
VALUES (
        'PREPARATION ENCRE PROD',
        0,
        0,
        1,
        11
    );


insert into etapeBrodMain(etape_brod_main,duree,duree_change_sdc,duree_prod) values ('APPRO MP',1,1,1);
insert into etapeBrodMain(etape_brod_main,duree,duree_change_sdc,duree_prod) values ('PLIS TISSU',4,4,0);
insert into etapeBrodMain(etape_brod_main,duree,duree_change_sdc,duree_prod) values ('DESSIN',1,1,2);
insert into etapeBrodMain(etape_brod_main,duree,duree_change_sdc,duree_prod) values ('PONCAGE',4,4,0);
insert into etapeBrodMain(etape_brod_main,duree,duree_change_sdc,duree_prod) values ('DEVELOPPEMENT',5,5,0);
