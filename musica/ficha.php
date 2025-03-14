<? require "_config.php";?>
<a href="index.php">Volver</a>
<?php
//0º Recoger el id de la cancion que queremos mostrar
$id = $_GET["id"];
$tabla = $_GET["tabla"];
// echo "El id de la cancion es: $id";

//1º Conectamos a la base de datos y hacer la consulta de: canciones/artistas/discos

conectaBaseDatos($tabla,$id);
// SELECT * FROM canciones WHERE id = 1;
//2ºDesplegamos la información de la consulta


?>