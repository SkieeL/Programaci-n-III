<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once 'ejer04/Verificadora.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


//*********************************************************************************************//
//INICIALIZO EL APIREST
//*********************************************************************************************//
$app = new \Slim\App(["settings" => $config]);

$app->group('/credenciales', function() {
    $this->get('[/]', function ($request, $response) {
        $response->getBody()->write("Entraste por GET!<br>");

        return $response;
    });

    $this->post('[/]', function ($request, $response) {
        $response->getBody()->write("Entraste por POST!<br>");
        
        return $response;
    });
});

$app->add(\Verificadora::class . "::verificarUsuario");

$app->run();