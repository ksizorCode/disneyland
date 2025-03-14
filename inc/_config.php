<?
// Modo debug 
// DATOS


// Modo desarrollo 
const DEBUG= 1;

// DATOS
const URL = "http://localhost:10119/disneyland/";
const SITENAME= "Disneyland DB";
const LANG= "es";

const DATOS = [
    'direccion' => 'Calle 123',
    'ciudad'    => 'Ciudad 1',
    'email'     => 'opel@opel.com',
    'pais'      => 'Pais 1',
    'tel'       => '123456789',
    'gps'       => '123.456.789'
];

// voy a hacer un array con los elementos para el menu de redes sociales


const MENU = [
    [
        'texto' => 'Inicio',
        'url'   => '', 
        'clase' => '',
        'target' => 0
    ],
    [
        'texto' => 'Contacto',
        'url'   => 'contacto.php',         
        'clase' => '',
        'target' => 0
    ],
    [
        'texto' => 'Instalación',
        'url'   => 'install.php', 
        'clase' => '',
        'target' => 0
    ]
];


//Llamar a contruir menú. Ejemplo de llamada a la función: contruirMenu(MENU2, false)
//Función que construirá nuestros menús, los valores por defecto son MENU y true
function construirMenu($array=MENU, $nav=true)
{
    
    $miHTML = '<ul>';
    foreach($array as $item)
    {
        $miHTML .= "<li><a href='".URL."{$item['url']}' target='{$item['target']}' class='{$item['clase']}'>{$item['texto']}</a></li>";
    }
    $miHTML .= '</ul>';

    if($nav){
        $miHTML = "<nav>$miHTML</nav>";
    }

    return $miHTML;
}


//Función que se asegura de sanitizar el código
// $algo = '<h1>Hola Mundo</h1>';
// limpiar($algo)
// &lth1&ht Hola Mundo &lt/h1&ht
function limpiar($aLimpiar){
    return htmlspecialchars($aLimpiar, ENT_QUOTES, 'UTF-8');
}

function slug($aSluguear){

}

function formConstructor(){}


// FUNCIÓN PARA EL TÍTULO SI CUENTA CON TÍTULO DE PAARTADO LO ESCRIBE Y SI NO, ESCRIBE EL APARTADO DE LA WEB
function titulo($ponerSiteTitulo=true)
{
    global $titulo;
    if(isset($titulo)){        echo $titulo;    }

    if(isset($titulo)&&$ponerSiteTitulo){ echo " - "; }
    
    if($ponerSiteTitulo){
        echo SITENAME;
    }

    if(!isset($titulo)){
    debug("titulo no definido");
    }
}

// Escribe texto en modo desarrollo
function debug($texto, $contenedor = false)
{
    if (DEBUG) {
        // Elimina espacios y tabulaciones al inicio de cada línea
        $texto = preg_replace('/^\s+/m', '', $texto);
        
        $miHTML = $texto;
        if ($contenedor) {
            $miHTML = "<pre class='debug'>$miHTML</pre>";
        }
        
        echo $miHTML;
    }
}

debug('<!-- config.php -->');






// DATA BASE - BASE DE DATOS --------------------------------

const HOST = 'localhost';
const USER = 'root';
const PASS = 'root';
const DBNA = 'disneylanddb';

// Example (MySQLi Procedural) -> https://www.w3schools.com/php/php_mysql_select.asp



//  $sql = "SELECT id, firstname, lastname FROM MyGuests";  almacenamos la consulta SQL en una variable
//  consulta($sql) llamamos a la función pasándole la consulta anterior
// Por defecto la consulta no nos devuelve ningún valor
// $consulta = consulta($sql, 1) // si queremos que nos devuelva un valor almacenamos el valor en una variable y le pasamos el segundo parametro true o 1

function consulta($sql, $devolver=false){
     // Crear conexión
    $conn = mysqli_connect(HOST, USER, PASS, DBNA);
    // Verificar conexión
    if (!$conn){
        die("Conexión fallida: " . mysqli_connect_error());
    }

    
 $resultado = mysqli_query($conn, $sql);
 
 if($devolver){
     $array_resultados = [];
     
     if($resultado && mysqli_num_rows($resultado) > 0) {
         while($fila = mysqli_fetch_assoc($resultado)) {
             $array_resultados[] = $fila;
         }
     }
     
     return $array_resultados;
    }
    else{
        return $resultado;
    }
    
    mysqli_close($conn);

}



//DEBUG
function printR($array){
    if(DEBUG){
        echo '<pre class="debug">';
        print_r($array);
        echo '</pre>';
    }
}


// Construir en formato JSON
function JSON($array){
    // Se muestra el resultado en formato JSON
    $json = json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    echo "<h3>Resultado en JSON</h3>";
    echo "<pre>$json</pre>";
}




// FORMATEAR FECHA
// Función que convierte una fecha en formato "YYYY-MM-DD" a "Día de Mes de Año"
function convertirFecha($fecha) {
    // Arreglos de traducción para días y meses
    $dias = array(
        'Sunday'    => 'Domingo',
        'Monday'    => 'Lunes',
        'Tuesday'   => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday'  => 'Jueves',
        'Friday'    => 'Viernes',
        'Saturday'  => 'Sábado'
    );
    $meses = array(
        '01' => 'Enero',
        '02' => 'Febrero',
        '03' => 'Marzo',
        '04' => 'Abril',
        '05' => 'Mayo',
        '06' => 'Junio',
        '07' => 'Julio',
        '08' => 'Agosto',
        '09' => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre'
    );
    
    // Creamos el objeto DateTime
    $fechaObj = new DateTime($fecha);
    
    // Obtenemos cada parte de la fecha
    $diaSemanaEn = $fechaObj->format('l'); // Nombre del día en inglés
    $diaSemana = isset($dias[$diaSemanaEn]) ? $dias[$diaSemanaEn] : $diaSemanaEn;
    
    $dia = $fechaObj->format('d');  // Día con dos dígitos (ej. "15")
    $mesNum = $fechaObj->format('m'); // Mes numérico "01", "02", etc.
    $mesEsp = isset($meses[$mesNum]) ? $meses[$mesNum] : $mesNum;
    
    $anio = $fechaObj->format('Y');
    
    // Retornamos la fecha formateada según lo solicitado
    return "{$diaSemana} {$dia} de {$mesEsp} de {$anio}";
}

// Ejemplo de uso:
//echo convertirFecha("1975-01-15"); // Salida: Martes 15 de Enero de 1975