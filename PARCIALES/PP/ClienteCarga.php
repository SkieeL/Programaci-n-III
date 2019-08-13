<?php

require_once('Cliente.php');

$nombre = $_GET['nombre'];
$correo = $_GET['correo'];
$clave = $_GET['clave'];

$cliente = new Cliente($nombre, $correo, $clave);

Cliente::GuardarEnArchivo($cliente);

?>