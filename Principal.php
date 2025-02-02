<?php
    // Incluye ficheros de variables y funciones
    require_once("utiles/variables.php");
    require_once("utiles/funciones.php");

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresa</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>
    <h1>Listados</h1>
    <div class="contenedor">
        <div class="enlaces">
            <!-- Poner enlace a listado de sedes -->
            <?php if ($privadoAdmin || $privadoConsulta): ?>
                <a href="sedes/listado.php">Listado de sedes</a>
            <?php endif; ?>
        </div>
        <div class="enlaces">
            <!-- Poner enlace a listado de departamentos -->
            <?php if ($privadoAdmin || $privadoConsulta): ?>
                <a href="departamentos/listado.php">Listado de departamentos</a>
            <?php endif; ?>
        </div>
        <div class="enlaces">
            <!-- Poner enlace a Listado de empleados -->
            <?php if ($privadoAdmin || $privadoGestor || $privadoConsulta): ?>
                <a href="empleados/listado.php">Listado de empleados</a>
            <?php endif; ?>
        </div>
    </div>
    <hr>
    <!-- Ampliación -->
    <div class="contenedor">
        <div class="enlaces">
            <!-- Poner enlace a Listado de empleado con ordenación -->
            <?php if ($privadoAdmin || $privadoGestor || $privadoConsulta): ?>
                <a href="empleados/listado_ordenar.php">Listado de empleados con ordenación</a>
            <?php endif; ?>
        </div>
        <div class="enlaces">
            <!-- Poner enlace a Listado de empleado con filtros (número de hijos y salario) -->
            <?php if ($privadoAdmin || $privadoGestor || $privadoConsulta): ?>
                <a href="empleados/listado_filtrar.php">Listado de empleados con filtros por números de hijos y salario</a>
            <?php endif; ?>
        </div>
    </div>
    <hr>
    <?php echo '<a href="../acceso/cerrar-sesion.php">Salir</a>'; ?>
</body>
</html>