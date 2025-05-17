<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../../config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: questions.php");
    exit;
}

// Obtener la pregunta y sus opciones
$stmt = $conn->prepare("SELECT * FROM questions WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$pregunta = $stmt->get_result()->fetch_assoc();

$stmt = $conn->prepare("SELECT * FROM options WHERE question_id = ? ORDER BY id ASC");
$stmt->bind_param("i", $id);
$stmt->execute();
$opciones = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Pregunta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Editar Pregunta</h3>
    <form method="POST" action="../../controllers/update_question.php">
        <input type="hidden" name="id" value="<?= $pregunta['id'] ?>">
        <div class="mb-3">
            <label>Texto de la pregunta</label>
            <textarea name="text" class="form-control" required><?= htmlspecialchars($pregunta['text']) ?></textarea>
        </div>
        <label>Opciones (una debe marcarse como correcta)</label>
        <?php foreach ($opciones as $index => $op): ?>
            <div class="input-group mb-2">
                <div class="input-group-text">
                    <input type="radio" name="correct" value="<?= $index ?>" <?= $op['is_correct'] ? 'checked' : '' ?> required>
                </div>
                <input type="hidden" name="option_ids[]" value="<?= $op['id'] ?>">
                <input type="text" name="options[]" class="form-control" value="<?= htmlspecialchars($op['text']) ?>" required>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary mt-3">Guardar cambios</button>
        <a href="questions.php" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
