<?php

include_once('Helado.php');

$sabor = $_POST['sabor'];
$precio = $_POST['precio'];
$heladoNuevo = new Helado($sabor, $precio);
$extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
$path = "heladosImagen/" . $sabor . "." . date("His") . "." . $extension; 
$heladoNuevo->SetPath($path);

$helados = Helado::TraerDeArchivo();
$heladoViejo = Helado::BuscarEnArray($helados, $heladoNuevo);

if ($heladoViejo) {
	Helado::EliminarDeArchivo($heladoViejo);
	Helado::GuardarEnArchivo($heladoNuevo);
	//Helado::ModificarEnDB($heladoViejo, $heladoNuevo);
	move_uploaded_file($_FILES["foto"]["tmp_name"], $path);
	echo "Helado modificado correctamente!";
}
else {
	echo "No se encontró el helado a ser modificado";
}

?>