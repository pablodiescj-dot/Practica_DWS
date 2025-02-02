# Registro de Criminales

Este proyecto es una aplicación web para la gestión de una empresa, que incluye funcionalidades para gestionar empleados, departamentos y sedes. También incluye un sistema de autenticación y recuperación de contraseñas.

## Características

- Añadir nuevos registros de empleados, departamentos y sedes.
- Buscar y listar empleados, departamentos y sedes.
- Actualizar información existente.
- Eliminar registros de empleados, departamentos y sedes.
- Sistema de autenticación de usuarios.
- Recuperación de contraseñas.

## Estructura del proyecto

- acceso.php: Maneja el inicio de sesión de los usuarios.
- cerrar-sesion.php: Maneja el cierre de sesión de los usuarios

- estilos.css: Archivo de estilos CSS para la aplicación.
- borrar.php: Permite borrar un departamento.
- listado.php: Muestra un listado de los departamentos.
- modificar.php: Permite modificar un departamento.
- nuevo.php: Permite añadir un nuevo departamento.


- borrar.php: Permite borrar un empleado.
- listado_filtrar.php: Muestra un listado de empleados con opciones de filtrado.
- listado_ordenar.php: Muestra un listado de empleados con opciones de ordenación.
- listado.php: Muestra un listado de los empleados.
- modificar.php: Permite modificar un empleado.
- nuevo.php: Permite añadir un nuevo empleado.


- cambiar_contraseña.php: Permite cambiar la contraseña de un usuario utilizando un token.
- recordar_contraseña.php: Envía un correo electrónico para recuperar la contraseña.
sedes/

- borrar.php: Permite borrar una sede.
- listado.php: Muestra un listado de las sedes.
- modificar.php: Permite modificar una sede.
- nuevo.php: Permite añadir una nueva sede.

- funciones.php: Contiene funciones de validación y de conexión a la base de datos.
- variables.php: Contiene las variables de configuración para la conexión a la base de datos.

- index.php: Página de inicio de sesión.
- Principal.php: Página principal que muestra enlaces a los listados de sedes, departamentos y empleados.
- recordar.php: Página para recordar la contraseña.

 ## Instalación
- 1.Clona el repositorio en tu máquina local.
- 2.Configura las variables de conexión a la base de datos en variables.php.
3. Importa la base de datos Aplicacion_Empresa en tu servidor MySQL.
4. Asegúrate de que tu servidor web tenga permisos para acceder a los archivos del proyecto.

 ## Uso
Accede a la página de inicio de sesión (index.php) y autentícate con tus credenciales.
Una vez autenticado, serás redirigido a la página principal (Principal.php), donde podrás acceder a los listados de sedes, departamentos y empleados.
Utiliza las opciones disponibles para añadir, modificar o borrar registros según sea necesario.

