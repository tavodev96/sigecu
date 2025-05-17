<?php
session_start();
require_once '../config/db.php';

$user_id = $_SESSION['user_id'];
$quiz_id = $_POST['quiz_id'];
$question_id = $_POST['question_id'];
$option_id = $_POST['option_id'];
$step = $_POST['step'];

$stmt = $conn->prepare("SELECT is_correct FROM options WHERE id = ?");
$stmt->bind_param("i", $option_id);
$stmt->execute();
$is_correct = $stmt->get_result()->fetch_assoc()['is_correct'];

$check = $conn->prepare("SELECT * FROM responses WHERE user_id = ? AND quiz_id = ? AND question_id = ?");
$check->bind_param("iii", $user_id, $quiz_id, $question_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    $stmt = $conn->prepare("INSERT INTO responses (user_id, quiz_id, question_id, option_id, is_correct) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiii", $user_id, $quiz_id, $question_id, $option_id, $is_correct);
    $stmt->execute();
}

$nextStep = (int)$step + 1;
header("Location: ../views/user/start_quiz.php?id=$quiz_id&step=$nextStep");
