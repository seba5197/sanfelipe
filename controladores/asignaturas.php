<?php

include_once '../config/config.php';
validarURL();
if (isset($_GET['opcion'])) {
    $opcion = $_GET['opcion'];
    $idAsignatura = $_GET['id'];

    if ($opcion == 'editar') {
     
        
        $asignatura = $_POST['asignatura'];

         if($asignatura=="" ||  $asignatura == null){

            //aqui va el formulario
      
$nombreactual=obtenerAsignaturaPorId($idAsignatura);

            $formulario=' <div class="fullscreen-container">
            <form class="login-form"  action="" method="post">
                 <input type="hidden" name="idAsignatura" value="' . htmlspecialchars($idAsignatura) . '">
                <label for="asignatura">Editar nombre de la asignatura: <b>'. $nombreactual.'</b></label>
                <input type="text" id="asignatura" name="asignatura" placeholder="Colocar nuevo nombre"required>
                <button type="submit" class="btn btn-success">Guardar</button></p>
            </form>
        </div>';

            web($formulario);
            die( );

         }
        // Lógica para editar la asignatura
        editarAsignatura($idAsignatura, $asignatura);
        header('Location:  ../public/crearasignaturas.php');
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
    $asignatura = $_POST['asignatura'];
    // Llamar a la función para crear la asignatura
    $mensaje = crearAsignatura($asignatura);

    // Mostrar el mensaje de éxito o error
    echo $mensaje;
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>