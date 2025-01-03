<?php
require_once("../config/config.php");
// Obtener la opción de la URL
$opcion = $_POST['opcion'];

// Obtener los profesores por asignatura


// Verificar y ejecutar la función correspondiente según la opción
switch ($opcion) {
    case 'profesorasignatura':
        // Llamar a la función que maneja la asignación de profesores
        echo mostrarprofes();
        break;
    
    // Agregar más casos según otras opciones en el futuro

    default:
        // Si no hay opción o es desconocida, puedes mostrar un mensaje o dejar vacío
        echo "opción no valida";
        header("Location: ../public/");

}




function mostrarprofes() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Verificar si el parámetro idAsignatura está presente en el POST
        if (isset($_POST['idAsignatura'])) {
            $idAsignatura = $_POST['idAsignatura'];
            
            // Generar y mostrar el HTML correspondiente
           return obtenerProfesoresPorAsignaturaHTML($idAsignatura);
        }
        
    }
   
    return;
}
// Función para obtener profesores por asignatura
function obtenerProfesoresPorAsignaturaHTML($idAsignatura) {
    // Obtener los profesores mediante la función ya existente
    $profesores = obtenerProfesoresPorAsignatura($idAsignatura);
    $dia = $_POST['dia'];
    $hora = $_POST['hora'];
    // Verifica si hay profesores
    
        // Generar el HTML para el select
        echo 'Escoger profesor para el día: '.$dia .' horario: '.$hora.'<select class="form-control" name="profesor" required>';
        echo '<option value="" disabled selected>Seleccione un profesor</option>';
    
        // Mostrar los profesores en las opciones del select
        foreach ($profesores as $profesor) {
            $usuario=obtenerUsuarioPorId($profesor['profesor']);
            $nombre=$usuario['nombre']." ". $usuario['apellido'];

            if (validarAsignacion($usuario['id_usuarios'], $dia, $hora)) {
                // Realizar la asignación
                echo '<option value="' . htmlspecialchars($usuario['id_usuarios']) . '"> ' .htmlspecialchars($nombre ) . '</option>';
            } else {
                // Mostrar mensaje de error, evitamos que se muestren profesores asignados al horario solicitado si ya esta ocupado
                //echo '<option value="' . htmlspecialchars($profesor['id_profesor_asignatura']) . '">' ."este profesor ya esta asignado a un horario" . '</option>';
            }

        }
    
        echo '</select>';
    
}

?>