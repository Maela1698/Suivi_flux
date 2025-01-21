-- ! SCRIPT
SELECT
    COLUMN_NAME
FROM
    INFORMATION_SCHEMA.COLUMNS
WHERE
    TABLE_NAME = '';

--? CLASSEMATIEREPREMIERE
--* CURRENT : 1
--* EN COURS : 2
--* FOURNISSEUR : 3

--? UTILISATIONWMS
--* production : 1
--* coupe TYPE : 2
--* autre : 3
CLIENT_STOCKCONSOMMABLE

SELECT
    MAX(ID)
FROM
    'nom_table';

SELECT
    SETVAL('your_sequence_name', (
        SELECT
            MAX(ID)
        FROM
            'nom_table'
    ) + 1);
