CREATE DATABASE Eventos;
USE Eventos;

CREATE TABLE evento (
id INT PRIMARY KEY AUTO_INCREMENT,
titulo VARCHAR(255) NOT NULL,
descripcion TEXT,
imagen VARCHAR(255),
lugar VARCHAR(255),
coordenadas_GPS POINT,

fecha_ini DATETIME NOT NULL,
fecha_fin DATETIME,
creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- ==================
-- EVENTOS
-- ==================


-- Insert sample events
INSERT INTO evento (titulo, descripcion, lugar, fecha_ini, fecha_fin, imagen, coordenadas_GPS) VALUES
('Disney Character Parade', 'Join Mickey and friends in a magical parade through Main Street', 'Magic Kingdom Park', '2024-02-15 14:00:00', '2024-02-15 15:30:00', 'parades/character_parade.jpg', POINT(28.417663, -81.581212)),
('Fireworks Spectacular', 'Experience an amazing nighttime show of fireworks, music and projections', 'Cinderella Castle', '2024-02-15 21:00:00', '2024-02-15 21:30:00', 'shows/fireworks.jpg', POINT(28.419411, -81.581216)),
('Princess Tea Party', 'Enjoy tea and treats with Disney Princesses', 'Grand Floridian Resort', '2024-02-16 10:00:00', '2024-02-16 11:30:00', 'events/tea_party.jpg', POINT(28.411362, -81.586697)),
('Star Wars: Galaxy''s Edge Tour', 'Guided tour of the Star Wars themed land', 'Hollywood Studios', '2024-02-17 09:00:00', '2024-02-17 11:00:00', 'tours/galaxy_edge.jpg', POINT(28.357192, -81.560068)),
('Epcot Food & Wine Festival', 'Sample cuisines from around the world', 'Epcot World Showcase', '2024-02-18 11:00:00', '2024-02-18 20:00:00', 'festivals/food_wine.jpg', POINT(28.373169, -81.549674)),
('Disney Villains After Hours', 'Special nighttime event featuring Disney Villains', 'Magic Kingdom Park', '2024-02-19 22:00:00', '2024-02-20 02:00:00', 'events/villains.jpg', POINT(28.417663, -81.581212)),
('Animation Workshop', 'Learn to draw Disney characters with professional animators', 'Animation Experience at Conservation Station', '2024-02-20 13:00:00', '2024-02-20 14:30:00', 'workshops/animation.jpg', POINT(28.357791, -81.590209)),
('Mickey''s Not-So-Scary Halloween Party', 'Family-friendly Halloween celebration with trick-or-treating', 'Magic Kingdom Park', '2024-10-31 19:00:00', '2024-11-01 00:00:00', 'events/halloween.jpg', POINT(28.417663, -81.581212)),
('Disney Springs Art Festival', 'Local artists showcase Disney-inspired artwork', 'Disney Springs', '2024-02-22 10:00:00', '2024-02-24 18:00:00', 'festivals/art.jpg', POINT(28.372101, -81.501867)),
('Disney on Ice: Dream Big', 'Spectacular ice skating show featuring Disney characters', 'ESPN Wide World of Sports Complex', '2024-02-25 19:00:00', '2024-02-25 21:30:00', 'shows/ice_show.jpg', POINT(28.338883, -81.558764));