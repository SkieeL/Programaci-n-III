<?php

try {
	$usuario='root';
	$clave='';
	$parametros=array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

	$conexionPDO = new PDO('mysql:host=localhost;dbname=helados;charset=utf8', $usuario, $clave, $parametros);
}
catch (PDOException $e) {
	echo "ERROR: " . $e->getMessage();
}


?>