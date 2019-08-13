<?php

require_once('Lamparita.php');

$tipo = $_POST['tipo'];
$precio = $_POST['precio'];
$color = $_POST['color'];

$lamparita = new Lamparita($tipo, $precio, $color);
$lamparita->Agregar();
Lamparita::GuardarEnArchivo($lamparita);

?>