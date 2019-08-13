<?php

require_once('Helado.php');

$sabor = $_GET['sabor'];
$cantidad = $_GET['cantidad'];
$helado = new Helado($sabor, 0);
$helados = Helado::RetornarArrayDeHelados();
$helado = Helado::BuscarEnArray($helados, $helado);

if ($helado) 
	echo "Precio con IVA: " . $helado->PrecioMasIva() * $cantidad;
else 
	echo "No hay helados de ese gusto!";

?>