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

('Sfera Ebbasta','https://phantomag.com/wp-content/uploads/2019/04/sfera-ebbasta-shot.jpg', 'Sfera Ebbasta, nome d\'arte di Gionata Boschetti (Sesto San Giovanni, 7 dicembre 1992), è un rapper italiano, originario di Cinisello Balsamo.
Muove i suoi passi nel mondo del rap attorno al 2011, esordendo due anni dopo con il mixtape Emergenza Mixtape Vol. 1.
Il successo arriva nel 2015 grazie allo street album XDVR, frutto della collaborazione con il produttore Charlie Charles, che lo lancia come uno dei maggiori esponenti della nuova scena rap italiana.
Nello stesso anno entra, assieme al fidato Charlie Charles, nel roster dell\'etichetta Roccia Music di Marracash e rilascia la riedizione di XDVR. Nel 2017 pubblica il suo primo album ufficiale, Sfera Ebbasta, per Universal.
Nel 2018, assieme a Charlie Charles e a Shablo, fonda l\'etichetta discografica BHMG, in partnership con Universal. L\'anno vede anche l\'uscita del suo secondo album, Rockstar, con cui conquista svariati dischi di platino e del quale viene realizzata anche una versione internazionale
Nel 2019 è uno dei giudici del talent show X Factor Italia.
A fine 2020 è la volta del suo quarto album, Famoso, anticipato da un documentario uscito in streaming su Prime Video.
Nel 2023 esce l\'album X2VR.'),

('Gemitaiz','https://yt3.googleusercontent.com/3SvC8DB9rday-685h3iCYykR-I1hjoHArYMZeMSiLQiFUitoZxb8FWsu3fpx2IUDt_QtHljI=s900-c-k-c0x00ffffff-no-rj',  'Gemitaiz, nome d\'arte di Davide De Luca (Roma, 4 novembre 1988), è un rapper e produttore italiano.
Dopo aver scoperto il rap tramite il suo amico e in seguito produttore Il Tre, inizia a rappare a 14 anni con il nome d\'arte Gemito, che poi cambia in Gemitaiz ispirandosi ad un amico che, per scherzare, aggiungeva "-aiz" ad ogni parola.
Muove i suoi primi passi nella scena a metà anni 2000 come membro del gruppo Xtreme Team, con il quale pubblica sei progetti tra il 2007 e il 2011.
Dopo la fine dell\'Xtreme, inizia la sua carriera solista e nel 2013 firma per Tanta Roba, pubblicando nello stesso anno il suo album d\'esordio, L\’unico compromesso. Nella sua attività discografica solista, oltre ai dischi ufficiali, figura la saga di mixtape Quello Che Vi Consiglio, iniziata nel 2009 e portata avanti con cadenza quasi annuale. Parallelamente, dal 2011, porta avanti una collaborazione, sia in studio sia dal vivo, con MadMan.
Nel 2020, inizia la sua attività di produttore, sia per sé stesso sia per altri artisti.')

('Marracash-Guè','https://mnd.shbcdn.com/blobs/variants/b/f/6/c/bf6c5ade-15cc-464a-ac7e-76baebf9a8a6_medium_p.jpg?_636162003771776734','Il 4 gennaio 2016, attraverso i social network, i due rapper hanno rivelato la loro intenzione di realizzare un album insieme;
già in passato, Marracash e Guè hanno avuto modo di collaborare insieme alla realizzazioni di vari brani, tra cui Fattore wow (presente nell\'album omonimo di Marracash del 2008), Big! e Brivido, questi ultimi rispettivamente presenti negli album Il ragazzo d\'oro e Bravo ragazzo di Pequeno.
Il 20 maggio 2016, per anticipare l\'album, i rapper pubblicarono un mixtape contenente tutte le loro 16 precedenti collaborazioni, intitolato Double Dragon Mixtape. L\'album è stato concepito, scritto e registrato tra Tenerife (Spagna), Trancoso (Brasile) e Milano (Italia).
Il 19 maggio è stato reso disponibile sull\'iTunes Store il pre-ordine dell\'album, inizialmente intitolato Marra/Guè: L\'album e con la data di pubblicazione fissata al 24 giugno, mentre il 7 giugno sono stati rivelati la copertina (curata dal visual artist colombiano Armando Mesìas), il titolo definitivo e la lista tracce, oltre alla pubblicazione del singolo di lancio Nulla accade.'),

('Salmo-Noyz', 'https://media.gqitalia.it/photos/653d35317771e0d78a5a5153/16:9/w_2560%2Cc_limit/Copia%2520di%2520DSC00122%2520copia.jpg', 'I due rapper italiani Salmo e Noyz Nascos pubblicano il 3 novembre 2023 il joint album Cult.
Il disco si caratterizza per sonorità più pesanti rispetto alle recenti produzioni dei due artisti, con continui riferimenti al mondo del cinema (in particolare a quello horror) e testi di ispirazione hardcore.
Non mancano tuttavia sperimentazioni sonore, come l\'elettronica in Brujeria e Nightcrawlers o elementi più pop come My Love Song 2 con Coez e Frah Quintale;
il brano Respira, in collaborazione con Marracash, presenta invece per un campionamento di Breathe dei The Prodigy'),

('Gemitaiz-MadMan', 'https://www.bitconcerti.it/slir/w768-h550/images/7/2/72-gem-mad-tour-banner-cropped-97.jpeg', 'Gemitaiz e MadMan sono due rapper italiani che contano innumerevoli collaborazioni insieme, tra cui gli album Kepler, Scatola Nera.'),

('Marracash','https://www.chimagazine.it/content/uploads/2024/12/Marracash_posato1_credits-Andrea-Bianchera-886x886.jpg','Marracash, nome d\'arte di Fabio Bartolo Rizzo (Nicosia, 22 maggio 1979), è un rapper italiano. Nato in Sicilia, si trasferisce con la famiglia a Milano da bambino, crescendo nel quartiere Barona. Comincia a fare rap a fine anni \'90, usando l\'alias Juza delle Nuvole – preso in prestito da un personaggio di Ken il Guerriero – e frequentando il Muretto alle spalle di piazza San Babila, storico luogo di ritrovo della scena hip hop milanese. Dopo aver abbandonato la scena per qualche anno, torna nel 2004 come Marracash, partecipando al mixtape PMC vs Club Dogo. Il suo nome d\'arte definitivo si rifà al nomignolo \"Marrakech\", che gli veniva dato quando era bambino dai suoi coetanei per via della carnagione scura e che ha rielaborato inserendo \"cash\", ovvero \"soldi\" in inglese. Nel 2005 pubblica la sua prima uscita solista, il mixtape Roccia Music, ed è tra gli artefici della nascita del collettivo Dogo Gang, fondato assieme a Club Dogo, Vincenzo da Via Anfossi e Deleterio, conosciuti ai tempi del Muretto. Nel 2008, dopo aver firmato per Universal, pubblica il suo album d\'esordio, Marracash, contenente il singolo \"Badabum Cha Cha\", che lo rende da subito uno dei rapper più noti della scena. Tra il 2012 e il 2014 conduce per tre edizioni MTV Spit, programma incentrato sulle sfide di freestyle tra rapper in onda su MTV. Nel 2016 collabora con Guè Pequeno realizzando l\'album collaborativo Santeria. Nel 2019 pubblica il pluricertificato album Persona, che rappresenterà il primo capitolo di una trilogia completata con gli album NOI, LORO, GLI ALTRI (2021) ed È FINITA LA PACE (2024).'),

('Ernia', 'https://www.azalea.it/wp-content/uploads/2023/04/ERNIA_low-e1680511379620.png', 'Ernia, nome d\'arte di Matteo Professione (Milano, 29 novembre 1993), è un rapper italiano. All\'asilo conosce Tedua e sarà grazie a questa amicizia che a 12 anni entra in contatto con il rap, iniziando a fare freestyle e a frequentare la scena delle jam milanesi. Durante l\'adolescenza entra a far parte dei collettivi Bonola Family (prima) e Razza a Parte (poi), tutti e due formati da gente più grande di lui. In seguito modifica il suo alias in Er Nyah e forma il gruppo Troupe D\'Elite, di cui era membro anche Ghali (che aveva conosciuto ai tempi delle jam di freestyle), con i quali pubblica un EP (2012) e un album (2014) prima dello scioglimento. Nel frattempo, nel 2013, esce il suo primo progetto solista, il mixtape New Generation Rap Boss. La fine dell\'esperienza Troupe D\'Elite, dovuta soprattutto alle pesanti critiche ricevute dal pubblico del rap italiano, lo segnerà al punto da spingerlo a smettere di fare musica. Dopo due anni di silenzio, torna nel 2016 con il singolo “Vuoto”, rilasciato in maniera indipendente, che segna l\'inizio della sua carriera solista a nome Ernia. Nel 2017 pubblica per Island/Universal il suo album d\'esordio, Come Uccidere Un Usignolo (67 Edition), riedizione del mini-album Come Uccidere Un Usignolo, pubblicato pochi mesi prima per Thaurus. Seguono gli album 68 (2018) e Gemelli (2020), entrambi certificati in poco tempo dischi di platino, che lo attestano come uno degli esponenti più importanti della scena rap nazionale.'),

('Kid Yugi', 'https://i.scdn.co/image/ab6761610000e5eba16e75af4567e52d37648d69', 'Kid Yugi, nome d\'arte di Francesco Stasi (Massafra, 14 aprile 2001), è un rapper italiano. Dopo aver iniziato a fare rap attorno ai tredici anni, esordisce nel 2019, con gli alias Abisso e Lil Killua, come parte del gruppo SAINTS MOB. Nel 2022 rilascia in maniera indipendente il singolo “GRAMMELOT”, la sua prima uscita ufficiale da solista come Kid Yugi, alias ripreso dal protagonista del manga, anime e gioco di carte Yu-Gi-Oh!. Nello stesso anno pubblica per Underdog Music il suo album d\'esordio, The Globe. Nel 2023 esce il singolo “Minaccia”, la sua prima pubblicazione per Virgin/Universal.'),

('Rkomi', 'https://www.corriere.it/methode_image/2021/11/17/Spettacoli/Foto%20Spettacoli%20-%20Trattate/rkomi-kOZ-U33001374987111sBE-656x492@Corriere-Web-Sezioni.jpg', 'Rkomi, nome d\'arte di Mirko Manuele Martorana (Milano, 19 aprile 1994), è un cantautore e rapper italiano. Esordisce nel novembre 2013 con l\'EP Cugini Bella Vita, come membro del duo Cugini Bellavita, formato con il cugino rapper Pablo Asso. L\'anno successivo pubblica il suo primo mixtape solista, Calvairate Mixtape, che include le collaborazioni di Tedua e IZI. La sua carriera discografica inizia, in maniera ufficiale, nel 2016, quando rilascia vari singoli, che verranno poi riuniti, assieme a due inediti, nell\'EP Dasein Sollen. Nel 2017 è la volta del suo primo album, Io In Terra, pubblicato per Universal. Due anni dopo, con il successivo Dove Gli Occhi Non Arrivano, si avvicina a sonorità maggiormente pop e al cantato. Nel 2022 partecipa al Festival di Sanremo con il brano “INSUPERABILE” e viene scelto come giudice del talent X Factor.'),

('Ele A','https://www.bohmagazine.it/wp-content/uploads/ele-a-rapper-biografia.jpg','Ele A, nome d\'arte di Eleonora Antognini (Lugano, 11 luglio 2002), è una rapper svizzera con cittadinanza italiana, originaria di Aranno. Figlia di due insegnanti di musica, suona il violoncello per dieci anni, ma parallelamente, nel periodo delle medie, si appassiona al rap grazie al mixtape QCVC 2 di Gemitaiz. Tra il 2020 e il 2022 pubblica diversi freestyle e remix sul suo profilo Instagram. Sempre nel 2022 rilascia la demo ZERODUE esclusivamente in CD e inizia ad esibirsi dal vivo, esordendo al festival MI AMI di Milano e suonando anche allo Sziget Festival di Budapest. A fine 2022 pubblica da indipendente il suo primo singolo ufficiale, “Mikado”, che anticipa l\'uscita del suo EP d\'esordio, GLOBO, rilasciato l\'anno successivo e interamente prodotto da Disse.'),

('Anna', 'https://www.trashitaliano.it/cdn-cgi/image/f=auto,fit=crop,h=633,q=90,w=768/https://media.trashitaliano.it/2024/06/Anna-jpg.webp', 'Anna Pepe (La Spezia, 15 agosto 2003), conosciuta semplicemente come ANNA, è una rapper italiana. Nata da madre scultrice e padre ex calciatore e DJ (con una predilezione per l\'hip hop), si avvicina al rap verso i 10 anni registrando cover di Nicki Minaj per poi pubblicare su Instagram i suoi primi freestyle all\'età di 15 anni. Di lì a poco inizia a collaborare con il rapper Anis, suo concittadino, con il quale pubblica i brani \"24/7\" e \"Holidays\" su YouTube. Nel frattempo decide di intraprendere un percorso da solista che la porta, nel marzo 2019, a pubblicare il suo singolo d\'esordio, \"Baby\". A farla esplodere è la successiva \"Bando\", rappata su una base house e pubblicata sul finire del 2019, che le permette di firmare per Universal. Nel 2022 rilascia per Universal il suo EP d\'esordio, Lista 47, seguito due anni dopo dal suo primo album, VERA BADDIE.'),

('Madame', 'https://media-assets.vanityfair.it/photos/63dbd9be8c138073fd69e0de/16:9/w_2560%2Cc_limit/unnamed.jpg', 'Madame, nome d\'arte di Francesca Calearo (Creazzo, 16 gennaio 2002), è una cantautrice italiana. Il suo nome d\'arte era inizialmente Madame Wild, alias nato da un generatore di nomi per drag queen su Instagram, che un\'amica le aveva fatto scoprire. In seguito opta per mantenere solamente Madame. Scoperta dall\'etichetta Arcade Army Records, esordisce nel settembre 2018 con il singolo “Anna”, ma è con la successiva “Sciccherie”, uscita nel dicembre dello stesso anno, che si afferma come uno dei maggiori talenti emergenti del panorama urban italiano. Di lì a breve firma per la Sugar, per la quale pubblica nel giugno del 2019 il suo primo singolo ufficiale, “17”. Tra il 2019 e il 2020 alterna singoli solisti e varie collaborazioni, tra le quali si ricordano “MADAME – L\'anima” di Marracash, “Fuoriluogo” di Ernia e “Non è vero niente” dei Negramaro, nonché la partecipazione alla hit estiva “DEFUERA” di DRD assieme a Ghali e al già citato Marracash. Nel 2021 partecipa al Festival di Sanremo presentando il brano “VOCE”, che anticipa l\'uscita del suo album d\'esordio, MADAME. Nel febbraio del 2023 torna a Sanremo con il brano “IL BENE NEL MALE”, unica anticipazione del suo secondo album, L\'AMORE, uscito nel marzo successivo.'),

('Tony Effe', 'https://rapteratura.it/wp-content/uploads/2024/03/tony-effe-2-e1710951773538.jpg', 'Tony Effe, nome d\'arte di Nicolò Rapisarda (Roma, 17 maggio 1991), è un rapper italiano. Dopo l\'esperienza nella Dark Polo Gang, nel giugno del 2021 pubblica il suo primo album solista, Untouchable. Nel 2024 ottiene il grande successo con l\'Album Icon, piazzandosi per molte settimane ai primi posti nelle classifiche FIMI. D\'estate pubblica il singolo \"Sesso e Samba\" assieme alla cantante Gaia. Nel 2025 parteciperà al festival di Sanremo per la sua prima volta');


('Massimo Pericolo','https://i.scdn.co/image/ab6761610000e5ebbcff54d6d50e5509211235a5','Massimo Pericolo, nome d\'arte di Alessandro Vanetti (Gallarate, 30 novembre 1992), è un rapper italiano.
Nato a Gallarate e cresciuto tra Malgesso, Treviso, Catania, Gavirate e Laveno, si avvicina al rap da bambino grazie al film 8 mile di Eminem, che lo ispirato a scrivere i suoi primi testi provando a ricreare con i suoi amici le battle di freestyle della pellicola.
Qualche anno più tardi conosce il rapper Kaso, che lavora coi ragazzi della provincia di Varese a progetti educativi e di formazione musicale, e può così registrare i suoi primissimi pezzi. Durante l\'adolescenza collabora con alcuni amici e realizza un demo di sette pezzi che però non verrà pubblicato.
La sua carriera di rapper inizia con il nome Shinobi, ispirato al videogioco ninjesco Shinobido: Way of the Ninja. Successivamente adotta lo pseudonimo Skinny Bitch, registrando due feat (“Come la Torta” e “Otto sotto un testo”) nell\'album Cime di R-ep della SpumaCru, pubblicato nel 2011. In quel periodo si esibisce per la prima volta dal vivo in piccoli eventi a microfono aperto organizzati dal rapper Kaso, oltre a registrare una demo dal produttore varesino Mocce.
Nel 2014 viene arrestato nell\'ambito dell\'operazione antidroga Scialla semper (che darà poi il titolo al suo album d\'esordio) e sconta due anni di detenzione tra carcere e arresti domiciliari. Durante questo periodo, cambia nome in Massimo Pericolo. Anche se non scriverà in carcere la svolta nel suo modo di fare rap arriverà proprio durante la detenzione, quando incoraggiato da un amico, inizia a scrivere anche della sua vita e del suo passato, adottando di fatto un approccio più conscious alla scrittura. Segue la pubblicazione su YouTube di brani con e senza video su beat editi ed inediti.
Nel 2018 conosce i produttori Phra e Nic Sarno e firma per Pluggers e Lucky Beard Rec, pubblicando nel gennaio 2019 il singolo “7 Miliardi” che ottiene consensi unanimi tra pubblico, critica e gli altri colleghi e che anticipa il suo album d\'esordio Scialla semper.
Nel 2021 pubblica il suo secondo album, SOLO TUTTO, e la sua autobiografia Il signore del bosco, edita Rizzoli.
'),

('Night Skinny','https://www.systemfailurewebzine.com/wp-content/uploads/2019/08/NightSkinny1-PhLeonardoScotti.jpg','Night Skinny (o The Night Skinny), nome d\'arte di Luca Pace (Termoli, 14 febbraio 1983), è un produttore e ingegnere del suono italiano.
Inizialmente noto come Cee Mass, esordisce come Night Skinny nel 2010 pubblicando l\'album Metropolis Stepson.
Nel febbraio del 2013 entra nel roster di Machete, per poi uscirne l\'anno successivo e pubblicare l\'album Zero Kills da indipendente. Il disco vanta la partecipazione di esponenti importanti del rap italiano (tra i quali Marracash e Noyz Narcos) ed ottiene un discreto successo, facendolo affermare Skinny tra i produttori più importanti della scena nazionale.
I suoi successivi album, Pezzi (2017) e Mattoni (2019), si rivelano nuovamente dei successi, portandolo a collaborare anche con artisti di una nuova ondata di rap italiano, affermatisi in quel periodo.
'),


('','',''),