<?php

function consulta($sql, $devolver = true) {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "dicampus";

    // Crear conexión
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Verificar conexión
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Ejecutar la consulta
    $result = mysqli_query($conn, $sql);

    // Inicializar el array para almacenar los resultados
    $miarray = [];

    // Verificar si la consulta devolvió resultados
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($fila = mysqli_fetch_assoc($result)) {
                $miarray[] = $fila;
            }
        }
    } else {
        // Manejar errores en la consulta
        echo "Error en la consulta: " . mysqli_error($conn);
    }

    // Cerrar la conexión
    mysqli_close($conn);

    // Devolver resultados si se requiere
    if ($devolver) {
        return $miarray;
    }
}



/*

CREATE DATABASE IF NOT EXISTS dicampus ;
USE dicampus;

CREATE TABLE cursos(
id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
nombre VARCHAR(255) NOT NULL,
descripcion TEXT NULL,
fechaini DATETIME NULL,
fechafin DATETIME NULL
);

INSERT INTO cursos(nombre, fechaini, fechafin, descripcion)
VALUES('Desarrollo de Apps con tecnología web', '2024-12-12-08:00:00', '2025-04-29-15:00:00'
, 'Preguntarle a ChatGPT cosas'),
('Calderería', '2024-12-12-08:00:00', '2025-04-29-15:00:00', 'Calderos'),
('Impresión 3D', '2024-12-12-08:00:00', '2025-04-29-15:00:00', 'Imprimir cosas'),
('Calderería', '2024-12-12-08:00:00', '2025-04-29-15:00:00', 'Calderos');


*/ 
?>


<!------ ESTO SERÍA YA MI INDEX.PHP ----->

<!-- LLAMO AL CONFIG, HEADER ETC...--->

<style>

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f0f0f0;
}
    </style>


<!-- BODY --->


<?php 

$sql ="SELECT * FROM cursos";
$cursos = consulta($sql);

echo "<table>";
echo "<thead>";
echo "<tr><th>id</th> <th>nombre</th> <th>descripcion</th> <th>fechaini</th> <th>fechafin</th> </tr>";
echo "</thead>";
echo "<tbody>";
// output data of each row
    echo "<tr>";

foreach($cursos as $i){
    echo "<td>{$i['id']}</td>";
    echo "<td>{$i['nombre']}</td>";
    echo "<td>{$i['descripcion']}</td>";
    echo "<td>{$i['fechaini']}</td>";
    echo "<td>{$i['fechafin']}</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "<tfoot>";
echo "<tr><th>id</th> <th>nombre</th> <th>descripcion</th> <th>fechaini</th> <th>fechafin</th> </tr>";
echo "</tfoot>";
echo "</table>";


?>



<?
echo '<pre>';
print_r($cursos);
echo '</pre>';
?>


<?
$json = json_encode($cursos, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

echo '<pre>';
echo $json;
echo '</pre>';

echo '<ul>';
foreach($cursos as $i){
    echo "<li>{$i['nombre']}</li>";

}
echo '</ul>';



?>