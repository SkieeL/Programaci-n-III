<?php

require_once('conexion.php');

$id = $_GET['id'];

// Prepara la consulta
$preparedQuery = $objetoPDO->prepare("SELECT titel AS titulo, interpret AS interprete, jahr AS anio FROM cds WHERE id >= :id");

// Se bindea el parámetro por nombre y valor únicamente
$preparedQuery->bindValue("id", $id);

// Ejecuta la consulta
$preparedQuery->execute();

// Trae el resultado como tipo Obj standard class
while ($obj = $preparedQuery->fetch(PDO::FETCH_LAZY)) {
    echo $obj->titulo . " - " . $obj->interprete . " - " . $obj->anio . "<br>";
}

?>