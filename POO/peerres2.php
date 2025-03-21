<?php

class Banco
{

    private int $saldo;
    public string $titular;
    public string $comercio;
    public string $precio;
    public string $concepto;
    public string $fecha;

    public function __construct($saldo, $titular)
    {
        //Cuenta bancaria
        $this->saldo = $saldo;
        $this->titular = $titular;

        // Datos de la compra
        // $this->comercio = $comercio;
        // $this->precio = $precio;
        // $this->concepto = $concepto;
        // ponme la hora que toy en españa
        date_default_timezone_set('Europe/Madrid');
        $this->fecha = date('d-m-Y h:i:s');

        // $this->cobro();
        $this->crearCuenta();
    }

    public function getSaldo($codigo): int | string
    {
        if($codigo == "1234"){
            return $this->saldo;
        }else{
            
            return "No tienes permisos para ver el saldo";
        }
    }

    public function setSaldo($saldo): void
    {
        $this->saldo = $saldo;
    }

    //CREAR CUENTA
    public function crearCuenta()
    {
        echo "<p>🎪Se ha creado la cuenta de {$this->titular} con un saldo de {$this->saldo}€</p>";
    }

    //INGRESAR DINERO
    public function ingresarDinero($cantidad)
    {
        $this->saldo += $cantidad;
        echo "<p>🎪Se ha ingresado la cantidad de {$cantidad}€ en la cuenta de {$this->titular}.";
    }

    //CONSULTAR SALDO
    public function consultarSaldo()
    {
        echo "<p>🎇El saldo de la cuenta de {$this->titular} es de {$this->saldo}€</p>";
    }

    //COBRAR
    public function cobro($precio, $concepto, $comercio)
    {
        if ($this->saldo >= $precio) {
            $this->saldo -= $precio;
            echo "<p>🖼Se ha cobrado al titular {$this->titular} la cantidad de {$precio}€ en el comercio {$comercio} por el concepto de {$concepto} el día {$this->fecha}</p>";
        } else {
            echo "Tas pobre {$this->titular}";
        }
    }
}




$usuario1 = new Banco(100, "Paco");

echo $usuario1->getSaldo('12');



$usuario1->cobro(50, "Comida", "Mercadona");
$usuario1->consultarSaldo();

$usuario1->cobro(50, "Comida", "Mercadona");
$usuario1->consultarSaldo();


$usuario1->cobro(50, "Comida", "Mercadona");
$usuario1->consultarSaldo();

$usuario1->ingresarDinero(100);
$usuario1->consultarSaldo();

$usuario1->cobro(50, "Comida", "Mercadona");
$usuario1->consultarSaldo();