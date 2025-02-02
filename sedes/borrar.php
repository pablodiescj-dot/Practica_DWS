<?php
    // Incluye ficheros de variables y funciones
    require_once("../utiles/variables.php");
    require_once("../utiles/funciones.php");

    // Intentamos recuperar la sesión
    session_name("sesion-privada");
    session_start();
    $privadoAdmin=False;
    $privadoGestor=False;
    $privadoConsulta=False;
    // Comprueba si existe la sesión "email"
    if (( $_SESSION['rol'])==1) $privadoAdmin=True;
    if (( $_SESSION['rol'])==2) $privadoGestor=True;
    if (( $_SESSION['rol'])==3) $privadoConsulta=True;
    if(!$privadoAdmin){header("Location: ../Principal.php");}

    


    //Si se ha seleccionado un registro para borrar
    if (count($_REQUEST) > 0)
    {

        if (isset($_GET["idSede"]))
        {
            //Declarar la variable para la sede que tomará el valor del $_GET, conectar a la BBDD, definir la consulta a ejecutar (DELETE), 
            //preparar la consulta (bindParam) y ejecutarla
            $exito=false;
            $idSede = $_REQUEST["idSede"];
            $conexion = conectarpdo($host, $user, $contrasenia, $bbdd);
			// consulta a ejecutar
			$delete = "DELETE FROM sedes where id = ?";
			// preparar la consulta
			$consulta = $conexion->prepare($delete);			
			$consulta->bindParam(1, $idSede);
			// ejecutar la consulta 
			try {
				$consulta->execute();
				$exito = true;
			} catch (PDOException $exception) {
				$exito = false;
			}
			$consulta = null;
			$conexion = null;

            //Si todo ha ido bien, mostrar mensaje
            if ($exito) 
            {
                print "<h2>Sede eliminada con éxito.</h2>";
                header("Location: ../Principal.php");               
            } 
            //Si no ha ido bien, mostrar mensaje 
            else 
            {
                print "<h2>No se ha podido eliminar la sede.</h2>";
            }
            
            //En ambos casos, redireccionar al listado original tras 3 segundos.
            header("refresh:3;url=listado.php");
	    	exit();
        } 
        
    } 
    //Evitar que se pueda entrar directamente a la página .../borrar.php, redireccionando en tal caso a la página del listado
    else 
    {
        header("Location: listado.php");
  		exit();
    }
