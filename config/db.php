<?php
$host = "localhost";
$user = "root";
$pass = "Thiago25*";
$dbname = "cuestionarios_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
