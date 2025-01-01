<?php

include_once '../config/config.php';

if (isset($_GET['opcion'])) {
    $opcion = $_GET['opcion'];
    $idSala = $_GET['id_sala'];
    
   if ($opcion == 'editar') {
$sala=obtenerSalaPorId($idSala);
$url = protegerURL("../controladores/salas.php?opcion=actualizacion");
$formulario = '
<div class="fullscreen-container">
    <form class="login-form" action="' . htmlspecialchars($url) . '" method="post">
        <h2 class="text-center">Editar Sala</h2>
        
        <!-- Campo oculto para el id_salas -->
        <input type="hidden" name="id_sala" value="' . htmlspecialchars($sala['id_salas']) . '">
        
        <div class="form-group">
            Nombre
            <input type="text" class="form-control" name="nombre_sala" value="' . htmlspecialchars($sala['sala']) . '" placeholder="Nombre de la sala" required>
        </div>
        <div class="form-group">
            Capacidad
            <input type="number" class="form-control" name="capacidad" value="' . htmlspecialchars($sala['capacidad']) . '" placeholder="Capacidad de la sala" required>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">Guardar Sala</button>
        </div>
    </form>
</div>';


      web($formulario);
        exit();
    }elseif ($opcion == 'eliminar') {
        // Lógica para eliminar la asignatura
        eliminarSala($idSala);  
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }else if($opcion=="actualizacion"){
        $id_sala= $_POST['id_sala'];
        $sala = $_POST['nombre_sala'];
        $capacidad = $_POST['capacidad'];
        $mensaje = editarSala($id_sala,$sala,$capacidad);
        header('Location: ../public/crearsalas.php' );

    }else if($opcion=="crearsala"){


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Recibir los datos del formulario
    $sala = $_POST['nombre_sala'];
    $capacidad = $_POST['capacidad'];
    // Llamar a la función para crear curso
    $mensaje = crearSala($sala,$capacidad);

    // Mostrar el mensaje de éxito o error
    echo $mensaje;
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

    }

}



?>