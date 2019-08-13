<?php 

require_once('IVendible.php');

class Helado implements IVendible {
    private $_sabor;
    private $_precio;
    private $_path;

    public function __construct($sabor, $precio) {
        $this->_sabor = $sabor;
        $this->_precio = $precio;
    }

    public function PrecioMasIva() {
        return $this->_precio * 1.21;
    }

    public function GetSabor() {
        return $this->_sabor;
    }

    public function GetPrecio() {
        return $this->_precio;
    }

    public function GetPath() {
        return $this->_path;
    }

    public function SetPath($path) {
        $this->_path = $path;
    }

    public function ToString() {
        return $this->_sabor . "-" . $this->_precio . "-" . $this->_path;
    }

    public static function RetornarArrayDeHelados() {
        $array = array();
        $array[0] = new Helado("Chocolate", 12);
        $array[1] = new Helado("Vainilla", 13);
        $array[2] = new Helado("Dulce de Leche", 14);
        $array[3] = new Helado("Americana", 15);
        $array[4] = new Helado("Frambuesa", 16);

        return $array;
    }

     public static function GuardarEnArchivo($obj) {
        // Abre el archivo en modo append y escribe el objeto en una nueva línea
        $archivo = fopen("heladosArchivo/helados.txt", "a");
        $retorno = fwrite($archivo, $obj->ToString() . chr(13) . chr(10));

        fclose($archivo);

        return $retorno;
    }

    public static function GuardarEnDB($obj) {
        require('Conexion.php');

        $query = $conexionPDO->prepare('INSERT INTO helados (sabor, precio, pathi) VALUES (:sabor, :precio, :pathi)');
        $result = $query->execute(array("sabor" => $obj->GetSabor(), "precio" => $obj->GetPrecio(), "pathi" => $obj->GetPath()));

        return $result;
    }

    public static function TraerDeArchivo() {
        // Abre el archivo en modo lectura
        $archivo = fopen("heladosArchivo/helados.txt", "r");
        $arrayObj = array();
        $i = 0;

        // Lee línea por línea separando los datos mediante un explode
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            $datos = explode("-", $linea);
        
            // Si los datos no están vacíos, crea el objeto y lo mete en el array
            if (!empty($datos[0])) {
                $arrayObj[$i] = new Helado(trim($datos[0]), trim($datos[1]));
                $arrayObj[$i]->SetPath(trim($datos[2]));
            }

            $i++;
        }
        
        fclose($archivo);

        return $arrayObj;
    }

    public static function TraerDeDB() {
        require('Conexion.php');

        $query = $conexionPDO->prepare('SELECT sabor, precio, pathi FROM helados');
        $query->execute();
        $arrayObj = array();

        while ($fila = $query->fetch()) {
            $sabor = trim($fila[0]);
            $precio = trim($fila[1]);
            $path = trim($fila[2]);

            $obj = new Helado($sabor, $precio);
            $obj->SetPath($path);

            array_push($arrayObj, $obj);
        }

        return $arrayObj;
    }

    public static function EliminarDeArchivo($obj) {
        // Trae los helados del archivo y borra el archivo viejo
        $arrayObj = Helado::TraerDeArchivo();
        unlink("heladosArchivo/helados.txt");

        // Escribe nuevamente todos los helados en el archivo a menos que sea igual al objeto que debe ser eliminado (parámetro)
        foreach ($arrayObj as $o) {
            if ($o == $obj)
                continue;

            Helado::GuardarEnArchivo($o);
        }

        // Toma el path del viejo archivo y hace un explode para conseguir la extensión
        $path = $obj->GetPath();
        $datos = explode(".", $path);
        $extension = $datos[2];

        // Mueve el archivo viejo a los archivos borrados renombrándolo
        copy($path, "heladosBorrados/" . $obj->GetSabor() . "." . "borrado" . "." . date("His") . "." . $extension);
        unlink($path);
    }

    public static function EliminarDeDB($obj) {
        require('Conexion.php');

        $query = $conexionPDO->prepare('DELETE FROM helados WHERE sabor = :sabor');
        $result = $query->execute(array("sabor" => $obj->GetSabor()));

        // Toma el path del viejo archivo y hace un explode para conseguir la extensión
        $path = $obj->GetPath();
        $datos = explode(".", $path);
        $extension = $datos[2];

        // Mueve el archivo viejo a los archivos borrados renombrándolo
        copy($path, "heladosBorrados/" . $obj->GetSabor() . "." . "borrado" . "." . date("His") . "." . $extension);
        unlink($path);
    }

    public static function BuscarEnArray($arrayObj, $obj) {
        // Verifica si un atributo del obj es igual a alguno de los del array, si coincide lo retorna
        foreach($arrayObj as $o) {
            if ($o->GetSabor() == $obj->GetSabor())
                return $o;
        }

        return false;
    } 

    public static function BuscarEnDB($obj) {
        require('Conexion.php');

        $query = $conexionPDO->prepare('SELECT sabor, precio, pathi FROM helados WHERE sabor = :sabor');
        $query->execute(array("sabor" => $obj->GetSabor()));

        if ($fila = $query->fetch()) {
            $sabor = trim($fila[0]);
            $precio = trim($fila[1]);
            $path = trim($fila[2]);

            $o = new Helado($sabor, $precio);
            $o->SetPath($path);

            return $o;
        }

        return false;
    }

    public static function ModificarEnDB($objViejo, $objNuevo) {
        require('Conexion.php');

        $query = $conexionPDO->prepare('UPDATE helados SET sabor = :saborNuevo, precio = :precio, pathi = :pathi WHERE sabor = :saborViejo');
        $result = $query->execute(array("saborNuevo" => $objNuevo->GetSabor(), "precio" => $objNuevo->GetPrecio(), "pathi" => $objNuevo->GetPath(), "saborViejo" => $objViejo->GetSabor()));

        return $result;
    }

    public static function MostrarObjetos($arrayObj) {
        echo "<table><tr><th>Sabor</th><th>Precio</th><th>Imagen</th></tr>";

        foreach($arrayObj as $obj) {
            echo "<tr><td>" . $obj->GetSabor() . "</td><td>" . $obj->GetPrecio() . "</td><td><img src=\"" . $obj->getPath() . "\" height=\"100px\"></td></tr>";
        }

        echo "</table>";
    } 
}

?>