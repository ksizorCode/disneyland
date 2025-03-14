<?php
//Funcion para conectar a la base de datos y hacer una consulta
// conectaBaseDatos("canciones");
// conectaBaseDatos("artistas");
function conectaBaseDatos($tabla,$id = null){

    //1.Conexion Base de Datos
    $conn = mysqli_connect('localhost', 'root', 'root', 'musica');

    //2.Comprobar que la conexion se ha realizado correctamente
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
    //3. Realizar una consulta a la base de datos
        if($id){ // si hay contenido en la variable $id

          switch($tabla){
            case "canciones":
                  $sql = "SELECT 
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
                    JOIN artistas a ON d.artista_id = a.id
                    WHERE c.id = $id;
                    ";
            break;

            case "artistas":
                $sql = "SELECT 
                      a.id AS id_artista,
                      a.nombre AS nombre_artista,
                      a.fecha_nacimiento,
                      c.id AS id_cancion,
                      c.nombre AS nombre_cancion,
                      c.duracion,
                      d.id AS id_disco,
                      d.nombre AS nombre_disco,
                      YEAR(d.fecha) AS anio_disco
                  FROM artistas a
                  JOIN artistas_canciones ac ON a.id = ac.artista_id
                  JOIN canciones c ON ac.cancion_id = c.id
                  LEFT JOIN discos d ON c.disco_id = d.id
                  WHERE a.id = $id
                  ORDER BY d.id, c.id;
                  ";
                break;

            case "discos":
                $sql = "SELECT 
                        d.id AS id_disco,
                        d.nombre AS nombre_disco,
                        d.portada,
                        a.id AS id_artista,
                        a.nombre AS nombre_artista,
                        c.id AS id_cancion,
                        c.nombre AS nombre_cancion
                    FROM discos d
                    JOIN artistas a ON d.artista_id = a.id
                    LEFT JOIN canciones c ON d.id = c.disco_id
                    WHERE d.id = $id;
                    ";
                break;
          } //Fin de SWITCH
            
        }

        else{
        $sql = "SELECT * FROM $tabla";  
        }

      $result = mysqli_query($conn, $sql);
    //4.Mostramos los datos de la consulta
      if (mysqli_num_rows($result) > 0) {
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
              
            if( $id){
                switch($tabla){
                    case "canciones":
                        echo "<h1>{$row['nombre_cancion']}</h1>
                        <p>Duracion:   {$row['duracion']}</p>
                        <p>Album:      <a href='ficha.php?id={$row['id_disco']}&tabla=discos'>{$row['nombre_disco']}</a></p>
                        <p>Portada:    {$row['portada']}</p>
                        <p>Artista:    <a href='ficha.php?id={$row['id_artista']}&tabla=artistas'>{$row['nombre_artista']}</a></p>
                        <p>Año:        {$row['anio_disco']}</p>
                        <p>ID Canción: {$row['id_cancion']}</p>
                        <p>ID Disco:   {$row['id_disco']}</p>
                        <p>ID Artista: {$row['id_artista']}</p>
                        ";
                        break;

                    case "artistas":
                        $html = "";
                        $artist = null;
                        $albums = array();
                
                        // Se recorre el resultado para agrupar los datos
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Guardamos los datos del artista (se asume que son iguales en todas las filas)
                            if (!$artist) {
                                $artist = array(
                                    'id_artista'       => $row['id_artista'],
                                    'nombre_artista'   => $row['nombre_artista'],
                                    'fecha_nacimiento' => $row['fecha_nacimiento']
                                );
                            }
                
                            // Usamos el id_disco para agrupar las canciones por álbum
                            $albumId = $row['id_disco'];
                            if (!isset($albums[$albumId])) {
                                $albums[$albumId] = array(
                                    'nombre_disco' => $row['nombre_disco'],
                                    'anio_disco'   => $row['anio_disco'],
                                    'canciones'    => array()
                                );
                            }
                            // Añadimos la canción al álbum correspondiente
                            $albums[$albumId]['canciones'][] = array(
                                'id_cancion'     => $row['id_cancion'],
                                'nombre_cancion' => $row['nombre_cancion'],
                                'duracion'       => $row['duracion']
                            );
                        }
                
                        // Construimos el HTML a partir de los datos agrupados
                        $html .= "<h1>{$artist['nombre_artista']}</h1>";
                        $html .= "<p>Fecha Nacimiento: {$artist['fecha_nacimiento']}</p>";
                
                        foreach ($albums as $album) {
                            $html .= "<h2>Álbum: {$album['nombre_disco']} ({$album['anio_disco']})</h2>";
                            $html .= "<ul>";
                            foreach ($album['canciones'] as $cancion) {
                                $html .= "<li><a href='ficha.php?id={$cancion['id_cancion']}&tabla=canciones'>{$cancion['nombre_cancion']}</a> (Duración: {$cancion['duracion']}, ID Canción: {$cancion['id_cancion']})</li>";
                            }
                            $html .= "</ul>";
                        }
                        echo $html;
                        break;

                      case "discos":
                          $html = "";
                          $albums = array();
                  
                          // Recorrer los resultados para agrupar por álbum (disco)
                          while ($row = mysqli_fetch_assoc($result)) {
                              $albumId = $row['id_disco'];
                              // Si el álbum no existe en el arreglo, se inicializa con sus datos
                              if (!isset($albums[$albumId])) {
                                  $albums[$albumId] = array(
                                      'id_disco'      => $row['id_disco'],
                                      'nombre_disco'  => $row['nombre_disco'],
                                      'portada'       => $row['portada'],
                                      'id_artista'    => $row['id_artista'],
                                      'nombre_artista'=> $row['nombre_artista'],
                                      'canciones'     => array()
                                  );
                              }
                              // Si la fila contiene información de una canción (puede venir nula en caso de no existir)
                              if (!empty($row['id_cancion'])) {
                                  $albums[$albumId]['canciones'][] = array(
                                      'id_cancion'    => $row['id_cancion'],
                                      'nombre_cancion'=> $row['nombre_cancion']
                                  );
                              }
                          }
                  
                          // Construir el HTML agrupando la información de cada álbum y sus canciones
                          foreach ($albums as $album) {
                              $html .= "<h2>Álbum: {$album['nombre_disco']} (ID Disco: {$album['id_disco']})</h2>";
                              $html .= "<img src='img/{$album['portada']}'>";
                              $html .= "<p>Artista: <a href='ficha.php?id={$album['id_artista']}&tabla=artistas'>{$album['nombre_artista']}</a> (ID Artista: {$album['id_artista']})</p>";
                              $html .= "<h3>Canciones:</h3>";
                              if (!empty($album['canciones'])) {
                                  $html .= "<ul>";
                                  foreach ($album['canciones'] as $cancion) {
                                      $html .= "<li><a href='ficha.php?id={$cancion['id_cancion']}&tabla=canciones   '>{$cancion['nombre_cancion']}</a> (ID Canción: {$cancion['id_cancion']})</li>";
                                  }
                                  $html .= "</ul>";
                              } else {
                                  $html .= "<p>No tiene canciones registradas.</p>";
                              }
                          }
                          echo $html;
                          break;
                        
                } //Fin de SWITCH
            }//fin del IF de $id

          else
          {
            echo 
            "<li> <a href='ficha.php?id={$row["id"]}&tabla={$tabla}'> {$row["nombre"]}</a>  </li>";
          }

    

        }
      } else {
        echo "0 results";
      }
    //5.Cerrar la conexion
      mysqli_close($conn);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
  
