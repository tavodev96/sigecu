<?php
require_once '../config/db.php';

$id = $_POST['id'];
$questionText = $_POST['text'];
$options = $_POST['options'];
$option_ids = $_POST['option_ids'];
$correctIndex = $_POST['correct'];

if (!$id || empty($questionText) || count($options) !== 4) {
    die("Datos incompletos");
}

$stmt = $conn->prepare("UPDATE questions SET text = ? WHERE id = ?");
$stmt->bind_param("si", $questionText, $id);
$stmt->execute();

foreach ($options as $index => $text) {
    $opt_id = $option_ids[$index];
    $is_correct = ($index == $correctIndex) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE options SET text = ?, is_correct = ? WHERE id = ?");
    $stmt->bind_param("sii", $text, $is_correct, $opt_id);
    $stmt->execute();
}

header("Location: ../views/admin/questions.php");
