<?php

require_once('Cliente.php');

$correo = $_POST['correo'];
$clave = $_POST['clave'];

$cliente = new Cliente("", $correo, $clave);

if ($cliente->ValidarCliente())
    echo "Cliente logueado!";
else
    echo "Cliente inexsistente!";

?>