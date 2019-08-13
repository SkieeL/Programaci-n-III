<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT as JWT;

require 'vendor/autoload.php';
require 'verificadora.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->group('/login', function (){
    $this->post('/email/clave/', function (Request $request, Response $response) {   
        $params=$request->getParsedBody();
        $key = "example_key";
        $fecha = time();
        $payload=array(
            "mail"=> $params['mail'],
            "clave"=> $params['clave'],
            "iat"=> $fecha,
            "exp"=> $fecha+10000
        );
        $jwt = JWT::encode($payload, $key);
        $objRetorno = new stdClass();
        $objRetorno->valido=true;
        $objRetorno->jwt=$jwt;
        return json_encode($objRetorno);
    })->add(\Verificadora::class.':VerificarUsuario');
});

$app->group('/empleados', function (){
    $this->post('/alta', function (Request $request, Response $response) {
        Verificadora::AltaRegistro($request,$response);
    });
});

$app->group('/acciones', function (){
    $this->get('/cosas', function (Request $request, Response $response, array $args){
        $listaCds=Verificadora::TraerLosCds($request,$response);
        return json_encode($listaCds);
    });
    $this->post('/add', function (Request $request, Response $response, array $args){
        return Verificadora::AgregarCd($request,$response);
    });
    $this->delete('/delete', function (Request $request, Response $response, array $args){
        return Verificadora::EliminarCd($request,$response);
    })->add(\Verificadora::class.':ValidarAcceso');
    $this->put('/modify', function (Request $request, Response $response, array $args){
        return Verificadora::ModificarCd($request,$response);
    })->add(\Verificadora::class.':ValidarAcceso');
})->add(\Verificadora::class.':ValidarToken');

$app->group('/lista', function (){
    $this->get('[/]', function (Request $request, Response $response) {
        $listaEmpleados = Verificadora::TraerLosEmpleados($request,$response);
        return json_encode($listaEmpleados);
    });
})->add(\Verificadora::class.':ValidarToken');


$app->run();

?>