<? require_once 'inc/_config.php'?>

<?php
// Verificar si se ha pasado el id de la atracción por GET
if (isset($_GET['id'])) {
    // Sanitizamos el valor recibido para evitar inyección SQL
    $id = intval($_GET['id']);
    $tabla = htmlspecialchars($_GET['ta'], ENT_QUOTES, 'UTF-8');
    
    debug("cargamos: $tabla", true);

    //Consulta y datos que aparecerán en función de la tabla que se haya seleccionado:
    switch ($tabla) {
        // Si la tabla es atracción
        case 'atraccion':
                // CONSULTA SQL

                $sql = "
                -- Consulta que une varias tablas para obtener información completa de la atracción,
                -- incluyendo el nombre del parque y del complejo.
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

                // Array con los campos que se van a mostrar y estructura
                $mostrar =[
                    ['item'=>'foto',            "tipo"=>"img","prefijo"=>""],
                    ['item'=>'descripcion',     "tipo"=>"p",  "prefijo"=>""],
                    ['item'=>'zona_nombre',     "tipo"=>"p",  "prefijo"=>"Zona:"],
                    ['item'=>'parque_nombre',   "tipo"=>"p",  "prefijo"=>"Parque:"],
                    ['item'=>'complejo_nombre', "tipo"=>"p",  "prefijo"=>"Complejo:"],
                    ['item'=>'inauguracion',    "tipo"=>"date",  "prefijo"=>"Inauguruación:"],
                ];

            break;
            
            
            case 'complejo':
                $sql = "
                SELECT * FROM complejo WHERE id = $id;
                ";

                $mostrar =[
                    ['item'=>'nombre',          "tipo"=>"h3", "prefijo"=>""],
                    ['item'=>'descripcion',     "tipo"=>"p",  "prefijo"=>""],
                    ['item'=>'lugar',            "tipo"=>"p",  "prefijo"=>""],
                ];
                
                
                break;


        // Para todos los demás casos 
        default:
                $sql = "
                SELECT p.id, p.nombre, p.descripcion, p.mapa, p.anio, c.nombre AS nombre_complejo
                FROM $tabla p
                JOIN complejo c ON p.id_complejo = c.id
                WHERE p.id = 1;
                ";

                $mostrar =[
                    ['item'=>'nombre',          "tipo"=>"h3", "prefijo"=>""],
                    ['item'=>'descripcion',     "tipo"=>"p",  "prefijo"=>""],
                    ['item'=>'nombre_complejo', "tipo"=>"p",  "prefijo"=>"Complejo"],
                    ['item'=>'anio',            "tipo"=>"date",  "prefijo"=>"Inauguración:"],
                ];
    }
}
else {
   echo "No se han encontrado resultados";
}

// Ejecutar la consulta
$resultado = consulta($sql, 1); 
$i = $resultado[0];


?>

<? $titulo= $i['nombre']?>


<? include 'inc/_header.php'?>
<a href="index.php" class="btn"><i class="fa-regular fa-square-caret-left"></i>Volver atrás</a>
<h2>Datos de <?=$titulo?> <span>(<?=$tabla?>)</span></h2>




<?

    // Se asume que la función consulta() ejecuta la consulta y devuelve el resultado.
    



// Si hay resultados, se extraen y muestran


if (!empty($resultado) && count($resultado) > 0) {
    // Si hay resultados, se extraen y muestran
    $i = $resultado[0];
    
      


        //Constructor de los campos que vamos a mostrar traidos del array $mostrar
        $miHTML = "";
        foreach($mostrar as $m){
            // para imagenes
            if($m['tipo'] == 'img'){
                $miHTML .= "<img src='assets/img/$tabla/{$i['foto']}' alt='{$i['nombre']}'>";
            }
            // para fechas
            elseif($m['tipo'] == 'date'){
                $miHTML .= "<p>";
                if($m['prefijo']){
                    $miHTML .="<span>{$m['prefijo']}</span>";
                }
                $miHTML.=convertirFecha($i[$m['item']])."</p>";
                $miHTML .= "</p>";
            }

            // para el resto de etiquetas
            else{
                $miHTML .= "<{$m['tipo']} class='{$i[$m['item']]}'>";
                if($m['prefijo']){
                    $miHTML .="<span>{$m['prefijo']}</span>";
                }
                $miHTML .="{$i[$m['item']]}";
                $miHTML .="</{$m['tipo']}>";
            }
        }
        echo $miHTML;
        // echo "<h3>{$i['nombre']}</h3>";
        // echo "<p>{$i['descripcion']}</p>";
        // echo "<p><strong>Parque:</strong> {$i['parque_nombre']}</p>";
        // echo "<p><strong>Complejo:</strong> {$i['complejo_nombre']}</p>";
        // echo "<p><strong>Tierra:</strong> {$i['zona_nombre']}</p>";


        //Mostrar JSON
        JSON($resultado);  

        //Mostrar SQL
        debug($sql,1);  

          //Debug
          printR($i);
    } 



?>

<? include 'inc/_footer.php'?>