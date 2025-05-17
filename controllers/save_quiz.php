<?php
require_once '../config/db.php';

$title = $_POST['title'];
$description = $_POST['description'];
$deadline = $_POST['deadline'];

$stmt = $conn->prepare("INSERT INTO quizzes (title, description, deadline) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $title, $description, $deadline);
$stmt->execute();

header("Location: ../views/admin/quizzes.php");
