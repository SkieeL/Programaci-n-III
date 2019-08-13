<?php

require_once('Helado.php');

$sabor = $_POST['sabor'];
$precio = $_POST['precio'];
$extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
$path = "heladosImagen/" . $sabor . "." . date("His") . "." . $extension; 

$helado = new Helado($sabor, $precio);
$helado->SetPath($path);

Helado::GuardarEnArchivo($helado);
move_uploaded_file($_FILES["foto"]["tmp_name"], $path);

?>