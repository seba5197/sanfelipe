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
    }elseif ($opcion == 'seleccionarprofe') {
        $url=protegerURL("../controladores/asignaturas.php?opcion=actualizacionprofeasignatura");

        $idrol = obtenerIdRolPorNombre("docente"); // Obtener el ID del rol "docente"

        // Obtener los IDs de los usuarios asociados a ese rol
        $iddocentes = obteneridusuariosxrol($idrol);
        
        // Inicializar un array para almacenar los datos de los profesores
        $listaProfesores = [];
        
        // Iterar sobre los IDs de los docentes para recuperar sus datos
        foreach ($iddocentes as $item) {
            // Obtener información del usuario
            $nombreasignatura=obtenerAsignaturaPorId($idAsignatura);
            $idUsuario = $item['usuario'];
            $profesor = obtenerUsuarioPorId($idUsuario); // Asume que esta función devuelve nombre, apellido e ID
        
            // Validar que el profesor tenga información válida
            if (!empty($profesor['nombre']) && !empty($profesor['apellido'])) {
                $listaProfesores[] = [
                    'id' => $profesor['id_usuarios'],
                    'nombreCompleto' => $profesor['nombre'] . ' ' . $profesor['apellido']
                ];
            }
        }
        
        // Generar el formulario
        $formularioasignaturaprofe = '
        <div class="fullscreen-container">
            <form class="login-form" action="'.$url.'" method="post">
                <h3 class="text-center">Asignar Profesor a   '.$nombreasignatura.'</h3>
                
                <!-- Campo oculto para el id_asignatura -->
                <input type="hidden" name="id_asignatura" value="' . htmlspecialchars($_GET['id']) . '">
                
                <div class="form-group">
                    <label for="profesor">Seleccione un profesor:</label>
                    <select name="id_profesor" class="form-control" required>
                        <option value="99">Seleccione un profesor</option>';
                        
        // Crear las opciones del desplegable
        foreach ($listaProfesores as $profesor) {
            $formularioasignaturaprofe .= '<option value="' . htmlspecialchars($profesor['id']) . '">' . htmlspecialchars($profesor['nombreCompleto']) . '</option>';
        }
        
        $formularioasignaturaprofe .= '
                    </select>
                </div>
                
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Asignar Profesor</button>
                </div>
            </form>
        </div>';
        
        web($formularioasignaturaprofe);
        
    }else if ($opcion == 'actualizacionprofeasignatura') {
       
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Recibir los datos del formulario
    $asignatura = $_POST['id_asignatura'];
    $idProfesor=$_POST['id_profesor'];
    // Llamar a la función para crear la asignatura
   $mensaje = crearProfesorAsignatura($idProfesor,$asignatura);

    echo "asignatura $asignatura profe $idProfesor";
    // Mostrar el mensaje de éxito o error
   echo $mensaje;
   header('Location: ../public/crearasignaturas.php');
    exit();
}
    
    }else if($opcion == 'crearasignatura'){




        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Recibir los datos del formulario
            $asignatura = $_POST['asignatura'];
            // Llamar a la función para crear la asignatura
           $mensaje = crearAsignatura($asignatura);
        
            echo "asignatura $asignatura profe $idProfesor";
            // Mostrar el mensaje de éxito o error
           echo $mensaje;
           header('Location: ../public/crearasignaturas.php');
            exit();
        }

    }
}




?>