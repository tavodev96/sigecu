<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Acceso al Cuestionario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex flex-column justify-content-center align-items-center vh-100">
  <div class="card p-4 shadow" style="width: 400px;">
    <h4 class="mb-3 text-center">Acceder al Cuestionario</h4>
    <form action="../../controllers/user_login.php" method="POST">
      <div class="mb-3">
        <label for="document" class="form-label">Número de Documento</label>
        <input type="text" class="form-control" name="document" id="document" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Ingresar</button>
    </form>
  </div>
  <div class="mt-4">
        Regresar a <a href="../../index.php">Inicio</a>
    </div>
</div>
</body>
</html>
