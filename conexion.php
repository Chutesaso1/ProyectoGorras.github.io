<?php
$host = "localhost"; // Cambia si es necesario
$user = "root"; // Usuario de MySQL
$password = ""; // Contraseña de MySQL
$dbname = "zomihats"; // Nombre de la base de datos

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
