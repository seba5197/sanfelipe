<?php

include_once '../config/config.php';

if (isset($_GET['opcion'])) {
    $opcion = $_GET['opcion'];
    $idcurso = $_GET['id'];

    if ($opcion == 'editar') {
        $idCurso = isset($_GET['id']) ? $_GET['id'] : null;

        $curso= obtenerCursoPorId($idCurso);
        $url = protegerURL("../controladores/cursos.php?opcion=actualizacion");
        $formulario = '
        <div class="fullscreen-container">
            <form class="login-form" action="' . htmlspecialchars($url) . '" method="post">
                <h2 class="text-center">Editar Curso</h2>
                
                <!-- Campo oculto para idcurso -->
                <input type="hidden" name="idcurso" value="' . htmlspecialchars($curso['id_cursos']) . '">
                
                <div class="form-group">
                    Nombre
                    <input type="text" class="form-control" name="curso" value="' . htmlspecialchars($curso['curso']) . '" placeholder="Nombre del curso" required>
                </div>
                
                <div class="form-group">
                    Nivel
                    <select class="form-control" name="nivel" required>
                        <option value="' . htmlspecialchars($curso['nivel']) . '" disabled selected>' . htmlspecialchars($curso['nivel']) . '</option>';
                
                // Iterar sobre los niveles y agregar las opciones dinámicamente
                foreach (NIVELES as $value => $label) {
                    $formulario .= '<option value="' . htmlspecialchars($value) . '">' . htmlspecialchars($label) . '</option>';
                }
        
        $formulario .= '
                    </select>
                </div>
                
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Guardar Curso</button>
                </div>
            </form>
        </div>';
        

        web($formulario);
        exit();
        
        
        

    } elseif ($opcion == 'eliminar') {
        // Lógica para eliminar la asignatura
        eliminarCurso($idcurso);  
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }else if($opcion == "actualizacion"){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recogemos los valores enviados por el formulario
            $idCurso = isset($_POST['idcurso']) ? $_POST['idcurso'] : null;  // idcurso es el campo oculto
            $curso = isset($_POST['curso']) ? $_POST['curso'] : '';  // Nombre del curso
            $nivel = isset($_POST['nivel']) ? $_POST['nivel'] : '';  // Nivel del curso
        
            // Asegúrate de validar y sanitizar los datos aquí
        
            // Ejemplo de validación básica
            if (empty($curso) || empty($nivel)) {
echo "debe proporcionar valores para editar el curso";
header("Refresh: 3; URL=../public/crearcursos.php");
} else {
                // Aquí iría el código para actualizar la base de datos, por ejemplo
                // editarCurso($idCurso, $curso, $nivel);
                editarCurso($idCurso,$curso,$nivel);
                header("Location: ../public/crearcursos.php");
                        exit();
                echo "Curso actualizado con éxito.";
            }
        }
        

    }else if ($opcion=="crear"){
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

        
    }else if($opcion=="asignarsala"){
$id=$_GET['id'];
        $salas = obtenerSalas(); // Llama a la función para obtener las salas
$url=protegerURL("../controladores/cursos.php?opcion=salaasignada&idcurso=$id");
$formulario = '
<div class="fullscreen-container">
    <form class="login-form" action="'.$url.'" method="post">
        <h2 class="text-center">Asignar Sala al Curso</h2>
        <input type="hidden" name="id_curso" value="' . htmlspecialchars($id) . '">
        <div class="form-group">
            <label for="id_sala">Seleccione una sala:</label>
            <select class="form-control" name="id_sala" required>
                <option value="" disabled selected>Seleccione una sala</option>';
                
foreach ($salas as $sala) {
    $formulario .= '<option value="' . htmlspecialchars($sala['id_salas']) . '">' . htmlspecialchars($sala['sala']) . '</option>';
}

$formulario .= '
            </select>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">Asignar Sala</button>
        </div>
    </form>
</div>';
        web($formulario);
        exit();
            }else if($opcion=="salaasignada"){
              
              
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Capturar datos del formulario
                    $idCurso = isset($_POST['id_curso']) ? intval($_POST['id_curso']) : null;
                    $idSala = isset($_POST['id_sala']) ? intval($_POST['id_sala']) : null;
                
                    // Validar que los datos no estén vacíos
                    if ($idCurso && $idSala) {
                        // Llamar a la función para asignar el curso a la sala
                        $resultado = asignarCursoSala($idCurso, $idSala);
                echo $resultado;
                        // Redirigir con mensaje de éxito
                        //header("Location: ../public/crearcursos.php");
                        exit;
                    }
                }

            }
}


?>