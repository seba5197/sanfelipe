<?php

include_once '../config/config.php';
validarURL();
if (isset($_GET['opcion'])) {
    $opcion = $_GET['opcion'];
    $idAlumno = $_GET['id'];

    if ($opcion == 'editar') {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $rut = $_POST['rut'];
        $fechaNacimiento = $_POST['fecha_nacimiento'];
        // Lógica para editar el alumno
        editarAlumno($idAlumno,$nombre,$apellidos, $rut, $fechaNacimiento);
        //header('Location: ' . $_SERVER['HTTP_REFERER']);

        exit();
        } elseif ($opcion == 'eliminar') {
       // Lógica para eliminar el alumno
        eliminarAlumno($idAlumno);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();

 
        echo "alumno eliminado";
    }
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $rut = $_POST['rut'];
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    // Llamar a la función de crear alumno
    $mensaje = crearAlumno($nombre, $apellidos, $rut, $fechaNacimiento);

    // Mostrar el mensaje de éxito o error
    echo $mensaje;
    eliminarAlumno($idAlumno);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();

}


?>