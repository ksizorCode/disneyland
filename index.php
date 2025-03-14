<? $titulo= "Disneyland Data Base"?>
<? require_once 'inc/_config.php'?>
<? include 'inc/_header.php'?>

<?
function constuirlista($tabla){
  $sql="SELECT * FROM $tabla";
  $resultado=consulta($sql,1);

  if(!empty($resultado) && count($resultado)>0) {
    // Si hay resultados
    echo "<ul>";
    foreach($resultado as $i) {
        echo "<li><a href='ficha.php?ta=$tabla&id={$i['id']}'>{$i['nombre']}</a></li>";
    }
    echo "</ul>";
  } else {
    // Si no hay resultados
    echo "No se han encontrado resultados";
  }
}
?>


<h2>Lista de Atracciones</h2>
<?
$tabla='atraccion';
constuirlista($tabla);
?>

<h2>Lista de Parques</h2>
<?
$tabla='parque';
constuirlista($tabla);
?>

<h2>Lista de Complejos</h2>
<?
$tabla='complejo';
constuirlista($tabla);
?>


<? include 'inc/_footer.php'?>