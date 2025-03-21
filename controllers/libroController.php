<?php
include '../includes/header.php';

$action = $_GET['action'] ?? '';
$crud = CrudFactory::createCrud('libro', $db);

switch ($action) {
    case 'create':
        $data = [
            'NombreL' => $_POST['nombreLibro'],
            'Descripcion' => $_POST['descripcionLibro'],
            'Id_autor' => $_POST['idAutor'],
            'Id_categoria' => $_POST['categoriaLibro']
        ];
        if ($crud->create($data)) {
            $_SESSION['message'] = "Libro creado exitosamente.";
        } else {
            $_SESSION['error'] = "Error al crear el libro.";
        }
        break;

    case 'update':
        $data = [
            'NombreL' => $_POST['nombreLibroEditar'],
            'Descripcion' => $_POST['descripcionLibroEditar'],
            'Id_autor' => $_POST['idAutorEditar'],
            'Id_categoria' => $_POST['categoriaLibroEditar']
        ];
        $id = $_POST['idLibroEditar'];
        if ($crud->update($id, $data)) {
            $_SESSION['message'] = "Libro actualizado exitosamente.";
        } else {
            $_SESSION['error'] = "Error al actualizar el libro.";
        }
        break;
    case 'delete':
        $id = $_GET['id'];
        if ($crud->delete($id)) {
            $_SESSION['message'] = "Libro eliminado exitosamente.";
        } else {
            $_SESSION['error'] = "Error al eliminar el libro.";
        }
        break;
    default:
        $_SESSION['error'] = "Acción no válida.";
        break;
}
header("Location: ../views/admin/libros.php");
exit();
?>