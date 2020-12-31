SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS utente;
DROP TABLE IF EXISTS sessione_utente;
DROP TABLE IF EXISTS carrello;
DROP TABLE IF EXISTS contenuto_carrello;
DROP TABLE IF EXISTS prodotto;
DROP TABLE IF EXISTS marca;
DROP TABLE IF EXISTS prodotto_ordinato;
DROP TABLE IF EXISTS ordine;
DROP TABLE IF EXISTS spedizione;
DROP TABLE IF EXISTS indirizzo;

CREATE TABLE utente(
       ID int PRIMARY KEY,
       cartID int,
       username varchar(16) not null,
       password varchar(10) not null,
       
       FOREIGN KEY (cartID) REFERENCES carrello(cartID)
)Engine=InnoDB;

CREATE TABLE carrello(
       cartID int PRIMARY KEY,
)Engine=InnoDB;


CREATE TABLE contenuto_carrello(
       cartID int,
       codArticolo int,
       quantita int DEFAULT 1,

       PRIMARY KEY(cartID, codArticolo),
       FOREIGN KEY (cartID) REFERENCES carrello(cartID),
       FOREIGN KEY (codArticolo) REFERENCES Prodotto(codArticolo)
)Engine=InnoDB;

CREATE TABLE prodotto(
       codArticolo int PRIMARY KEY,
       descrizione varchar(100),
       scala varchar(3),
       prezzo decimal,
       sconto int,
       marca varchar(20),
       tipo varchar(20),
       quantita int DEFAULT 1,

       FOREIGN KEY (marca) REFERENCES marca(nome)
)Engine=InnoDB;

CREATE TABLE marca(
       nome varchar(20) PRIMARY KEY
)Engine=InnoDB;

CREATE TABLE prodotto_ordinato(
       codArticolo int,
       orderID int,
       shippingID int,
       quantita int NOT NULL,
       stato varchar(50) DEFAULT 'Processing',

       PRIMARY KEY(codArticolo, orderID),
       FOREIGN KEY (codArticolo) REFERENCES Prodotto(codArticolo),
       FOREIGN KEY (orderID) REFERENCES ordine(orderID),
       FOREIGN KEY (shippingID) REFERENCES spedizione(shippingID)
)Engine=InnoDB;

CREATE TABLE ordine(
       orderID int PRIMARY KEY,
       accountID int NOT NULL,
       data_ordine timestamp,
       total decimal,

       FOREIGN KEY (accountID) REFERENCES utente(ID)
)Engine=InnoDB;

CREATE TABLE spedizione(
       shippingID int PRIMARY KEY,
       orderID int NOT NULL,
       addressID int NOT NULL,
       stato varchar(50),
       data_prevista date,

       FOREIGN KEY (orderID) REFERENCES ordine(orderID),
       FOREIGN KEY (addressID) REFERENCES indirizzo(addressID)
)Engine=InnoDB;

CREATE TABLE indirizzo(
       addressID int PRIMARY KEY,
       nome varchar(50),
       via varchar(50),
       numero varchar(50),
       citta varchar(50),
       stato varchar(50),
       comune varchar(50),
       cap int
)Engine=InnoDB;

SET FOREIGN_KEY_CHECKS=1;
