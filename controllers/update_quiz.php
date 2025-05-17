<?php
require_once '../config/db.php';

$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$deadline = $_POST['deadline'];

$stmt = $conn->prepare("UPDATE quizzes SET title = ?, description = ?, deadline = ? WHERE id = ?");
$stmt->bind_param("sssi", $title, $description, $deadline, $id);
$stmt->execute();

header("Location: ../views/admin/quizzes.php");
