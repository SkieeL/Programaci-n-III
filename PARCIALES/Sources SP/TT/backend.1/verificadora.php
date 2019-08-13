<?php
    use \Firebase\JWT\JWT as JWT;

    class Verificadora
    {
        public function AltaRegistro($request,$response)
        {
            $parametros=$request->getParsedBody();
            $nombre=$parametros['nombre'];
            $apellido=$parametros['apellido'];
            $mail=$parametros['mail'];
            $legajo=$parametros['legajo'];
            $clave=$parametros['clave'];
            $perfil=$parametros['perfil'];

            $destino = "./fotos/usuarios/" . $mail . "-" . $legajo . ".jpg";

            try
            {
                $usuario='root';
                $pass='';
                $objetoPDO = new PDO('mysql:host=localhost;dbname=parcialprog;charset=utf8', $usuario, $pass);
                $sql=$objetoPDO->prepare('INSERT INTO `empleados`(`nombre`,`apellido`,`mail`,`foto`,`legajo`,`clave`,`perfil`) VALUES (:nombre,:apellido,:mail,:foto,:legajo,:clave,:perfil)');
                
                $sql->execute(array(
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'mail' => $mail,
                    'foto' => $destino,
                    'legajo' => $legajo,
                    'clave' => $clave,
                    'perfil' => $perfil,
                    
                ));
                
                move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);
                
                return $response->withJson((["destino"=>$destino]));
            }
            catch(PDOException $e) 
            {
                return $response->withJson((["error"=>$e->getMessage()]));
            }
        }

        public function VerificarUsuario($request,$response,$next)
        {
            $parametros=$request->getParsedBody();
            $mail=$parametros['mail'];
            $clave=$parametros['clave'];
            try
            {
                $usuario='root';
                $pass='';
                $objetoPDO = new PDO('mysql:host=localhost;dbname=parcialprog;charset=utf8', $usuario, $pass);
                $sql=$objetoPDO->prepare('SELECT `mail`,`clave` FROM `empleados` WHERE `mail` = :mail AND `clave` = :clave');
                $sql->bindValue(':mail', $mail);
                $sql->bindValue(':clave', $clave);
                $sql->execute();
                $result = $sql->rowCount();
                if($result)
                {
                    $response = $next($request, $response);
                }
                else
                {
                    $objRetorno->valido=false;
                    $objRetorno->jwt="Datos de logeo incorrectos";
                    return $objRetorno;
                }
            }
            catch(PDOException $e)
            {
                echo "Error!\n" . $e->getMessage();
            }
            return $response;
        }

        public function ValidarToken($request,$response,$next)
        {
            $elToken= $request->getHeader('miToken');
            try
            {
                $jwtDecode = JWT::decode($elToken[0],'example_key',array('HS256'));
                $response = $next($request, $response);
                return $response;
            }
            catch(Exception $e)
            {
                return $response->withJson((["mensaje"=>"token invalido"]));
            }
        }

        public static function TraerLosCds($request,$response)
        {
            $arrayDeCds=array();
            try
            {
                $usuario='root';
                $pass='';
                $objetoPDO = new PDO('mysql:host=localhost;dbname=cdcol;charset=utf8', $usuario, $pass);
                //$sql=$objetoPDO->prepare('SELECT `titel`,`interpret`,`jahr`,`id` FROM `cds`');
                $sql=$objetoPDO->prepare('SELECT `titulo`,`interprete`,`anio`,`id`,`foto` FROM `discos`');
                $sql->execute();
                while($result = $sql->fetchObject())
                {
                    array_push($arrayDeCds,$result);
                }
            }
            catch(PDOException $e)
            {
                echo "Error!\n" . $e->getMessage();
            }
            return $arrayDeCds;
        }

        public static function TraerLosEmpleados($request,$response)
        {
            $arrayEmpleados=array();
            try
            {
                $usuario='root';
                $pass='';
                $objetoPDO = new PDO('mysql:host=localhost;dbname=parcialprog;charset=utf8', $usuario, $pass);
                $sql=$objetoPDO->prepare('SELECT `id`,`nombre`,`apellido`,`mail`,`foto`,`legajo`,`clave`,`perfil` FROM `empleados`');
                $sql->execute();
                while($result = $sql->fetchObject())
                {
                    array_push($arrayEmpleados,$result);
                }
            }
            catch(PDOException $e)
            {
                echo "Error!\n" . $e->getMessage();
            }
            return $arrayEmpleados;
        }

        public static function AgregarCd($request,$response)
        {
            $parametros=$request->getParsedBody();

            $titulo=$parametros['titulo'];
            $interprete=$parametros['interprete'];
            $anio=$parametros['anio'];
            
            try
            {
                $usuario='root';
                $pass='';
                $objetoPDO = new PDO('mysql:host=localhost;dbname=cdcol;charset=utf8', $usuario, $pass);
                $sql=$objetoPDO->prepare('INSERT INTO `discos`(`titulo`, `interprete`, `anio`) VALUES (:titulo, :interprete, :anio)');
                
                $sql->execute(array(
                    'titulo' => $titulo,
                    'interprete' => $interprete,
                    'anio' => $anio,
                ));
                                
                return $response;
            }
            catch(PDOException $e) 
            {
                return $response->withJson((["error"=>$e->getMessage()]));
            }
        }

        public static function EliminarCd($request,$response)
        {
            $parametros=$request->getParsedBody();
            
            $id=$parametros['id'];
            $titulo=$parametros['titulo'];
            $interprete=$parametros['interprete'];

            try
            {
                $usuario='root';
                $pass='';
                $objetoPDO = new PDO('mysql:host=localhost;dbname=cdcol;charset=utf8', $usuario, $pass);
                $sql=$objetoPDO->prepare('DELETE FROM `discos` WHERE `id`= :id');
                
                $sql->execute(array('id' => $id));
                                
                return $response->withJson((["mensaje"=>"todoOk"]));
            }
            catch(PDOException $e) 
            {
                return $response->withJson((["error"=>$e->getMessage()]));
            }
        }

        public static function ModificarCd($request,$response)
        {
            $parametros=$request->getParsedBody();
            
            $id=$parametros['id'];
            $titulo=$parametros['titulo'];
            $interprete=$parametros['interprete'];
            $anio=$parametros['anio'];

            try
            {
                $usuario='root';
                $pass='';
                $objetoPDO = new PDO('mysql:host=localhost;dbname=cdcol;charset=utf8', $usuario, $pass);
                $sql=$objetoPDO->prepare('UPDATE `discos` SET `titulo`=:titulo,`interprete`=:interprete,`anio`=:anio WHERE `id`=:id');
                
                $sql->execute(array(
                    'titulo' => $titulo,
                    'interprete' => $interprete,
                    'anio' => $anio,
                    'id' => $id
                ));
                return $response->withJson((["mensaje"=>"todoOk"]));
            }
            catch(PDOException $e) 
            {
                return $response->withJson((["error"=>$e->getMessage()]));
            }
        }

        public function ValidarAcceso($request,$response,$next)
        {
            $elToken= $request->getHeader('miToken');
            try
            {
                $jwtDecode = JWT::decode($elToken[0],'example_key',array('HS256'));
                try
                {
                    $usuario='root';
                    $pass='';
                    $objetoPDO = new PDO('mysql:host=localhost;dbname=parcialprog;charset=utf8', $usuario, $pass);
                    $sql=$objetoPDO->prepare('SELECT `perfil` FROM `empleados` WHERE `mail` = :mail AND `clave` = :clave');
                    $sql->bindValue(':mail', $jwtDecode->mail);
                    $sql->bindValue(':clave', $jwtDecode->clave);
                    $sql->execute();
                    $result = $sql->rowCount();
                    if($result)
                    {
                        $objeto=$sql->fetchObject();
                        if ($objeto->perfil ==="Admin") 
                        {
                            $response = $next($request, $response);
                            return $response;
                        }
                    }
                    return $response->withJson((["mensaje"=>"no tiene los permisos suficientes"]));
                }
                catch(PDOException $e)
                {
                    echo "Error!\n" . $e->getMessage();
                }
            }
            catch(Exception $e)
            {
                return $response->withJson((["mensaje"=>"token invalido"]));
            }
        }
    }
    
?>