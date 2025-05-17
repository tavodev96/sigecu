<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
require_once '../../config/db.php';

// Obtener todos los cuestionarios
$quizzes = $conn->query("SELECT * FROM quizzes ORDER BY id DESC");

// Obtener usuarios
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center">
            <h3>Reportes</h3>
            <a href="dashboard.php" class="btn btn-secondary">Volver</a>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h5>Reporte individual por usuario</h5>
                <form action="report_user.php" method="GET">
                    <div class="input-group">
                        <select name="user_id" class="form-select" required>
                            <option value="">Seleccione un usuario</option>
                            <?php while ($u = $users->fetch_assoc()): ?>
                                <option value="<?= $u['id'] ?>"><?= $u['document_number'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <button class="btn btn-primary">Ver reporte</button>
                    </div>
                </form>
            </div>

            <div class="col-md-6">
                <h5>Reporte general por cuestionario</h5>
                <form action="report_quiz.php" method="GET">
                    <div class="input-group">
                        <select name="quiz_id" class="form-select" required>
                            <option value="">Seleccione un cuestionario</option>
                            <?php while ($q = $quizzes->fetch_assoc()): ?>
                                <option value="<?= $q['id'] ?>"><?= $q['title'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <button class="btn btn-primary">Ver reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>