<?php
include_once '../config/config.php';
$titulo = ""; // Variable para almacenar el título
// Verificar si se pasa el parámetro 'opcion' en la URL 

if (isset($_GET['opcion'])) {
    $opcion = $_GET['opcion'];
validarURL();
    // Validar si la opción es 'primeruso'
    if ($opcion === 'primeruso') {
        $url=protegerURL("../controladores/usuarios.php");
        $titulo = "<b><center>Configuración Inicial:<br> Crear Usuario Administrador<hr></center></b>";
       
    } else  if ($opcion === 'docente') {
        validasesion();
        $url=protegerURL("../controladores/usuarios.php?rol=docente");
        // Opcional: manejar otras opciones o mostrar un mensaje predeterminado
        $titulo = "<center><b>Crear docente</b></center>";
       
    }
}
$formulario = '
<div class="fullscreen-container d-flex justify-content-center align-items-center" style="height: 100vh; background-color: #f8f9fa;">

    <form class="card p-4 shadow-sm" style="width: 100%; max-width: 400px;" action="'.$url.'" method="post">
        <div class="form-group mb-3">
       '. $titulo.' <hr>
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el nombre" required>
        </div>
        <div class="form-group mb-3">
            <label for="apellido" class="form-label">Apellido:</label>
            <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Ingrese el apellido" required>
        </div>
        <div class="form-group mb-3">
            <label for="correo" class="form-label">Correo:</label>
            <input type="email" id="correo" name="correo" class="form-control" placeholder="Ingrese el correo" required>
        </div>
        <div class="form-group mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Ingrese el teléfono" required>
        </div>
        <div class="form-group mb-3">
            <label for="pass" class="form-label">Contraseña:</label>
            <input type="password" id="pass" name="pass" class="form-control" placeholder="Ingrese la contraseña" required>
        </div>
        <div class="form-group mb-3">
            <label for="rut" class="form-label">RUT:</label>
            <input type="text" id="rut" name="rut" class="form-control" placeholder="Ingrese el RUT" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Crear Usuario</button>
    </form>
</div>';




//generamos web
if (isset($_GET['opcion'])) {
    $opcion = $_GET['opcion'];

    // Validar si la opción es 'primeruso'
    if ($opcion === 'primeruso') {
       
        web($formulario);
    } else  if ($opcion === 'docente') {
       
        web($formulario);
    }
}

?>