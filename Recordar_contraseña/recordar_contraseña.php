<?php
// Verifica si se ha enviado un correo electrónico
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Conecta a la base de datos
    require_once("../utiles/variables.php");
    require_once("../utiles/funciones.php");
    $conexion = conectarPDO($host, $user, $contrasenia, $bbdd);

    // Verifica si el correo electrónico existe en la base de datos
    $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE email = :email");
    $consulta->bindParam(':email', $email);
    $consulta->execute();
    $resultado = $consulta->fetch();

    if ($resultado) {
        // Genera un token seguro
        $tokenSeguro = bin2hex(openssl_random_pseudo_bytes(16));

        // Actualiza el token en la base de datos
        $actualizar = $conexion->prepare("UPDATE usuarios SET token = :token WHERE email = :email");
        $actualizar->bindParam(':token', $tokenSeguro);
        $actualizar->bindParam(':email', $email);
        $actualizar->execute();

        // Nuestro mensaje en HTML
        $mensaje = "
        <html>
        <head>
        <title>Recupera la contraseña</title>
        </head>
        <body>
        <a href=\"http://localhost:3000/Recordar_contrase%C3%B1a/cambiar_contrase%C3%B1a.php?token=$tokenSeguro\">Pulsa aquí para cambiarla</a>
        </body>
        </html>
        ";

        // Cabeceras. Y la dirección del emisor.
        $headers = [
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=utf-8',
            'From' => 'dwes@php.com'
        ];

        // Lo enviamos
        if (mail($email, 'Recuperar contraseña', $mensaje, $headers)) {
            echo "<p style='color: green;'>Se ha enviado un correo con las instrucciones para recuperar tu contraseña.</p>";
        } else {
            echo "<p style='color: red;'>Hubo un error al enviar el correo. Inténtalo de nuevo.</p>";
        }
    } else {
        echo "<p style='color: red;'>El correo electrónico no existe en nuestra base de datos.</p>";
    }
} else {
    // Si no se ha enviado un correo, muestra el formulario para ingresar el correo
    ?>
    <h2>Recuperar Contraseña</h2>
    <form action="recordar_contraseña.php" method="post">
        <p>
            <input type="email" name="email" placeholder="Email" required> 
        </p>
        <p>
            <input type="submit" value="Enviar"> 
        </p>
    </form>
    <?php
}
?>