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
    if (count($_REQUEST) > 0) {
        if (isset($_GET["idDepartamento"])) {
            // Declarar la variable para el departamento que tomará el valor del $_GET
            $idDepartamento = $_GET["idDepartamento"];
            
            try {
                // Conectar a la BBDD
                $conexion = conectarPDO($host, $user, $contrasenia, $bbdd);
                
                // Primero, eliminar los empleados asociados al departamento
                $consultaEmpleados = "DELETE FROM empleados WHERE departamento_id = :idDepartamento";
                $stmtEmpleados = $conexion->prepare($consultaEmpleados);
                $stmtEmpleados->bindParam(':idDepartamento', $idDepartamento, PDO::PARAM_INT);
                $stmtEmpleados->execute();
    
                // Ahora, eliminar el departamento
                $consulta = "DELETE FROM departamentos WHERE id = :idDepartamento";
                $stmt = $conexion->prepare($consulta);
                $stmt->bindParam(':idDepartamento', $idDepartamento, PDO::PARAM_INT);
                $stmt->execute();
                
                // Si todo ha ido bien, mostrar mensaje
                if ($stmt->rowCount() > 0) {
                    echo "Departamento eliminado con éxito.";
                } else {
                    // Si no ha ido bien, mostrar mensaje 
                    echo "No ha sido posible eliminar el departamento.";
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