<?php

require_once('Usuario.php');

use Firebase\JWT\JWT as JWT;

class MW {
    public function seteadoCorreoClave($request, $response, $next) {
        $arrayDeParametros = $request->getParsedBody();

        if (!isset($arrayDeParametros["correo"]) || !isset($arrayDeParametros["clave"])) {
            $json = '{ "Error" : "No se encuentra seteado el correo o la clave" }';
            return $response->withJson(json_decode($json), 409);
        }

        return $next($request, $response);
    }

    public static function vacioCorreoClave($request, $response, $next) {
        $arrayDeParametros = $request->getParsedBody();

        if ($arrayDeParametros["correo"] == "" || $arrayDeParametros["clave"] == "") {
            $json = '{ "Error" : "El correo o la clave se encuentra vacío" }';
            return $response->withJson(json_decode($json), 409);
        }

        return $next($request, $response);
    }

    public function existeCorreoClave($request, $response, $next) {
        $arrayDeParametros = $request->getParsedBody();
        $correo = $arrayDeParametros["correo"];
        $clave = $arrayDeParametros["clave"];

        $usuario = new Usuario("", $correo, $clave);
        $resultado = $usuario->traerEste();

        if ($resultado == FALSE) {
            $json = '{ "Error" : "El correo o la contraseña es incorrecto" }';
            return $response->withJson(json_decode($json), 409);
        }

        return $next($request, $response);
    }

    public function verificarToken($request, $response, $next) {
        $token = ($request->getHeader("token")[0]);

        try {
            $todo = JWT::decode($token, "1235", ["HS256"]);
        }
        catch(Exception $e) {
            $json = '{ "Error" : "Token inválido" }';
            return $response->withJson(json_decode($json), 409);
        }

        return $next($request, $response);
    }

    public static function verificarPropietario($request, $response, $next) {
        $token = ($request->getHeader("token")[0]);

        $data = JWT::decode($token, "1235", ["HS256"]);

        if ($data->perfil != "propietario" && $request->isDelete()) {
            $json = '{ "Error" : "Sin permisos: No es propietario" }';
            return $response->withJson(json_decode($json), 409);
        }
        else if ($data->perfil != "propietario" && $request->isPut()) {
            $request = $request->withAttribute('propietario', false);
        }
        else if ($data->perfil == "propietario") {
            $request = $request->withAttribute('propietario', true);
        }

        return $next($request, $response);
    }

    public function verificarEncargado($request, $response, $next) {
        $token = ($request->getHeader("token")[0]);

        $data = JWT::decode($token, "1235", ["HS256"]);

        if ($data->perfil != "encargado" && !($request->getAttribute('propietario'))) {
            $json = '{ "Error" : "Sin permisos: No es encargado ni propietario" }';
            return $response->withJson(json_decode($json), 409);
        }

        return $next($request, $response);
    }
}