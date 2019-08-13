<?php

require_once('conexion.php');

$id = $_GET['id'];

// Prepara la consulta
$preparedQuery = $objetoPDO->prepare("SELECT titel AS titulo, interpret AS interprete, jahr AS anio FROM cds WHERE id = :id");

// Ejecuta la consulta , indicándole el ID a reemplazar en la consulta preparada (:id) [DEBE SER UN ARRAY SIEMPRE]
$preparedQuery->execute(array("id" => $id));

// Trae el resultado
while ($row = $preparedQuery->fetch()) {
    echo $row[0] . " - " . $row[1] . " - " . $row[2] . "<br>";
}

?>