<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../../config/db.php';
$quizzes = $conn->query("SELECT * FROM quizzes ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Cuestionarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Gestión de Cuestionarios</h3>
    <div class="d-flex justify-content-between align-items-center">
      <button class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#modalQuiz">Nuevo Cuestionario</button>
      <a href="dashboard.php" class="btn btn-secondary">Volver</a>
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Título</th>
            <th>Fecha límite</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($quiz = $quizzes->fetch_assoc()): ?>
            <tr>
                <td><?= $quiz['id'] ?></td>
                <td><?= htmlspecialchars($quiz['title']) ?></td>
                <td><?= $quiz['deadline'] ?></td>
                <td>
                    <a href="edit_quiz.php?id=<?= $quiz['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                    <a href="../../controllers/delete_quiz.php?id=<?= $quiz['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este cuestionario?')">Eliminar</a>
                    <a href="assign_questions.php?id=<?= $quiz['id'] ?>" class="btn btn-sm btn-secondary">Asignar preguntas</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal Nuevo Cuestionario -->
<div class="modal fade" id="modalQuiz" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="../../controllers/save_quiz.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crear Nuevo Cuestionario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descripción (opcional)</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Fecha límite</label>
            <input type="datetime-local" name="deadline" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
