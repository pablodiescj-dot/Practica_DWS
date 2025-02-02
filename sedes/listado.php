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
    if($privadoGestor ){header("Location: ../Principal.php");}

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de sedes</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
    <h1>Listado de sedes usando fetch (PDO::FETCH_BOUND)</h1>

    <?php
        // Realiza la conexion a la base de datos a través de una función 
        $conexion = conectarPDO($host, $user, $contrasenia, $bbdd);
        // Realiza la consulta a ejecutar en la base de datos en una variable
        $consulta = "SELECT id, nombre, direccion FROM sedes";
        // Obten el resultado de ejecutar la consulta para poder recorrerlo. El resultado es de tipo PDOStatement
        $resultado = resultadoConsulta($conexion, $consulta);
    ?>

    <table border="1" cellpadding="10">
        <thead>
            <th>Nombre</th>
            <th>Dirección</th>
    <?php
        if ($privadoAdmin || $privadoGestor ):
    ?>                    
            <th>Acción</th>
    <?php
        endif;
    ?>
        </thead>
        <tbody>
            <!-- Muestra los datos -->
    <?php         
            while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>".$registro['nombre']."</td><td>".$registro['direccion']."</td>";
                if ($privadoAdmin || $privadoGestor ){
                    echo "<td><a href='modificar.php?idSede=" . $registro["id"] . "' class='estilo_enlace'>&#9998</a>"; 
                    echo "<a href='borrar.php?idSede=". $registro["id"] . "' class='confirmacion_borrar'>&#128465</a></td>";
                }
                echo "</tr>" . PHP_EOL;
            }
    ?>

        </tbody>
    </table>
    <div class="contenedor">
        <div class="enlaces">
            <a href="../index.php">Volver a página de listados</a>&nbsp;
    <?php
        if ($privadoAdmin || $privadoGestor ){
            echo '<a href="nuevo.php">Añadir</a>&nbsp;';
            
        } 
        echo '<a href="../acceso/cerrar-sesion.php">Salir</a>';
    ?>    
        </div>
    </div>

    <?php
        // Libera el resultado y cierra la conexión
        $resultado = null;
        $conexion = null;    
    ?>
    <script type="text/javascript">    
        var elementos = document.getElementsByClassName("confirmacion_borrar");
        var confirmFunc = function (e) {
            if (!confirm('Está seguro de que desea borrar este registro?')) e.preventDefault();
        };
        for (var i = 0, l = elementos.length; i < l; i++) {
            elementos[i].addEventListener('click', confirmFunc, false);
        }
    </script>    
</body>
</html>