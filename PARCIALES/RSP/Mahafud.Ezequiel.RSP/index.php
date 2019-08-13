<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once "./vendor/autoload.php";
require_once "./clases/Usuario.php";
require_once "./clases/MW.php";
require_once "./clases/Media.php";

use Firebase\JWT\JWT as JWT;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new Slim\App(["settings" => $config]);

$app->post('[/]', \Media::class . '::cargarMedia');

$app->get('/medias[/]', \Media::class . '::traerMedias');

$app->post('/usuarios[/]', \Usuario::class . '::cargarUsuario');

$app->get('[/]', \Usuario::class . '::traerUsuarios');

$app->post('/login[/]', \Usuario::class . '::crearToken')->add(\MW::class . ':existeCorreoClave')->add(\MW::class . '::vacioCorreoClave')->add(\MW::class . ':seteadoCorreoClave');

$app->get('/login[/]', \Usuario::class . '::verificarToken');

$app->delete('[/]', \Media::class . '::borrarMedia')->add(\MW::class . '::verificarPropietario')->add(\MW::class . ':verificarToken');

$app->put('[/]', \Media::class . '::modificarMedia')->add(\MW::class . ':verificarEncargado')->add(\MW::class . '::verificarPropietario')->add(\MW::class . ':verificarToken');

$app->get('/listados[/]', \Media::class . '::traerMedias');

$app->run();

?>