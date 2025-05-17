<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
require_once '../../config/db.php';

$usuarios = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Listado de Usuarios</h3>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Documento</th>
                <th>Cuestionarios Respondidos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($u = $usuarios->fetch_assoc()): ?>
                <?php
                $uid = $u['id'];
                $r = $conn->query("SELECT COUNT(DISTINCT quiz_id) AS total FROM responses WHERE user_id = $uid")->fetch_assoc();
                $total = $r['total'];
                ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['document_number']) ?></td>
                    <td><?= $total ?> cuestionario(s)</td>
                    <td>
                        <a href="report_user.php?user_id=<?= $u['id'] ?>" class="btn btn-sm btn-primary">Ver reporte</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Volver al panel</a>
</div>
</body>
</html>
