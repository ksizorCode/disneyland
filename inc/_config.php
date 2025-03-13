<?
// Modo debug 
// DATOS





// Modo desarrollo 
const DEBUG= true;

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
    if(defined('TITULO'))
    {
        echo TITULO;
    }

    if(defined('TITULO')&&$ponerSiteTitulo)
    {
    echo " - ";
    }
    
    if($ponerSiteTitulo)
    {
        echo SITENAME;
    }

    if(!defined("TITULO"))
    {
    debug("titulo no definido");
    }
}

// Escribe texto en modo desarrollo
function debug($texto, $contenedor=false)
{
    if(DEBUG)
    {
        $miHTML= "$texto";
        if($contenedor){
            $miHTML = "<div class='debug'>$miHTML</div>";
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

