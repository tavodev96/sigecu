<?php
require_once '../config/db.php';

$quiz_id = $_POST['quiz_id'];
$selected = $_POST['questions'] ?? [];

$stmt = $conn->prepare("DELETE FROM quiz_questions WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();

foreach ($selected as $question_id) {
    $stmt = $conn->prepare("INSERT INTO quiz_questions (quiz_id, question_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $quiz_id, $question_id);
    $stmt->execute();
}

header("Location: ../views/admin/quizzes.php");
