<?php

require_once('Lamparita.php');

$tipo = $_POST['tipo'];
$precio = $_POST['precio'];
$color = $_POST['color'];
$extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
$path = "../lamparitas/imagenes/" . $tipo . "." . $color . "." . date("His") . "." . $extension; 
$pathNuevo = "../lamparitasModificadas/" . $tipo . "." . $color . "." . date("His") . "." . $extension; 

$lamparita = new Lamparita($ipo, $precio, $color, $path);
Lamparita::Modificar($lamparita);
move_uploaded_file($_FILES["foto"]["tmp_name"], $pathNuevo);
echo "Lamparita modificada!";

?>

