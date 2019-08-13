<?php

require_once('IVendible.php');

class Lamparita implements IVendible {
    private $_tipo;
    private $_precio;
    private $_color;
    private $_pathFoto;

    public function __construct($tipo = "", $precio = 0, $color = "", $pathFoto = "") {
        $this->_tipo = $tipo;
        $this->_precio = $precio;
        $this->_color = $color;
        $this->_pathFoto = $pathFoto;
    }

    public function GetColor() {
        return $this->_color;
    }

    public function GetTipo() {
        return $this->_tipo;
    }

    public function GetPrecio() {
        return $this->_precio;
    }

    public function GetPath() {
        return $this->_pathFoto;
    }

    public function PrecioConIva() {
        return $this->_precio * 1.21;
    }

    public function ToString() {
        return $this->_tipo . "-" . $this->_precio . "-" . $this->_color . "-" . $this->_pathFoto;
    }

    public function Agregar() {    
        $conexionPDO = new PDO('mysql:host=localhost;dbname=lamparitas_bd;charset=utf8', 'root', '');

        $query = $conexionPDO->prepare('INSERT INTO lamparitas (tipo, color, precio, path) VALUES (:tipo, :color, :precio, :path)');
        $query->execute(array("tipo" => $this->_tipo, "color" => $this->_color, "precio" => $this->_precio, "path" => $this->_pathFoto));

        echo "Lamparita agregada!";
    }

    public static function GuardarEnArchivo($obj) {
        $archivo = fopen("../archivos/lamparitas_sin_foto.txt", "a");
        $retorno = fwrite($archivo, date("YmdHis") . "-" . $obj->ToString() . chr(13) . chr(10));

        fclose($archivo);

        return $retorno;
    }

    public static function TraerTodas() {
        $conexionPDO = new PDO('mysql:host=localhost;dbname=lamparitas_bd;charset=utf8', 'root', '');

        $query = $conexionPDO->prepare('SELECT tipo, color, precio, path FROM lamparitas');
        $query->execute();
        $arrayObj = array();

        while ($fila = $query->fetch()) {
            $tipo = trim($fila[0]);
            $color = trim($fila[1]);
            $precio = trim($fila[2]);
            $path = trim($fila[3]);

            $obj = new Lamparita($tipo, $precio, $color, $path);

            array_push($arrayObj, $obj);
        }

        return $arrayObj;
    }

    public static function MostrarObjetos($arrayObj) {
        echo "[";

        foreach($arrayObj as $obj) {
            echo "{ \"Tipo\" : \"" . $obj->GetTipo() . "\", \"Precio\" : " . $obj->GetPrecio() . ", \"Color\" : \"" . $obj->GetColor() . "\", \"Path\" : \"" . $obj->getPath() . "\" }";
        }

        echo "]";
    } 

    public static function BuscarEnArray($arrayObj, $obj) {
        foreach($arrayObj as $o) {
            if ($o->GetTipo() == $obj->GetTipo())
                return $o;
        }

        return false;
    } 

    public function Eliminar() {
        $conexionPDO = new PDO('mysql:host=localhost;dbname=lamparitas_bd;charset=utf8', 'root', '');

        $query = $conexionPDO->prepare('DELETE FROM lamparitas WHERE tipo = :tipo');
        $result = $query->execute(array("tipo" => $this->_tipo));

        $path = $this->_pathFoto;
        $datos = explode(".", $path);
        $extension = $datos[4];

        copy($path, "lamparitasBorradas/" . $this->_tipo . "." . "borrado" . "." . date("His") . "." . $extension);
        unlink($path);
    }

    public static function Modificar($obj) {
        $conexionPDO = new PDO('mysql:host=localhost;dbname=lamparitas_bd;charset=utf8', 'root', '');

        $query = $conexionPDO->prepare('UPDATE lamparitas SET precio = :precio, path = :path WHERE tipo = :tipo AND color = :color');
        $result = $query->execute(array("precio" => $obj->GetPrecio(), "path" => $obj->GetPath(), "tipo" => $obj->GetTipo(), "color" => $obj->GetColor()));

        $path = $obj->GetPath();
        $datos = explode(".", $path);
        $extension = $datos[4];

        copy($path, "lamparitasModificadas/" . $obj->GetTipo() . "." . $obj->GetColor() . "." . date("His") . "." . $extension);
        unlink($path);
    }
}