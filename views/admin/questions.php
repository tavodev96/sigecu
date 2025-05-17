<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
require_once '../../config/db.php';

// Obtener todas las preguntas
$preguntas = $conn->query("SELECT * FROM questions ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Preguntas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Gestión de Preguntas</h3>
    <div class="d-flex justify-content-between align-items-center">
        <button class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#modalPregunta">Nueva Pregunta</button>
      <a href="dashboard.php" class="btn btn-secondary">Volver</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Pregunta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $preguntas->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['text']) ?></td>
                    <td>
                        <a href="edit_question.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                        <a href="../../controllers/delete_question.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta pregunta?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal Nueva Pregunta -->
<div class="modal fade" id="modalPregunta" tabindex="-1" aria-labelledby="modalPreguntaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="../../controllers/save_question.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crear Nueva Pregunta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label>Texto de la pregunta</label>
            <textarea name="text" class="form-control" required></textarea>
        </div>
        <label>Opciones (una debe marcarse como correcta)</label>
        <?php for ($i = 1; $i <= 4; $i++): ?>
            <div class="input-group mb-2">
                <div class="input-group-text">
                    <input type="radio" name="correct" value="<?= $i - 1 ?>" required>
                </div>
                <input type="text" name="options[]" class="form-control" placeholder="Opción <?= $i ?>" required>
            </div>
        <?php endfor; ?>
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
