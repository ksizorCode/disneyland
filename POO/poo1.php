<style>
body {
    font-family: sans-serif;
    max-width: 960px;
    padding: 20px;
}

.info {
    border-radius: 20px;
    padding: 20px;
    margin-bottom: 8px;

    .datos {
        display: flex;
        flex-wrap: wrap;
        flex-direction: row-reverse;
        gap: 10px;

        * {
            flex: 1 1 0;
        }

        img {
            max-width: 320px;
        }
    }
}

img {
    display: block;
    max-width: 100%;
}

.black, .Black, .BLACK {
    color: white;
}
</style>
<?php

// Programación Orientada a Objetos
class Coche {
    // Propiedades / Atributos
    public string $conductor;
    public string $marca;
    public string $modelo;
    public string $color;
    public string $imagen;
    private int $velocidad;

    // ---- Métodos ----
    // Constructor
    public function __construct($conductor, $marca, $modelo, $color, $imagen='pordefecto.webp'){
        $this->conductor = $conductor;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->color = $color;
        $this->imagen = $imagen;
        $this->velocidad = 0;
        $this->presentacion();
    }

    public function presentacion() {
        echo "<div class='info {$this->color}' style='background-color: {$this->color}'>";
        echo "<h2>Soy el coche de {$this->conductor}</h2>";
        echo "<div class='datos'>";
        echo "<div>";
        echo "<p>Mi color es {$this->color}</p>";
        echo "<p>Mi marca es {$this->marca}</p>";
        echo "<p>Mi modelo es {$this->modelo}</p>";
        echo "</div>";
        echo "<img src='assets/img/coches/{$this->imagen}' alt='{$this->marca}-{$this->modelo} de color {$this->color}'>";
        echo "</div>";
        echo "</div>";
    }

    
}

// Creamos una instancia de la clase Coche con los parametros iniciales
// definidos en el constructor
$cocheIker = new Coche("Iker", "Seat", "Ibiza", "Grey", "seat-ibiza-gris-oscuro.webp");
$elBugaDelMoi = new Coche("Moises", "Chevrolet", "Impala", "Black");
$crisCar = new Coche("Cristian", "Lamborghini", "Sexto Elemento", "Orange");
$elBatMiguel = new Coche("Miguel", "Renault", "Clio", "Yellow");

// $cocheIker->presentacion();
// $elBugaDelMoi->presentacion();
$crisCar->presentacion();
$elBatMiguel->presentacion();

