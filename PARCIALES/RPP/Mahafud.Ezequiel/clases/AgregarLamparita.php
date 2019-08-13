<?php

require_once('Lamparita.php');

$tipo = $_POST['tipo'];
$precio = $_POST['precio'];
$color = $_POST['color'];
$extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
$path = "../lamparitas/imagenes/" . $tipo . "." . $color . "." . date("His") . "." . $extension; 
$lamparita = new Lamparita($tipo, $precio, $color, $path);
$lamparita->Agregar();
move_uploaded_file($_FILES["foto"]["tmp_name"], $path);
header('Location: Listado.php');

?>