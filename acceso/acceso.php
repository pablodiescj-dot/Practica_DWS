<?php 
// Incluye ficheros de variables y funciones
require_once("../utiles/variables.php");
require_once("../utiles/funciones.php");

// Comprobamos que nos llega los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// Variables del formulario
$emailFormulario = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
$contrasenaFormulario = isset($_REQUEST['contrasena']) ? $_REQUEST['contrasena'] : null;

//Conectamos a la bbdd y hacemos un SELECT
$conexion = conectarPDO($host, $user, $contrasenia, $bbdd);
//Usamos un SELECT para traer los valores del usuario.
$select = 'SELECT email, contrasenia, rol_id FROM usuarios WHERE email = :email';
// preparamos la consulta (bindParam)
$consulta = $conexion->prepare($select);
$consulta->bindParam(':email', $emailFormulario); 
$consulta->execute();

// Comprobamos si los datos son correctos
if ($consulta->rowCount() > 0 )
{
    $registro = $consulta->fetch();
    if(password_verify($contrasenaFormulario, $registro['contrasenia'])){
        // Si son correctos, creamos la sesión
        session_name("sesion-privada");
        session_start();
        $_SESSION['email'] = $_REQUEST['email'];
        // Almacenamos el rol del usuario en la sesión
        $_SESSION['rol'] = $registro['rol_id'];
        // Redireccionamos a la página privada
        //echo "Vamos a privado";
        //header('Location: privado.php');
        header('Location: ../Principal.php');
        exit();
    }
    else {
        // Si no son correctos, informamos al usuario
        print'<p style="color: red">El email o la contraseña es incorrecta.</p>';
        header("refresh:3;url=../index.php");
        exit();
    }
}
else 
{
    // Si no son correctos, informamos al usuario
    print'<p style="color: red">El email o la contraseña es incorrecta.</p>';
    header("refresh:3;url=../index.php");
    exit();
}
}

// Comprobamos si los datos son correctos
/*
if ($baseDeDatos['email'] == $emailFormulario && password_verify($contrasenaFormulario, $baseDeDatos['password'])) {
    // Si son correctos, creamos la sesión
    session_name("sesion-privada");
    session_start();
    $_SESSION['email'] = $_REQUEST['email'];
    // Redireccionamos a la página privada
    //echo "Vamos a privado";
    header('Location: privado.php');
    exit();
    }
    else {
    // Si no son correctos, informamos al usuario
    print'<p style="color: red">El email o la contraseña es incorrecta.</p>';
    header("refresh:3;url=login.php");
	exit();
    }
}
*/
?>