<?php
require_once '../config/db.php';
$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM quizzes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: ../views/admin/quizzes.php");
