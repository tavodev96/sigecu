<?php
session_start();
require_once '../../config/db.php';

$quiz_id = $_GET['id'] ?? null;
if (!$quiz_id) {
    header("Location: quizzes.php");
    exit;
}

// Obtener cuestionario
$stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$quiz = $stmt->get_result()->fetch_assoc();

// Obtener todas las preguntas
$questions = $conn->query("SELECT * FROM questions");

// Obtener preguntas ya asignadas
$assigned = $conn->query("SELECT question_id FROM quiz_questions WHERE quiz_id = $quiz_id");
$assigned_ids = array_column($assigned->fetch_all(MYSQLI_ASSOC), 'question_id');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Preguntas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h4>Asignar preguntas al cuestionario: <?= htmlspecialchars($quiz['title']) ?></h4>

    <form method="POST" action="../../controllers/assign_questions.php">
        <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">

        <ul class="list-group mb-3">
            <?php while ($q = $questions->fetch_assoc()): ?>
                <li class="list-group-item">
                    <label>
                        <input type="checkbox" name="questions[]" value="<?= $q['id'] ?>"
                            <?= in_array($q['id'], $assigned_ids) ? 'checked' : '' ?>>
                        <?= htmlspecialchars($q['text']) ?>
                    </label>
                </li>
            <?php endwhile; ?>
        </ul>

        <button type="submit" class="btn btn-success">Guardar asignaciones</button>
        <a href="quizzes.php" class="btn btn-secondary">Volver</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
