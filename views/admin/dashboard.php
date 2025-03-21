<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php"); 
    exit();
}
if ($_SESSION['role'] != 'admin') {
    header("Location: ../../index.php"); 
    exit();
}
if (isset($_POST['logout'])) {
    session_unset(); 
    session_destroy(); 
    header("Location: ../../index.php"); 
    exit();
}
include '../../includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Roboto', sans-serif;
        }
        nav {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        .brand-logo {
            font-size: 1.8rem;
            font-weight: bold;
        }
        .container {
            margin-top: 30px;
        }
        h4 {
            color: #333;
            font-weight: 600;
        }
        .card {
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            text-align: center;
        }
        .btn-large {
            border-radius: 25px;
            padding: 15px 30px;
            font-size: 1.1rem;
        }
        .btn-large:hover {
            transform: scale(1.05);
            transition: transform 0.2s;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Administrador</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <form action="" method="POST" style="display: inline;">
                <button type="submit" name="logout" class="nav-link btn btn-link" style="color: white;">Cerrar Sesión</button>
            </form>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h4>Bienvenido, Administrador</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="https://www.comunidadbaratz.com/wp-content/uploads/La-biblioteca-es-inclusion-social-e-igualdad-de-oportunidades.jpg" class="card-img-top" alt="Gestionar Libros">
                    <div class="card-body">
                        <a href="libros.php" class="btn btn-lg btn-primary">Gestionar Libros</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT2_Oc-qi3MZxKT0eonxg6baiaPdcyjnTE9LA&s" class="card-img-top" alt="Gestionar Autores">
                    <div class="card-body">
                        <a href="autores.php" class="btn btn-lg btn-success">Gestionar Autores</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://asm.es/wp-content/uploads/2019/10/usuarios-y-skills-en-traksys-1024x682.jpg" class="card-img-top" alt="Gestionar Autores">
                    <div class="card-body">
                        <a href="usuarios.php" class="btn btn-lg btn-warning">Gestionar Usuarios</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
