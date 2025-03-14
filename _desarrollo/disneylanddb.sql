-- ----------------------------------------------------------------------------------------------------------------------
-- CREACIÓN DE BASE DE DATOS DisneylandDB
-- ----------------------------------------------------------------------------------------------------------------------

CREATE DATABASE IF NOT EXISTS disneylanddb;
USE disneylanddb;


-- ----------------------------------------------------------------------------------------------------------------------
-- CREACIÓN DE TABLAS EN LA BASE DE DATOS DisneylandDB
-- ----------------------------------------------------------------------------------------------------------------------


-- Tabla: complejo
CREATE TABLE complejo (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  lugar VARCHAR(100),
  descripcion TEXT,
  gps VARCHAR(50)
) ENGINE=InnoDB;

-- Tabla: parque
CREATE TABLE parque (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  id_complejo INT DEFAULT NULL,
  descripcion TEXT,
  mapa TEXT,
  anio INT,
  CONSTRAINT fk_parque_complejo 
    FOREIGN KEY (id_complejo) REFERENCES complejo(id) 
    ON DELETE SET NULL
) ENGINE=InnoDB;

-- Tabla: atraccion
CREATE TABLE atraccion (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  foto TEXT,
  video_pov TEXT,
  descripcion TEXT,
  inauguracion DATE,
  longitud_gps VARCHAR(50),
  latitud_gps VARCHAR(50)
) ENGINE=InnoDB;

-- Tabla: tipo
CREATE TABLE tipo (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  descripcion TEXT,
  icono TEXT
) ENGINE=InnoDB;

-- Tabla: zonaparque
CREATE TABLE zonaparque (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  descripcion TEXT,
  icono TEXT
) ENGINE=InnoDB;

-- Tabla: tematica
CREATE TABLE tematica (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  descripcion TEXT,
  icono TEXT
) ENGINE=InnoDB;

-- Tabla: hoteles
CREATE TABLE hoteles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  estrellas INT,
  descripcion TEXT,
  fotos TEXT
) ENGINE=InnoDB;

-- Tabla de relación: _complejo_parque
CREATE TABLE _complejo_parque (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_complejo INT,
  id_parque INT,
  CONSTRAINT fk_complejo_parque_complejo 
    FOREIGN KEY (id_complejo) REFERENCES complejo(id),
  CONSTRAINT fk_complejo_parque_parque 
    FOREIGN KEY (id_parque) REFERENCES parque(id)
) ENGINE=InnoDB;

-- Tabla de relación: _atraccion_parque
CREATE TABLE _atraccion_parque (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_atraccion INT,
  id_parque INT,
  CONSTRAINT fk_atraccion_parque_atraccion 
    FOREIGN KEY (id_atraccion) REFERENCES atraccion(id),
  CONSTRAINT fk_atraccion_parque_parque 
    FOREIGN KEY (id_parque) REFERENCES parque(id)
) ENGINE=InnoDB;

-- Tabla de relación: _atraccion_zonaparque
CREATE TABLE _atraccion_zonaparque (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_atraccion INT,
  id_zonaparque INT,
  CONSTRAINT fk_atraccion_zonaparque_atraccion 
    FOREIGN KEY (id_atraccion) REFERENCES atraccion(id),
  CONSTRAINT fk_atraccion_zonaparque_zonaparque 
    FOREIGN KEY (id_zonaparque) REFERENCES zonaparque(id)
) ENGINE=InnoDB;

-- Tabla de relación: _atraccion_tipo
CREATE TABLE _atraccion_tipo (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_atraccion INT,
  id_tipo INT,
  CONSTRAINT fk_atraccion_tipo_atraccion 
    FOREIGN KEY (id_atraccion) REFERENCES atraccion(id),
  CONSTRAINT fk_atraccion_tipo_tipo 
    FOREIGN KEY (id_tipo) REFERENCES tipo(id)
) ENGINE=InnoDB;

-- Tabla de relación: _atraccion_tematica
CREATE TABLE _atraccion_tematica (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_atraccion INT,
  id_tematica INT,
  CONSTRAINT fk_atraccion_tematica_atraccion 
    FOREIGN KEY (id_atraccion) REFERENCES atraccion(id),
  CONSTRAINT fk_atraccion_tematica_tematica 
    FOREIGN KEY (id_tematica) REFERENCES tematica(id)
) ENGINE=InnoDB;

-- Tabla de relación: _zonaparque_tematica
CREATE TABLE _zonaparque_tematica (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_zonaparque INT,
  id_tematica INT,
  CONSTRAINT fk_zonaparque_tematica_zonaparque 
    FOREIGN KEY (id_zonaparque) REFERENCES zonaparque(id),
  CONSTRAINT fk_zonaparque_tematica_tematica 
    FOREIGN KEY (id_tematica) REFERENCES tematica(id)
) ENGINE=InnoDB;

-- Tabla de relación: _complejo_hoteles
CREATE TABLE _complejo_hoteles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_complejo INT,
  id_hoteles INT,
  CONSTRAINT fk_complejo_hoteles_complejo 
    FOREIGN KEY (id_complejo) REFERENCES complejo(id),
  CONSTRAINT fk_complejo_hoteles_hoteles 
    FOREIGN KEY (id_hoteles) REFERENCES hoteles(id)
) ENGINE=InnoDB;


-- ----------------------------------------------------------------------------------------------------------------------
-- INSERCIÓN DE DATOS EN LA BASE DE DATOS DisneylandDB
-- ----------------------------------------------------------------------------------------------------------------------

INSERT INTO complejo (nombre, lugar, descripcion, gps) VALUES 
  ('Walt Disney World', 'Orlando, Florida', 'El complejo más grande de Disney, hogar de cuatro parques temáticos y numerosos hoteles.', '28.3852,-81.5639'),
  ('Disneyland Resort', 'Anaheim, California', 'El resort original de Disney, que incluye dos parques temáticos y varios hoteles.', '33.8121,-117.9190'),
  ('Disneyland Paris', 'Marne-la-Vallée, Francia', 'El destino mágico de Disney en Europa, con dos parques temáticos y entretenimiento variado.', '48.8700,2.7800'),
  ('Tokyo Disney Resort', 'Urayasu, Chiba, Japón', 'Un resort encantador con dos parques temáticos y experiencias únicas.', '35.6329,139.8804'),
  ('Hong Kong Disneyland', 'Isla Lantau, Hong Kong', 'El parque temático más completo de Hong Kong, con atracciones y entretenimiento para toda la familia.', '22.3128,114.0419'),
  ('Shanghai Disney Resort', 'Pudong, Shanghai, China', 'El primer resort de Disney en China, con innovadoras atracciones y espectáculos.', '31.1425,121.6610');


-- Walt Disney World Orlando
INSERT INTO parque (nombre, id_complejo, descripcion, mapa, anio) VALUES 
  ('Magic Kingdom', 1, 'Parque temático icónico con castillos y atracciones clásicas.', 'mapa_magic_kingdom.png', 1971),
  ('EPCOT', 1, 'Parque que celebra la innovación y la cultura internacional.', 'mapa_epcot.png', 1982),
  ('Disney''s Hollywood Studios', 1, 'Parque temático centrado en el cine y la televisión.', 'mapa_hollywood_studios.png', 1989),
  ('Disney''s Animal Kingdom', 1, 'Parque temático que combina atracciones y naturaleza.', 'mapa_animal_kingdom.png', 1998);

-- Disneyland Resort Anaheim
INSERT INTO parque (nombre, id_complejo, descripcion, mapa, anio) VALUES 
  ('Disneyland Park', 2, 'El parque original de Disneyland con clásicos y nuevas aventuras.', 'mapa_disneyland_park.png', 1955),
  ('Disney California Adventure', 2, 'Parque temático que celebra la cultura y paisajes de California.', 'mapa_california_adventure.png', 2001);

-- Disneyland Paris
INSERT INTO parque (nombre, id_complejo, descripcion, mapa, anio) VALUES 
  ('Disneyland Park', 3, 'Parque temático con atracciones inspiradas en cuentos y leyendas.', 'mapa_dp_disneyland_park.png', 1992),
  ('Walt Disney Studios Park', 3, 'Parque que celebra el cine y la producción de películas.', 'mapa_dp_studios.png', 2002);

-- Tokyo Disney Resort
INSERT INTO parque (nombre, id_complejo, descripcion, mapa, anio) VALUES 
  ('Tokyo Disneyland', 4, 'Parque temático con magia y aventura en cada rincón.', 'mapa_tokyo_disneyland.png', 1983),
  ('Tokyo DisneySea', 4, 'Un parque único inspirado en la exploración marítima y legendaria.', 'mapa_tokyo_disneysea.png', 2001);

-- Hong Kong Disneyland
INSERT INTO parque (nombre, id_complejo, descripcion, mapa, anio) VALUES 
  ('Hong Kong Disneyland', 5, 'Un parque lleno de magia y sorpresas, adaptado a la cultura local.', 'mapa_hk_disneyland.png', 2005);

-- Shanghai Disney Resort
INSERT INTO parque (nombre, id_complejo, descripcion, mapa, anio) VALUES 
  ('Shanghai Disneyland', 6, 'Un parque que fusiona la tradición china con la magia de Disney.', 'mapa_shanghai_disneyland.png', 2016);





INSERT INTO atraccion (nombre, foto, video_pov, descripcion, inauguracion, longitud_gps, latitud_gps) VALUES
  -- Walt Disney World – Magic Kingdom
  ('Space Mountain', 'space_mountain.jpg', 'space_mountain.mp4', 'Montaña rusa espacial con efectos especiales.', '1975-01-15', '28.3860', '-81.5630'),
  ('PeopleMover', 'peoplemover.jpg', 'peoplemover.mp4', 'Paseo en vehículo para toda la familia.', '1971-10-01', '28.3861', '-81.5631'),
  ('TRON Lightcycle / Run', 'tron.jpg', 'tron.mp4', 'Experiencia de alta velocidad en motocicletas futuristas.', '2021-03-31', '28.3862', '-81.5632'),
  ('Seven Dwarfs Mine Train', 'mine_train.jpg', 'mine_train.mp4', 'Montaña rusa inspirada en los siete enanitos.', '2014-05-28', '28.3863', '-81.5633'),
  ('Peter Pan''s Flight', 'peter_pan.jpg', 'peter_pan.mp4', 'Vuelo mágico sobre Londres y Nunca Jamás.', '1971-10-01', '28.3864', '-81.5634'),
  ('It''s a Small World', 'small_world.jpg', 'small_world.mp4', 'Paseo musical a través de culturas del mundo.', '1971-10-01', '28.3865', '-81.5635'),
  ('Pirates of the Caribbean', 'pirates.jpg', 'pirates.mp4', 'Aventura en alta mar con piratas y tesoros.', '1973-12-14', '28.3866', '-81.5636'),
  ('Jungle Cruise', 'jungle_cruise.jpg', 'jungle_cruise.mp4', 'Recorrido en bote por ríos exóticos y selvas misteriosas.', '1971-10-01', '28.3867', '-81.5637'),
  ('Big Thunder Mountain Railroad', 'big_thunder.jpg', 'big_thunder.mp4', 'Montaña rusa en una mina del viejo oeste.', '1980-09-15', '28.3868', '-81.5638'),
  ('Country Bear Jamboree', 'bears.jpg', 'bears.mp4', 'Espectáculo musical con osos animados.', '1971-10-01', '28.3869', '-81.5639'),
  ('Haunted Mansion', 'haunted_mansion.jpg', 'haunted_mansion.mp4', 'Recorrido por una mansión encantada llena de fantasmas.', '1971-10-01', '28.3870', '-81.5640'),
  
  -- EPCOT
  ('Guardians of the Galaxy: Cosmic Rewind', 'cosmic_rewind.jpg', 'cosmic_rewind.mp4', 'Atracción de simulación con héroes espaciales.', '2022-05-27', '28.3871', '-81.5641'),
  ('Frozen Ever After', 'frozen.jpg', 'frozen.mp4', 'Paseo musical inspirado en la película Frozen.', '2016-04-20', '28.3872', '-81.5642'),
  ('Remy''s Ratatouille Adventure', 'ratatouille.jpg', 'ratatouille.mp4', 'Aventura en miniatura en la cocina de un gran chef.', '2021-10-01', '28.3873', '-81.5643'),
  
  -- Hollywood Studios
  ('Millennium Falcon: Smugglers Run', 'falcon.jpg', 'falcon.mp4', 'Simulador a bordo del legendario Halcón Milenario.', '2017-05-31', '28.3874', '-81.5644'),
  ('Star Wars: Rise of the Resistance', 'rise_resistance.jpg', 'rise_resistance.mp4', 'Experiencia inmersiva en el universo de Star Wars.', '2019-12-05', '28.3875', '-81.5645'),
  ('Slinky Dog Dash', 'slinky_dog.jpg', 'slinky_dog.mp4', 'Montaña rusa familiar inspirada en Toy Story.', '2018-06-23', '28.3876', '-81.5646'),
  ('Toy Story Mania!', 'toy_story_mania.jpg', 'toy_story_mania.mp4', 'Competencia interactiva en un mundo de juguetes.', '2008-05-31', '28.3877', '-81.5647'),
  ('The Twilight Zone Tower of Terror', 'tower_of_terror.jpg', 'tower_of_terror.mp4', 'Caída libre en un hotel embrujado.', '1994-07-22', '28.3878', '-81.5648'),
  ('Rock ''n'' Roller Coaster', 'rock_roller.jpg', 'rock_roller.mp4', 'Montaña rusa musical a alta velocidad.', '2001-10-10', '28.3879', '-81.5649'),
  
  -- Animal Kingdom
  ('Avatar Flight of Passage', 'avatar_flight.jpg', 'avatar_flight.mp4', 'Simulador que te lleva a volar sobre Pandora.', '2017-05-27', '28.3880', '-81.5650'),
  ('Na''vi River Journey', 'navi_river.jpg', 'navi_river.mp4', 'Paseo en bote por los ríos de Pandora.', '2017-05-27', '28.3881', '-81.5651'),
  ('Expedition Everest', 'expedition_everest.jpg', 'expedition_everest.mp4', 'Montaña rusa en una expedición por el Himalaya.', '2006-04-07', '28.3882', '-81.5652'),
  ('Kali River Rapids', 'kali_rapids.jpg', 'kali_rapids.mp4', 'Aventura acuática en rápidos salvajes.', '1998-04-22', '28.3883', '-81.5653'),
  ('Kilimanjaro Safaris', 'safari.jpg', 'safari.mp4', 'Recorrido en vehículo por una sabana africana.', '1998-04-22', '28.3884', '-81.5654'),
  ('Festival of the Lion King', 'lion_king.jpg', 'lion_king.mp4', 'Espectáculo en vivo con música y personajes.', '1998-06-15', '28.3885', '-81.5655'),
  
  -- Disneyland Resort – Disneyland Park
  ('Space Mountain', 'dl_space_mountain.jpg', 'dl_space_mountain.mp4', 'Versión del clásico recorrido espacial en Disneyland.', '1977-05-27', '33.8122', '-117.9191'),
  ('Star Tours', 'star_tours.jpg', 'star_tours.mp4', 'Simulador de vuelo en el universo de Star Wars.', '1987-01-09', '33.8123', '-117.9192'),
  ('Indiana Jones Adventure', 'indiana_jones.jpg', 'indiana_jones.mp4', 'Aventura arqueológica en templos antiguos.', '1995-03-03', '33.8124', '-117.9193'),
  ('Haunted Mansion', 'dl_haunted_mansion.jpg', 'dl_haunted_mansion.mp4', 'Recorrido por una mansión encantada con efectos sorprendentes.', '1969-08-09', '33.8125', '-117.9194'),
  ('Pirates of the Caribbean', 'dl_pirates.jpg', 'dl_pirates.mp4', 'Aventura pirata en alta mar.', '1967-03-18', '33.8126', '-117.9195'),
  ('Millennium Falcon: Smugglers Run', 'dl_falcon.jpg', 'dl_falcon.mp4', 'Simulador en el Halcón Milenario versión Disneyland.', '2020-03-31', '33.8127', '-117.9196'),
  ('Rise of the Resistance', 'dl_rise.jpg', 'dl_rise.mp4', 'Experiencia inmersiva en el universo Star Wars.', '2023-01-20', '33.8128', '-117.9197'),
  
  -- Disney California Adventure
  ('Web Slingers: A Spider-Man Adventure', 'spiderman.jpg', 'spiderman.mp4', 'Aventura interactiva con Spider-Man.', '2021-10-17', '33.8129', '-117.9198'),
  ('Radiator Springs Racers', 'radiator_springs.jpg', 'radiator_springs.mp4', 'Competencia en la famosa Ruta 66.', '2012-06-15', '33.8130', '-117.9199'),
  ('Incredicoaster', 'incredicoaster.jpg', 'incredicoaster.mp4', 'Montaña rusa inspirada en los Increíbles.', '2018-03-20', '33.8131', '-117.9200'),
  ('Toy Story Mania!', 'dlca_toy_story.jpg', 'dlca_toy_story.mp4', 'Juego interactivo basado en Toy Story.', '2009-10-20', '33.8132', '-117.9201'),
  
  -- Disneyland Paris
  ('Star Wars Hyperspace Mountain', 'dp_hyperspace.jpg', 'dp_hyperspace.mp4', 'Montaña rusa con temática de Star Wars.', '2017-03-26', '48.8701', '2.7801'),
  ('Pirates of the Caribbean', 'dp_pirates.jpg', 'dp_pirates.mp4', 'Aventura pirata en Disneyland Paris.', '1992-04-12', '48.8702', '2.7802'),
  ('Avengers Assemble: Flight Force', 'dp_avengers.jpg', 'dp_avengers.mp4', 'Simulador basado en los Avengers.', '2022-07-15', '48.8703', '2.7803'),
  ('Ratatouille: The Adventure', 'dp_ratatouille.jpg', 'dp_ratatouille.mp4', 'Aventura en miniatura por las cocinas de París.', '2014-07-01', '48.8704', '2.7804'),
  
  -- Tokyo Disney Resort
  ('Space Mountain', 'td_space_mountain.jpg', 'td_space_mountain.mp4', 'Versión de Space Mountain para Tokyo Disneyland.', '1983-04-15', '35.6330', '139.8805'),
  ('Buzz Lightyear''s Astro Blasters', 'buzz.jpg', 'buzz.mp4', 'Aventura interactiva con Buzz Lightyear.', '1983-04-15', '35.6331', '139.8806'),
  ('Journey to the Center of the Earth', 'journey.jpg', 'journey.mp4', 'Simulador de expedición subterránea.', '2001-09-04', '35.6332', '139.8807'),
  ('Indiana Jones Adventure', 'td_indiana.jpg', 'td_indiana.mp4', 'Aventura arqueológica en Tokyo DisneySea.', '2001-09-04', '35.6333', '139.8808'),
  
  -- Hong Kong Disneyland
  ('Mystic Manor', 'mystic_manor.jpg', 'mystic_manor.mp4', 'Recorrido misterioso en una mansión encantada.', '2005-09-12', '22.3129', '114.0420'),
  ('Iron Man Experience', 'iron_man.jpg', 'iron_man.mp4', 'Simulador a bordo de la armadura de Iron Man.', '2016-11-12', '22.3130', '114.0421'),
  
  -- Shanghai Disney Resort
  ('TRON Lightcycle Power Run', 'tron_shanghai.jpg', 'tron_shanghai.mp4', 'Montaña rusa futurista basada en TRON.', '2016-05-16', '31.1426', '121.6611'),
  ('Pirates of the Caribbean: Battle for the Sunken Treasure', 'sh_pirates.jpg', 'sh_pirates.mp4', 'Aventura acuática en busca de tesoros hundidos.', '2016-06-16', '31.1427', '121.6612');






-- Tipos de Atracciónes
  INSERT INTO tipo (nombre, descripcion, icono) VALUES
  ('Roller Coaster', 'Montaña rusa de alta velocidad y adrenalina.', 'roller_coaster_icon.png'),
  ('Dark Ride', 'Aventura en ambientes oscuros y tematizados.', 'dark_ride_icon.png'),
  ('Simulator', 'Experiencia que utiliza tecnología de simulación.', 'simulator_icon.png'),
  ('Family Ride', 'Atracción apta para todas las edades.', 'family_ride_icon.png'),
  ('Interactive', 'Atracción con participación activa del visitante.', 'interactive_icon.png');

-- Temática
INSERT INTO tematica (nombre, descripcion, icono) VALUES
  ('Space', 'Temática espacial y futurista.', 'space_icon.png'),
  ('Fantasy', 'Mundo de cuentos y magia.', 'fantasy_icon.png'),
  ('Adventure', 'Aventura y exploración.', 'adventure_icon.png'),
  ('Sci-Fi', 'Ficción científica y tecnología.', 'scifi_icon.png'),
  ('Pirate', 'Temática de piratas y aventuras marítimas.', 'pirate_icon.png'),
  ('Classic', 'Encanto y tradición de Disney.', 'classic_icon.png');


-- ZONAS DE PARQUES / LANDS
  INSERT INTO zonaparque (nombre, descripcion, icono) VALUES
  -- Magic Kingdom (Walt Disney World)
  ('Tomorrowland (Magic Kingdom)', 'Zona futurista y espacial en Magic Kingdom.', 'zone_tomorrowland.png'),
  ('Fantasyland (Magic Kingdom)', 'Zona mágica inspirada en cuentos clásicos.', 'zone_fantasyland.png'),
  ('Adventureland (Magic Kingdom)', 'Zona de aventuras exóticas y misteriosas.', 'zone_adventureland.png'),
  ('Frontierland (Magic Kingdom)', 'Zona del viejo oeste y minas abandonadas.', 'zone_frontierland.png'),
  ('Liberty Square (Magic Kingdom)', 'Zona histórica y encantada.', 'zone_liberty.png'),

  -- EPCOT
  ('World Discovery (EPCOT)', 'Zona dedicada a la innovación y la tecnología.', 'zone_discovery.png'),
  ('World Showcase (EPCOT)', 'Zona que celebra culturas del mundo.', 'zone_showcase.png'),

  -- Hollywood Studios
  ('Star Wars: Galaxy''s Edge (Hollywood Studios)', 'Zona inmersiva en el universo Star Wars.', 'zone_starwars.png'),
  ('Toy Story Land (Hollywood Studios)', 'Zona inspirada en el mundo de Toy Story.', 'zone_toystory.png'),
  ('Sunset Boulevard (Hollywood Studios)', 'Zona con ambiente de Hollywood clásico.', 'zone_sunset.png'),

  -- Animal Kingdom
  ('Pandora – The World of Avatar (Animal Kingdom)', 'Zona inspirada en la película Avatar.', 'zone_pandora.png'),
  ('Asia (Animal Kingdom)', 'Zona con atracciones inspiradas en Asia.', 'zone_asia.png'),
  ('Africa (Animal Kingdom)', 'Zona con safaris y ambiente africano.', 'zone_africa.png'),

  -- Disneyland Resort – Disneyland Park
  ('Tomorrowland (Disneyland)', 'Zona futurista en Disneyland Park.', 'dl_tomorrowland.png'),
  ('Adventureland (Disneyland)', 'Zona de aventuras en Disneyland Park.', 'dl_adventureland.png'),
  ('New Orleans Square (Disneyland)', 'Zona con ambiente del sur de Estados Unidos.', 'dl_neworleans.png'),
  ('Star Wars: Galaxy''s Edge (Disneyland)', 'Zona inmersiva de Star Wars en Disneyland.', 'dl_starwars.png'),

  -- Disney California Adventure
  ('Avengers Campus (California Adventure)', 'Zona dedicada a los superhéroes de Marvel.', 'dlca_avengers.png'),
  ('Cars Land (California Adventure)', 'Zona inspirada en la película Cars.', 'dlca_cars.png'),
  ('Pixar Pier (California Adventure)', 'Zona colorida y lúdica inspirada en Pixar.', 'dlca_pixar.png'),

  -- Disneyland Paris
  ('Discoveryland (Disneyland Paris)', 'Zona futurista y de exploración en Disneyland Paris.', 'dp_discovery.png'),
  ('Adventureland (Disneyland Paris)', 'Zona de aventuras y leyendas en Disneyland Paris.', 'dp_adventure.png'),
  ('Studio Zone (Walt Disney Studios Park)', 'Zona temática dedicada al cine y la producción.', 'dp_studio.png'),

  -- Tokyo Disney Resort
  ('Tomorrowland (Tokyo Disneyland)', 'Zona futurista en Tokyo Disneyland.', 'td_tomorrowland.png'),
  ('Main Area (Tokyo DisneySea)', 'Zona principal de Tokyo DisneySea.', 'td_sea.png'),

  -- Hong Kong Disneyland
  ('Main Zone (Hong Kong Disneyland)', 'Zona central de Hong Kong Disneyland.', 'hk_main.png'),

  -- Shanghai Disney Resort
  ('Main Zone (Shanghai Disney Resort)', 'Zona principal de Shanghai Disneyland.', 'sh_main.png');


  -- HOTELES
  INSERT INTO hoteles (nombre, estrellas, descripcion, fotos) VALUES
  ('Disney’s Grand Floridian Resort & Spa', 5, 'Hotel de lujo en Walt Disney World con estilo victoriano.', 'grand_floridian.jpg'),
  ('Disney’s Contemporary Resort', 4, 'Hotel moderno con vistas al Magic Kingdom.', 'contemporary.jpg'),
  ('Disneyland Hotel', 5, 'Hotel icónico en Disneyland Resort.', 'disneyland_hotel.jpg'),
  ('Disney’s Newport Bay Club', 4, 'Hotel con temática náutica en Disneyland Resort.', 'newport_bay.jpg');

-- ----------------------------------------------------------------------------------------------------------------------
-- RELACIONES entre tablas
-- ----------------------------------------------------------------------------------------------------------------------

-- Complejo - Parque
  INSERT INTO _complejo_parque (id_complejo, id_parque) VALUES
  (1, 1), (1, 2), (1, 3), (1, 4),
  (2, 5), (2, 6),
  (3, 7), (3, 8),
  (4, 9), (4, 10),
  (5, 11),
  (6, 12);


-- Atracción Parque
-- Walt Disney World – Magic Kingdom (parque id 1)
INSERT INTO _atraccion_parque (id_atraccion, id_parque) VALUES
  (1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1),
  (7, 1), (8, 1), (9, 1), (10, 1), (11, 1);

-- EPCOT (parque id 2)
INSERT INTO _atraccion_parque (id_atraccion, id_parque) VALUES
  (12, 2), (13, 2), (14, 2);

-- Hollywood Studios (parque id 3)
INSERT INTO _atraccion_parque (id_atraccion, id_parque) VALUES
  (15, 3), (16, 3), (17, 3), (18, 3), (19, 3), (20, 3);

-- Animal Kingdom (parque id 4)
INSERT INTO _atraccion_parque (id_atraccion, id_parque) VALUES
  (21, 4), (22, 4), (23, 4), (24, 4), (25, 4), (26, 4);

-- Disneyland Resort – Disneyland Park (parque id 5)
INSERT INTO _atraccion_parque (id_atraccion, id_parque) VALUES
  (27, 5), (28, 5), (29, 5), (30, 5), (31, 5), (32, 5), (33, 5);

-- Disney California Adventure (parque id 6)
INSERT INTO _atraccion_parque (id_atraccion, id_parque) VALUES
  (34, 6), (35, 6), (36, 6), (37, 6);

-- Disneyland Paris – Disneyland Park (parque id 7)
INSERT INTO _atraccion_parque (id_atraccion, id_parque) VALUES
  (38, 7), (39, 7);

-- Disneyland Paris – Walt Disney Studios Park (parque id 8)
INSERT INTO _atraccion_parque (id_atraccion, id_parque) VALUES
  (40, 8), (41, 8);

-- Tokyo Disney Resort – Tokyo Disneyland (parque id 9)
INSERT INTO _atraccion_parque (id_atraccion, id_parque) VALUES
  (42, 9), (43, 9);

-- Tokyo Disney Resort – Tokyo DisneySea (parque id 10)
INSERT INTO _atraccion_parque (id_atraccion, id_parque) VALUES
  (44, 10), (45, 10);

-- Hong Kong Disneyland (parque id 11)
INSERT INTO _atraccion_parque (id_atraccion, id_parque) VALUES
  (46, 11), (47, 11);

-- Shanghai Disney Resort (parque id 12)
INSERT INTO _atraccion_parque (id_atraccion, id_parque) VALUES
  (48, 12), (49, 12);


-- Atracción Zona Parque

-- Walt Disney World – Magic Kingdom
INSERT INTO _atraccion_zonaparque (id_atraccion, id_zonaparque) VALUES
  (1, 1), (2, 1), (3, 1),   -- Tomorrowland
  (4, 2), (5, 2), (6, 2),   -- Fantasyland
  (7, 3), (8, 3),           -- Adventureland
  (9, 4), (10, 4),          -- Frontierland
  (11, 5);                 -- Liberty Square

-- EPCOT
INSERT INTO _atraccion_zonaparque (id_atraccion, id_zonaparque) VALUES
  (12, 6),                 -- World Discovery
  (13, 7), (14, 7);        -- World Showcase

-- Hollywood Studios
INSERT INTO _atraccion_zonaparque (id_atraccion, id_zonaparque) VALUES
  (15, 8), (16, 8),        -- Star Wars: Galaxy's Edge
  (17, 9), (18, 9),        -- Toy Story Land
  (19, 10), (20, 10);      -- Sunset Boulevard

-- Animal Kingdom
INSERT INTO _atraccion_zonaparque (id_atraccion, id_zonaparque) VALUES
  (21, 11), (22, 11),      -- Pandora – The World of Avatar
  (23, 12), (24, 12),      -- Asia
  (25, 13), (26, 13);      -- Africa

-- Disneyland Resort – Disneyland Park
INSERT INTO _atraccion_zonaparque (id_atraccion, id_zonaparque) VALUES
  (27, 14), (28, 14),      -- Tomorrowland (Disneyland)
  (29, 15),              -- Adventureland
  (30, 16), (31, 16),      -- New Orleans Square
  (32, 17), (33, 17);      -- Star Wars: Galaxy's Edge

-- Disney California Adventure
INSERT INTO _atraccion_zonaparque (id_atraccion, id_zonaparque) VALUES
  (34, 18),              -- Avengers Campus
  (35, 19),              -- Cars Land
  (36, 20), (37, 20);      -- Pixar Pier

-- Disneyland Paris
INSERT INTO _atraccion_zonaparque (id_atraccion, id_zonaparque) VALUES
  (38, 21),              -- Discoveryland
  (39, 22),              -- Adventureland
  (40, 23), (41, 23);      -- Studio Zone

-- Tokyo Disney Resort
INSERT INTO _atraccion_zonaparque (id_atraccion, id_zonaparque) VALUES
  (42, 24), (43, 24),      -- Tomorrowland (Tokyo Disneyland)
  (44, 25), (45, 25);      -- Main Area (Tokyo DisneySea)

-- Hong Kong Disneyland
INSERT INTO _atraccion_zonaparque (id_atraccion, id_zonaparque) VALUES
  (46, 26), (47, 26);

-- Shanghai Disney Resort
INSERT INTO _atraccion_zonaparque (id_atraccion, id_zonaparque) VALUES
  (48, 27), (49, 27);

-- Atracción Tipo
INSERT INTO _atraccion_tipo (id_atraccion, id_tipo) VALUES
  -- Walt Disney World – Magic Kingdom
  (1, 1),  -- Space Mountain: Roller Coaster
  (2, 4),  -- PeopleMover: Family Ride
  (3, 1),  -- TRON Lightcycle / Run: Roller Coaster
  (4, 1),  -- Seven Dwarfs Mine Train: Roller Coaster
  (5, 2),  -- Peter Pan's Flight: Dark Ride
  (6, 4),  -- It's a Small World: Family Ride
  (7, 2),  -- Pirates of the Caribbean: Dark Ride
  (8, 4),  -- Jungle Cruise: Family Ride
  (9, 1),  -- Big Thunder Mountain Railroad: Roller Coaster
  (10, 2), -- Country Bear Jamboree: Dark Ride
  (11, 2), -- Haunted Mansion: Dark Ride

  -- EPCOT
  (12, 3), -- Cosmic Rewind: Simulator
  (13, 4), -- Frozen Ever After: Family Ride
  (14, 3), -- Remy's Ratatouille Adventure: Simulator

  -- Hollywood Studios
  (15, 3), -- Millennium Falcon: Smugglers Run: Simulator
  (16, 3), -- Star Wars: Rise of the Resistance: Simulator
  (17, 1), -- Slinky Dog Dash: Roller Coaster
  (18, 5), -- Toy Story Mania!: Interactive
  (19, 2), -- Tower of Terror: Dark Ride
  (20, 1), -- Rock 'n' Roller Coaster: Roller Coaster

  -- Animal Kingdom
  (21, 3), -- Avatar Flight of Passage: Simulator
  (22, 2), -- Na'vi River Journey: Dark Ride
  (23, 1), -- Expedition Everest: Roller Coaster
  (24, 4), -- Kali River Rapids: Family Ride
  (25, 4), -- Kilimanjaro Safaris: Family Ride
  (26, 2), -- Festival of the Lion King: Dark Ride

  -- Disneyland Resort – Disneyland Park
  (27, 1), -- Space Mountain (Disneyland): Roller Coaster
  (28, 3), -- Star Tours: Simulator
  (29, 2), -- Indiana Jones Adventure: Dark Ride
  (30, 2), -- Haunted Mansion: Dark Ride
  (31, 2), -- Pirates of the Caribbean: Dark Ride
  (32, 3), -- Millennium Falcon: Smugglers Run: Simulator
  (33, 3), -- Rise of the Resistance: Simulator

  -- Disney California Adventure
  (34, 5), -- Web Slingers: Interactive
  (35, 1), -- Radiator Springs Racers: Roller Coaster
  (36, 1), -- Incredicoaster: Roller Coaster
  (37, 5), -- Toy Story Mania!: Interactive

  -- Disneyland Paris
  (38, 1), -- Hyperspace Mountain: Roller Coaster
  (39, 2), -- Pirates of the Caribbean: Dark Ride
  (40, 3), -- Avengers Assemble: Flight Force: Simulator
  (41, 3), -- Ratatouille: The Adventure: Simulator

  -- Tokyo Disney Resort
  (42, 1), -- Space Mountain (Tokyo): Roller Coaster
  (43, 5), -- Buzz Lightyear's Astro Blasters: Interactive
  (44, 3), -- Journey to the Center of the Earth: Simulator
  (45, 2), -- Indiana Jones Adventure (TD Sea): Dark Ride

  -- Hong Kong Disneyland
  (46, 2), -- Mystic Manor: Dark Ride
  (47, 3), -- Iron Man Experience: Simulator

  -- Shanghai Disney Resort
  (48, 1), -- TRON Lightcycle Power Run: Roller Coaster
  (49, 2); -- Pirates of the Caribbean: Battle for the Sunken Treasure: Dark Ride


  -- Atracción Temática
  INSERT INTO _atraccion_tematica (id_atraccion, id_tematica) VALUES
  -- Walt Disney World – Magic Kingdom
  (1, 1),  -- Space Mountain: Space
  (2, 6),  -- PeopleMover: Classic
  (3, 4),  -- TRON Lightcycle / Run: Sci-Fi
  (4, 2),  -- Seven Dwarfs Mine Train: Fantasy
  (5, 2),  -- Peter Pan's Flight: Fantasy
  (6, 6),  -- It's a Small World: Classic
  (7, 5),  -- Pirates of the Caribbean: Pirate
  (8, 3),  -- Jungle Cruise: Adventure
  (9, 3),  -- Big Thunder Mountain Railroad: Adventure
  (10, 6), -- Country Bear Jamboree: Classic
  (11, 6), -- Haunted Mansion: Classic

  -- EPCOT
  (12, 4), -- Cosmic Rewind: Sci-Fi
  (13, 2), -- Frozen Ever After: Fantasy
  (14, 3), -- Ratatouille Adventure: Adventure

  -- Hollywood Studios
  (15, 4), -- Smugglers Run: Sci-Fi
  (16, 4), -- Rise of the Resistance: Sci-Fi
  (17, 2), -- Slinky Dog Dash: Fantasy
  (18, 2), -- Toy Story Mania!: Fantasy
  (19, 6), -- Tower of Terror: Classic
  (20, 6), -- Rock 'n' Roller Coaster: Classic

  -- Animal Kingdom
  (21, 3), -- Avatar Flight of Passage: Adventure
  (22, 3), -- Na'vi River Journey: Adventure
  (23, 3), -- Expedition Everest: Adventure
  (24, 3), -- Kali River Rapids: Adventure
  (25, 3), -- Kilimanjaro Safaris: Adventure
  (26, 6), -- Festival of the Lion King: Classic

  -- Disneyland Resort – Disneyland Park
  (27, 1), -- Space Mountain: Space
  (28, 4), -- Star Tours: Sci-Fi
  (29, 3), -- Indiana Jones Adventure: Adventure
  (30, 6), -- Haunted Mansion: Classic
  (31, 5), -- Pirates of the Caribbean: Pirate
  (32, 4), -- Smugglers Run: Sci-Fi
  (33, 4), -- Rise of the Resistance: Sci-Fi

  -- Disney California Adventure
  (34, 3), -- Web Slingers: Adventure
  (35, 3), -- Radiator Springs Racers: Adventure
  (36, 1), -- Incredicoaster: Space
  (37, 2), -- Toy Story Mania!: Fantasy

  -- Disneyland Paris
  (38, 4), -- Hyperspace Mountain: Sci-Fi
  (39, 5), -- Pirates of the Caribbean: Pirate
  (40, 4), -- Avengers Assemble: Sci-Fi
  (41, 3), -- Ratatouille Adventure: Adventure

  -- Tokyo Disney Resort
  (42, 1), -- Space Mountain (Tokyo): Space
  (43, 4), -- Buzz Lightyear's: Sci-Fi
  (44, 3), -- Journey to the Center of the Earth: Adventure
  (45, 3), -- Indiana Jones (TD Sea): Adventure

  -- Hong Kong Disneyland
  (46, 2), -- Mystic Manor: Fantasy
  (47, 4), -- Iron Man Experience: Sci-Fi

  -- Shanghai Disney Resort
  (48, 4), -- TRON Lightcycle: Sci-Fi
  (49, 5); -- Pirates Battle: Pirate


  -- Zona Parque Temática
  INSERT INTO _zonaparque_tematica (id_zonaparque, id_tematica) VALUES
  -- Magic Kingdom (Walt Disney World)
  (1, 1),  -- Tomorrowland: Space
  (2, 2),  -- Fantasyland: Fantasy
  (3, 3),  -- Adventureland: Adventure
  (4, 3),  -- Frontierland: Adventure
  (5, 6),  -- Liberty Square: Classic

  -- EPCOT
  (6, 4),  -- World Discovery: Sci-Fi
  (7, 6),  -- World Showcase: Classic

  -- Hollywood Studios
  (8, 4),  -- Star Wars: Galaxy's Edge: Sci-Fi
  (9, 2),  -- Toy Story Land: Fantasy
  (10, 6), -- Sunset Boulevard: Classic

  -- Animal Kingdom
  (11, 3), -- Pandora – The World of Avatar: Adventure
  (12, 3), -- Asia: Adventure
  (13, 3), -- Africa: Adventure

  -- Disneyland Resort – Disneyland Park
  (14, 1), -- Tomorrowland: Space
  (15, 3), -- Adventureland: Adventure
  (16, 6), -- New Orleans Square: Classic
  (17, 4), -- Star Wars: Galaxy's Edge: Sci-Fi

  -- Disney California Adventure
  (18, 3), -- Avengers Campus: Adventure
  (19, 3), -- Cars Land: Adventure
  (20, 2), -- Pixar Pier: Fantasy

  -- Disneyland Paris
  (21, 4), -- Discoveryland: Sci-Fi
  (22, 3), -- Adventureland: Adventure
  (23, 6), -- Studio Zone: Classic

  -- Tokyo Disney Resort
  (24, 1), -- Tomorrowland (Tokyo): Space

  -- Tokyo DisneySea
  (25, 3), -- Main Area: Adventure

  -- Hong Kong Disneyland
  (26, 2), -- Main Zone: Fantasy

  -- Shanghai Disney Resort
  (27, 4); -- Main Zone: Sci-Fi


  -- Complejo Hoteles
  INSERT INTO _complejo_hoteles (id_complejo, id_hoteles) VALUES
  (1, 1),  -- Walt Disney World: Grand Floridian
  (1, 2),  -- Walt Disney World: Contemporary Resort
  (2, 3),  -- Disneyland Resort: Disneyland Hotel
  (2, 4);  -- Disneyland Resort: Newport Bay Club

  