<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php"); 
    exit();
}
if ($_SESSION['role'] != 'admin') 
    header("Location: ../../login.php"); 
    exit();
}
include '../../includes/header.php'; 

$crud = CrudFactory::createCrud('user', $db);
$usuarios = $crud->read();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Usuarios</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Gestionar Usuarios</a>
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
        <h4>Lista de Usuarios</h4>
        
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalAgregarUsuario">Agregar Usuario</button>
        
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['Id_user'] ?></td>
                    <td><?= $usuario['nombre'] . ' ' . $usuario['apellidoP'] . ' ' . $usuario['apellidoM'] ?></td>
                    <td><?= $usuario['email'] ?></td>
                    <td><?= $usuario['role'] == 'admin' ? 'Admin' : 'User' ?></td>
                    <td>
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEditarUsuario" data-id="<?= $usuario['Id_user'] ?>">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?= $usuario['Id_user'] ?>)">Eliminar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar usuario -->
    <div class="modal fade" id="modalAgregarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalAgregarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarUsuarioLabel">Agregar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="../../controllers/UserController.php?action=create" onsubmit="return validarContraseñas()">
                    <div class="form-group">
                        <label for="nombreUsuario">Nombre</label>
                        <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidoP">Apellido Paterno</label>
                        <input type="text" class="form-control" id="apellidoP" name="apellidoP" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidoM">Apellido Materno</label>
                        <input type="text" class="form-control" id="apellidoM" name="apellidoM" required>
                    </div>
                    <div class="form-group">
                        <label for="correoUsuario">Correo</label>
                        <input type="email" class="form-control" id="correoUsuario" name="correoUsuario" required>
                    </div>
                    <div class="form-group">
                        <label for="passwordUsuario">Contraseña</label>
                        <input type="password" class="form-control" id="passwordUsuario" name="passwordUsuario"  minlength="8"required>
                    </div>
                    <div class="form-group">
                        <label for="confirmarPassword">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="confirmarPassword" name="confirmarPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="rolUsuario">Rol</label>
                        <select class="form-control" name="rolUsuario" required>
                            <option value="" disabled selected>Selecciona un rol</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Modal para editar usuario -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="../../controllers/UserController.php?action=update">
                        <input type="hidden" id="idUsuarioEditar" name="idUsuarioEditar">
                        <div class="form-group">
                            <label for="nombreUsuarioEditar">Nombre</label>
                            <input type="text" class="form-control" id="nombreUsuarioEditar" name="nombreUsuarioEditar" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidoPEditar">Apellido Paterno</label>
                            <input type="text" class="form-control" id="apellidoPEditar" name="apellidoPEditar" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidoMEditar">Apellido Materno</label>
                            <input type="text" class="form-control" id="apellidoMEditar" name="apellidoMEditar" required>
                        </div>
                        <div class="form-group">
                            <label for="rolUsuarioEditar">Rol</label>
                            <select class="form-control" id="rolUsuarioEditar" name="rolUsuarioEditar" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
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
        // Llenar el modal de edición con los datos del usuario
        $('#modalEditarUsuario').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var usuario = <?= json_encode($usuarios) ?>.find(u => u.Id_user == id);
            if (usuario) {
                $('#idUsuarioEditar').val(usuario.Id_user);
                $('#nombreUsuarioEditar').val(usuario.nombre);
                $('#apellidoPEditar').val(usuario.apellidoP);
                $('#apellidoMEditar').val(usuario.apellidoM);
                $('#correoUsuarioEditar').val(usuario.email);
                $('#rolUsuarioEditar').val(usuario.role);
            }
        });

        function confirmarEliminar(id) {
            if (confirm("¿Estás seguro de eliminar este usuario?")) {
                window.location.href = "../../controllers/UserController.php?action=delete&id=" + id;
            }
        }

        function validarContraseñas() {
        var password = document.getElementById('passwordUsuario').value;
        var confirmarPassword = document.getElementById('confirmarPassword').value;

        if (password !== confirmarPassword) {
            alert('Las contraseñas no coinciden. Por favor, intenta nuevamente.');
            return false; 
        }

        return true; 
    }
    </script>
</body>
</html>
