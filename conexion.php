<?php
$servername = "db";
$username = "root";
$password = "root";
$dbname = "mi_banco_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error critico de conexion con la base de datos: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>