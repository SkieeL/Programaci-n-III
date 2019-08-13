<?php

require_once('Lamparita.php');

if (isset($_GET['tipo']) && isset($_GET['color'])) {
    $tipo = $_GET['tipo'];
    $color = $_GET['color'];

    $arrayLamparitas = Lamparita::TraerTodas();
    $encontro = false;

    foreach ($arrayLamparitas as $lamparita) {
        if ($lamparita->GetTipo() == $tipo && $lamparita->GetColor() == $color) {
            $resultado = $lamparita->ToString() . "-Precio mas IVA: " . $lamparita->PrecioConIva();
            $encontro = true;
            break;
        }
        else if ($lamparita->GetTipo() == $tipo) {
            $resultado = "La lamparita no coincide con el color<br>";
            $encontro = true;
        }
        else if ($lamparita->GetColor() == $color) {
            $resultado = "La lamparita no coincide con el tipo<br>";
            $encontro = true;
        }
    }

    if (!$encontro) {
        $resultado = "No se encontró la lamparita en la base de datos.";
    }

    echo $resultado;
}

?>