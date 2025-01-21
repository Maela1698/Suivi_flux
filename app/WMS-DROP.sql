DROP TABLE IF EXISTS CELLULE_STOCKTISSU CASCADE;

DROP TABLE IF EXISTS RESERVATION CASCADE;

DROP TABLE IF EXISTS STOCKTISSU_TIERS_MODELE CASCADE;

DROP TABLE IF EXISTS STOCKTISSU CASCADE;

DROP TABLE IF EXISTS ENTREECT_CELLULE CASCADE;

DROP TABLE IF EXISTS ENTREETISSU CASCADE;

DROP TABLE IF EXISTS BCINTERNE CASCADE;

DROP TABLE IF EXISTS PARITE CASCADE;

DROP TABLE IF EXISTS CELLULE CASCADE;

DROP TABLE IF EXISTS RACK CASCADE;

DROP TABLE IF EXISTS UTILISATIONWMS CASCADE;

DROP TABLE IF EXISTS SECTIONWMS CASCADE;

--!VIEW!--
DROP VIEW IF EXISTS V_PARITE CASCADE;

DROP VIEW IF EXISTS V_ENTREE_CT CASCADE;

INSERT INTO UTILISATIONWMS VALUES(
    DEFAULT,
    'Coupe Type',
    DEFAULT
),
(
    DEFAULT,
    'Production',
    DEFAULT
);

INSERT INTO SECTIONWMS VALUES (
    DEFAULT,
    'Tissu',
    DEFAULT
),
(
    DEFAULT,
    'Accessoire',
    DEFAULT
),
(
    DEFAULT,
    'Serigraphie',
    DEFAULT
),
(
    DEFAULT,
    'Teinture et Lavage',
    DEFAULT
),
(
    DEFAULT,
    'Maintenance',
    DEFAULT
);

INSERT INTO RACK VALUES (
    DEFAULT,
    1,
    'A',
    15,
    15,
    15,
    NULL,
    1,
    DEFAULT
),
(
    DEFAULT,
    1,
    'B',
    15,
    15,
    15,
    NULL,
    2,
    DEFAULT
),
(
    DEFAULT,
    1,
    'C',
    15,
    15,
    15,
    NULL,
    1,
    DEFAULT
),
(
    DEFAULT,
    1,
    'D',
    15,
    15,
    15,
    NULL,
    2,
    DEFAULT
),
(
    DEFAULT,
    1,
    'E',
    15,
    15,
    15,
    NULL,
    1,
    DEFAULT
),
(
    DEFAULT,
    2,
    'A',
    15,
    15,
    15,
    NULL,
    1,
    DEFAULT
),
(
    DEFAULT,
    2,
    'B',
    15,
    15,
    15,
    NULL,
    2,
    DEFAULT
),
(
    DEFAULT,
    2,
    'C',
    15,
    15,
    15,
    NULL,
    1,
    DEFAULT
),
(
    DEFAULT,
    2,
    'D',
    15,
    15,
    15,
    NULL,
    2,
    DEFAULT
),
(
    DEFAULT,
    2,
    'E',
    15,
    15,
    15,
    NULL,
    1,
    DEFAULT
);

INSERT INTO CELLULE VALUES (
    DEFAULT,
    '10',
    1,
    5,
    5,
    5,
    1,
    NULL,
    DEFAULT
),
(
    DEFAULT,
    '11',
    1,
    5,
    5,
    5,
    2,
    NULL,
    DEFAULT
),
(
    DEFAULT,
    '12',
    1,
    5,
    5,
    5,
    1,
    NULL,
    DEFAULT
),
(
    DEFAULT,
    '13',
    1,
    5,
    5,
    5,
    2,
    NULL,
    DEFAULT
),
(
    DEFAULT,
    '14',
    1,
    5,
    5,
    5,
    1,
    NULL,
    DEFAULT
),
(
    DEFAULT,
    '15',
    1,
    5,
    5,
    5,
    2,
    NULL,
    DEFAULT
);