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

('Santa Sede','https://images.genius.com/8c4b412341512db9848ef6db4e984d80.621x621x1.jpg','Santa Sede è un collettivo formato dai rapper RollzRois e Less Torrance (entrambi anche produttori) e dai produttori Carlo Ragazzo e Antee (quest\'ultimo occasionalmente anche rapper), tutti e quattro originari dell\'area metropolitana di Milano.
Inizialmente ne facevano parte, oltre a Rollz e Less, i rapper Davide Bates e Lord Lamont, e i quattro pubblicarono nel 2022 l\'album Santa Sede.'),

('Nayt','https://www.thefrontrow.it/wp-content/uploads/2021/11/MG_6562.jpg','Nayt, nome d\'arte di William Mezzanotte (Isernia, 9 novembre 1994), è un rapper italiano.
Nato in Molise ma cresciuto a Roma fin da molto piccolo, inizia la sua carriera nel 2009 registrando i primi brani.
Nel febbraio del 2011 rilascia il suo primo singolo ufficiale, “No Story”. Il brano segna l\'inizio della sua collaborazione con 3D, che da allora è il suo produttore principale, ed è il primo estratto dal suo album d\'esordio, Nayt One, uscito nel 2012.
Nel 2015, dopo un paio di progetti minori ed essere stato scritturato dalla VNT1 Records di 3D, rilascia Raptus, primo capitolo di una una trilogia di street album che si completerà con Raptus 2 (2017) e Raptus 3 (2019). Quest\'ultimo, sua prima uscita discografica in licenza per Sony Music Italy, è anticipato da “Gli occhi della tigre”, brano che contribuisce a farlo conoscere nella scena rap italiana.
Nel 2020 è la volta di MOOD, seguito l\'anno successivo dallo speculare DOOM e infine, nel 2023, da HABITAT, che compongono la sua seconda trilogia.'),

('Izi','https://www.hiphopstarztour.com/wp-content/uploads/2020/10/izi-1020-coverpage1.jpg','IZI, nome d\'arte di Diego Germini (Savigliano, 30 luglio 1995), è un rapper italiano, originario di Cogoleto. È membro della crew Wild Bandana e del movimento Drilliguria.
Prima di approdare nel 2015 all\'alias IZI, ha adottato i nomi d\'arte EazyRhymes e Izi Erre.'),

('Noyz Narcos','https://www.lecceinscena.it/images/com_eventbooking/musica/URBAN-FEST-Noyz-Narcos.jpg','Noyz Narcos, nome d\'arte di Emanuele Frasca (Roma, 15 dicembre 1979), è un rapper e produttore italiano.
Si avvicina all\'hip hop nei primi anni novanta, scoprendo nelle riviste di skate il mondo dei graffiti; di lì a poco comincia quindi la sua attività di writer con la tag Noyz (in precedenza Noyze). Il suo primo approccio con il rap avviene a metà anni ‘90, quando comincia a rappare con Fetz Darko. L\'esperienza in questione rimane tuttavia di breve durata e bisognerà aspettare il 2000 per avere la sua prima strofa pubblicata ufficialmente, contenuta nel brano “Saloon” dei Truceboys, gruppo formato inizialmente da Gel, Metal Carter e Cole di cui Noyz da lì a poco diventa membro.
Nel 2003 i Truceboys pubblicano Sangue, seguito due anni dopo dall\'album d\'esordio di Noyz, Non Dormire, prodotto prevalentemente dal rapper stesso, che proseguirà l\'attività di produttore fino al successivo Verano Zombie, rilasciato nel 2007. È nel periodo di Non Dormire che, dalla convergenza tra i gruppi Truceboys e In The Panchine, nasce il TruceKlan, uno dei collettivi più influenti nella storia del rap italiano, che rimarrà attivo grosso modo fino al 2014.
Nella sua carriera, oltre ai suoi lavori solisti e al disco con i Truceboys, ha rilasciato tre album collaborativi (La Calda Notte con Chicoria, altro membro del T.Klan, Localz Only con il produttore Fritz Da Cat e CVLT con Salmo) e due mixtape con DJ Gengis. La sua carriera dagli esordi al 2021 è raccontata nel documentario Noyz Narcos – Dope Boys Alphabet.'),

('Lazza','https://bisceglie.gocity.it/library/media/lazza_foto_ufficiale.jpg','Lazza, nome d\'arte di Jacopo Lazzarini (Milano, 22 agosto 1994), è un rapper, produttore e pianista italiano.
Dopo aver studiato pianoforte al Conservatorio Giuseppe Verdi di Milano, comincia a fare rap e da adolescente è membro del collettivo Zero2. In quel periodo partecipa a varie gare di freestyle e nel 2012 pubblica il suo primo progetto, Destiny Mixtape.
Nel 2013 lascia la Zero2 per entrare in Blocco Recordz, etichetta di Emis Killa, per la quale rilascia l\'anno successivo il mixtape K1.
Nel 2016, lascia Blocco Recordz ed entra in 333 Mob, l\'allora neonato collettivo ed etichetta costola di Machete. L\'anno successivo pubblica per 333 Mob il suo album d\'esordio, Zzala, seguito due anni più tardi da Re Mida, edito Island/Universal e suo primo disco major.
Nel 2023 partecipa al Festival di Sanremo con il brano “CENERE”, classificandosi secondo.'),

('','',''),
('','',''),
('','',''),
('','',''),