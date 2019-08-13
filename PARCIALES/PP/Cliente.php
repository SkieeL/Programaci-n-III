<?php

class Cliente {
    private $_nombre;
    private $_correo;
    private $_clave;

    public function __construct($nombre, $correo, $clave) {
        $this->_nombre = $nombre;
        $this->_correo = $correo;
        $this->_clave = $clave;
    }

    public function ToString() {
        return $this->_nombre . "-" . $this->_correo . "-" . $this->_clave;
    }

    public static function GuardarEnArchivo($cliente) {
        $archivo = fopen("clientes/clientesActuales.txt", "a");
        $retorno = fwrite($archivo, $cliente->ToString() . chr(13) . chr(10));

        fclose($archivo);

        return $retorno;
    }

    public function ValidarCliente() {
        $archivo = fopen("clientes/clientesActuales.txt", "r");

        while (!feof($archivo)) {
            $linea = fgets($archivo);
            $datos = explode("-", $linea);

            if (!empty($datos[0])) {
                if (trim($datos[1]) == $this->_correo && trim($datos[2]) == $this->_clave) {
                    fclose($archivo);
                    return true;
                }
            }
        }

        fclose($archivo);

        return false;
    }
}

?>