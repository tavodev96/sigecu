<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../../config/db.php';

$user_id = $_GET['user_id'] ?? null;
if (!$user_id) {
    header("Location: reports.php");
    exit;
}

// Obtener usuario
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();

// Obtener todos los cuestionarios que respondió
$quizzes = $conn->query("
    SELECT DISTINCT q.id, q.title
    FROM quizzes q
    JOIN responses r ON r.quiz_id = q.id
    WHERE r.user_id = $user_id
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h4>Reporte del usuario: <?= $user['document_number'] ?></h4>
    <?php while ($quiz = $quizzes->fetch_assoc()): ?>
        <h5 class="mt-4"><?= $quiz['title'] ?></h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Pregunta</th>
                    <th>Respuesta del usuario</th>
                    <th>¿Correcta?</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $respuestas = $conn->query("
                    SELECT q.text AS pregunta, o.text AS respuesta, r.is_correct
                    FROM responses r
                    JOIN questions q ON r.question_id = q.id
                    JOIN options o ON r.option_id = o.id
                    WHERE r.user_id = $user_id AND r.quiz_id = {$quiz['id']}
                ");
                while ($row = $respuestas->fetch_assoc()):
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['pregunta']) ?></td>
                    <td><?= htmlspecialchars($row['respuesta']) ?></td>
                    <td>
                        <?= $row['is_correct'] ? '<span class="text-success">✔ Sí</span>' : '<span class="text-danger">✘ No</span>' ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endwhile; ?>
    <a href="reports.php" class="btn btn-secondary">Volver</a>
</div>
</body>
</html>
