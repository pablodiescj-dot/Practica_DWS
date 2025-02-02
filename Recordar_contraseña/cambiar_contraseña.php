<?php
// Incluye ficheros de variables y funciones
require_once("../utiles/variables.php");
require_once("../utiles/funciones.php");

// Verifica si se ha proporcionado un token
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Conecta a la base de datos
    $conexion = conectarPDO($host, $user, $contrasenia, $bbdd);

    // Verifica si el token es válido
    $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE token = :token");
    $consulta->bindParam(':token', $token);
    $consulta->execute();
    $resultado = $consulta->fetch();

    if ($resultado) {
        // Si el token es válido, muestra el formulario para cambiar la contraseña
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nuevaContrasena = $_POST['nueva_contrasena'];
            $confirmarContrasena = $_POST['confirmar_contrasena'];

            // Validar que las contraseñas coincidan
            if ($nuevaContrasena === $confirmarContrasena) {
                // Hashear la nueva contraseña
                $contrasenaHash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

                // Generar un nuevo token seguro
                $nuevoToken = bin2hex(openssl_random_pseudo_bytes(16));

                // Actualizar la contraseña y el token en la base de datos
                $actualizar = $conexion->prepare("UPDATE usuarios SET contrasenia = :passwordd, token = :nuevoToken WHERE token = :token");
                $actualizar->bindParam(':passwordd', $contrasenaHash);
                $actualizar->bindParam(':nuevoToken', $nuevoToken);
                $actualizar->bindParam(':token', $token);
                $actualizar->execute();

                echo "<p style='color: green;'>La contraseña ha sido actualizada con éxito.</p>";
            } else {
                echo "<p style='color: red;'>Las contraseñas no coinciden. Inténtalo de nuevo.</p>";
            }
        } else {
            // Muestra el formulario para cambiar la contraseña
            ?>
            <h2>Cambiar Contraseña</h2>
            <form action="cambiar_contraseña.php?token=<?php echo $token; ?>" method="post">
                <p>
                    <input type="password" name="nueva_contrasena" placeholder="Nueva Contraseña" required>
                </p>
                <p>
                    <input type="password" name="confirmar_contrasena" placeholder="Confirmar Contraseña" required>
                </p>
                <p>
                    <input type="submit" value="Cambiar Contraseña">
                </p>
            </form>
            <?php
        }
    } else {
        echo "<p style='color: red;'>El token no es válido o ha expirado.</p>";
    }
} else {
    echo "<p style='color: red;'>No se ha proporcionado un token.</p>";
}
?>