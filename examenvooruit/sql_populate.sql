-- Populate gegevens voor de database. Heb het geprobeerd om in populate.php te doen maar het werkte niet dus moet maar zo.

INSERT INTO tafels
        (id, tafels)
        VALUES
        (1, '1');
INSERT INTO tafels
        (id, tafels)
        VALUES
        (2, '2');
INSERT INTO tafels
        (id, tafels)
        VALUES
        (3, '3');
INSERT INTO menu
        (id, product, type, verkoopprijs)
        VALUES
        (1, 'biefstuk', 'vlees', '25');
INSERT INTO menu
        (id, product, type, verkoopprijs)
        VALUES
        (2,'kipfillet', 'kip', '22');
INSERT INTO menu
        (id, product, type, verkoopprijs)
        VALUES
        (3, 'gouda kaas', 'kaas', '45');
INSERT INTO menu
        (id, product, type, verkoopprijs)
        VALUES
        (4, 'cheddar kaas', 'kaas', '115');
INSERT INTO menu
        (id, product, type, verkoopprijs)
        VALUES
        (5, 'oude kaas', 'kaas', '1,15');
INSERT INTO menu
        (id, product, type, verkoopprijs)
        VALUES
        (6, 'klok', 'bier', '7');

INSERT INTO bestellingen
        (id, tafID, menuID, aantal)
        VALUES
        (1, '1', '3', '1');
INSERT INTO bestellingen
        (id, tafID, menuID, aantal)
        VALUES
        (2, '1', '6', '2');

INSERT INTO bestellingen
        (id, tafID, menuID, aantal)
        VALUES
        (3, '2', '2', '1');
INSERT INTO bestellingen
        (id, tafID, menuID, aantal)
        VALUES
        (4, '2', '5', '2');

INSERT INTO bestellingen
        (id, tafID, menuID, aantal)
        VALUES
        (5, '3', '1', '1');
INSERT INTO bestellingen
        (id, tafID, menuID, aantal)
        VALUES
        (6, '3', '4', '2');
