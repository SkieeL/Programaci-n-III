<?php

require_once('conexion.php');

$id = $_GET['id'];

// Prepara la consulta
$preparedQuery = $objetoPDO->prepare("SELECT titel, interpret, jahr FROM cds WHERE id >= :id");

// Se bindea el parámetro por nombre y valor únicamente
$preparedQuery->bindValue("id", $id);

// Bindea las columnas según su posición a variables de salida
$preparedQuery->bindColumn(1, $colTitulo);
$preparedQuery->bindColumn(2, $colInterprete);
$preparedQuery->bindColumn(3, $colAnio);

// Ejecuta la consulta
$preparedQuery->execute();

// Trae el resultado mostrando la información mediante las variables de salida
while ($preparedQuery->fetch(PDO::FETCH_BOUND)) {
    echo $colTitulo . " - " . $colInterprete . " - " . $colAnio . "<br>";
}