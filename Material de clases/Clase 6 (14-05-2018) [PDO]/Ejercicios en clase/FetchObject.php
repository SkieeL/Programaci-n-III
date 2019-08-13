<?php

require_once('conexion.php');
require_once('cd.php');

$sql = $objetoPDO->query("SELECT titel AS 'titulo', interpret AS 'interprete', jahr AS 'anio' FROM cds");

while ($fila = $sql->fetchObject("cd")) {
    echo "**" . $fila->mostrarDatos() . "**<br>";
}

?>