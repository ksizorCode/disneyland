<?php

// Personajes de winnieh pooh
class Personajes{

    //Atributos del bicho
    private string $nombre;
    public string $color;
    public string $animal;
    public string $foto;
    public string $casa;
    public string $personalidad;

    //Constructor del Objeto Personaje
    // public function __construct($nombre, $color, $animal, $foto, $casa, $personalidad){
    //     $this->nombre = $nombre;
    //     $this->color = $color;
    //     $this->animal = $animal;
    //     $this->foto = $foto;
    //     $this->casa = $casa;
    //     $this->personalidad = $personalidad;

    //     //
    //     $this->medicar();
    // }

    //Métodos del objeto
    public function medicar(){
        echo "<p>Hola soy {$this->nombre}, y represento al animal {$this->animal}, y me he tomado unas pastillas para apaciguar {$this->personalidad}</p>";
    }

}

$miNombre = new Personajes();
$miNombre->nombre = "Winnie the Pooh";
echo $miNombre->nombre;


// $wini = new Personajes("Winnie the Pooh", "Amarillo", "Oso", "https://www.disneyclips.com/imagesnewb4/images/pooh-bear.png", "Bosque de los cien acres", "Glotón");
// $tigger = new Personajes("Tigger", "Naranja", "Tigre", "https://www.disneyclips.com/imagesnewb4/images/tigger.png", "Bosque de los cien acres", "Hiperactivo");
// $piglet = new Personajes("Piglet", "Rosa", "Cerdo", "https://www.disneyclips.com/imagesnewb4/images/piglet.png", "Bosque de los cien acres", "Miedoso");
