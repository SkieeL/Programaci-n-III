<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


//*********************************************************************************************//
//INICIALIZO EL APIREST
//*********************************************************************************************//
$app = new \Slim\App(["settings" => $config]);

$app->group('/credenciales', function() {
    $this->get('[/]', function ($request, $response) {
        $response->getBody()->write("Entraste por GET<br>");

        return $response;
    });

    $this->post('[/]', function ($request, $response) {
        $response->getBody()->write("Entraste por POST<br>");
        
        return $response;
    });
})->add(function($request, $response, $next) {
    if ($request->isGet()) {
        $response->getBody()->write("Es GET!<br>");
        $response = $next($request, $response);
    }
    else if ($request->isPost()) {
        $arrayVariables = $request->getParsedBody();

        if (isset($arrayVariables['nombre']) && isset($arrayVariables['perfil'])) {
            $nombre = $arrayVariables['nombre'];
            $perfil = $arrayVariables['perfil'];

            if ($perfil == "admin") {
                $response->getBody()->write("Bienvenido " . $nombre . "!<br>");
                $response = $next($request, $response);
            }
            else {
                $response->getBody()->write("ERROR!");
            }
        }
        else {
            $response->getBody()->write("ERROR!");
        }
    }

    return $response;
});

$app->run();