<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once "./vendor/autoload.php";
require_once "./clases/Empleado.php";
require_once "./clases/Producto.php";

use Firebase\JWT\JWT as JWT;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new Slim\App(["settings" => $config]);

$app->post('/email/clave', function ($request, $response) {
    $arrayDeParametros = $request->getParsedBody();
    $email = $arrayDeParametros["email"];
    $clave = $arrayDeParametros["clave"];

    try {
        $empleado = new Empleado("","","",$email,"","",$clave,"");
        $usuarios=$empleado->TraerEste();

        if($usuarios > 0) {
            $json='{"valido":true,"usuario":{"nombre":"'.$usuariosObtenidos["nombre"].'","apellido":"'.$usuariosObtenidos["apellido"].'","mail":"'.$usuariosObtenidos["mail"].'","id":'.$usuariosObtenidos["id"].',"foto":"'.$usuariosObtenidos["foto"].'","legajo":'.$usuariosObtenidos["legajo"].'}}';
        
            //$array=array("valido"=>true,"usuario"=> $usuariosObtenidos/*,"exp"=>time(),"iat"=>time()*/);
            //$token=JWT::encode($array,"clave");
            return $response->withJson(json_decode($json),200);
        }

        $json='{ "valido" : false }';
        return $response->withJson(json_decode($json),200);   
    }
    catch(Exception $e) {
        throw $e;
    }
});

$app->post('[/]', function ($request, $response) 
{
    $arrayDeParametros = $request->getParsedBody();
    $nombre = $arrayDeParametros['nombre'];
    $apellido = $arrayDeParametros['apellido'];
    $email = $arrayDeParametros['mail'];
    $legajo = $arrayDeParametros['legajo'];
    $clave = $arrayDeParametros['clave'];
    $perfil = $arrayDeParametros['perfil'];

    $archivos = $request->getUploadedFiles();
    $destino = "fotos/";
    $nombreAnterior = $archivos['foto']->getClientFilename();
    $extension = explode(".", $nombreAnterior);
    $extension = array_reverse($extension);
    $foto = $destino . $legajo . "." . $extension[0];
    $archivos['foto']->moveTo($foto);

    //return $response->withJson($arrayDeParametros, 200);

    try {
        $empleado = new Empleado("", $nombre, $apellido, $email, $foto, $legajo, $clave, $perfil);

        if($empleado->Agregar() > 0) {
            $array=array("mail"=>$mail,"nombre"=> $nombre/*,"exp"=>time(),"iat"=>time()*/);
            //$token=JWT::encode($array,"clave");
            move_uploaded_file($tmp_name, $foto);
            return $response->withJson(array("TodoOK" => true), 200);
        }
        else {
            return $response->withJson(array("TodoOK" => false),200);
        }              
    }
    catch(Exception $e) {
        throw $e;
    }
});

$app->get('[/]', function ($request, $response) {
    $Empleados=Empleado::TraerTodo();
    $str="{";
    $i=0;
    foreach ($Empleados as $key) 
    {
        if($str=="{")
        {
            $str.='"'.$i.'":{"id":'.$key["id"].',"nombre":"'.$key["nombre"].'","apellido":"'.$key["apellido"].'","legajo":'.$key["legajo"].',"foto":"'.$key["foto"].'","mail":"'.$key["mail"].'","perfil":"'.$key["perfil"].'"}';
        }
        else
        {
            $str.=',"'.$i.'":{"id":'.$key["id"].',"nombre":"'.$key["nombre"].'","apellido":"'.$key["apellido"].'","legajo":'.$key["legajo"].',"foto":"'.$key["foto"].'","mail":"'.$key["mail"].'","perfil":"'.$key["perfil"].'"}';            
        }
        $i++;
        
    }
    $str.="}";
    if($str=="{}")
    {
        $str='{"Error":"Error"}';
    }
    return $response->withJson(json_decode($str),200);
});

/*$app->get('[/]', function ($request, $response) {
    $Empleados = Empleado::TraerTodo();

    $str = "[ ";

    foreach ($Empleados as $empleado)  {
        if($str != "[ ")
            $str .= ", ";

        $str .= $empleado->toJson();
    }

    $str.=" ]";

    if($str == "[  ]") {
        $str = '{ "Error" : "Error" }';
    }

    return $response->withJson(json_encode($str), 200);
});*/


$app->group('/productos', function () {
    $this->post('[/]', function ($request, $response)  {   
        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];

        try {
            $producto=new Producto("",$nombre,$precio);
            //var_dump($producto);
            if($producto->Agregar()>0) {
                return $response->withJson("Ok",200);
            }

            return $response->withJson("Error",200);            
        }
        catch(Exception $e) {
            throw $e;
        }

        return $response->withJson("Super error",200);
    });

    $this->get('[/]', function ($request, $response) {        
        $productos=Producto::TraerTodo();
        $str="{";
        $i=0;

        foreach ($productos as $key) {
            if($str=="{") {
                $str.='"'.$i.'":{"id":'.$key["id"].',"nombre":"'.$key["nombre"].'","precio":"'.$key["precio"].'"}';
            }
            else {
                $str.=',"'.$i.'":{"id":'.$key["id"].',"nombre":"'.$key["nombre"].'","precio":"'.$key["precio"].'"}';
            }
            $i++;
        }

        $str.="}";
        if($str=="{}") {
            $str='{ "Error" : true }';
        }

        return $response->withJson(json_decode($str),200);
    });

    $this->put('[/]', function ($request, $response,$arg) {   
        $nombre = ($request->getHeader("nombre")[0]);
        $precio = ($request->getHeader("precio")[0]);
        $id = ($request->getHeader("id")[0]);
        try {
            $prod=new Producto($id,$nombre,$precio);
            if($prod->Modificar()>0) {
                return $response->withJson("modificado",200);
            }

            return $response->withJson("Error",200);   
        }
        catch(Exception $e) {
            throw $e;
        }
    });

    $this->delete('[/]', function ($request, $response,$arg) {   
        $id=($request->getHeader("id")[0]);

        try {
            $prod=new Producto($id,"","");
            if($prod->Borrar()>0) {
                return $response->withJson("Eliminado",200);
            }

            return $response->withJson("Error",200);   
        }
        catch(Exception $e) {
            throw $e;
        }
    });
});
































$app->group('/usuario', function () {

    $this->post('[/]', function ($request, $response) 
    {   
        $json=$request->getParsedBody();
        try
        {
            $todo= JWT::decode($json["token"],"clave",["HS256"]);
            $var=Usuario::TraerTodo();
            
            return $response->withJson($var,200);
        }
        catch(Exception $e)
        {
            throw $e;

        }

    
    return $response;
    });

    $this->get('[/]', function ($request, $response,$arg) 
    {  
        $mail=($request->getHeader("mail")[0]);
        $clave=($request->getHeader("clave")[0]);
        $usuario=new Usuario($mail,"",$clave);
        $usuariosObtenidos=$usuario->TraerEste();
        if($usuariosObtenidos>0)
        {
            /*        PONER EL TIEMPO DE EXPIRACION      */
        $array=array("mail"=>$usuariosObtenidos["mail"],"nombre"=> $usuariosObtenidos["nombre"]/*,"exp"=>time(),"iat"=>time()*/);
                $token=JWT::encode($array,"clave");
                return $response->withJson($token,200);
        }
        else
        {
            return $response->withJson("ERROR",200);
        }  
    });

    $this->put('[/]', function ($request, $response,$arg) 
    {   
        $mail=($request->getHeader("mail")[0]);
        $clave=($request->getHeader("clave")[0]);
        $nombre=($request->getHeader("nombre")[0]);
        try
        {
            $usuario=new Usuario($mail,$nombre,$clave);
            if($usuario->Agregar()==1)
            {

                    $array=array("mail"=>$usuario->mail,"nombre"=> $usuario->nombre/*,"exp"=>time(),"iat"=>time()*/);
                    $token=JWT::encode($array,"clave");
                    return $response->withJson($token,200);
            }
            return $response->withJson("Error",200);   
        }
        catch(Exception $e)
        {
            throw $e;

        }
    });
    $this->delete('[/]', function ($request, $response,$arg) 
    {   
        $mail=($request->getHeader("mail")[0]);
        $clave=($request->getHeader("clave")[0]);
        $token=($request->getHeader("token")[0]);        
        try
        {
            $todo= JWT::decode($token,"clave",["HS256"]);
            $usuario=new Usuario($mail,"",$clave);
            if($usuario->Borrar()>0)
            {
                return $response->withJson("Borrado",200);
            }
            return $response->withJson("Error",200);   
        }
        catch(Exception $e)
        {
            throw $e;

        }
        
        
        
    });
     
});



$app->group('/videojuegos', function () {

    $this->post('[/]', function ($request, $response) 
    {   
        $json=$request->getParsedBody();

        //$titulo="",$path="",$precio=0,$empresa="",$genero=""
        $titulo=$json["titulo"];
        $path=$json["path"];
        $precio=$json["precio"];
        $genero=$json["genero"];
        $empresa=$json["empresa"];


        try
        {
            $todo= JWT::decode($json["token"],"clave",["HS256"]);
            $videojuego=new Videojuego($titulo,$path,$precio,$empresa,$genero);
            if($videojuego->Agregar()>0)
            {
                $extencion=pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);
                $tmp_name=$_FILES["foto"]["tmp_name"];

                if(($extencion!="png"&&$extencion!="jpg"&&$extencion!="jpeg") )
                {
                    return $response->withJson("Error al subir la foto",200);
                }
                else if( $_FILES["foto"]["size"]>1000000)
                {
                    return $response->withJson("Error al subir la foto",200);                    
                }
                else
                {
                     move_uploaded_file($tmp_name,$path);   
                }

                return $response->withJson("Agregado",200);
            }
            return $response->withJson("Error",200);   
        }
        catch(Exception $e)
        {
            throw $e;

        }
        /*try
        {
            $todo= JWT::decode($json["token"],"clave",["HS256"]);

            $var=Videojuego::TraerTodo();
            
            return $response->withJson($var,200);
        }
        catch(Exception $e)
        {
            throw $e;

        }*/

    
    return $response;
    });



    $this->put('[/]', function ($request, $response,$arg) 
    {   

        $token=($request->getHeader("token")[0]);
        if(isset($request->getHeader("titulo")[0]))
        {
            $titulo=$request->getHeader("titulo")[0];
        }
        try
        {

            $todo= JWT::decode($token,"clave",["HS256"]);
            if(isset($request->getHeader("titulo")[0]))
            {
                $videojuego=new Videojuego($titulo,"",0,"","");
                $var=$videojuego->TraerEste();
            }
            else
            {
                $var=Videojuego::TraerTodo();
            }
                        
            return $response->withJson($var,200);
        }
        catch(Exception $e)
        {
            throw $e;

        }
    });


    $this->post('/modificar', function ($request, $response) 
    {
        $json=$request->getParsedBody();
        $titulo=$json["titulo"];
        $path=$json["path"];
        $precio=$json["precio"];
        $genero=$json["genero"];
        $empresa=$json["empresa"];


        try
        {
            $todo= JWT::decode($json["token"],"clave",["HS256"]);
            $videojuego=new Videojuego($titulo,$path,$precio,$empresa,$genero);
            if($videojuego->Modificar()>0)
            {
                if(isset($_FILES["foto"]))
                {

                    unlink($path);

                    $extencion=pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION);
                    $tmp_name=$_FILES["foto"]["tmp_name"];

                    if(($extencion!="png"&&$extencion!="jpg"&&$extencion!="jpeg") )
                    {
                        return $response->withJson("Error",200);
                    }
                    else
                    {
                        move_uploaded_file($tmp_name,$path);   
                    }
                }
                return $response->withJson("Modificado",200);
            }
            return $response->withJson("Error",200);   
        }
        catch(Exception $e)
        {
            throw $e;

        }
        
    });

    $this->delete('[/]', function ($request, $response,$arg) 
    {   
        $titulo=($request->getHeader("titulo")[0]);
        $path=($request->getHeader("path")[0]);        
        $token=($request->getHeader("token")[0]);        
        try
        {
            $todo= JWT::decode($token,"clave",["HS256"]);
            $videojuego=new Videojuego($titulo,$path);
            if($videojuego->Borrar()>0)
            {
                unlink($path);
                return $response->withJson("Borrado",200);
            }
            return $response->withJson("Error",200);   
        }
        catch(Exception $e)
        {
            throw $e;

        }
        
        
        
    });
     
});














// lo nuevo 









































/*
$app->post('[/]', function ($request, $response) {   
    $cd=new cd();
    $json=$request->getParsedBody();
    $cd->titulo=$json["titulo"];
    $cd->cantante=$json["cantante"];
    $cd->año=$json["año"];
    try
        {
            $todo= JWT::decode($json["token"],"clave",["HS256"]);
            $response->getBody()->write("token valido");
        }
        catch(Exception $e)
        {
            throw $e;

        }

    
    $response->getBody()->write($cd->InsertarElCd());

    
    return $response;
    
});
$app->get('[/]', function (Request $request, Response $response) { 
    $header=($request->getHeader("token"));
    try
    {
        $todo= JWT::decode($header[0],"clave",["HS256"]);
    }
    catch(Exception $e)
    {
        throw $e;
    }   
    $cd=new cd();
    $todo=cd::TraerTodoLosCds();
    
    
    //$response=$response->withJson($todo, 200);
   return $response->withJson($todo, 200);
});
$app->put('[/]', function (Request $request, Response $response) { 
    $header=($request->getHeader("token"));
    try
    {
        $todo= JWT::decode($header[0],"clave",["HS256"]);
    }
    catch(Exception $e)
    {
        throw $e;
    }   
    $cd=new cd();
    $todo=cd::TraerTodoLosCds();
    
    
    //$response=$response->withJson($todo, 200);
   return $response->withJson($todo, 200);
});
$app->delete('[/]', function (Request $request, Response $response) { 
    $header=($request->getHeader("token"));
    try
    {
        $todo= JWT::decode($header[0],"clave",["HS256"]);
    }
    catch(Exception $e)
    {
        throw $e;
    }   
    $cd=new cd();
    $todo=cd::TraerTodoLosCds();
    
    
    //$response=$response->withJson($todo, 200);
   return $response->withJson($todo, 200);
});

//$app->add(\Verificadora::class."::VerificarUsuario");*/
$app->run();

?>