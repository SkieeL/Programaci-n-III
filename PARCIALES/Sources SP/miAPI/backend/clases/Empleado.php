<?php
class Empleado
{
    public $mail;
    public $nombre;
    public $apellido;
    public $clave;
    public $legajo;
    public $perfil;
    public $id;
    public $foto;

    public function __construct($id = "", $nombre = "", $apellido = "", $email = "", $foto = "", $legajo = "", $clave = "", $perfil = "") {
        $this->apellido=$apellido;
        $this->legajo=$legajo;
        $this->perfil=$perfil;
        $this->mail=$email;
        $this->nombre=$nombre;
        $this->clave=$clave;
        $this->foto=$foto;
        $this->id=$id;
    }

    /*public function toJson() {
        return '{"nombre":"'.$this->nombre.'","apellido":"'.$this->apellido.'","email":"'.$this->mail.'","foto":"'.$this->foto.'","legajo":'.$this->legajo.',"clave":"'.$this->clave.'","perfil":"'.$this->perfil.'"}';
    }*/

    public function Agregar() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleados (nombre,apellido,mail,foto,legajo,clave,perfil) VALUES (:nombre,:apellido,:mail,:foto,:legajo,:clave,:perfil)");
        $consulta->bindValue(':mail',$this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':legajo',$this->legajo, PDO::PARAM_INT);
        $consulta->bindValue(':perfil',$this->perfil, PDO::PARAM_STR);
        $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':foto',$this->foto, PDO::PARAM_STR);
        		
        return $consulta->execute();
    }

    /*public function Borrar()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
		delete 
		from usuarios 				
		WHERE legajo=:legajo");	
        $consulta->bindValue(':legajo',$this->legajo, PDO::PARAM_STR);
		$consulta->execute();
		return $consulta->rowCount();
    }

    public function Modificar()
	{

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
			update usuarios
			set
            nombre='$this->nombre',
            apellido='$this->apellido',
            mail='$this->mail',
            nombre='$this->nombre',
			clave='$this->clave',
			WHERE legajo='$this->legajo'");
		return $consulta->execute();

    }*/

    public static function TraerTodo() {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id,nombre,apellido,mail,foto,legajo,perfil FROM empleados");
            $consulta->execute();		
            	
			return $consulta->fetchAll();		
    }

    /*public static function TraerTodo()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id,nombre,apellido,mail,foto,legajo,clave,perfil from empleados");
            $consulta->execute();
            $arrayObj = array();
            
            while($fila = $consulta->fetch()){
                $obj = new Empleado($fila[0], $fila[1], $fila[2], $fila[3], $fila[4], $fila[5], $fila[6], $fila[7]);
                array_push($arrayObj, $obj);
            }

			return $arrayObj;
    }*/
    
    public function TraerEste() {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM empleados WHERE mail = '".$this->mail."' AND clave = '".$this->clave."'");
            $consulta->execute();
            $var=$consulta->fetch(PDO::FETCH_ASSOC);

			return $var;
	}

}





?>