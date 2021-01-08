INSERT INTO carrello(cartID) VALUES
       1,
       2;

INSERT INTO utente(username, cartID, email, password) VALUES
       ('admin', 1, 'admin@mail.com', 'admin'),
       ('user', 2, 'user@mail.com', 'user');

INSERT INTO marca VALUES ('acme');

-- Inserito ogni tipo di prodotto solo della marca acme
INSERT INTO prodotto(codArticolo, descrizione, amministrazione, scala, prezzo, tipo, marca) VALUES
       (60052, 'DB locomotiva BR 185-244 livrea RAILION Logistik', 'FS', 'HO', 190, 'locomotiva', 'acme'),
       (60106, 'FS locomotiva E 444-004	 blu e grigia con vetri frontali modificati ep. V', 'FS', 'HO', 199, 'locomotiva', 'acme'),
       (40071, 'FS carro frigo 2 assi con garitta ep. III', 'FS', 'HO', 29, 'carro', 'acme'),
       (40092, 'DR carro chiuso 2 assi posso corto tipo F livrea verde ep. III', 'DR', 'HO', 32, 'carro',  'acme'),
       (30001, 'casello FS', NULL, 'HO', 13, 'accessorio', 'acme'),
       (30002, 'confezione 2 garrete in kit', NULL,'HO', 13, 'accessorio', 'acme'),
       (16515, 'Scala N FS set carrozze  Tipo X livrea grigio/rosso fegato, 2a cl.+2a classe livrea sperimentale', 'FS', 'N',115, 'carrozza', 'acme'),
       (50161, 'FS carrozza FS Bz 30800 grigia epoca IV, senza pittogrammi', 'FS', 'HO',61.50, 'carrozza', 'acme');

INSERT INTO indirizzo(addressID, username, nome, via, numero, citta, stato, comune, cap) VALUES
       (1, 'user', 'Marco User', 'via fasulla', '123', 'Springfield', 'USA', '', '');
