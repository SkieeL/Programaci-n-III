<?php

$consulta = $_GET['consulta'];

$dbconn = mysql_connect("localhost", "root", "");

switch ($consulta) {
    case 1:
        $query = "SELECT * FROM proveedores";
        $result = mysql_db_query("utn", $query);

        while ($row = mysql_fetch_array($result)) {
            echo "Numero: $row[0] - Nombre: $row[1] - Domicilio: " . utf8_encode($row[2]) . "- Localidad: $row[3]<br>";
        }

        break;
    case 2:
        $query = "UPDATE proveedores SET domicilio = 'C. de los Pozos 1361' WHERE nombre = 'Aguirre'";
        $result = mysql_db_query("utn", $query);

        var_dump($result);

        break;
    case 3:
        
}

?>

