
DROP DATABASE IF EXISTS fournil_alsacien;

CREATE DATABASE fournil_alsacien CHARACTER SET utf8mb4;
USE fournil_alsacien;

CREATE TABLE CATEGORIE(
   codeCat VARCHAR(5) PRIMARY KEY,
   nomCat VARCHAR(20),
   nomEmploye VARCHAR(50)
);

CREATE TABLE ALLERGENE(
   id VARCHAR(5) PRIMARY KEY,
   denomination VARCHAR(50)
);

CREATE TABLE PRODUIT(
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

CREATE TABLE EXISTER(
   id VARCHAR(5),
   refP VARCHAR(5),
   PRIMARY KEY(id, refP),
   CONSTRAINT fk_exister
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

CREATE TABLE UTILISATEUR(
    idU VARCHAR(50) PRIMARY KEY NOT NULL,
    nomU VARCHAR(50),
    prenomU VARCHAR(50),
    numVoieU VARCHAR(6),
    nomVoieU VARCHAR(50),
    cpU VARCHAR(5),
    villeU VARCHAR(50),
    mailU VARCHAR(50)
);

CREATE TABLE COMMANDE(
   idCommande INT PRIMARY KEY AUTO_INCREMENT,
   validee BOOLEAN,
   idU VARCHAR(50),
   dateCommande DATE,
   CONSTRAINT fk_commande
   FOREIGN KEY (idU)
           REFERENCES UTILISATEUR(idU)
           ON UPDATE CASCADE
           ON DELETE CASCADE
);

ALTER TABLE COMMANDE AUTO_INCREMENT = 1;

CREATE TABLE QUANTIFIER(
   refP VARCHAR(5),
   idCommande INT,
   quantite INT,
   PRIMARY KEY(refP, idCommande),
   CONSTRAINT fk_quantifier
   FOREIGN KEY (idCommande)
           REFERENCES COMMANDE(idCommande)
           ON UPDATE CASCADE
           ON DELETE CASCADE,
   FOREIGN KEY (refP)
           REFERENCES PRODUIT(refP)
           ON UPDATE CASCADE
           ON DELETE CASCADE
);


-- CATEGORIE
INSERT INTO CATEGORIE VALUES ('PAINS', 'Pains', 'Keller');
INSERT INTO CATEGORIE VALUES ('VIENN', 'Viennoiseries', 'Keller');
INSERT INTO CATEGORIE VALUES ('SPECI', 'Spécialités', 'Keller');

-- PRODUIT
-- INSERT INTO PRODUIT VALUES (refP, photoP, prix, poidsP, designation, descriptif, codeCat)
INSERT INTO PRODUIT VALUES ('P001', 'images/pains/baguette250gr.png', 1.30, 250, 'Baguette traditionnelle', 'Une baguette croustillante à la croûte dorée pour accompagner vos repas ou pour réaliser des sandwichs.', 'PAINS');
INSERT INTO PRODUIT VALUES ('P002', 'images/pains/painCampagne400gr.png', 3.80, 400, 'Pain de campagne', 'Un pain rustique au levain, avec une mie généreuse et un goût légèrement acidulé.', 'PAINS');
INSERT INTO PRODUIT VALUES ('P003', 'images/pains/painCereales350gr.png', 4.00, 350, 'Pain aux céréales', 'Un pain moelleux aux graines de lin, pour une texture légèrement croquante.', 'PAINS');
INSERT INTO PRODUIT VALUES ('V001', 'images/viennoiseries/croissantBeurre50gr.png', 1.30, 50, 'Croissant pur beurre', "Un classique de la boulangerie, un croissant feuilleté, croustillant à l'extérieur, tendre et fondant à l'intérieur. ", 'VIENN');
INSERT INTO PRODUIT VALUES ('V002', 'images/viennoiseries/painChocolat50gr.png', 2.60, 50, 'Pain au chocolat', 'Une viennoiserie gourmande, avec une généreuse barre chocolatée enveloppée dans une pâte feuilletée. croustillante. ', 'VIENN');
INSERT INTO PRODUIT VALUES ('V003', 'images/viennoiseries/chaussonPommes90gr.png', 2.90, 90, 'Chausson aux pommes', ' Un chausson croustillant garni de compote de pommes maison, saupoudré de sucre et de cannelle. ', 'VIENN');
INSERT INTO PRODUIT VALUES ('S001', 'images/specialites/fougasseOlives400gr.jpg', 2.00, 400, 'Fougasse aux olives', 'Une spécialité provençale, une focaccia moelleuse aux olives noires. Une portion.', 'SPECI');
INSERT INTO PRODUIT VALUES ('S002', 'images/specialites/painEpicesMaison500gr.jpg', 5.50, 500, "Pain d'épices", "Un pain d'épices traditionnel, moelleux et parfumé, aux arômes de miel, de cannelle.", 'SPECI');
INSERT INTO PRODUIT VALUES ('S003', 'images/specialites/galetteFrangipane660gr.png', 18.00, 660, 'Galette frangipane', 'Une galette pour 4 personnes à base de pâte d’amandes. Prix au kg.', 'SPECI');

-- INSERT INTO ALLERGENE VALUES (id, denomination);
INSERT INTO ALLERGENE VALUES ('GLUT', 'gluten');
INSERT INTO ALLERGENE VALUES ('LEVA', 'levain');
INSERT INTO ALLERGENE VALUES ('LIN', 'lin');
INSERT INTO ALLERGENE VALUES ('TOUR', 'tournesol');
INSERT INTO ALLERGENE VALUES ('SESA', 'sésame');
INSERT INTO ALLERGENE VALUES ('CHOC', 'chocolat');
INSERT INTO ALLERGENE VALUES ('POMM', 'pommes');
INSERT INTO ALLERGENE VALUES ('OLIV', 'olives');
INSERT INTO ALLERGENE VALUES ('MIEL', 'miel');
INSERT INTO ALLERGENE VALUES ('CANN', 'cannelle');
INSERT INTO ALLERGENE VALUES ('EPIC', 'épices');
INSERT INTO ALLERGENE VALUES ('AMAN', 'amandes');
INSERT INTO ALLERGENE VALUES ('COQU', 'fruits à coques');

-- INSERT INTO EXISTER VALUES (id, refP, presence, trace);
INSERT INTO EXISTER VALUES ('GLUT', 'P001', true, false);
INSERT INTO EXISTER VALUES ('GLUT', 'P002', true, false);
INSERT INTO EXISTER VALUES ('LEVA', 'P002', true, false);
INSERT INTO EXISTER VALUES ('GLUT', 'P003', true, false);
INSERT INTO EXISTER VALUES ('LIN', 'P003', true, false);
INSERT INTO EXISTER VALUES ('TOUR', 'P003', true, false);
INSERT INTO EXISTER VALUES ('SESA', 'P003', true, false);
INSERT INTO EXISTER VALUES ('GLUT', 'V001', true, false);
INSERT INTO EXISTER VALUES ('GLUT', 'V002', true, false);
INSERT INTO EXISTER VALUES ('CHOC', 'V002', true, false);
INSERT INTO EXISTER VALUES ('GLUT', 'V003', true, false);
INSERT INTO EXISTER VALUES ('POMM', 'V003', true, false);
INSERT INTO EXISTER VALUES ('GLUT', 'S001', true, false);
INSERT INTO EXISTER VALUES ('OLIV', 'S001', true, false);
INSERT INTO EXISTER VALUES ('GLUT', 'S002', true, false);
INSERT INTO EXISTER VALUES ('MIEL', 'S002', true, false);
INSERT INTO EXISTER VALUES ('CANN', 'S002', true, false);
INSERT INTO EXISTER VALUES ('EPIC', 'S002', true, false);
INSERT INTO EXISTER VALUES ('GLUT', 'S003', true, false);
INSERT INTO EXISTER VALUES ('AMAN', 'S003', true, false);
INSERT INTO EXISTER VALUES ('COQU', 'S003', false, true);

-- UTILISATEURS
-- CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';
DROP USER IF EXISTS 'visiteur';
flush privileges;
CREATE USER 'visiteur'@'%' IDENTIFIED BY 'visiteur';

DROP USER IF EXISTS 'test'@'%';
flush privileges;
CREATE USER 'test'@'%' IDENTIFIED BY 'azerty67000$';

DROP USER IF EXISTS 'MmeKeller'@'localhost';
flush privileges;
CREATE USER 'MmeKeller'@'localhost' IDENTIFIED BY 'querty67000$';

-- GRANT x ON fournil_alsacien TO username;
-- GRANT SELECT, INSERT, UPDATE, DELETE ON fournil_alsacien TO username; -- lecture, ecriture, modification, suppression (pas execution)
-- GRANT SELECT ON fournil_alsacien TO username; -- lecture

GRANT SELECT, INSERT, UPDATE, DELETE ON * TO 'MmeKeller'@'localhost'; -- lecture, ecriture, modification, suppression (pas execution)

GRANT SELECT ON fournil_alsacien.CATEGORIE TO 'visiteur'@'%'; -- lecture
GRANT SELECT ON fournil_alsacien.ALLERGENE TO 'visiteur'@'%';
GRANT SELECT ON fournil_alsacien.PRODUIT TO 'visiteur'@'%'; -- lecture
GRANT SELECT ON fournil_alsacien.EXISTER TO 'visiteur'@'%';
GRANT SELECT ON fournil_alsacien.UTILISATEUR TO 'visiteur'@'%';
GRANT SELECT, INSERT, UPDATE ON fournil_alsacien.COMMANDE TO 'visiteur'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON fournil_alsacien.QUANTIFIER TO 'visiteur'@'%';
GRANT SELECT, INSERT, UPDATE ON fournil_alsacien.UTILISATEUR TO 'visiteur'@'%';

GRANT SELECT ON fournil_alsacien.PRODUIT TO 'test'@'%'; -- lecture
GRANT SELECT ON fournil_alsacien.CATEGORIE TO 'test'@'%'; -- lecture
GRANT SELECT ON fournil_alsacien.ALLERGENE TO 'test'@'%';
GRANT SELECT ON fournil_alsacien.EXISTER TO 'test'@'%';
GRANT SELECT, INSERT, UPDATE ON fournil_alsacien.COMMANDE TO 'test'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON fournil_alsacien.QUANTIFIER TO 'test'@'%';
GRANT SELECT, INSERT, UPDATE ON fournil_alsacien.UTILISATEUR TO 'test'@'%';

-- Permet à visiteur de créer des utilisateurs et de leur donner ses droits
GRANT CREATE USER ON *.* TO 'visiteur'@'%' WITH GRANT OPTION;

-- INSERT INTO UTILISATEUR VALUES (idU, nomU, prenomU, numVoieU, nomVoieU, cpU, villeU, mailU);
INSERT INTO UTILISATEUR VALUES ('test', 'Doe', 'John', 1, 'rue Schoch', '67000', 'Strasbourg', 'johndoe@gmail.com');
