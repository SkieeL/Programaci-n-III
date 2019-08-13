<?php

require_once('conexion.php');

$sql = $objetoPDO->query("SELECT titel AS 'titulo', interpret AS 'interprete', jahr AS 'anio' FROM cds");

$resultado = $sql->fetchAll(); 
$output = "";

foreach ($resultado as $fila) {
    $output .= $fila[0] . " - ";
    $output .= $fila['interprete'] . " - ";
    $output .= $fila[2] . "<br>";
}

echo $output;

?>