<? const TITULO= "Bienvenidos a la Base de datos de Disneyland"?>
<? require_once 'inc/_config.php'?>
<? include 'inc/_header.php'?>
<h2>Lista de Atracciones</h2>

<?
$sql='SELECT * FROM atraccion'; 
//Seleccionaa todas las a atracciones de Disneyland paris (id_parque=1)
$resultado=consulta($sql,1);

if (mysqli_num_rows($resultado) > 0) {
    // output data of each row
    echo '<ul>';
    while($row = mysqli_fetch_assoc($resultado)) {
      echo "<li>{$row["nombre"]}</li>";
    }
    echo '</ul>';
  } 
  else {
    echo "0 resultados";
  }
  
?>

<? include 'inc/_footer.php'?>