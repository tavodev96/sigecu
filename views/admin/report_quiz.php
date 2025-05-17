<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../../config/db.php';

$quiz_id = $_GET['quiz_id'] ?? null;
if (!$quiz_id) {
    header("Location: reports.php");
    exit;
}

$quiz = $conn->query("SELECT * FROM quizzes WHERE id = $quiz_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte General</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h4>Reporte general del cuestionario: <?= $quiz['title'] ?></h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Usuario (documento)</th>
                <th>Respuestas correctas</th>
                <th>Total de preguntas</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $usuarios = $conn->query("
                SELECT u.document_number, 
                    SUM(r.is_correct) AS correctas, 
                    COUNT(r.id) AS total
                FROM responses r
                JOIN users u ON r.user_id = u.id
                WHERE r.quiz_id = $quiz_id
                GROUP BY r.user_id
            ");

            while ($u = $usuarios->fetch_assoc()):
            ?>
            <tr>
                <td><?= htmlspecialchars($u['document_number']) ?></td>
                <td><?= $u['correctas'] ?></td>
                <td><?= $u['total'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="reports.php" class="btn btn-secondary">Volver</a>
</div>
</body>
</html>
