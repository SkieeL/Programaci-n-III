<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>Visor de imagenes</title>
</head>
<body>
    <center>
        <table>
            <?php 
                $archivo = fopen("archivos/imagenes.txt", "r");

                while(!feof($archivo)) {
                    $linea = fgets($archivo);
                    trim($linea);

                    if ($linea != "") {
                        echo "<tr><td><img src=\"archivos/" . $linea . "\" width=\"100px\" /><a href='zoom.php?img=". $linea . "'>Ver</a></td></tr>";
                    }
                }

                fclose($archivo);
            ?>
        </table>
    </center>
</body>
</html>