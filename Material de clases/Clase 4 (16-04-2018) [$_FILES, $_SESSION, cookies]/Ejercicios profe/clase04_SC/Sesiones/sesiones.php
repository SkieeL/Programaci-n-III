<?php
session_start();

if(isset($_GET["op"])){

	switch($_GET["op"]){
		case "1":

			$_SESSION["clave"] = "valor";

			var_dump($_SESSION);
			
			echo '<a href="verificar_sesion.php" >Ir a otra p&aacute;gina</a><br/>';
			break;
		case "2":
			session_unset();
			echo "session_unset()<br>";			

//			session_destroy();	
//			echo "session_destroy()<br>";

			var_dump($_SESSION);			
			break;
			
	}
}
?>
<a href="../index.html" >Volver al Inicio</a>