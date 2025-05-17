<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

require_once '../../config/db.php';

$user_id = $_SESSION['user_id'];
$quiz_id = $_GET['id'] ?? null;

$step = $_GET['step'] ?? 'auto';

if ($step === 'auto') {
  $result = $conn->query("SELECT question_id FROM quiz_questions WHERE quiz_id = $quiz_id ORDER BY id ASC");
  $question_ids = array_column($result->fetch_all(MYSQLI_ASSOC), 'question_id');

  $answered = $conn->query("
        SELECT question_id FROM responses 
        WHERE quiz_id = $quiz_id AND user_id = $user_id
    ");
  $answered_ids = array_column($answered->fetch_all(MYSQLI_ASSOC), 'question_id');

  $step = 0;
  foreach ($question_ids as $i => $qid) {
    if (!in_array($qid, $answered_ids)) {
      $step = $i;
      break;
    }
  }

  if (count($answered_ids) >= count($question_ids)) {
    header("Location: start_quiz.php?id=$quiz_id&step=" . count($question_ids));
    exit;
  }

  header("Location: start_quiz.php?id=$quiz_id&step=$step");
  exit;
} else {
  $step = (int) $step;
}


if (!$quiz_id) {
  header("Location: select_quiz.php");
  exit;
}

$totalAnswered = $conn->query("SELECT COUNT(*) AS total FROM responses WHERE user_id = $user_id AND quiz_id = $quiz_id")->fetch_assoc()['total'];
$totalQuestions = $conn->query("SELECT COUNT(*) AS total FROM quiz_questions WHERE quiz_id = $quiz_id")->fetch_assoc()['total'];


if ($totalAnswered >= $totalQuestions) {
  $stmt = $conn->prepare("SELECT COUNT(*) AS correctas FROM responses WHERE user_id = ? AND quiz_id = ? AND is_correct = 1");
  $stmt->bind_param("ii", $user_id, $quiz_id);
  $stmt->execute();
  $correctas = $stmt->get_result()->fetch_assoc()['correctas'];
?>
  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="UTF-8">
    <title>Cuestionario Completado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
      <div class="alert alert-success text-center p-5 shadow-lg">
        <h4 class="alert-heading mb-3">¡Cuestionario Completado!</h4>
        <p>Ya has respondido todas las preguntas de este cuestionario.</p>
        <p><strong>Resultado:</strong> <?= $correctas ?> de <?= $totalQuestions ?> respuestas correctas.</p>
        <hr>
        <a href="select_quiz.php" class="btn btn-primary">Volver al listado</a>
      </div>
    </div>
  </body>

  </html>
<?php exit;
}




$result = $conn->query("SELECT qq.question_id FROM quiz_questions qq WHERE quiz_id = $quiz_id ORDER BY qq.id ASC");
$questions = array_column($result->fetch_all(MYSQLI_ASSOC), 'question_id');

if (!isset($questions[$step])) {
  header("Location: start_quiz.php?id=$quiz_id&step=" . count($questions));
  exit;
}
$current_question_id = $questions[$step];

$question = $conn->query("SELECT * FROM questions WHERE id = $current_question_id")->fetch_assoc();
$options = $conn->query("SELECT * FROM options WHERE question_id = $current_question_id")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Cuestionario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    setTimeout(() => {
      alert("Tiempo agotado por inactividad. Serás redirigido.");
      window.location.href = 'login.php';
    }, 120000);
  </script>
</head>

<body>
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center"> 
      <h4>Pregunta <?= $step + 1 ?> de <?= count($questions) ?></h4>
      <a href="login.php" class="btn btn-secondary">Volver</a>
    </div>
    <form action="../../controllers/save_response.php" method="POST">
      <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
      <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
      <input type="hidden" name="step" value="<?= $step ?>">

      <div class="mb-3">
        <p><strong><?= htmlspecialchars($question['text']) ?></strong></p>
        <?php foreach ($options as $opt): ?>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="option_id" value="<?= $opt['id'] ?>" required>
            <label class="form-check-label"><?= htmlspecialchars($opt['text']) ?></label>
          </div>
        <?php endforeach; ?>
      </div>

      <button type="submit" class="btn btn-primary">Siguiente</button>
    </form>
  </div>
</body>

</html>