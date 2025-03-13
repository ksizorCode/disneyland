-- Crear la base de datos y seleccionarla
CREATE DATABASE IF NOT EXISTS disneylanddb;
USE disneylanddb;

-- -------------------------------------------------
-- Tablas principales
-- -------------------------------------------------

-- Tabla: complejo
CREATE TABLE complejo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    lugar VARCHAR(100),
    descripcion TEXT,
    gps VARCHAR(50)
);

-- Tabla: parque (debe crearse después de complejo, pues usa su clave foránea)
CREATE TABLE parque (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    id_complejo INT,
    descripcion TEXT,
    mapa TEXT,
    anio INT,
    FOREIGN KEY (id_complejo) REFERENCES complejo(id) ON DELETE SET NULL
);

-- Tabla: atraccion
CREATE TABLE atraccion (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    foto TEXT,
    video_pov TEXT,
    descripcion TEXT,
    longitud_gps VARCHAR(50),
    latitud_gps VARCHAR(50)
);

-- Tabla: tipo
CREATE TABLE tipo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    icono TEXT
);

-- Tabla: zonaparque
CREATE TABLE zonaparque (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    icono TEXT
);

-- Tabla: tematica
CREATE TABLE tematica (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    icono TEXT
);

-- Tabla: hoteles
CREATE TABLE hoteles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    estrellas INT,
    descripcion TEXT,
    fotos TEXT
);

-- -------------------------------------------------
-- Tablas de relaciones
-- -------------------------------------------------

-- Tabla: _complejo_parque (referencia a complejo y parque)
CREATE TABLE _complejo_parque (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_complejo INT,
    id_parque INT,
    FOREIGN KEY (id_complejo) REFERENCES complejo(id) ON DELETE CASCADE,
    FOREIGN KEY (id_parque) REFERENCES parque(id) ON DELETE CASCADE
);

-- Tabla: _atraccion_parque (referencia a atraccion y parque)
CREATE TABLE _atraccion_parque (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_atraccion INT,
    id_parque INT,
    FOREIGN KEY (id_atraccion) REFERENCES atraccion(id) ON DELETE CASCADE,
    FOREIGN KEY (id_parque) REFERENCES parque(id) ON DELETE CASCADE
);

-- Tabla: _atraccion_zonaparque (referencia a atraccion y zonaparque)
CREATE TABLE _atraccion_zonaparque (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_atraccion INT,
    id_zonaparque INT,
    FOREIGN KEY (id_atraccion) REFERENCES atraccion(id) ON DELETE CASCADE,
    FOREIGN KEY (id_zonaparque) REFERENCES zonaparque(id) ON DELETE CASCADE
);

-- Tabla: _atraccion_tipo (referencia a atraccion y tipo)
CREATE TABLE _atraccion_tipo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_atraccion INT,
    id_tipo INT,
    FOREIGN KEY (id_atraccion) REFERENCES atraccion(id) ON DELETE CASCADE,
    FOREIGN KEY (id_tipo) REFERENCES tipo(id) ON DELETE CASCADE
);

-- Tabla: _atraccion_tematica (referencia a atraccion y tematica)
CREATE TABLE _atraccion_tematica (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_atraccion INT,
    id_tematica INT,
    FOREIGN KEY (id_atraccion) REFERENCES atraccion(id) ON DELETE CASCADE,
    FOREIGN KEY (id_tematica) REFERENCES tematica(id) ON DELETE CASCADE
);

-- Tabla: _zonaparque_tematica (referencia a zonaparque y tematica)
CREATE TABLE _zonaparque_tematica (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_zonaparque INT,
    id_tematica INT,
    FOREIGN KEY (id_zonaparque) REFERENCES zonaparque(id) ON DELETE CASCADE,
    FOREIGN KEY (id_tematica) REFERENCES tematica(id) ON DELETE CASCADE
);

-- Tabla: _complejo_hoteles (referencia a complejo y hoteles)
CREATE TABLE _complejo_hoteles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_complejo INT,
    id_hoteles INT,
    FOREIGN KEY (id_complejo) REFERENCES complejo(id) ON DELETE CASCADE,
    FOREIGN KEY (id_hoteles) REFERENCES hoteles(id) ON DELETE CASCADE
);

-- -------------------------------------------------
-- Inserción de contenidos
-- -------------------------------------------------

-- Inserción en complejo
INSERT INTO complejo (id, nombre, lugar, descripcion, gps) VALUES
(1, 'disneyland resort', 'anaheim, california, usa', 'el primer complejo de disney, inaugurado en 1955.', '33.8121,-117.9190'),
(2, 'walt disney world resort', 'orlando, florida, usa', 'complejo turístico con varios parques temáticos y hoteles.', '28.3852,-81.5639'),
(3, 'disneyland paris', 'marne-la-vallée, francia', 'parque temático europeo inaugurado en 1992.', '48.8708,2.7832'),
(4, 'tokyo disney resort', 'tokyo, japón', 'el primer parque disney fuera de ee.uu., inaugurado en 1983.', '35.6329,139.8804'),
(5, 'hong kong disneyland resort', 'lantau island, hong kong', 'el parque disney en asia, inaugurado en 2005.', '22.3121,114.0419'),
(6, 'shanghai disney resort', 'shanghai, china', 'el parque más moderno de disney, inaugurado en 2016.', '31.1413,121.6600'),
(7, 'disney adventure resort', 'orlando, florida, usa', 'complejo ficticio para nuevas experiencias de aventura.', '28.4500,-81.2000');

-- Inserción en parque
INSERT INTO parque (id, nombre, id_complejo, descripcion, mapa, anio) VALUES
(1, 'disneyland park', 1, 'el parque original con atracciones clásicas.', 'link_a_mapa', 1955),
(2, 'disney california adventure', 1, 'parque temático de aventuras y diversión.', 'link_a_mapa', 2001),
(3, 'magic kingdom', 2, 'el parque temático más famoso de walt disney world.', 'link_a_mapa', 1971),
(4, 'epcot', 2, 'parque de innovación y cultura.', 'link_a_mapa', 1982),
(5, 'disney\'s hollywood studios', 2, 'parque temático de cine y espectáculos.', 'link_a_mapa', 1989),
(6, 'disney\'s animal kingdom', 2, 'parque temático con atracciones y animales.', 'link_a_mapa', 1998),
(7, 'disneyland park', 3, 'parque temático con inspiración en cuentos de hadas.', 'link_a_mapa', 1992),
(8, 'walt disney studios park', 3, 'parque centrado en el cine y la producción.', 'link_a_mapa', 2002),
(9, 'tokyo disneyland', 4, 'parque temático similar a disneyland en california.', 'link_a_mapa', 1983),
(10, 'tokyo disneysea', 4, 'parque temático único con ambientación marítima.', 'link_a_mapa', 2001),
(11, 'hong kong disneyland', 5, 'el parque original en hong kong.', 'link_a_mapa', 2005),
(12, 'shanghai disneyland', 6, 'el parque más moderno de disney.', 'link_a_mapa', 2016),
(13, 'disney adventure park', 7, 'parque temático de aventura y exploración, parte del nuevo complejo disney adventure resort.', 'link_a_mapa', 2023);

-- Inserción en atraccion
INSERT INTO atraccion (id, nombre, foto, video_pov, descripcion, longitud_gps, latitud_gps) VALUES
(1, 'big thunder mountain railroad', 'link_foto_btm', 'link_video_btm', 'montaña rusa ambientada en una mina abandonada.', '-117.9200', '33.8125'),
(2, 'haunted mansion', 'link_foto_hm', 'link_video_hm', 'casa encantada con fantasmas y efectos especiales.', '-117.9210', '33.8127'),
(3, 'space mountain', 'link_foto_sm', 'link_video_sm', 'montaña rusa en la oscuridad con temática espacial.', '-117.9220', '33.8129'),
(4, 'pirates of the caribbean', 'link_foto_pc', 'link_video_pc', 'aventura en barco con escenas de piratas y saqueos.', '-117.9230', '33.8130'),
(5, 'it\'s a small world', 'link_foto_ia', 'link_video_ia', 'paseo en bote que celebra la diversidad cultural del mundo.', '-117.9240', '33.8131'),
(6, 'splash mountain', 'link_foto_sm2', 'link_video_sm2', 'aventura acuática con descensos emocionantes.', '-117.9250', '33.8132'),
(7, 'jungle cruise', 'link_foto_jc', 'link_video_jc', 'paseo en bote por ríos exóticos y divertidos guiones.', '-117.9260', '33.8133'),
(8, 'soarin\' around the world', 'link_foto_sa', 'link_video_sa', 'simulación de vuelo sobre paisajes impresionantes del mundo.', '-117.9270', '33.8134'),
(9, 'seven dwarfs mine train', 'link_foto_sdmt', 'link_video_sdmt', 'montaña rusa familiar basada en la historia de los siete enanitos.', '-117.9280', '33.8135');

-- Inserción en tipo
INSERT INTO tipo (id, nombre, descripcion, icono) VALUES
(1, 'montaña rusa', 'atracción con recorrido en rieles y velocidad.', 'icono_montana.png'),
(2, 'simulado', 'atracción basada en simulación de experiencias.', 'icono_simulado.png'),
(3, 'indoor', 'atracción ubicada en espacios cerrados.', 'icono_indoor.png'),
(4, 'paseo', 'atracción de recorrido lento y escénico.', 'icono_paseo.png');

-- Inserción en zonaparque
INSERT INTO zonaparque (id, nombre, descripcion, icono) VALUES
(1, 'main street, usa', 'zona de entrada inspirada en una ciudad americana de principios del siglo xx.', 'mainstreet.png'),
(2, 'frontierland', 'zona con temática del viejo oeste y aventuras de pioneros.', 'frontierland.png'),
(3, 'tomorrowland', 'zona futurista con tecnología avanzada y visión del mañana.', 'tomorrowland.png'),
(4, 'adventureland', 'zona con ambientación de exploración y aventuras exóticas.', 'adventureland.png'),
(5, 'fantasyland', 'zona inspirada en cuentos de hadas y mundos mágicos.', 'fantasyland.png');

-- Inserción en tematica
INSERT INTO tematica (id, nombre, descripcion, icono) VALUES
(1, 'pirata', 'temática basada en aventuras de piratas y el mar.', 'pirata.png'),
(2, 'fantasma', 'temática de terror y espíritus enigmáticos.', 'fantasma.png'),
(3, 'infantil', 'temática orientada a los más pequeños, colorida y lúdica.', 'infantil.png'),
(4, 'ciencia ficción', 'temática futurista con elementos espaciales y tecnológicos.', 'cienciaficcion.png'),
(5, 'aventura', 'temática de exploración y desafíos en entornos exóticos.', 'aventura.png');

-- Inserción en hoteles
INSERT INTO hoteles (id, nombre, estrellas, descripcion, fotos) VALUES
(1, 'disneyland hotel', 5, 'hotel de lujo ubicado en disneyland resort, con decoración temática y servicio exclusivo.', 'link_foto_hotel1'),
(2, 'disney\'s grand californian hotel & spa', 5, 'hotel de alta gama en disneyland resort, con acceso directo a los parques.', 'link_foto_hotel2'),
(3, 'disney\'s contemporary resort', 4, 'hotel con vista al magic kingdom en walt disney world, moderno y elegante.', 'link_foto_hotel3'),
(4, 'disney\'s animal kingdom lodge', 4, 'hotel temático en walt disney world, inspirado en la sabana africana.', 'link_foto_hotel4'),
(5, 'disneyland hotel paris', 4, 'hotel con encanto europeo ubicado en el complejo de disneyland paris.', 'link_foto_hotel5'),
(6, 'disney ambassador hotel', 4, 'hotel ubicado en tokyo disney resort, que ofrece una experiencia única y cultural.', 'link_foto_hotel6'),
(7, 'disney adventure resort hotel', 5, 'hotel exclusivo en el nuevo complejo disney adventure resort.', 'link_foto_hotel7');

-- -------------------------------------------------
-- Inserción en tablas de relaciones
-- -------------------------------------------------

-- Tabla: _complejo_parque
INSERT INTO _complejo_parque (id, id_complejo, id_parque) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 2, 4),
(5, 2, 5),
(6, 2, 6),
(7, 3, 7),
(8, 3, 8),
(9, 4, 9),
(10, 4, 10),
(11, 5, 11),
(12, 6, 12),
(13, 7, 13);

-- Tabla: _atraccion_parque
INSERT INTO _atraccion_parque (id, id_atraccion, id_parque) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 3),
(4, 4, 3),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 4),
(9, 9, 3);

-- Tabla: _atraccion_zonaparque
INSERT INTO _atraccion_zonaparque (id, id_atraccion, id_zonaparque) VALUES
(1, 1, 2),
(2, 2, 5),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 4),
(7, 7, 4),
(8, 8, 3),
(9, 9, 5);

-- Tabla: _atraccion_tipo
INSERT INTO _atraccion_tipo (id, id_atraccion, id_tipo) VALUES
(1, 1, 1),
(2, 2, 3),
(3, 3, 1),
(4, 4, 4),
(5, 5, 4),
(6, 6, 1),
(7, 7, 4),
(8, 8, 2),
(9, 9, 1);

-- Tabla: _atraccion_tematica
INSERT INTO _atraccion_tematica (id, id_atraccion, id_tematica) VALUES
(1, 1, 5),
(2, 2, 2),
(3, 3, 4),
(4, 4, 1),
(5, 5, 3),
(6, 6, 5),
(7, 7, 5),
(8, 8, 4),
(9, 9, 3);

-- Tabla: _zonaparque_tematica
INSERT INTO _zonaparque_tematica (id, id_zonaparque, id_tematica) VALUES
(1, 1, 3),
(2, 2, 1),
(3, 3, 4),
(4, 4, 5),
(5, 5, 3);

-- Tabla: _complejo_hoteles
INSERT INTO _complejo_hoteles (id, id_complejo, id_hoteles) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 2, 4),
(5, 3, 5),
(6, 4, 6),
(7, 7, 7);