DROP DATABASE IF EXISTS fournil_alsacien;

CREATE DATABASE fournil_alsacien CHARACTER SET utf8mb4;
USE fournil_alsacien;

CREATE TABLE IF NOT EXISTS CATEGORIE(
   codeCat VARCHAR(5) PRIMARY KEY,
   nomCat VARCHAR(20),
   nomEmploye VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS ALLERGENE(
   id VARCHAR(5) PRIMARY KEY,
   denomination VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS PRODUIT(
   refP VARCHAR(5) PRIMARY KEY,
   photoP VARCHAR(50),
   prix DOUBLE,
   poidsP DOUBLE,
   designation VARCHAR(50),
   descriptif VARCHAR(255),
   codeCat VARCHAR(5),
   CONSTRAINT fk_categorie
   FOREIGN KEY (codeCat)
           REFERENCES CATEGORIE(codeCat)
           ON UPDATE CASCADE
           ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS EXISTER(
   id VARCHAR(5),
   refP VARCHAR(5),
   PRIMARY KEY(id, refP),
   CONSTRAINT fk_allergenes
   FOREIGN KEY (id)
        REFERENCES ALLERGENE(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
   FOREIGN KEY (refP)
        REFERENCES PRODUIT(refP)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
   presence BOOLEAN,
   trace BOOLEAN
);

-- CATEGORIE
INSERT INTO CATEGORIE VALUES ('PAINS', 'Pains', 'Keller');
INSERT INTO CATEGORIE VALUES ('VIENN', 'Viennoiseries', 'Keller');
INSERT INTO CATEGORIE VALUES ('SPECI', 'Spécialités', 'Keller');

-- PRODUIT
-- INSERT INTO PRODUIT VALUES (refP, photoP, prix, poidsP, designation, descriptif, codeCat)
INSERT INTO PRODUIT VALUES ('P001', null, 1.30, 250, 'Baguette traditionnelle', 'Une baguette croustillante à la croûte dorée pour accompagner vos repas ou pour réaliser des sandwichs.', 'PAINS');
INSERT INTO PRODUIT VALUES ('P002', null, 3.80, 400, 'Pain de campagne', 'Un pain rustique au levain, avec une mie généreuse et un goût légèrement acidulé.', 'PAINS');
