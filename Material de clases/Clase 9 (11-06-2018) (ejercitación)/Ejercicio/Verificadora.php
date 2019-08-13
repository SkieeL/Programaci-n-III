<?php

require('IMiddleware.php');
require('cd.php');

class Verificadora implements IMiddleware { 
    public static function buscarUsuarioDB($nombre, $clave) {
        $conexionPDO = new PDO('mysql:host=localhost;dbname=cdcol;charset=utf8', 'root', '');

        $query = $conexionPDO->prepare('SELECT nombre, clave FROM usuarios WHERE nombre = :nombre AND clave = :clave');
        $query->execute(array("nombre" => $nombre, "clave" => $clave));

        if ($query->fetch() > 0) 
            return true;

        return false;
    }

    public static function traerTodosCds($request, $response) {
        $conexionPDO = new PDO('mysql:host=localhost;dbname=cdcol;charset=utf8', 'root', '');
        $consulta = $conexionPDO->prepare("select id,titel as titulo, interpret as cantante,jahr as año from cds");
        $consulta->execute();			

        $todosLosCds = $consulta->fetchAll(PDO::FETCH_CLASS, "cd");
        $newResponse = $response->withJson($todosLosCds, 200);
        return $newResponse;
    }

    public function verificarUsuario($request, $response, $next) {
        if (!$request->isGet()) {
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
        }
        else {
            $response = $next($request, $response);
        }
    
        return $response;
    }
}