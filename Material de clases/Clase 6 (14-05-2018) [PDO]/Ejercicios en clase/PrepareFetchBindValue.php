<?php

require_once('conexion.php');

$id = $_GET['id'];
$titulo = $_GET['titulo'];

// Prepara la consulta
$preparedQuery = $objetoPDO->prepare("SELECT titel, interpret, jahr FROM cds WHERE id = :id AND titel = :titulo");
// Se bindean los parámetros por nombre (Las variables NO quedan asociadas a la consulta)
$preparedQuery->bindValue("id", $id);
$preparedQuery->bindValue("titulo", $titulo);
// Ejecuta la consulta
$preparedQuery->execute();
// Trae el resultado
while ($row = $preparedQuery->fetch()) {
    echo $row[0] . " - " . $row[1] . " - " . $row[2] . "<br>";
}

// Prepara la consulta
$preparedQueryDos = $objetoPDO->prepare("SELECT titel, interpret, jahr FROM cds WHERE id = ? AND titel = ?");
// Se bindean los parámetros por posición (Las variables NO quedan asociadas a la consulta)
$preparedQueryDos->bindValue(1, $id);
$preparedQueryDos->bindValue(2, $titulo);
// Ejecuta la consulta
$preparedQueryDos->execute();
// Trae el resultado
while ($row = $preparedQueryDos->fetch()) {
    echo $row[0] . " - " . $row[1] . " - " . $row[2] . "<br>";
}

?>