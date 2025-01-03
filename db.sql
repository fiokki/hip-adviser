-- Creazione della tabella users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    user_name VARCHAR(20),
    role ENUM('user', 'admin') DEFAULT 'user',
    newsletter BOOLEAN DEFAULT FALSE,
    cookie_id VARCHAR(64) DEFAULT NULL,
    cookie_expiry INT(11) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Creazione della tabella artists
CREATE TABLE artists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    artist_name VARCHAR(30) NOT NULL UNIQUE,
    photo VARCHAR(255),
    bio TEXT
);

-- Creazione della tabella albums
CREATE TABLE albums (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    artist_id INT NOT NULL,
    release_date DATE NOT NULL,
    cover VARCHAR(255),
    link VARCHAR(255),
    FOREIGN KEY (artist_id) REFERENCES artists(id)
        ON DELETE CASCADE
);

-- Creazione della tabella reviews
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    album_id INT NOT NULL,
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, album_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    FOREIGN KEY (album_id) REFERENCES albums(id)
        ON DELETE CASCADE
);




INSERT INTO artists (artist_name, photo, bio)
VALUES ('Guè','https://media.gqitalia.it/photos/63c11182decdff44e3ad15e2/1:1/w_2500,h_2500,c_limit/gue%201.jpg','Guè (in precedenza Guè Pequeno), nome d\'arte di Cosimo Fini (Milano, 25 dicembre 1980), è un rapper italiano.

Il suo nome d\'arte è inizialmente Il Guercio, ispirato dalla sua ptosi dell\'occhio sinistro, in seguito diventato Guè Pequeno, ispirandosi ad un personaggio del film City of God.

Dopo gli inizi con il gruppo Sacre Scuole (formato con Jake La Furia e Dargen D\'Amico), forma i Club Dogo con lo stesso Jake e il produttore Don Joe.

Dopo essere arrivato al successo con i Dogo, nel 2011 inizia la sua carriera solista, parallelamente al gruppo, pubblicando l\'album Il ragazzo d\'oro.

Nello stesso anno fonda insieme a DJ Harsh l\'etichetta discografica Tanta Roba Label, con cui lancia Fedez, Salmo ed Ensi. In seguito lascerà la gestione della label.

Nel 2015 firma un contratto con la Def Jam Recordings, diventando il primo artista italiano ad entrare nella casa discografica statunitense, per la quale rilascia Vero.

Nel 2018 entra a far parte della BHMG, team creato da Sfera Ebbasta, Charlie Charles e Shablo in collaborazione con Universal, e pubblica l\'album Sinatra.

Nel 2021 cambia nome in Guè.'),
('Tedua','https://media.gqitalia.it/photos/5f10af06492631454e2d3c03/4:3/w_3647,h_2735,c_limit/tedua%20mario%20molinari%20nuovo%20album%20e%20sliding%20doors_gq%20italia_giuditta%20avellina.jpg','Tedua, nome d\'arte di Mario Molinari (Genova, 21 febbraio 1994), è un rapper italiano, membro della crew Wild Bandana e del movimento Drilliguria.

Nato nel capoluogo ligure, si trasferisce poco dopo con la madre a Milano, dove cresce – senza il padre – tra case famiglia e famiglie affidatarie. Dopo aver scoperto il rap grazie alla madre, inizia a rappare verso gli 11 anni con il nome Incubo frequentando le jam e le battaglie di freestyle milanesi assieme all\'amico Ernia, ai tempi suo vicino di casa nel quartiere QT8.

Nel 2007, in terza media, finito il periodo in affido, lascia Milano e ritorna con la madre in Liguria, vivendo prima ad Arenzano – dove pratica il pugilato, disputando anche per tre anni incontri a livello agonistico, prima di lasciare la disciplina dopo un infortunio al polso e concentrarsi sulla musica – e poi a Cogoleto, entrambe alle porte di Genova. È qui che cambia nome d\'arte in Duate, originariamente pronunciato all\'inglese ma storpiato all\'italiana dagli amici. Nel 2008 fonda la crew Wild Bandana assieme a Ill Rave, ai quali poi si aggiungeranno Vaz Tè, Guesan e IZI. I cinque cominciano a registrare i loro brani allo Studio Ostile del produttore Demo e da queste sessioni nasce il mixtape Medaglia d\'Oro, pubblicato nel 2014 da Tedua assieme a Vaz Tè.

L\'anno successivo cambia nome in Tedua – che, oltre ad essere il riocontra di Duate, vuol dire “ti amo” in albanese – e pubblica per Studio Ostile Aspettando Orange County, il suo primo mixtape solista nonché il prequel del mixtape del 2016 Orange County, che lo fa emergere come uno dei nomi di punta di quella nuova ondata del rap italiano riconducibile alla trap. Nel frattempo, nel 2014, torna a Milano, dove in seguito condivide un appartamento, prima nel quartiere Calvairate e poi nel confinante Taliedo-Mecenate, assieme a Rkomi, Bresh e Sonny Willa.

Nel gennaio del 2017 esce, con distribuzione Universal, il suo primo progetto discografico ufficiale, Orange County – California, riedizione del tape Orange County, che conclude un\'ideale trilogia. Nello stesso anno nasce ufficialmente il collettivo Drilliguria, in un certo senso un\'evoluzione di Wild Bandana, che rilascia il mixtape Amici Miei.

Nel 2018 Tedua pubblica per Sony Music il suo primo vero e proprio album, Mowgli, che dopo pochi mesi, trainato da singoli come “La legge del più forte” e “Vertigini”, viene certificato disco di platino.

Il 2020 di Tedua si apre con con un freestyle in cui annuncia l\'uscita del suo nuovo album nello stesso anno. La pubblicazione viene poi rimandata a causa della pandemia di COVID-19 e sostituita nel 2021 dal mixtape Vita vera mixtape: Aspettando la Divina Commedia, nel quale viene rivelato il titolo del futuro disco, La Divina Commedia, uscito poi nel 2023.

Nel 2022 debutta al cinema interpretando il ruolo di Cecco, modello, assistente, amico e amante di Michelangelo Merisi, nel film L\'ombra di Caravaggio di Michele Placido.
'),
('','',''),
('','',''),
('','',''),
('','',''),
('','',''),
('','',''),
('','',''),
('','',''),
('','',''),