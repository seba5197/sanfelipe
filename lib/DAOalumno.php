<?php



function crearAlumno($nombre, $apellidos, $rut, $fechaNacimiento) {
    try {
        // Normalizar el RUT eliminando espacios, puntos, comas, guiones y convertir la 'K' a 'k'
        $rut = preg_replace('/[^0-9kK]/', '', $rut); // Eliminar caracteres no válidos
        $rut = strtolower($rut); // Convertir cualquier 'K' a minúscula 'k'

        // Validar que el RUT solo contenga números y opcionalmente una 'k' al final
        if (!preg_match('/^[0-9]+k?$/', $rut)) {
            return "El RUT ingresado no es válido. Debe contener solo números y una 'k' opcional.";
        }

        echo "creando alumno $nombre $apellidos $rut $fechaNacimiento<br>";

        $conn = getDbConnection();
        // Consulta SQL para insertar un alumno
        $sql = "INSERT INTO `alumno` (`id_alumno`, `nombre`, `apellidos`, `rut`, `fecha de nacimiento`) 
        VALUES (NULL, :nombre, :apellidos, :rut, :fechaNacimiento)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);
        $stmt->bindParam(':fechaNacimiento', $fechaNacimiento, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        return "Alumno creado exitosamente.";
    } catch (PDOException $e) {
        return "Error al crear el alumno : - " . $e->getMessage();
    }
}


function editarAlumno($idAlumno, $nombre, $apellidos, $rut, $fechaNacimiento) {
    try {
        $conn = getDbConnection();

        $sql = "UPDATE alumno SET nombre = :nombre, apellidos = :apellidos, rut = :rut, fecha de nacimiento = :fecha_nacimiento WHERE id_alumno = :id_alumno";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_alumno', $idAlumno, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_nacimiento', $fechaNacimiento, PDO::PARAM_STR);

        $stmt->execute();

        echo "Alumno editado exitosamente.";
    } catch (PDOException $e) {
        die("Error al editar el alumno: " . $e->getMessage());
    }
}

function eliminarAlumno($idAlumno) {
    try {
        $conn = getDbConnection();

        $sql = "DELETE FROM alumno WHERE id_alumno = :id_alumno";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_alumno', $idAlumno, PDO::PARAM_INT);

        $stmt->execute();

        echo "Alumno eliminado exitosamente.";
    } catch (PDOException $e) {
        die("Error al eliminar el alumno: " . $e->getMessage());
    }
}
function listarAlumnos() {
    try {
        $conn = getDbConnection();

        $sql = "SELECT * FROM alumno";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($alumnos) {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th><th>Nombre</th><th>Apellidos</th><th>RUT</th><th>Fecha de Nacimiento</th><th>Acciones</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($alumnos as $alumno) {
                $alumno_id = $alumno['id_alumno'];
                $urleditar = protegerURL('../controladores/alumnos.php?opcion=editar&id=' . $alumno_id);
                $urlelimnar = protegerURL('../controladores/alumnos.php?opcion=eliminar&id=' . $alumno_id);
                
                echo '<tr>';
                echo '<td>' . htmlspecialchars($alumno['id_alumno']) . '</td>';
                echo '<td>' . htmlspecialchars($alumno['nombre']) . '</td>';
                echo '<td>' . htmlspecialchars($alumno['apellidos']) . '</td>';
                echo '<td>' . htmlspecialchars($alumno['rut']) . '</td>';
                echo '<td>' . htmlspecialchars($alumno['fecha de nacimiento']) . '</td>';
                echo '<td>';
                echo '<a href="' .$urleditar . '" class="btn btn-primary">Editar</a> '; 
                echo '<a href="' . $urlelimnar . '" class="btn btn-danger" onclick="return confirm(\'¿Estás seguro de eliminar este alumno?\');">Eliminar</a>'; 
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo 'No hay alumnos registrados.';
        }
    } catch (PDOException $e) {
        die("Error al listar los alumnos: " . $e->getMessage());
    }
}
function obtenerAlumnoPorId($idAlumno) {
    try {
        $conn = getDbConnection();

        $sql = "SELECT * FROM alumno WHERE id_alumno = :id_alumno";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_alumno', $idAlumno, PDO::PARAM_INT);
        $stmt->execute();

        $alumno = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($alumno) {
            return $alumno;
        } else {
            return "No se encontró un alumno con el ID proporcionado.";
        }
    } catch (PDOException $e) {
        die("Error al obtener el alumno por ID: " . $e->getMessage());
    }
}


function obtenerAlumnoPorRut($rut) {
    try {
        $conn = getDbConnection();

        $sql = "SELECT * FROM alumno WHERE rut = :rut";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);
        $stmt->execute();

        $alumno = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($alumno) {
            return $alumno;
        } else {
            return "No se encontró un alumno con el RUT proporcionado.";
        }
    } catch (PDOException $e) {
        die("Error al obtener el alumno por RUT: " . $e->getMessage());
    }
}

function listarHorarios() {
    try {
        $conn = getDbConnection();

        // Consulta SQL para obtener todos los horarios
        $sql = "SELECT * FROM nombreshorarios";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($horarios) {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th><th>Nombre</th><th>Descripción</th><th>Código</th><th>Acciones</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($horarios as $horario) {
                $horario_id = $horario['id_nombrehorario'];
                $urleditar = protegerURL('../controladores/horarios.php?opcion=editar&id=' . $horario_id);
                $urleliminar = protegerURL('../controladores/horarios.php?opcion=eliminar&id=' . $horario_id);
                $urlasignarcurso = protegerURL('../controladores/horarios.php?opcion=asignarcurso&id=' . $horario_id);
                
                echo '<tr>';
                echo '<td>' . htmlspecialchars($horario['id_nombrehorario']) . '</td>';
                echo '<td>' . htmlspecialchars($horario['nombre']) . '</td>';
                echo '<td>' . htmlspecialchars($horario['descripcion']) . '</td>';
                echo '<td>' . htmlspecialchars($horario['codigo']) . '</td>';
                echo '<td>';
                echo '<a href="' . $urleditar . '" class="btn btn-primary">Editar</a> '; 
                echo '<a href="' . $urleliminar . '" class="btn btn-danger" onclick="return confirm(\'¿Estás seguro de eliminar este horario?\');">Eliminar</a> ';
                echo '<a href="' . $urlasignarcurso . '" class="btn btn-success">Asignar Curso</a>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo 'No hay horarios registrados.';
        }
    } catch (PDOException $e) {
        die("Error al listar los horarios: " . $e->getMessage());
    }
}


?>