<?php
require_once 'config/db.php';

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "Administrador creado correctamente.";
} else {
    echo "Error al crear administrador: " . $stmt->error;
}
