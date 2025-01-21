
CREATE TABLE Section (
    ID SERIAL PRIMARY KEY,
    VALEUR VARCHAR(255) NOT NULL,
    DESCRIPTION VARCHAR(255)
);

CREATE TABLE DEPARTEMENT (
    ID SERIAL PRIMARY KEY,
    VALEUR VARCHAR(255) NOT NULL,
    IDRESPONSABLE INT REFERENCES Utilisateur(id)
);

CREATE TABLE PROCEDE (
    ID SERIAL PRIMARY KEY,
    VALEUR VARCHAR(255) NOT NULL,
    DEPARTEMENT_ID INT REFERENCES DEPARTEMENT(id)
);

CREATE TABLE AXE (
    ID SERIAL PRIMARY KEY,
    VALEUR VARCHAR(255) NOT NULL,
    DESCRIPTION VARCHAR(255)
);

Create table roles (
    id SERIAL PRIMARY KEY,
    valeur VARCHAR(255) NOT NULL,
    description VARCHAR(255)
);

CREATE TABLE Utilisateur (
    ID SERIAL PRIMARY KEY,
    Nom VARCHAR(255) NOT NULL,
    Role_id INT REFERENCES roles(id)
);

CREATE TABLE TYPEAUDIT (
    ID SERIAL PRIMARY KEY,
    valeur VARCHAR(255),
    Description VARCHAR(255)
--('Interne', 'Externe', 'Périmètre', 'Procédure')
);

CREATE TABLE Constat (
    ID SERIAL PRIMARY KEY,
    Dateconstat DATE NOT NULL,
    Chaine_ID INT REFERENCES Section(ID),
    Priorite INT CHECK (Priorite IN (1, 2, 3)),
    Description TEXT NOT NULL,
    TYPEAUDIT_ID INT REFERENCES TYPEAUDIT(ID)
);

CREATE TABLE norme (
    ID SERIAL PRIMARY KEY,
    VALEUR VARCHAR(255),
    Description VARCHAR(255)
)

CREATE TABLE referencenorme(
    ID SERIAL PRIMARY KEY,
    VALEUR VARCHAR(255),
    Description VARCHAR(255),
    norme_id INT REFERENCES norme(id)
);

CREATE TABLE Audit (
    ID SERIAL PRIMARY KEY,
    TYPEAUDIT_ID INT REFERENCES TYPEAUDIT(ID),
    Date DATE NOT NULL,
    Section_ID INT REFERENCES Section(ID),
    referencenorme_id INT REFERENCES referencenorme(id)
    Description TEXT
);

CREATE TABLE PlanAction (
    ID SERIAL PRIMARY KEY,
    numero VARCHAR(250),
    Constat_ID INT REFERENCES Constat(ID),
    Audit_ID INT REFERENCES Audit(ID),
    DateDebut DATE NOT NULL,
    Moyens TEXT NOT NULL,
    Priorite VARCHAR(50) CHECK (Priorite IN (1, 2, 3)),
    Responsable_ID INT REFERENCES Utilisateur(ID),
    Deadline DATE,
    Commentaires TEXT
);

CREATE TABLE AvancementPlanAction (
    ID SERIAL PRIMARY KEY,
    PLANACTION_ID INT REFERENCES PlanAction(ID),
    DATEAVANCEMENT DATE,
    DESIGNATION VARCHAR(255),
    Avancement INT,
);

CREATE TABLE Questionnaire (
    ID SERIAL PRIMARY KEY,
    Audit_ID INT REFERENCES Audit(ID),
    Question TEXT NOT NULL,
    Statut INT CHECK (Statut IN (1, -1)),
    Criticite INT CHECK (Criticite IN (1, 2, 3)),
    PROCEDE_ID REFERENCES PROCEDE(ID),
    AXE_ID REFERENCES AXE(ID),
    Score INT
);

CREATE TABLE Fichier (
    ID SERIAL PRIMARY KEY,
    Chemin TEXT NOT NULL,
    Type VARCHAR(50),
    Constat_ID INT REFERENCES Constat(ID),
    PlanAction_ID INT REFERENCES PlanAction(ID),
    Questionnaire_ID INT REFERENCES Questionnaire(ID),
    Audit_ID INT REFERENCES Audit(ID)
);

CREATE TABLE Budget (
    ID SERIAL PRIMARY KEY,
    Audit_ID INT REFERENCES Audit(ID),
    BudgetPrevisionnel NUMERIC(10, 2),
    BudgetReel NUMERIC(10, 2)
);

CREATE INDEX idx_constat_date ON Constat(Date);
CREATE INDEX idx_plan_action_deadline ON PlanAction(Deadline);
