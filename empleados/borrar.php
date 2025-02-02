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
    if($privadoConsulta){header("Location: ../Principal.php");}

    //Si se ha seleccionado un registro para borrar
    if (count($_REQUEST) > 0) {
        if (isset($_GET["idEmpleado"])) {
            // Declarar la variable para el empleado que tomará el valor del $_GET
            $idEmpleado = $_GET["idEmpleado"];
            
            try {
                // Conectar a la BBDD
                $conexion = conectarPDO($host, $user, $contrasenia, $bbdd);
                
                // Consulta para eliminar el empleado
                $consulta = "DELETE FROM empleados WHERE id = :idEmpleado";
                $stmt = $conexion->prepare($consulta);
                $stmt->bindParam(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
                $stmt->execute();
                
                // Si todo ha ido bien, mostrar mensaje
                if ($stmt->rowCount() > 0) {
                    echo "Empleado eliminado con éxito.";
                } else {
                    // Si no ha ido bien, mostrar mensaje 
                    echo "No ha sido posible eliminar el empleado.";
                }
            } catch (PDOException $e) {
                // Manejo de error si la consulta falla
                echo "Error al eliminar: " . $e->getMessage();
            } finally {
                // Cerrar la conexión si fue exitosa
                if (isset($conexion)) {
                    $conexion = null;
                }
            }
            
            // Redireccionar al listado original tras 3 segundos.
            header("refresh:3;url=listado.php");
            exit;
        }
    } else {
        // Evitar que se pueda entrar directamente a la página .../borrar.php, redireccionando en tal caso a la página del listado
        header("Location: listado.php");
        exit;
    }
    ?>