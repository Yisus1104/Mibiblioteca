<?php
include 'DatabaseConnection.php';
include 'CrudFactory.php';
include 'Auth.php';

$db = DatabaseConnection::getInstance()->getConnection();
$auth = new Auth($db);
?>