<style>
  body { font-family: Arial, sans-serif; text-align: center; }
        .calendar { display: inline-block; text-align: center; }
        .month-nav { display: flex; justify-content: space-between; align-items: center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: center; }
        a { text-decoration: none; color: black; }

    </style>

<?php
if(isset($_GET['f'])){
    $dia = $_GET['f'];
}

echo "El día es: $dia";



$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "eventos";

// Especifica que estamos usando la Hora Local Española
setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain.1252');

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//$sql = "SELECT * FROM evento WHERE DATE(fecha_ini) = '$dia'"; // contempla solo eventos que sean hoy y no tengan una duración semanal 
$sql = "SELECT *
FROM evento
WHERE '$dia' >= fecha_ini
  AND ('$dia' <= fecha_fin OR fecha_fin IS NULL)
  OR DATE(fecha_ini)='$dia';";
$result = mysqli_query($conn, $sql);


// Convertir formato fecha a formato español legible:

$date = new DateTime($dia);
$dayName = strftime('%A', $date->getTimestamp());
$dayNumber = $date->format('d');
$monthName = strftime('%B', $date->getTimestamp());
$year = $date->format('Y');
$diaGuapo = ucfirst($dayName) . ' ' . $dayNumber . ' de ' . ucfirst($monthName) . ' de ' . $year;
     


echo "<h1>Eventos para el día $diaGuapo:</h1>";


if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        ?>
  
        <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($row["titulo"]); ?></h2>
        <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($row['descripcion']); ?></p>
        <p class="text-sm text-gray-500">
            <span class="font-medium">Hora Inicio: <?php echo date('H:i', strtotime($row['fecha_ini'])); ?></span> <br>
            <?php if ($row['fecha_fin']): ?>
                <span class="font-medium">Hora Fin:</span> <?php echo date('H:i', strtotime($row['fecha_fin'])); ?>
                <?php endif; ?>
            </p>
            <span class="font-medium">Lugar:</span> <?php echo htmlspecialchars($row['lugar']); ?><br>
        </li>

        <?php
    }
} else {
    echo "0 eventos";
}

mysqli_close($conn);
?>


<a href="index.php">Volver</a>



<div class="calendar">
        <div class="month-nav">
            <button onclick="changeMonth(-1)">&lt;</button>
            <h2 id="month-year"></h2>
            <button onclick="changeMonth(1)">&gt;</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>L</th><th>M</th><th>X</th><th>J</th><th>V</th><th>S</th><th>D</th>
                </tr>
            </thead>
            <tbody id="calendar-body"></tbody>
        </table>
    </div>



    <script src="calendar.js"></script>
</body>
</html>