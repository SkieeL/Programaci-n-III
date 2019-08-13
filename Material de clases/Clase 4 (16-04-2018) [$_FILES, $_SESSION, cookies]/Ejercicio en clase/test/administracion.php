<?php

$nombreArchivo = $_FILES["archivo"]["name"];

$extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

if ($extension != "jpg" && $extension != "jpeg" && $extension != "png") {
    echo "Quién te conoce extensión? La extensión del archivo es invalida papá!";
    die();
}
else {
    $nombre = date("Y_m_d_H_i_s");
    move_uploaded_file($_FILES["archivo"]["tmp_name"], "archivos/" . $nombre . "." . $extension);

    $archivo = fopen("archivos/imagenes.txt", "a");
    fwrite($archivo, $nombre . "." . $extension . "\r\n");

    fclose($archivo);

    require_once('visor.php');
    echo "<center>Imagen cargada correctamente!</center>";
}

?>