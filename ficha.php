<? const TITULO= "Bienvenidos a la Base de datos de Disneyland"?>
<? require_once 'inc/_config.php'?>
<? include 'inc/_header.php'?>
<h2>Lista de Atracciones</h2>

<?php
// Verificar si se ha pasado el id de la atracción por GET
if (isset($_GET['id'])) {
    // Sanitizamos el valor recibido para evitar inyección SQL
    $id = intval($_GET['id']);
    
    // Consulta que une varias tablas para obtener información completa de la atracción,
    // incluyendo el nombre del parque y del complejo.
    $sql = "
    SELECT 
        a.*, 
        p.nombre AS parque_nombre, 
        c.nombre AS complejo_nombre,
        z.nombre AS zona_nombre
    FROM atraccion a
    LEFT JOIN _atraccion_parque ap ON a.id = ap.id_atraccion
    LEFT JOIN parque p ON ap.id_parque = p.id
    LEFT JOIN complejo c ON p.id_complejo = c.id
    LEFT JOIN _atraccion_zonaparque az ON a.id = az.id_atraccion
    LEFT JOIN zonaparque z ON az.id_zonaparque = z.id
    WHERE a.id = $id";
    // Se asume que la función consulta() ejecuta la consulta y devuelve el resultado.
    $resultado = consulta($sql, 1);


    echo '<pre>';
    var_dump($resultado);
    echo '</pre>';
    // Si hay resultados, se extraen y muestran

    
    if (!empty($resultado) && count($resultado) > 0) {
        // Si hay resultados, se extraen y muestran
        $i = $resultado[0];
        echo "<h3>{$i['nombre']}</h3>";
        echo "<p>{$i['descripcion']}</p>";
        echo "<p><strong>Parque:</strong> {$i['parque_nombre']}</p>";
        echo "<p><strong>Complejo:</strong> {$i['complejo_nombre']}</p>";
        echo "<p><strong>Tierra:</strong> {$i['zona_nombre']}</p>";
        $json = json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    echo "<pre>$json</pre>";

    } else {
        echo "No se han encontrado resultados";
    }
} else {
    echo "No se ha seleccionado ninguna atracción";
}





?>

<? include 'inc/_footer.php'?>