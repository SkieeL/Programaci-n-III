<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once 'Verificadora.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

//*********************************************************************************************//
//INICIALIZO EL APIREST
//*********************************************************************************************//
$app = new \Slim\App(["settings" => $config]);

$app->get('[/]', function ($request, $response, $next) {
    $response->getBody()->write('Entraste por GET!');
})->add(\Verificadora::class . ":traerTodosCds");

$app->post('[/]', function ($request, $response, $next) {
    $response->getBody()->write('Entraste por POST!');
});

$app->put('[/]', function ($request, $response, $next) {
    $response->getBody()->write('Entraste por PUT!');
});

$app->delete('[/]', function ($request, $response, $next) {
    $response->getBody()->write('Entraste por DELETE!');
});

$app->add(\Verificadora::class . ":verificarUsuario");

$app->run();