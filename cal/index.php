
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "eventos";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM evento";
$result = mysqli_query($conn, $sql);


echo '<table>';
echo '<thead>';
echo '<th>Evento</th><th>Fecha Inicio</th><th>Fecha Fin</th>';
echo '</thead>';

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row["titulo"]}</td><td>{$row["fecha_ini"]}</td><td>{$row["fecha_fin"]}</td></tr>";
    }
} else {
    echo "0 eventos";
}

mysqli_close($conn);
?>


<ul>
    <li> <a href="dia.php?f=2024-02-15"> 15 Febrero 2024</a></li>
    <li> <a href="dia.php?f=2024-02-16"> 16 Febrero 2024</a></li>
    <li> <a href="dia.php?f=2024-02-17"> 17 Febrero 2024</a></li>
    <li> <a href="dia.php?f=2024-02-18"> 18 Febrero 2024</a></li>
    <li> <a href="dia.php?f=2024-02-19"> 19 Febrero 2024</a></li>
    <li> <a href="dia.php?f=2024-02-20"> 20 Febrero 2024</a></li>
</ul>