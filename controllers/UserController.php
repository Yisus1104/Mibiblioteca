<?php
include '../includes/header.php';

$action = $_GET['action'] ?? '';
$crud = CrudFactory::createCrud('user', $db);

switch ($action) {
    case 'create':
        $data = [
            'email' => $_POST['correoUsuario'],
            'nombre' => $_POST['nombreUsuario'],
            'apellidoP' => $_POST['apellidoP'],
            'apellidoM' => $_POST['apellidoM'],
            'password' => password_hash($_POST['passwordUsuario'], PASSWORD_DEFAULT),
            'role' => $_POST['rolUsuario']
        ];

        if ($crud->create($data)) {
            $_SESSION['message'] = "Usuario creado exitosamente.";
        } else {
            $_SESSION['error'] = "Error al crear el usuario.";
        }
        break;

    case 'update':
        $data = [
            'nombre' => $_POST['nombreUsuarioEditar'],
            'apellidoP' => $_POST['apellidoPEditar'],
            'apellidoM' => $_POST['apellidoMEditar'],
            'role' => $_POST['rolUsuarioEditar']
        ];
        $id = $_POST['idUsuarioEditar'];
        if ($crud->update($id, $data)) {
            $_SESSION['message'] = "Usuario actualizado exitosamente.";
        } else {
            $_SESSION['error'] = "Error al actualizar el usuario.";
        }
        break;

    case 'delete':
        $id = $_GET['id'];
        if ($crud->delete($id)) {
            $_SESSION['message'] = "Usuario eliminado exitosamente.";
        } else {
            $_SESSION['error'] = "Error al eliminar el usuario.";
        }
        break;

    default:
        $_SESSION['error'] = "Acción no válida.";
        break;
}

header("Location: ../views/admin/usuarios.php");
exit();
?>
