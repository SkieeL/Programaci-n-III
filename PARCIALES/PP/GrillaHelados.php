<?php

include_once('Helado.php');

$arrayObj = Helado::TraerDeArchivo();
Helado::MostrarObjetos($arrayObj);

?>