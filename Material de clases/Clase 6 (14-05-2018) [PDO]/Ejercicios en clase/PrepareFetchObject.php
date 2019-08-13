<?php

require_once('conexion.php');
require_once('cd.php');

$id = $_GET['id'];

// Prepara la consulta
$preparedQuery = $objetoPDO->prepare("SELECT titel AS titulo, interpret AS interprete, jahr AS anio FROM cds WHERE id = :id");

// Se bindea el parámetro por nombre y valor únicamente
$preparedQuery->bindValue("id", $id);

// Setea el modo para traer la información como objeto de la clase "cd"
$preparedQuery->SetFetchMode(PDO::FETCH_INTO, new cd);

// Ejecuta la consulta
$preparedQuery->execute();

// Trae el resultado como tipo Obj de la clase seteada en el Mode
while ($obj = $preparedQuery->fetch()) {
    echo $obj->mostrarDatos() . "<br>";
}

?>