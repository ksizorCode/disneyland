<? const TITULO= "Disneyland Data Base"?>
<? require_once 'inc/_config.php'?>
<? include 'inc/_header.php'?>
<h2>Lista de Atracciones</h2>

<?
$sql='SELECT * FROM atraccion'; 
//Seleccionaa todas las a atracciones de Disneyland paris (id_parque=1)
$resultado=consulta($sql,1);

if(!empty($resultado) && count($resultado)>0) {
  // Si hay resultados
  echo "<ul>";
  foreach($resultado as $i) {
      echo "<li><a href='ficha.php?id={$i['id']}'>{$i['nombre']}</a></li>";
  }
  echo "</ul>";
} else {
  // Si no hay resultados
  echo "No se han encontrado resultados";
}
?>

<? include 'inc/_footer.php'?>