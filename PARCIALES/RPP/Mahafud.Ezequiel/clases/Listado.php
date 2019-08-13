<?php

require_once('Lamparita.php');

$arrayObj = Lamparita::TraerTodas();
Lamparita::MostrarObjetos($arrayObj);

?>