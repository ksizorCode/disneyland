<?php

//Harry POOtter

//Clase Personaje con el cual crearemos nuestros personajes
class Personaje{

    //Atributos de la clase
    //Los atributos publicos se espera que se pasen cuando creas una instancia de la clase y 
    //los privados son para uso interno.
    public string $nombre;
    public string $apellido;
    public string $varita;
    public string $casa;
    public string $mascota;
    public int $curso;

    //Constructor de la clase Personajes
    //El constructor se ejecuto al crear la instancia del Objeto, se le pasará como parámetros todos los atributos públicos
    public function __construct($nombre, $apellido, $varita, $casa, $mascota, $curso=1){
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->varita = $varita;
        $this->casa = $casa;
        $this->mascota = $mascota;
        $this->curso = $curso;

        //Si ejecutamos la función dentro del constructor del Objeto no es necesario llamar a la función más adelante
        $this->inscribirAlumno();
    }
    
    //Método que nos inscrbirá a los alumnos
    public function inscribirAlumno(){
        echo "<p>Se ha inscrito al alumno {$this->nombre} {$this->apellido} en la casa {$this->casa}</p>";
    }

    //Método que hará pasar de curso al alumno
    public function pasarCurso(){
        $cursoAnterior=$this->curso;
        $this->curso+=1;
        echo "<p>Felicidades {$this->nombre}, has aprobado el curso $cursoAnterior, ahora estás en el curso {$this->curso}</p>";
        if(($this->curso)>=5){ //Si curso es mayor o igual que 5 la mascota del personaje muere
            echo "<p>{$this->mascota} ha fallecido de una manera terrible</p>";
            $this->mascota="D.E.P. 💀";
        }
    }

}

//Creamos varios objetos de la clase Personaje
$alumno1 = new Personaje("Harry", "Potter", "Sauco", "Griffindor", "Lechuza");
$alumno2 = new Personaje("Hermione", "No se como se apellida", "Roble", "Griffindor", "gato");
$alumno3 = new Personaje("Draco", "Malfoy", "palo", "Slytherin", "Rata");

$alumno1->pasarCurso();
echo "<p>Mascota:  $alumno1->mascota</p>";

$alumno1->pasarCurso();
echo "<p>Mascota:  $alumno1->mascota</p>";

$alumno1->pasarCurso();
echo "<p>Mascota:  $alumno1->mascota</p>";

$alumno1->pasarCurso();
echo "<p>Mascota:  $alumno1->mascota</p>";

echo "<p>El alumno {$alumno1->nombre} está en el curso {$alumno1->curso} y su mascota es: {$alumno1->mascota}</p>";
echo "<p>El alumno {$alumno2->nombre} está en el curso {$alumno2->curso} y su mascota es: {$alumno2->mascota}</p>";
echo "<p>El alumno {$alumno3->nombre} está en el curso {$alumno3->curso} y su mascota es: {$alumno3->mascota}</p>";

// $alumno1->inscribirAlumno();
// $alumno2->inscribirAlumno();
// $alumno3->inscribirAlumno();


?>