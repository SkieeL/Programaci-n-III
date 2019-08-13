<?php

require_once('AccesoDatos.php');

class Media {
    public $id;
    public $color;
    public $marca;
    public $precio;
    public $talle;

    public function __construct($id = "", $color = "", $marca = "", $precio = "", $talle = "") {
        $this->id = $id;
        $this->color = $color;
        $this->marca = $marca;
        $this->precio = $precio;
        $this->talle = $talle;
    }

    public function toJson() {
        return '{"id":"'.$this->id.'","color":"'.$this->color.'","marca":"'.$this->marca.'","precio":'.$this->precio.',"talle":"'.$this->talle.'"}';
    }

    public static function cargarMedia($request, $response) {
        $arrayDeParametros = $request->getParsedBody();
        $color = $arrayDeParametros["color"];
        $marca = $arrayDeParametros["marca"];
        $precio = $arrayDeParametros["precio"];
        $talle = $arrayDeParametros["talle"];
    
        $media = new Media("", $color, $marca, $precio, $talle);
        $respuesta = $media->Agregar();
    
        if ($respuesta) {
            $json = '{ "status" : "Registro insertado exitosamente" }';
            $codigo = 200;
        }
        else {
            $json = '{ "status" : "Error, no se pudo ingresar el registro en la base de datos" }';
            $codigo = 409;
        }
            
        return $response->withJson(json_decode($json), $codigo);
    }

    public static function traerMedias($request, $response) {
        $medias = Media::TraerTodoObj();
    
        $str = "[ ";
    
        foreach ($medias as $media)  {
            if($str != "[ ")
                $str .= ", ";
    
            $str .= $media->toJson();
        }
    
        $str.=" ]";
    
        if($str == "[  ]") {
            $str = '{ "status" : "Error" }';
        }
    
        return $response->withJson(json_decode($str), 200);
    }

    public static function borrarMedia($request, $response) {
        $id = ($request->getHeader("id")[0]);
    
        $media = new Media($id);
        $respuesta = $media->Borrar();
    
        if ($respuesta) {
            $json = '{ "status" : "Registro eliminado exitosamente" }';
            $codigo = 200;
        }
            
        else {
            $json = '{ "status" : "Error, no se pudo eliminar el registro en la base de datos" }';
            $codigo = 409;
        }
            
        return $response->withJson(json_decode($json), $codigo);
    }

    public static function modificarMedia($request, $response) {
        $arrayDeParametros = $request->getParsedBody();
        $id = ($request->getHeader("id")[0]);
        $color = ($request->getHeader("color")[0]);
        $marca = ($request->getHeader("marca")[0]);
        $precio = ($request->getHeader("precio")[0]);
        $talle = ($request->getHeader("talle")[0]);
    
        $media = new Media($id, $color, $marca, $precio, $talle);
        $respuesta = $media->Modificar();
    
        if ($respuesta) {
            $json = '{ "status" : "Registro modificado exitosamente" }';
            $codigo = 200;
        }
            
        else {
            $json = '{ "status" : "Error, no se pudo modificar el registro en la base de datos" }';
            $codigo = 409;
        }
            
        return $response->withJson(json_decode($json), $codigo);
    }

    public function Agregar() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO medias (color, marca, precio, talle) VALUES (:color, :marca, :precio, :talle)");
        $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':talle', $this->talle, PDO::PARAM_STR);
        		
        return $consulta->execute();
    }

    public function Borrar() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM medias WHERE id = :id"); 
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();
        
		return $consulta->rowCount();
    }

    public function Modificar() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE medias SET color = :color, marca = :marca, precio = :precio, talle = :talle WHERE id = :id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':talle', $this->talle, PDO::PARAM_STR);
        		
        return $consulta->execute();
    }

    public function TraerEste() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM medias WHERE color = :color AND marca = :marca AND talle = :talle");
        $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(':talle', $this->talle, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function TraerEsteObj() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM medias WHERE color = :color AND marca = :marca AND talle = :talle");
        $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(':talle', $this->talle, PDO::PARAM_STR);
        $consulta->execute();
        $obj = NULL;

        while($fila = $consulta->fetch()){
            $obj = new Media($fila[0], $fila[1], $fila[2], $fila[3], $fila[4]);
        }

        return $obj;
    }

    public static function TraerTodo() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM medias");
        $consulta->execute();

        return $consulta->fetchAll();
    }

    public static function TraerTodoObj() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM medias");
        $consulta->execute();
        $arrayObj = array();
        
        while($fila = $consulta->fetch()){
            $obj = new Media($fila[0], $fila[1], $fila[2], $fila[3], $fila[4]);
            array_push($arrayObj, $obj);
        }

        return $arrayObj;
    }
}