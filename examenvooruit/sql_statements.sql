-- create new db
CREATE DATABASE excellenttaste;


-- tabel Usertype aanmaken, met dit tabel kun je kijken of iemand een admin is of een medewerker is
CREATE TABLE usertype(
    id INT NOT NULL AUTO_INCREMENT,
    type VARCHAR(255),
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY(id)
);

-- insert entrIES into table usertype (admin AND user)
INSERT INTO usertype VALUES (NULL, 'admin', now(), now()), (NULL, 'chef', now(), now()), (NULL, 'chef', now(), now());

-- tabel Locatie aanmaken.
CREATE TABLE tafels(
    id INT NOT NULL AUTO_INCREMENT,
    tafels INT NOT NULL,
    PRIMARY KEY(id)
);

-- tabel Artikel aanmaken.
CREATE TABLE menu(
    id INT NOT NULL AUTO_INCREMENT,
    product VARCHAR(250) NOT NULL,
    type VARCHAR(250) NOT NULL,
    verkoopprijs INT(250) NOT NULL,
    PRIMARY KEY(id)
);

-- tabel Voorraad aanmaken.
CREATE TABLE bestellingen(
    id INT NOT NULL AUTO_INCREMENT,
    tafID INT NOT NULL,
    menuID INT NOT NULL,
    aantal VARCHAR(250) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(tafID) REFERENCES tafels(id),
    FOREIGN KEY(menuID) REFERENCES menu(id)
);

-- tabel Medewerker aanmaken.
CREATE TABLE medewerker(
    id INT NOT NULL AUTO_INCREMENT,
    usertype_id INT NOT NULL,
    voorletters VARCHAR(250) NOT NULL,
    voorvoegsels VARCHAR(250),
    achternaam VARCHAR(250),
    gebruikersnaam VARCHAR(250),
    wachtwoord VARCHAR(250),
    PRIMARY KEY(id),
    FOREIGN KEY(usertype_id) REFERENCES usertype(id)
);

-- tabel Medewerker aanmaken.
CREATE TABLE reservering(
    id INT NOT NULL AUTO_INCREMENT,
    voornaam VARCHAR(250) NOT NULL,
    achternaam VARCHAR(250) NOT NULL,
    email VARCHAR(250) NOT NULL,
    telefoon INT NOT NULL,
    aantal INT NOT NULL,
    datum DATE,
    tijd TIME,
    PRIMARY KEY(id)
);
