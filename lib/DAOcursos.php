<?php


function crearCurso($curso, $nivel) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para insertar un nuevo curso
        $sql = "INSERT INTO cursos (curso, nivel) VALUES (:curso, :nivel)";
        
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Asociar los parámetros
        $stmt->bindParam(':curso', $curso, PDO::PARAM_STR);
        $stmt->bindParam(':nivel', $nivel, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Confirmación de éxito
        return "Curso creado con éxito.";
    } catch (PDOException $e) {
        die("Error al crear el curso: " . $e->getMessage());
    }
}
function editarCurso($id_curso, $curso, $nivel) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para actualizar un curso
        $sql = "UPDATE cursos SET curso = :curso, nivel = :nivel WHERE id_cursos = :id_curso";
        
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Asociar los parámetros
        $stmt->bindParam(':curso', $curso, PDO::PARAM_STR);
        $stmt->bindParam(':nivel', $nivel, PDO::PARAM_STR);
        $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Confirmación de éxito
        return "Curso actualizado con éxito.";
    } catch (PDOException $e) {
        die("Error al editar el curso: " . $e->getMessage());
    }
}
function eliminarCurso($id_curso) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para eliminar un curso
        $sql = "DELETE FROM cursos WHERE id_cursos = :id_curso";
        
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Asociar el parámetro
        $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Confirmación de éxito
        return "Curso eliminado con éxito.";
    } catch (PDOException $e) {
        die("Error al eliminar el curso: " . $e->getMessage());
    }
}



function listarCursosEnGrid() {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener todos los cursos
        $sql = "SELECT id_cursos, curso, nivel FROM cursos";
        
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);
        
        // Ejecutar la consulta
        $stmt->execute();

        // Obtener todos los cursos
        $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si existen cursos
        if ($cursos) {
            echo '<div class="row">';  // Contenedor para la fila de cursos

            $contador = 0;
            foreach ($cursos as $curso) {
            
                //protegemos url 
                $id = $curso['id_cursos'];
                $urleditar = protegerURL('../controladores/cursos.php?opcion=editar&id=' . $id);
                $urlelimnar = protegerURL('../controladores/cursos.php?opcion=eliminar&id=' . $id);
                $urldetalles = protegerURL('../controladores/cursos.php?opcion=detalles&id=' . $id);
                
                // Crear una nueva fila cada 3 cursos
                if ($contador % 3 == 0 && $contador != 0) {
                    echo '</div><div class="row">';  // Nueva fila después de cada 3 columnas
                }
               
                // Mostrar cada curso en una columna
                echo '<div class="col-md-3">';  // Columna con Bootstrap
                echo '<div class="card mb-3">';  // Card para cada curso
                echo '<div class="card-body">';
                echo '<h5 class="card-title">Curso ' . htmlspecialchars($curso['curso']) .  '</h5>';
                echo '<p class="card-text">Nivel: ' . htmlspecialchars($curso['nivel']) . '</p>';
                echo '<a href="'.$urldetalles . '" class="btn btn-success">ver alumnos</a> ';
                echo '<a href="'.$urleditar . '" class="btn btn-primary">Editar</a> ';
                echo '<a href="' .$urlelimnar . '" class="btn btn-danger" onclick="return confirm(\'¿Estás seguro de eliminar este curso?\');">Eliminar</a><hr>';
                echo listarSalasPorIdCurso($curso['id_cursos']).'</div>';
                echo '</div>';
                echo '</div>';

                $contador++;
            }

            echo '</div>';  // Cerrar la última fila
        } else {
            echo 'No hay cursos disponibles.';
        }
    } catch (PDOException $e) {
        die("Error al listar los cursos: " . $e->getMessage());
    }
}


function listarCursosEnSelect() {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener todos los cursos
        $sql = "SELECT id_cursos, curso, nivel FROM cursos";
        
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);
        
        // Ejecutar la consulta
        $stmt->execute();

        // Obtener todos los cursos
        $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si existen cursos
        if ($cursos) {
            // Crear el select con id 'curso' y la clase 'form-control' para la apariencia
            echo '<select class="form-control" name="curso" id="curso">';
            echo '<option value="">Selecciona un curso</option>';

            // Recorrer los cursos y agregar cada uno como opción
            foreach ($cursos as $curso) {
                // Mostrar cada curso en el select con el id_cursos como value y el nombre del curso como texto
                echo '<option value="' . htmlspecialchars($curso['curso']) . '">' . 
                     htmlspecialchars($curso['curso']) . ' - ' . htmlspecialchars($curso['nivel']) . '</option>';
            }

            echo '</select>';  // Cerrar el select

            // Agregar el script para inicializar Select2 y el buscador
          
        } else {
            echo '<p>No hay cursos disponibles.</p>';
        }
    } catch (PDOException $e) {
        die("Error al listar los cursos: " . $e->getMessage());
    }
}

function listarCursosEnSelectid() {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener todos los cursos
        $sql = "SELECT id_cursos, curso, nivel FROM cursos";
        
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);
        
        // Ejecutar la consulta
        $stmt->execute();

        // Obtener todos los cursos
        $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si existen cursos
        if ($cursos) {
            // Crear el select con id 'curso' y la clase 'form-control' para la apariencia
            echo '<select class="form-control" name="id_curso" id="curso">';
            echo '<option value="">Selecciona un curso</option>';

            // Recorrer los cursos y agregar cada uno como opción
            foreach ($cursos as $curso) {
                // Mostrar cada curso en el select con el id_cursos como value y el nombre del curso como texto
                echo '<option value="' . htmlspecialchars($curso['id_cursos']) . '">' . 
                     htmlspecialchars($curso['curso']) . ' - ' . htmlspecialchars($curso['nivel']) . '</option>';
            }

            echo '</select>';  // Cerrar el select

            // Agregar el script para inicializar Select2 y el buscador
          
        } else {
            echo '<p>No hay cursos disponibles.</p>';
        }
    } catch (PDOException $e) {
        die("Error al listar los cursos: " . $e->getMessage());
    }
}
function obtenerCursoPorId($idCurso) {
    try {
        $conn = getDbConnection(); // Asegúrate de tener una función para obtener la conexión a la base de datos

        // Consulta SQL para obtener el curso por ID
        $sql = "SELECT id_cursos, curso, nivel FROM cursos WHERE id_cursos = :id_cursos";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_cursos', $idCurso, PDO::PARAM_INT);
        $stmt->execute();

        $curso = $stmt->fetch(PDO::FETCH_ASSOC);

        return $curso;
    } catch (PDOException $e) {
        echo "Error al obtener el curso: " . $e->getMessage();
    }
}

function asignarCursoSala($idCurso, $idSala) {
    try {

        eliminarCursoSala($idCurso , $idSala );
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para insertar la relación entre curso y sala
        $sql = "INSERT INTO `curso-sala` (id_curso_sala, id_curso, id_sala) VALUES (NULL, :id_curso, :id_sala)";
        $stmt = $conn->prepare($sql);

        // Vinculamos los parámetros
        $stmt->bindParam(':id_curso', $idCurso, PDO::PARAM_INT);
        $stmt->bindParam(':id_sala', $idSala, PDO::PARAM_INT);

        // Ejecutamos la consulta
        $stmt->execute();

        return "Curso asignado a la sala exitosamente.";
    } catch (PDOException $e) {
        return "Error al asignar el curso a la sala: " . $e->getMessage();
    }
}

function eliminarCursoSala($idCurso, $idSala) {
    try {
        $conn = getDbConnection();

        // Eliminar el registro de la tabla `curso-sala` si coincide con `id_curso` o `id_sala`
        $sql = "DELETE FROM `curso-sala` WHERE `id_curso` = :id_curso OR `id_sala` = :id_sala";  // Uso de `OR` para eliminar con cualquiera de los dos valores
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_curso', $idCurso, PDO::PARAM_INT);
        $stmt->bindParam(':id_sala', $idSala, PDO::PARAM_INT);
        $stmt->execute();

        echo "Registro eliminado con éxito.";
    } catch (PDOException $e) {
        echo "Error al eliminar el registro: " . $e->getMessage();
    }
}



function obtenerCursoPorCodigo($codigoHorario) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener el curso por código de horario
        $sql = "SELECT curso FROM `curso-horario` WHERE horario = :codigoHorario";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Asociar el parámetro
        $stmt->bindParam(':codigoHorario', $codigoHorario, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el curso correspondiente
        $curso = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si no se encuentra el curso, retornar un mensaje
        if (!$curso) {
            return "No se encontró un curso para el código proporcionado.";
        }

        // Retornar el curso
        return $curso['curso'];

    } catch (PDOException $e) {
        // Manejo de errores
        return "Error al obtener el curso: " . $e->getMessage();
    }
}


function obtenerCursoPorIdAlumno($idAlumno) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener la relación entre el alumno y el curso
        $sql = "SELECT * FROM `alumno-curso` WHERE `id_alumno` = :id_alumno";
        
        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_alumno', $idAlumno, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el resultado de la consulta
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            // Si existe una relación entre el alumno y el curso, retornamos el resultado
            return $resultado; // Devuelve el registro de la relación entre alumno y curso
        } else {
            // Si no se encuentra relación, retornamos un mensaje indicando que no existe
            return "No se encuentra curso asignado para este alumno.";
        }
    } catch (PDOException $e) {
        die("Error al obtener la relación del curso: " . $e->getMessage());
    }
}
function obtenerCodigoHorarioPorCurso($curso) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta para obtener el código de horario asociado al curso
        $sql = "SELECT * FROM `curso-horario` WHERE `curso` = :curso LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':curso', $curso, PDO::PARAM_STR); // Sin comillas simples
        $stmt->execute();

        // Obtener el resultado
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    
        if ($resultado) {

            return $resultado['horario'];
        } else {
            return "Sin horario asignado";
        }
    } catch (PDOException $e) {
        die("Error al obtener el código de horario: " . $e->getMessage());
    }
}

function obtenerDatosCursoHorario($curso) {
    try {
        $conn = getDbConnection();

        $sql = "SELECT * FROM `curso-horario` WHERE `curso` = :curso";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':curso', $curso, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error al obtener los datos del curso-horario: " . $e->getMessage());
    }
}