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

$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("GET => Hola mundo!<br>");
    return $response;

})->add(function(Request $request, Response $response, $next) {
    $response->getBody()->write("Middleware sólo GET PRE<br>");

    $response = $next($request, $response);
    
    $response->getBody()->write("Middleware sólo GET AFTER<br>");

    return $response;
});

$app->add(function(Request $request, Response $response, $next) {
    $response->getBody()->write("Middleware global PRE<br>");

    $response = $next($request, $response);
    
    $response->getBody()->write("Middleware global AFTER<br>");

    return $response;
});





$app->run();