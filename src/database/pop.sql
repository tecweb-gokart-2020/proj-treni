INSERT INTO carrello (cartID) VALUES (
       1,
       2
)

INSERT INTO utente (username, cartID, email, password) VALUES (
       ('admin', 1, 'admin@mail.com', 'admin'),
       ('user', 2, 'user@mail.com', 'user')
)

INSERT INTO prodotto (codArticolo, descrizione, amministrazione, scala, prezzo, tipo, marca) VALUES (
       (60052, 'DB locomotiva BR 185-244 livrea RAILION Logistik', 'FS', 'HO', 190, 'locomotiva', 'acme'),
       (60106, 'FS locomotiva E 444-004	 blu e grigia con vetri frontali modificati ep. V', 'FS', 'HO', 199, 'locomotiva acme')
);
