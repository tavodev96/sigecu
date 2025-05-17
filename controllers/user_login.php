<?php
session_start();
require_once '../config/db.php';

$document = trim($_POST['document']);

if (empty($document)) {
    die("Documento requerido");
}

$stmt = $conn->prepare("SELECT * FROM users WHERE document_number = ?");
$stmt->bind_param("s", $document);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    $_SESSION['user_id'] = $user['id'];
} else {
    $stmt = $conn->prepare("INSERT INTO users (document_number) VALUES (?)");
    $stmt->bind_param("s", $document);
    $stmt->execute();
    $_SESSION['user_id'] = $conn->insert_id;
}

header("Location: ../views/user/select_quiz.php");
