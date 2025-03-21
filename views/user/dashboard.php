<?php include '../../includes/header.php'; 
$crud = CrudFactory::createCrud('libro', $db);
$libros = $crud->read();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Usuario</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav>
        <div class="nav-wrapper blue darken-3">
            <a href="#" class="brand-logo">Mi Biblioteca</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
            <form action="../../controllers/logout.php" method="POST" style="display: inline;">
    <button type="submit" class="nav-link btn btn-link" style="color: white;">Cerrar Sesión</button>
</form>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container">
        <div class="row">
            <?php foreach ($libros as $libro): ?>
            <div class="col s12 m6 l4">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title"><?= $libro['NombreL'] ?></span>
                        <p><?= $libro['Descripcion'] ?></p>
                        <p><strong>Autor:</strong> <?= $libro['Id_autor'] ?></p>
                        <p><strong>Categoría:</strong> <?= $libro['Id_categoria'] ?></p>
                    </div>
                    <div class="card-action">
                        <!-- Botón para abrir el modal -->
                        <a href="#modalLibro<?= $libro['Id_libro'] ?>" class="modal-trigger btn blue">Mostrar Más</a>
                    </div>
                </div>
            </div>

            <!-- Modal para mostrar detalles del libro -->
            <div id="modalLibro<?= $libro['Id_libro'] ?>" class="modal">
                <div class="modal-content">
                    <h4><?= $libro['NombreL'] ?></h4>
                    <p><strong>Descripción:</strong> <?= $libro['Descripcion'] ?></p>
                    <p><strong>Autor:</strong> <?= $libro['Id_autor'] ?></p>
                    <p><strong>Categoría:</strong> <?= $libro['Id_categoria'] ?></p>
                </div>
                <div class="modal-footer">
                    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
                </div>
            </div>

            <?php endforeach; ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        // Inicialización de modales
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.modal');
            var instances = M.Modal.init(elems);
        });
    </script>
</body>
</html>
