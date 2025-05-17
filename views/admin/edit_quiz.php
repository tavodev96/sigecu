<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../../config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: quizzes.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$quiz = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cuestionario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Editar Cuestionario</h3>
    <form action="../../controllers/update_quiz.php" method="POST">
        <input type="hidden" name="id" value="<?= $quiz['id'] ?>">

        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($quiz['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($quiz['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Fecha límite</label>
            <input type="datetime-local" name="deadline" class="form-control" 
                value="<?= date('Y-m-d\TH:i', strtotime($quiz['deadline'])) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="quizzes.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
