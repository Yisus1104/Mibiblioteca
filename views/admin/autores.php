<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php"); 
    exit();
}
if ($_SESSION['role'] != 'admin') {
    header("Location: ../../login.php"); 
    exit();
}
include '../../includes/header.php'; 

$crud = CrudFactory::createCrud('autor', $db);
$autores = $crud->read();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Autores</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Gestionar Autores</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Inicio</a>
                </li>
                <form action="../../controllers/logout.php" method="POST" style="display: inline;">
    <button type="submit" class="nav-link btn btn-link" style="color: white;">Cerrar Sesión</button>
</form>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h4>Lista de Autores</h4>
                <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalAgregarAutor">Agregar Autor</button>
                <table class="table table-striped">
            <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Nacionalidad</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($autores as $autor): ?>
                        <tr>
                            <td><?= $autor['Id_autor'] ?></td>
                            <td><?= $autor['NombreA'] ?></td>
                            <td><?= $autor['Nacionalidad'] ?></td>
                            <td><?= $autor['Fecha_nacimiento'] ?></td>
                            <td>
                            <button class="btn btn-success btn-sm modal-trigger" 
        data-toggle="modal" 
        data-target="#modalEditarAutor" 
        data-id="<?= $autor['Id_autor'] ?>">Editar
</button>

                                <button class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?= $autor['Id_autor'] ?>)">Eliminar</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para agregar autor -->
    <div id="modalAgregarAutor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalAgregarAutorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarAutorLabel">Agregar Autor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="../../controllers/autorController.php?action=create">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreAutor">Nombre del Autor</label>
                            <input type="text" class="form-control" id="nombreAutor" name="nombreAutor" required>
                        </div>
                        <div class="form-group">
                            <label for="nacionalidadAutor">Nacionalidad</label>
                            <input type="text" class="form-control" id="nacionalidadAutor" name="nacionalidadAutor" required>
                        </div>
                        <div class="form-group">
                            <label for="fechaNacimientoAutor">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fechaNacimientoAutor" name="fechaNacimientoAutor" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para editar autor -->
    <div id="modalEditarAutor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalEditarAutorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarAutorLabel">Editar Autor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="../../controllers/autorController.php?action=update">
                    <input type="hidden" id="idAutorEditar" name="idAutorEditar">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreAutorEditar">Nombre del Autor</label>
                            <input type="text" class="form-control" id="nombreAutorEditar" name="nombreAutorEditar" required>
                        </div>
                        <div class="form-group">
                            <label for="nacionalidadAutorEditar">Nacionalidad</label>
                            <input type="text" class="form-control" id="nacionalidadAutorEditar" name="nacionalidadAutorEditar" required>
                        </div>
                        <div class="form-group">
                            <label for="fechaNacimientoAutorEditar">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fechaNacimientoAutorEditar" name="fechaNacimientoAutorEditar" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).on('click', '.modal-trigger', function() {
        var id = $(this).data('id');
        var autores = <?= json_encode($autores) ?>;
        var autor = autores.find(a => a.Id_autor == id);

        if (autor) {
            $('#idAutorEditar').val(autor.Id_autor);
            $('#nombreAutorEditar').val(autor.NombreA);
            $('#nacionalidadAutorEditar').val(autor.Nacionalidad);
            $('#fechaNacimientoAutorEditar').val(autor.Fecha_nacimiento);
        }
    });

        function confirmarEliminar(id) {
            if (confirm("¿Estás seguro de eliminar este autor?")) {
                window.location.href = `../../controllers/autorController.php?action=delete&id=${id}`;
            }
        }
    </script>
</body>
</html>
