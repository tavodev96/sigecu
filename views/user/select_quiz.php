<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
require_once '../../config/db.php';

$quizzes = $conn->query("
    SELECT * FROM quizzes 
    WHERE deadline > NOW() 
    AND id IN (SELECT DISTINCT quiz_id FROM quiz_questions)
    ORDER BY deadline ASC
");

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Seleccionar Cuestionario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
      <h3>Cuestionarios Disponibles</h3>
      <a href="../../index.php" class="btn btn-secondary">Volver</a>
    </div>
    <ul class="list-group mt-3">
      <?php while ($q = $quizzes->fetch_assoc()): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong><?= htmlspecialchars($q['title']) ?></strong><br>
            <small>Disponible hasta: <?= $q['deadline'] ?></small>
          </div>
          <a href="start_quiz.php?id=<?= $q['id'] ?>&step=auto" class="btn btn-primary">Comenzar</a>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>
</body>

</html>