<?php

try {
    $usuario = 'root';
    $clave = '';

    $objetoPDO = new PDO('mysql:host=localhost;dbname=cdcol;charset=utf8', $usuario, $clave);

    echo "Conectó!<br><br>";
} 
catch (PDOException $e) {
    echo "Error!!!\n" . $e->getMessage();
}

?>