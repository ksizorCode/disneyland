-- =====================================================
-- Crea la base de datos 
-- =====================================================
CREATE DATABASE IF NOT EXISTS musica;
USE musica;

-- =====================================================
-- Crea las tablas
-- =====================================================

CREATE TABLE artistas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    foto VARCHAR(100) NULL,
    fecha_nacimiento DATE NULL
);

CREATE TABLE discos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    portada VARCHAR(100) NULL,
    fecha DATE NULL,
    artista_id INT,
    FOREIGN KEY (artista_id) REFERENCES artistas(id) ON DELETE CASCADE
);

CREATE TABLE canciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    duracion TIME,
    disco_id INT,
    FOREIGN KEY (disco_id) REFERENCES discos(id) ON DELETE CASCADE
);

-- =====================================================
-- Tabla de relación entre artistas y canciones
-- =====================================================
CREATE TABLE artistas_canciones (  
    artista_id INT,
    cancion_id INT,
    PRIMARY KEY (artista_id, cancion_id),
    FOREIGN KEY (artista_id) REFERENCES artistas(id) ON DELETE CASCADE,
    FOREIGN KEY (cancion_id) REFERENCES canciones(id) ON DELETE CASCADE
);

-- Inserta datos en artistas con fecha de nacimiento y foto
INSERT INTO artistas (nombre, fecha_nacimiento, foto) VALUES 
('Dire Straits', '1977-05-01', 'dire_straits.jpg'),
('Coldplay', '1996-01-16', 'coldplay.jpg'),
('Taylor Swift', '1989-12-13', 'taylor_swift.jpg');

-- Inserta datos en discos con fecha de lanzamiento y portada
INSERT INTO discos (nombre, artista_id, fecha, portada) VALUES 
('Diamonds & Rust', 1, '1980-04-01', 'diamonds_rust.jpg'),          -- Album 1
('On Every Street', 1, '1991-09-15', 'on_every_street.jpg'),        -- Album 2

('A Rush of Blood to the Head', 2, '2002-08-26', 'rush_blood.jpg'), -- Album 3
('X&Y', 2, '2005-06-06', 'xandy.jpg'),                              -- Album 4

('1989', 3, '2014-10-27', '1989.jpg'),                              -- Album 5
('Repuation', 3, '2017-11-10', 'reputation.jpg'),                   -- Album 6
('Red', 3, '2012-10-22', 'red.jpg');                                -- Album 7


-- Inserta canciones para Dire Straits
INSERT INTO canciones (nombre, duracion, disco_id) VALUES 
-- Album 1
('Diamonds & Rust', '00:04:45', 1),
('Sultans of Swing', '00:05:48', 1),
('Walk of Life', '00:04:12', 1),
('Money for Nothing', '00:06:34', 1),
('Romeo and Juliet', '00:06:00', 1),
('Tunnel of Love', '00:05:10', 1),
-- Album 2
('Calling Elvis', '00:04:00', 2),
('Heavy Fuel', '00:05:00', 2),
('The Bug', '00:03:30', 2),
('Money for Nothing (Reprise)', '00:02:45', 2),
('What s Love Got to Do with It', '00:03:15', 2),
('Walk of Life (Live)', '00:04:10', 2);

-- Inserta canciones para Coldplay
INSERT INTO canciones (nombre, duracion, disco_id) VALUES 
-- Album 3
('The Scientist', '00:05:09', 3),
('Clocks', '00:05:07', 3),
('Yellow', '00:04:29', 3),
('Viva la Vida', '00:04:02', 3),
('Paradise', '00:04:38', 3),
('Fix You', '00:04:55', 3),
-- Album 4
('Speed of Sound', '00:04:45', 4),
('Fix You (Alternate)', '00:04:55', 4),
('Talk', '00:04:05', 4),
('The Hardest Part', '00:03:50', 4),
('Swallowed in the Sea', '00:04:10', 4),
('A Message', '00:03:30', 4);

-- Inserta canciones para Taylor Swift
INSERT INTO canciones (nombre, duracion, disco_id) VALUES 
-- Album 5
('Shake It Off', '00:03:39', 5),
('Blank Space', '00:03:51', 5),
('Style', '00:03:51', 5),
('Bad Blood', '00:03:31', 5),
('Wildest Dreams', '00:03:40', 5),
('Love Story', '00:03:55', 5),
-- Album 6
('State of Grace', '00:04:55', 7),
('Red', '00:03:43', 7),
('Treacherous', '00:04:10', 7),
('I Knew You Were Trouble', '00:03:17', 7),
('All Too Well', '00:05:29', 7),
('22', '00:03:52', 7);

-- =====================================================
-- Inserta en la tabla de relación 'artistas_canciones'
-- =====================================================

-- Dire Straits
INSERT INTO artistas_canciones (artista_id, cancion_id) VALUES 
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6),
(1, 7), (1, 8), (1, 9), (1, 10), (1,11), (1, 12);

-- Coldplay
INSERT INTO artistas_canciones (artista_id, cancion_id) VALUES 
(2, 13), (2, 14), (2, 15), (2, 16), (2, 17), (2, 18),
(2, 19), (2, 20), (2, 21), (2, 22), (2, 23), (2, 24);

-- Taylor Swift
INSERT INTO artistas_canciones (artista_id, cancion_id) VALUES 
(3, 25), (3, 26), (3, 27), (3, 28), (3, 29), (3, 30),
(3, 31), (3, 32), (3, 33), (3, 34), (3, 35), (3, 36);

-- =====================================================
-- Consultas de prueba
-- =====================================================
