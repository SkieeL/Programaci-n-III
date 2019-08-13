<?php

require_once('Helado.php');

if (isset($_GET['sabor'])) {
    $sabor = $_GET['sabor'];
    $helado = new Helado($sabor, 0);

    $helados = Helado::TraerDeArchivo();
    $helado = Helado::BuscarEnArray($helados, $helado);

    if ($helado) 
        echo "El helado está en el archivo";
    else
        echo "El helado no está en el archivo";
}

if (isset($_POST['sabor']) && isset($_POST['queDeboHacer'])) {
    if ($_POST['queDeboHacer'] == "borrar") {
        $sabor = $_POST['sabor'];
        $helados = Helado::TraerDeArchivo();

        foreach ($helados as $h) {
            if ($h->GetSabor() == $sabor) {
                $resultado = Helado::EliminarDeArchivo($h);
                echo "Objeto eliminado exitosamente!";
                break;
            }
        }
    }
}

?>