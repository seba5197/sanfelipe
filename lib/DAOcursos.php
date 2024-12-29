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
