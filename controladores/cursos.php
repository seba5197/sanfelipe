<?php

include_once '../config/config.php';

if (isset($_GET['opcion'])) {
    $opcion = $_GET['opcion'];
    $idAsignatura = $_GET['id'];

    if ($opcion == 'editar') {
        echo "editar";
        
        $asignatura = $_POST['curso'];
        // Lógica para editar la asignatura
        editarAsignatura($idAsignatura, $asignatura);
       // header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();

    } elseif ($opcion == 'eliminar') {
        // Lógica para eliminar la asignatura
        eliminarAsignatura($idAsignatura);  
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Recibir los datos del formulario
    $curso = $_POST['curso'];
    $nivel = $_POST['nivel'];
    // Llamar a la función para crear curso
    $mensaje = crearCurso($curso,$nivel);

    // Mostrar el mensaje de éxito o error
    echo $mensaje;
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>