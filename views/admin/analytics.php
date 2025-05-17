<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
require_once '../../config/db.php';

// Usuarios destacados (más respuestas correctas)
$usuarios = $conn->query("
    SELECT u.document_number, COUNT(*) AS correctas
    FROM responses r
    JOIN users u ON r.user_id = u.id
    WHERE r.is_correct = 1
    GROUP BY r.user_id
    ORDER BY correctas DESC
    LIMIT 5
");

// Preguntas con más errores
$preguntas = $conn->query("
    SELECT q.text, COUNT(*) AS errores
    FROM responses r
    JOIN questions q ON r.question_id = q.id
    WHERE r.is_correct = 0
    GROUP BY r.question_id
    ORDER BY errores DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Análisis del Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Análisis del Sistema (Valor Agregado)</h3>

    <div class="row mt-4">
        <div class="col-md-6">
            <h5>Usuarios Destacados</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Respuestas Correctas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($u = $usuarios->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['document_number']) ?></td>
                            <td><?= $u['correctas'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <h5>Preguntas con Más Errores</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Pregunta</th>
                        <th>Errores</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($p = $preguntas->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['text']) ?></td>
                            <td><?= $p['errores'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <a href="dashboard.php" class="btn btn-secondary mt-4">Volver al Panel</a>
</div>
</body>
</html>
