<?php

include_once '../config/config.php';
validarURL();
if (isset($_GET['opcion'])) {
    $opcion = $_GET['opcion'];
    $idAlumno = $_GET['id'];

    if ($opcion == 'actualizaralumno') {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $rut = $_POST['rut'];
        $fechaNacimiento = $_POST['fecha_nacimiento'];
        // Lógica para editar el alumno
        editarAlumno($idAlumno,$nombre,$apellidos, $rut, $fechaNacimiento);
        header('Location: ../public/crearalumnos.php' );

        exit();
        } elseif ($opcion == 'eliminar') {
       // Lógica para eliminar el alumno
        eliminarAlumno($idAlumno);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();

 
        echo "alumno eliminado";
    }else if($opcion=="editar"){
        $id=$_GET['id'];
        $alumno=obtenerAlumnoPorId($id);
        $nombre=$alumno['nombre'];
        $apellidos=$alumno['apellidos'];
        $rut=$alumno['rut'];
        $fechaNacimiento=$alumno['fecha de nacimiento'];

        $url = protegerURL("../controladores/alumnos.php?opcion=actualizaralumno&id=$id");
        $formulario = '
        <div class="fullscreen-container">
            <form class="login-form" action="' . htmlspecialchars($url) . '" method="post">
                <h2 class="text-center">Editar Alumno</h2>
                
                <div class="form-group">
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="'. $nombre.'" required>
                </div>
                
                <div class="form-group">
                    <input type="text" class="form-control" name="apellidos" placeholder="Apellidos" value="'. $apellidos.'" required>
                </div>
                
                <div class="form-group">
                    <input type="text" class="form-control" name="rut" placeholder="RUT" value="'. $rut.'"required>
                </div>
                
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                    <input type="date" class="form-control" name="fecha_nacimiento" value="'. $fechaNacimiento.'" required>
                </div>
        
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>';
        
    web($formulario);

    die();
    }else if($opcion == "selectcurso"){
       // Asumiendo que $id_alumno viene de la URL o alguna otra fuente
$id_alumno = $_GET['id']; // o $_POST['id'] si viene del POST
$url=protegerURL("../controladores/alumnos.php?opcion=actualizacioncurso");
$alumno=obtenerAlumnoPorId($id_alumno);
// Aquí generamos el formulario para asignar un curso al alumno
$formulario = '
    <div class="fullscreen-container">
        
        <form class="login-form" action="'.$url.'" method="post">
            <h3>Asignar Curso</h3>
            <label for="alumno">Selecciona un Curso</label>
                    ';
            

    // Llamar a la función listarCursosEnSelect() para generar el select con los cursos
    ob_start(); // Capturar la salida de listarCursosEnSelect()
    listarCursosEnSelectid();
    $formulario .= ob_get_clean();  // Agregar el contenido generado a la variable $formulario
    
    // Botón de submit
    $formulario .= '
                <input type="hidden" name="id_alumno" value="' . htmlspecialchars($id_alumno) . '">

            <hr><button type="submit" class="btn btn-success">Guardar Curso</button>
        </form>
    </div>';
    
    
        web($formulario);
    }else if($opcion =="actualizacioncurso"){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recibe los valores del formulario
            $idAlumno = $_POST['id_alumno'];
            $idCurso = $_POST['id_curso'];
            // Llamada a la función para asignar el curso
            $mensaje = asignarCursoAlumno($idAlumno, $idCurso);
            
            // Mostrar mensaje
            echo "$mensaje";
        }            header('Location: ../public/crearalumnos.php');

    }else if($opcion=="crearalumno"){



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

    }



}



?>