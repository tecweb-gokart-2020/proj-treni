INSERT INTO carrello(cartID) VALUES
       (1),
       (2);

INSERT INTO utente(username, cartID, email, password) VALUES
       ('admin', 1, 'admin@mail.com', 'admin'),
       ('user', 2, 'user@mail.com', 'user');

INSERT INTO marca VALUES ('acme');

-- Inserito ogni tipo di prodotto solo della marca acme
INSERT INTO prodotto(codArticolo, quantita, descrizione, amministrazione, scala, prezzo, tipo, marca) VALUES
       (60052, 100, 'DB locomotiva BR 185-244 livrea RAILION Logistik', 'FS', 'HO', 190, 'locomotiva', 'acme'),
       (60106, 100, 'FS locomotiva E 444-004	 blu e grigia con vetri frontali modificati ep. V', 'FS', 'HO', 199, 'locomotiva', 'acme'),
       (40071, 100, 'FS carro frigo 2 assi con garitta ep. III', 'FS', 'HO', 29, 'carro', 'acme'),
       (40092, 100, 'DR carro chiuso 2 assi posso corto tipo F livrea verde ep. III', 'DR', 'HO', 32, 'carro',  'acme'),
       (30001, 100, 'casello FS', NULL, 'HO', 13, 'accessorio', 'acme'),
       (30002, 100, 'confezione 2 garrete in kit', NULL,'HO', 13, 'accessorio', 'acme'),
       (16515, 100, 'Scala N FS set carrozze  Tipo X livrea grigio/rosso fegato, 2a cl.+2a classe livrea sperimentale', 'FS', 'N',115, 'carrozza', 'acme'),
       (50161, 100, 'FS carrozza FS Bz 30800 grigia epoca IV, senza pittogrammi', 'FS', 'HO',61.50, 'carrozza', 'acme');

INSERT INTO indirizzo(addressID, username, nome, via, numero, citta, stato, cap) VALUES
       (1, 'user', 'Marco User', 'via fasulla', '123', 'Springfield', 'USA', '');

INSERT INTO contenuto_carrello(cartID, codArticolo, quantita) VALUES
       (2, 60052, 2);

INSERT INTO ordine(orderID, username, data_ordine, total) VALUES
	(1, 'user', CURRENT_TIMESTAMP, 190);

INSERT INTO spedizione(shippingID, orderID, addressID, stato, data_prevista) VALUES
	(1, 1, 1, 'Spedito', '2020-12-25');

INSERT INTO prodotto_ordinato(codArticolo, orderID, shippingID, quantita, prezzo_netto) VALUES
	(60052, 1, 1, 1, 190),
	(60106, 1, 1, 1, 199),
	(30002, 1, 1, 1, 13),
	(16515, 1, 1, 1, 115);
