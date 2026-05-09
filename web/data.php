<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// data.php
$host = "localhost";
$dbname = "rp_02_website";
$user = "rp_02";
$password = "sI+01";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

// Die letzten 20 Messungen holen
$query = "SELECT zeitpunkt, temperatur, feuchtigkeit, luftdruck FROM wetterdaten ORDER BY zeitpunkt DESC LIMIT 20";
$result = pg_query($conn, $query);

$data = array();
while ($row = pg_fetch_assoc($result)) {
    $data[] = $row;
}

// Umdrehen, damit die Zeit von links nach rechts läuft
echo json_encode(array_reverse($data));
?>
