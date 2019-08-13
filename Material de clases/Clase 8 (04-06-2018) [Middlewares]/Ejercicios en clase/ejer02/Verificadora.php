<?php

class Verificadora {
    public static function buscarUsuarioDB($nombre, $clave) {
        $conexionPDO = new PDO('mysql:host=localhost;dbname=usuarios;charset=utf8', 'root', '');

        $query = $conexionPDO->prepare('SELECT nombre, clave FROM usuarios WHERE nombre = :nombre AND clave = :clave');
        $query->execute(array("nombre" => $nombre, "clave" => $clave));

        if ($query->fetch() > 0) 
            return true;

        return false;
    }

    public static function verificarUsuario($request, $response, $next) {
        $arrayVariables = $request->getParsedBody();

        if (isset($arrayVariables['nombre']) && isset($arrayVariables['clave'])) {
            $nombre = $arrayVariables['nombre'];
            $clave = $arrayVariables['clave'];
            $retorno = Verificadora::buscarUsuarioDB($nombre, $clave);
    
            if ($retorno) {
                $response->getBody()->write("Bienvenido " . $nombre . "!<br>");
                $response = $next($request, $response);
            }
            else {
                $response->getBody()->write("Usuario no registrado!");
            }
        }
        else {
            $response->getBody()->write("Parámetros no establecidos!");
        }
    
        return $response;
    }
}