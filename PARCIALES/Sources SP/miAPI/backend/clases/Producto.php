<?php

include_once "AccesoDatos.php";

class Producto {
    public $nombre;
    public $precio;
    public $id;

    public function __construct($id = "", $nombre = "", $precio = "") {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->id = $id;
    }

    public function Agregar() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into productos (nombre,precio)values(:nombre,:precio)");
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        		
        return $consulta->execute();
    }

    public function Borrar() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM productos WHERE id = :id");	
        $consulta->bindValue(':id', $this->id, PDO::PARAM_STR);
        $consulta->execute();
        
		return $consulta->rowCount();
    }

    public function Modificar() {
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE productos SET precio = '$this->precio', nombre = '$this->nombre' WHERE id= $this->id");
        
		return $consulta->execute();
    }
    public static function TraerTodo() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM productos");
        $consulta->execute();
                
        return $consulta->fetchAll(PDO::FETCH_ASSOC);		
    }
    
    public function TraerEste() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT FROM productos WHERE nombre = '".$this->nombre."'");
        $consulta->execute();
                
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>