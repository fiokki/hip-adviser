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
    cover VARCHAR(255),
    release_date DATE NOT NULL,
    genre VARCHAR(30),
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

