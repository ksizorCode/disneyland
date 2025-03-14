-- Consultas:

-- 1. Consulta: Canción con todos sus datos (id, nombre, duración), junto a información del artista y disco (incluyendo año y portada del disco, id del disco y del artista):

SELECT 
    c.id AS id_cancion,
    c.nombre AS nombre_cancion,
    c.duracion,
    d.id AS id_disco,
    d.nombre AS nombre_disco,
    YEAR(d.fecha) AS anio_disco,
    d.portada,
    a.id AS id_artista,
    a.nombre AS nombre_artista
FROM canciones c
JOIN discos d ON c.disco_id = d.id
JOIN artistas a ON d.artista_id = a.id;


-- 2. Consulta: Artista (id, nombre y fecha de nacimiento) junto a todas sus canciones, mostrando también la duración de cada una y el disco al que pertenecen:

SELECT 
    ar.id AS id_artista,
    ar.nombre AS nombre_artista,
    ar.fecha_nacimiento,
    c.id AS id_cancion,
    c.nombre AS nombre_cancion,
    c.duracion,
    d.nombre AS nombre_disco
FROM artistas ar
JOIN artistas_canciones ac ON ar.id = ac.artista_id
JOIN canciones c ON ac.cancion_id = c.id
LEFT JOIN discos d ON c.disco_id = d.id;


-- 3. Consulta: Disco, portada, artista y canciones de cada disco:

SELECT 
    d.id AS id_disco,
    d.nombre AS nombre_disco,
    d.portada,
    a.id AS id_artista,
    a.nombre AS nombre_artista,
    c.id AS id_cancion,
    c.nombre AS nombre_cancion
FROM discos d
JOIN artistas a ON d.artista_id = a.id
LEFT JOIN canciones c ON d.id = c.disco_id;