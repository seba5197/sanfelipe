<?php

include_once '../config/config.php';
validarURL();
$token= $_GET['token'];
$codigo= $_GET['codigo'];
if (isset($_GET['opcion'])) {
    $opcion = $_GET['opcion'];
    $idHorario = $_GET['id'];
    

    if ($opcion == 'editar') {
        $codigo = $_GET['codigo'];
        $horario=nombreHorarioPorCodigo($codigo);
        $url=protegerURL("../controladores/horarios.php?opcion=actualizacionhorario");
            // Obtener los valores actuales
           
            $formulario = '
            <div class="fullscreen-container">
                <form class="login-form" action="' . htmlspecialchars($url) . '" method="post">
                 <h3> actualizar horario</h3>
                    <input type="hidden" name="idHorario" value="' . htmlspecialchars($horario['id_nombrehorario']) . '">
                    
                    <label for="nombre_horario">Nombre del horario actual: <b>' . htmlspecialchars($horario['nombre']) . '</b></label>
                    <input type="text" id="nombre_horario" name="nombre_horario" value="'.htmlspecialchars($horario['nombre']).'" placeholder="Colocar nuevo nombre del horario" value="' . (isset($nombreHorario) ? htmlspecialchars($nombreHorario) : '') . '" required>
                    
                    <label for="codigo_horario">Código del horario actual: <b>' . htmlspecialchars($codigo) . '</b></label>
                    <input type="text" style="text-transform: uppercase;" value="'.htmlspecialchars($codigo).'" id="codigo_horario" name="codigo_horario" placeholder="Colocar nuevo código del horario" value="' . (isset($codigoHorario) ? htmlspecialchars($codigoHorario) : '') . '" required>
                    
                    <label for="descripcion">Descripción del horario actual: <b>' . htmlspecialchars($horario['descripcion']) . '</b></label>
                    <input type="text" id="descripcion" name="descripcion" value="'.htmlspecialchars($horario['descripcion']).' " placeholder="Colocar nueva descripción del horario" value="' . (isset($descripcion) ? htmlspecialchars($descripcion) : '') . '">
                    
                  <center>  <button type="submit" class="btn btn-success">Guardar</button></center>
                </form>
            </div>';
            

            

            web($formulario);
            die();
        

     
        exit();

    } elseif ($opcion == 'actualizaciondetallehoradia') {
        //guarda detalle de hora dia profesor.

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger los valores enviados por POST
            $profesor = isset($_POST['profesor']) ? htmlspecialchars($_POST['profesor']) : 99;
            $id_horario = isset($_POST['id_horario']) ? htmlspecialchars($_POST['id_horario']) : null;
            $asignatura = isset($_POST['asignatura']) ? htmlspecialchars($_POST['asignatura']) : 99;
            $codigo = isset($_POST['codigo']) ? htmlspecialchars($_POST['codigo']) : null;
            actualizarHorarioasignaturaprofesor($id_horario, $profesor, $asignatura);
            $url=protegerURL("../public/horariocompleto.php?codigo=$codigo");
                       header("Location: $url ");
                       echo "<h3>Información recibida del formulario:</h3>";
                       echo "<ul>";
                       echo "<li><strong>Profesor:</strong> " . $profesor . "</li>";
                       echo "<li><strong>ID Horario:</strong> " . ($id_horario !== null ? $id_horario : "No proporcionado") . "</li>";
                       echo "<li><strong>Asignatura:</strong> " . $asignatura . "</li>";
                       echo "<li><strong>Código:</strong> " . $codigo . "</li>";
                       echo "</ul>";
            } 
die();

       
    }
    
    elseif ($opcion == 'actualizacionhorario') {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger los valores de los campos del formulario
            $idHorario = isset($_POST['idHorario']) ? $_POST['idHorario'] : null;
            $nombreHorario = isset($_POST['nombre_horario']) ? $_POST['nombre_horario'] : '';
            $codigoHorario = isset($_POST['codigo_horario']) ? $_POST['codigo_horario'] : '';
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';

        editarHorario($idHorario, $nombreHorario, $descripcion, $codigoHorario);
           // Lógica para editar el horario
           header('Location: ../public/crearhorarios.php');
    } }
    
    elseif ($opcion == 'eliminar') {
        // Lógica para eliminar el horario
        eliminarHorario($idHorario);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } elseif ($opcion == 'editarhora') {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $horario= obtenerDetalleHorarioPorId($id);
        if ($id !== null) {
        $url=protegerURL("#");
        $dia=  $horario['dia'];
        $hora=  $horario['hora']; 
        $codigo=$horario['codigo horario'];
        $asignatura_actual=obtenerAsignaturaPorId( $horario['asignatura']);   
        $profesoractual=obtenerNombreUsuarioPorId( $horario['profesor']);    
            $url=protegerURL("../controladores/horarios.php?opcion=actualizaciondetallehoradia&codigo=$codigo");
            $asignaturas = obtenerAsignaturas(); // Llama a la función para obtener las asignaturas
            $titulo="<center><h4>Asignar Materia Horario - $codigo</h4><hr>
            <b>Día:</b> $dia <b>Horario:</b> $hora Hrs<br><b>Asignatura actual:</b> $asignatura_actual<br><b>Profesor actual:</b> $profesoractual</b>
            <hr></center>";
            $formulario =   '<div class="fullscreen-container">
    <form class="login-form" action="' . htmlspecialchars($url) . '" method="post">'.$titulo.
                                '<input type="hidden" name="dia" value="' . htmlspecialchars($dia) . '" class="dia">'.
                                '<input type="hidden" name="hora" value="' . htmlspecialchars($hora) . '" class="hora">'.
                                '<input type="hidden" name="id_horario" value="' . htmlspecialchars($id) . '" class="detalleid">'.
                                '<input type="hidden" name="codigo" value="' . htmlspecialchars($codigo) . '" class="detalleid">'.
                            '<div class="form-group">
                                Escoger Asignatura
                            <select class="form-control selectasignatura" name="asignatura" onchange="cargaprofe()" required>
                                <option value="'.$horario['asignatura'].'" disabled selected>'.$asignatura_actual.'</option>';

            foreach ($asignaturas as $asignatura) {
            $formulario .= '<option value="' . htmlspecialchars($asignatura['id_asignaturas']) . '">' . htmlspecialchars($asignatura['asignatura']) . '</option>';
            }

            $formulario .= '
            </select> 
            <div class="form-group cargaprofe"></div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
       
    </form>
        </div>';
web($formulario);
        }






    }elseif ($opcion == 'asignarcursohorario') {
        // Lógica para eliminar el horario
$codigo=$_GET['codigo'];
        $url=protegerURL("./horarios.php?opcion=guardarcurso&codigo=$codigo");
        $formulario = '
    <div class="fullscreen-container">
        
        <form class="login-form" action="'.$url.'" method="post">
            <h3>Asignar Curso</h3>
            <label for="curso">Selecciona un Curso</label>';

    // Llamar a la función listarCursosEnSelect() para generar el select con los cursos
    ob_start(); // Capturar la salida de listarCursosEnSelect()
    listarCursosEnSelect();
    $formulario .= ob_get_clean();  // Agregar el contenido generado a la variable $formulario
    
    // Botón de submit
    $formulario .= '
            <hr><button type="submit" class="btn btn-success">Guardar Curso</button>
        </form>
    </div>';
    echo '
    <script>
    $(document).ready(function() {
        $("#curso").select2({
            placeholder: "Selecciona un curso",
            allowClear: true
        });
    });
    </script>';
    
        web($formulario);
        
    }elseif ($opcion == 'guardarcurso') {

// Obtener el parámetro "codigo" de la URL
$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : null;

// Verificar si "codigo" tiene valor
if ($codigo !== null) {
   // echo "El código es: " . htmlspecialchars($codigo);
} else {
    echo "No se proporcionó un código en la URL.";
    die();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el valor del curso seleccionado
    if (isset($_POST['curso'])) {
        $cursoSeleccionado = $_POST['curso'];

        // Hacer algo con el curso seleccionado, por ejemplo, guardarlo en la base de datos
       // echo "El curso seleccionado es: " . htmlspecialchars($cursoSeleccionado);
       
        $resultado = insertarCursoHorario($cursoSeleccionado, $codigo,'insertar');
        // Si el mensaje sugiere actualizar, pasamos el parámetro 'actualizar' y ejecutamos la actualización
        if ($resultado === "Ya tiene un curso asignado en este horario. ¿Desea actualizar el registro?") {
            // Aquí debes manejar la confirmación del usuario
            // Si el usuario acepta la actualización, se vuelve a llamar con la acción 'actualizar'
            echo "
            <script>
                if (confirm('Ya tiene un curso asignado en este horario. ¿Desea actualizar el registro?')) {
                    // Redirige con el token incluido
                    window.location.href = 'horarios.php?opcion=actualizacurso&curso={$cursoSeleccionado}&codigo={$codigo}&token={$token}';
                } else {
                    alert('El curso no será actualizado.');
                }
            </script>
        ";
            
            $resultado = insertarCursoHorario($cursoSeleccionado, $codigo, 'actualizar');
        }
        
        echo $resultado;

        // Aquí puedes agregar el código para guardar el curso en la base de datos
    } else {
        echo "No se ha seleccionado ningún curso.";
        die();
    }
}
        echo " guardar curso";

die();


    }else if($opcion == 'crearhorario'){
        echo "crear horario";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recibir los datos del formulario
            $codigo = strtoupper($_POST['codigo_horario'] ?? '');
            $nombre = $_POST['nombre_horario'] ?? 'Sin nombre de horario';
            $descripcion = $_POST['descripcion'] ?? 'Sin descripción de horario';
        
            // Llamar a la función para crear el horario
            $mensaje = crearHorario($nombre, $descripcion, $codigo);
        
            // Mostrar el mensaje de éxito o error
            echo $mensaje;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
        
        }elseif ($opcion == 'actualizacurso'){
$curso=$_GET['curso'];

echo "actualizar curso $curso $codigo";

            if ($codigo !== null) {
                // echo "El código es: " . htmlspecialchars($codigo);
             } else {
                 echo "No se proporcionó un código en la URL.";
                 die();
             }
                           
                    
                     $resultado = insertarCursoHorario($curso, $codigo, 'actualizar');
                     header("Location: ../public/crearhorarios.php");

                


        }elseif ($opcion == 'listadetalles') {

echo "codigo para listar profesores asignados a la asignatura y poder eliminar";

        }
        
    
  
    
            // Llamar a la función para generar la página
           

}
?>

