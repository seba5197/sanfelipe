<?php
function crearHorario($nombre, $descripcion, $codigo) {
    try {
        // Obtener la conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para insertar un nuevo horario
        $sql = "INSERT INTO nombreshorarios (nombre, descripcion, codigo) VALUES (:nombre, :descripcion, :codigo)";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros utilizando bindParam()
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Mensaje de éxito
        echo "Horario creado exitosamente.";
    } catch (PDOException $e) {
        // Capturar y mostrar cualquier error que ocurra
        die("Error al crear el horario: " . $e->getMessage());
    }
}
function editarHorario($id, $nombre, $descripcion, $codigo) {
    try {
        // Obtener la conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para actualizar un horario existente
        $sql = "UPDATE nombreshorarios SET nombre = :nombre, descripcion = :descripcion, codigo = :codigo WHERE id_nombrehorario = :id";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros utilizando bindParam()
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si se actualizó algún registro
        if ($stmt->rowCount() > 0) {
            echo "Horario actualizado exitosamente.";
        } else {
            echo "No se encontró el horario con el ID especificado o no hubo cambios.";
        }
    } catch (PDOException $e) {
        // Capturar y mostrar cualquier error que ocurra
        die("Error al editar el horario: " . $e->getMessage());
    }
}

function eliminarHorario($id) {
    try {
        // Obtener la conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para eliminar un horario existente
        $sql = "DELETE FROM nombreshorarios WHERE id_nombrehorario = :id";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Vincular el parámetro de ID a la consulta
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si se eliminó algún registro
        if ($stmt->rowCount() > 0) {
            echo "Horario eliminado exitosamente.";
        } else {
            echo "No se encontró el horario con el ID especificado.";
        }
    } catch (PDOException $e) {
        // Capturar y mostrar cualquier error que ocurra
        die("Error al eliminar el horario: " . $e->getMessage());
    }
}


function insertarHorarios($codigo_horario) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Definir los horarios (estáticos)
        $horarios = HORARIOS;
        // Definir los días de la semana (estáticos)
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

        // Asignatura y profesor predefinidos (ID 99)
        $asignaturaId = 99;
        $profesorId = 99;

        // Insertar los horarios con el código A1
        foreach ($horarios as $index_horario => $hora) {
            $hora_inicio = $hora[0];
            $hora_fin = $hora[1];

         
            // Insertar el horario en la tabla `horarios` con el código A1
            $sql_hora = "INSERT INTO horarios (hora_inicio, hora_fin, codigo) VALUES (:hora_inicio, :hora_fin, :codigo)";
            $stmt_hora = $conn->prepare($sql_hora);
            $stmt_hora->bindParam(':hora_inicio', $hora_inicio);
            $stmt_hora->bindParam(':hora_fin', $hora_fin);
            $stmt_hora->bindParam(':codigo', $codigo_horario);
            $stmt_hora->execute();

            // Obtener el ID del horario insertado
            $id_horario = $conn->lastInsertId();

            // Insertar las combinaciones de asignaturas y profesores para cada día y hora
            foreach ($dias as $index_dia => $dia) {
                // Insertar la combinación de horario, día, asignatura y profesor
                $sql_detalle = "INSERT INTO horarios_detalles (id_horario, id_dia, id_asignatura, id_profesor) 
                                VALUES (:id_horario, :id_dia, :id_asignatura, :id_profesor)";
                $stmt_detalle = $conn->prepare($sql_detalle);
                $stmt_detalle->bindParam(':id_horario', $id_horario);
                $stmt_detalle->bindParam(':id_dia', $index_dia + 1); // Los días empiezan en 1
                $stmt_detalle->bindParam(':id_asignatura', $asignaturaId);
                $stmt_detalle->bindParam(':id_profesor', $profesorId);

                $stmt_detalle->execute();
            }
        }

        echo "Horarios con código $codigo_horario insertados exitosamente.";
    } catch (PDOException $e) {
        die("Error al insertar horarios: " . $e->getMessage());
    }
}


?>