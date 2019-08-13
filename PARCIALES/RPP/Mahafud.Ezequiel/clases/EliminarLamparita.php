<?php

require_once('Lamparita.php');

if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    $lamparita = new Lamparita($tipo);

    $lamparas = Lamparita::TraerTodas();
    $lampara = Lamparita::BuscarEnArray($lamparas, $lamparita);

    if ($lampara) 
        echo "La lampara está en la base de datos";
    else
        echo "La lampara no está en la base de datos";
}

if (isset($_POST['tipo']) && isset($_POST['accion'])) {
    if ($_POST['accion'] == "borrar") {
        $tipo = $_POST['tipo'];
        $lamparitas = Lamparita::TraerTodas();

        foreach ($lamparitas as $l) {
            if ($l->GetTipo() == $tipo) {
                $resultado = $l->Eliminar();
                echo "Lampara eliminada exitosamente!";
                break;
            }
        }
    }
}

?>