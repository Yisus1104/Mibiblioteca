<?php
include '../includes/header.php';

$action = $_GET['action'] ?? '';
$crud = CrudFactory::createCrud('autor', $db);

switch ($action) {
    case 'create':
        $data = [
            'NombreA' => $_POST['nombreAutor'],
            'Nacionalidad' => $_POST['nacionalidadAutor'],
            'Fecha_nacimiento' => $_POST['fechaNacimientoAutor']
        ];
        $crud->create($data);
        break;
    case 'update':
        $data = [
            'NombreA' => $_POST['nombreAutorEditar'],
            'Nacionalidad' => $_POST['nacionalidadAutorEditar'],
            'Fecha_nacimiento' => $_POST['fechaNacimientoAutorEditar']
        ];
        $id = $_POST['idAutorEditar'];
        $crud->update($id, $data);
        break;
    case 'delete':
        $id = $_GET['id'];
        $crud->delete($id);
        break;
}

header("Location: ../views/admin/autores.php");
?>