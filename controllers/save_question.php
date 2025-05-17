<?php
require_once '../config/db.php';

$questionText = $_POST['text'];
$options = $_POST['options'];
$correctIndex = $_POST['correct'];

if (empty($questionText) || count($options) < 2) {
    die("Datos incompletos");
}

$stmt = $conn->prepare("INSERT INTO questions (text) VALUES (?)");
$stmt->bind_param("s", $questionText);
$stmt->execute();
$questionId = $conn->insert_id;

foreach ($options as $index => $optText) {
    $isCorrect = ($index == $correctIndex) ? 1 : 0;
    $stmt = $conn->prepare("INSERT INTO options (question_id, text, is_correct) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $questionId, $optText, $isCorrect);
    $stmt->execute();
}

header("Location: ../views/admin/questions.php");
