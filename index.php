<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso al Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row text-center">
        <h2 class="mb-5">Bienvenido al Sistema de Cuestionarios</h2>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm p-4">
                <i class="bi bi-person-lock display-1 text-primary"></i>
                <h5 class="mt-3">Administrador</h5>
                <a href="views/login.php" class="btn btn-outline-primary mt-3">Ingresar</a>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm p-4">
                <i class="bi bi-person-circle display-1 text-success"></i>
                <h5 class="mt-3">Usuario</h5>
                <a href="views/user/login.php" class="btn btn-outline-success mt-3">Ingresar</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
