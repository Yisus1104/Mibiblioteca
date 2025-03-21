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

$crud = CrudFactory::createCrud('libro', $db);
$libros = $crud->read();
$autores = CrudFactory::createCrud('autor', $db)->read(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Libros</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Gestionar Libros</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Inicio</a></li>
                <form action="../../controllers/logout.php" method="POST" style="display: inline;">
    <button type="submit" class="nav-link btn btn-link" style="color: white;">Cerrar Sesión</button>
</form>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-4">
        <h4>Lista de Libros</h4>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalAgregarLibro">Agregar Libro</button>
        
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Autor</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($libros as $libro): ?>
                <tr>
                    <td><?= $libro['Id_libro'] ?></td>
                    <td><?= $libro['NombreL'] ?></td>
                    <td><?= $libro['Descripcion'] ?></td>
                    <td><?= $libro['Id_autor'] ?></td>
                    <td><?= $libro['Id_categoria'] ?></td>
                    <td>
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEditarLibro" data-id="<?= $libro['Id_libro'] ?>">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?= $libro['Id_libro'] ?>)">Eliminar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar libro -->
    <div class="modal fade" id="modalAgregarLibro" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLibroLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarLibroLabel">Agregar Libro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="../../controllers/libroController.php?action=create">
                        <div class="form-group">
                            <label for="nombreLibro">Nombre del Libro</label>
                            <input type="text" class="form-control" id="nombreLibro" name="nombreLibro" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcionLibro">Descripción</label>
                            <textarea class="form-control" id="descripcionLibro" name="descripcionLibro" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="idAutor">Autor</label>
                            <select class="form-control" name="idAutor" required>
                                <option value="" disabled selected>Selecciona un autor</option>
                                <?php foreach ($autores as $autor): ?>
                                <option value="<?= $autor['Id_autor'] ?>"><?= $autor['NombreA'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="categoriaLibro">Categoría</label>
                            <input type="text" class="form-control" id="categoriaLibro" name="categoriaLibro" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar libro -->
    <div class="modal fade" id="modalEditarLibro" tabindex="-1" role="dialog" aria-labelledby="modalEditarLibroLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLibroLabel">Editar Libro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="../../controllers/libroController.php?action=update">
                        <input type="hidden" id="idLibroEditar" name="idLibroEditar">
                        <div class="form-group">
                            <label for="nombreLibroEditar">Nombre del Libro</label>
                            <input type="text" class="form-control" id="nombreLibroEditar" name="nombreLibroEditar" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcionLibroEditar">Descripción</label>
                            <textarea class="form-control" id="descripcionLibroEditar" name="descripcionLibroEditar" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="idAutorEditar">Autor</label>
                            <select class="form-control" id="idAutorEditar" name="idAutorEditar" required>
                                <option value="" disabled selected>Selecciona un autor</option>
                                <?php foreach ($autores as $autor): ?>
                                <option value="<?= $autor['Id_autor'] ?>"><?= $autor['NombreA'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="categoriaLibroEditar">Categoría</label>
                            <input type="text" class="form-control" id="categoriaLibroEditar" name="categoriaLibroEditar" required>
                        </div>
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Llenar el modal de edición con los datos del libro
        $('#modalEditarLibro').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var libro = <?= json_encode($libros) ?>.find(l => l.Id_libro == id);
            if (libro) {
                $('#idLibroEditar').val(libro.Id_libro);
                $('#nombreLibroEditar').val(libro.NombreL);
                $('#descripcionLibroEditar').val(libro.Descripcion);
                $('#idAutorEditar').val(libro.Id_autor);
                $('#categoriaLibroEditar').val(libro.Id_categoria);
            }
        });

        function confirmarEliminar(id) {
            if (confirm("¿Estás seguro de eliminar este libro?")) {
                window.location.href = `../../controllers/libroController.php?action=delete&id=${id}`;
            }
        }
    </script>
</body>
</html>
