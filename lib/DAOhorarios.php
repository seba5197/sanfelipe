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
        insertarHorarios($codigo);
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
//generar horario completo

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
           // Valores predeterminados para asignatura y profesor
           $asignaturaId = 99;
           $profesorId = 99;
   $indice=0;
           // Insertar cada combinación
           $sql = "INSERT INTO `horario` (`id_horario`, `hora`, `dia`, `asignatura`, `profesor`, `codigo horario`, `indice_horario`) 
                   VALUES (NULL, :hora, :dia, :asignatura, :profesor, :codigo_horario, :indice)";
           $stmt = $conn->prepare($sql);
   
           foreach ($dias as $dia) {
               foreach ($horarios as $horario) {
                $indice++;
                   $hora_inicio = $horario[0];
                   $hora_fin = $horario[1];
                   $hora = "$hora_inicio - $hora_fin";
   
                   // Vincular parámetros
                   $stmt->bindParam(':hora', $hora);
                   $stmt->bindParam(':dia', $dia);
                   $stmt->bindParam(':asignatura', $asignaturaId);
                   $stmt->bindParam(':profesor', $profesorId);
                   $stmt->bindParam(':codigo_horario', $codigo_horario);
                   $stmt->bindParam(':indice', $indice);
   
                   // Ejecutar la consulta
                   $stmt->execute();
               }
           }

        echo "Horarios generado con exito, Horario: $codigo_horario.";
    } catch (PDOException $e) {
        die("Error al insertar horarios: " . $e->getMessage());
    }
}

function obtenerHorarioPorId($idHorario) {
    try {
        $conn = getDbConnection();
        $sql = "SELECT * FROM horarios WHERE id_horario = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $idHorario, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return $resultado; // Retorna el horario como un array asociativo
        } else {
            return null; // Retorna null si no encuentra el horario
        }
    } catch (PDOException $e) {
        die("Error al obtener el horario por ID: " . $e->getMessage());
    }
}
function obtenerHorarioPorCodigo($codigoHorario) {
    try {
        $conn = getDbConnection();
        $sql = "SELECT * FROM horarios WHERE codigo_horario = :codigo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codigo', $codigoHorario, PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return $resultado; // Retorna el horario como un array asociativo
        } else {
            return null; // Retorna null si no encuentra el horario
        }
    } catch (PDOException $e) {
        die("Error al obtener el horario por código: " . $e->getMessage());
    }
}

function nombreHorarioPorCodigo($codigoHorario) {
    try {
        $conn = getDbConnection();
        $sql = "SELECT * FROM nombreshorarios WHERE codigo = :codigo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codigo', $codigoHorario, PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return $resultado; // Retorna el horario como un array asociativo
        } else {
            return null; // Retorna null si no encuentra el horario
        }
    } catch (PDOException $e) {
        die("Error al obtener el horario por código: " . $e->getMessage());
    }
}

function mostrarHorariosPorCodigo($codigo_horario) {
    $urlcursohorario=protegerURL('../controladores/horarios.php?opcion=asignarcursohorario&codigo=' . $codigo_horario);

    echo "<center><h3> Curso - horario </h3> <br>";
    echo '<button class="btn btn-success" id="descargar"  onclick="imprimir()">Imprimir horario</button>';
    echo '<a href="' . $urlcursohorario . '"><button class="btn btn-primary">Asignar curso</button></a></center>';

    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener los horarios por código
        $sql = "SELECT * FROM `horario` WHERE `codigo horario` = :codigo_horario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codigo_horario', $codigo_horario);
        $stmt->execute();

        // Verificar si se encuentran resultados
        if ($stmt->rowCount() > 0) {
            // Crear la tabla HTML
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Hora</th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Inicializar arreglo para los días de la semana
            $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

            // Inicializar un array para almacenar los horarios por día
            $horarios_dia = [];

            // Obtener todos los registros
            $horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Recorrer los registros y agrupar por hora
            foreach ($horarios as $horario) {
                $hora = $horario['hora']; // Obtener hora
                $dia = $horario['dia']; // Obtener el día
                $asignatura = obtenerAsignaturaPorId( $horario['asignatura']); // Obtener asignatura
                $profesor = obtenerNombreUsuarioPorId( $horario['profesor']); // Obtener profesor
                $id=$horario['id_horario'];
                // Organizar los horarios por hora y día

                
                $url=protegerURL('../controladores/horarios.php?opcion=editarhora&id=' . $id);
                $horarios_dia[$hora][$dia] = "Asignatura: $asignatura<br>Profesor: $profesor <br>" .
                '<a href="'.$url.'" class="edit-icon" data-dia="' . $dia . '" data-id="' . $horario['id_horario'] . '">
                    <img src="lapiz.png" alt="Editar" class="edit-icon-img"> Editar
                </a>';
            
            }

            // Mostrar las filas de la tabla
            foreach ($horarios_dia as $hora => $dias_hora) {
                echo '<tr>';
                echo '<td>' . $hora . '</td>';

                // Recorrer los días (lunes a viernes) y mostrar la asignatura y profesor
                foreach ($dias as $dia) {
                    // Verificar si hay datos para este día y hora
                    $detalle = isset($dias_hora[$dia]) ? $dias_hora[$dia] : 'No asignado';
                    echo "<td>$detalle</td>";
                }

                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo "El código no está disponible. Serás redirigido a la página anterior en <span id='countdown'>3</span> segundos.";
            echo "<script>
                    let countdown = 3;
                    const countdownElement = document.getElementById('countdown');
                    const interval = setInterval(function() {
                        countdown--;
                        countdownElement.textContent = countdown;
                        if (countdown <= 0) {
                            clearInterval(interval);
                            window.history.back(); // Redirige a la página anterior
                        }
                    }, 1000); // Actualiza el contador cada segundo
                  </script>";
        }
    } catch (PDOException $e) {
        die("Error al obtener los horarios: " . $e->getMessage());
    }
}


function insertarCursoHorario($curso, $horario, $accion = 'insertar') {


    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Verificar si ya existe el curso con el mismo horario
        $sqlCheck = "SELECT * FROM `curso-horario` WHERE `curso` = :curso OR `horario` = :horario";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':curso', $curso, PDO::PARAM_INT);
        $stmtCheck->bindParam(':horario', $horario, PDO::PARAM_STR);
        $stmtCheck->execute();

        // Si el curso y horario ya existen, ofrecer la opción de actualización
        if ($stmtCheck->rowCount() > 0) {

            if ($accion === 'actualizar') {
                eliminarCursoHorarioPorCursoYHorario($curso,$horario);
                // Si se ha confirmado la actualización, ejecutamos el UPDATE
                $sqlUpdate = "UPDATE `curso-horario` SET `curso` = :curso WHERE `curso` = :curso OR `horario` = :horario" ;
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->bindParam(':curso', $curso, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':horario', $horario, PDO::PARAM_STR);
                $stmtUpdate->execute();
                return "Curso y horario actualizados con éxito.";
            } else {
                return "Ya tiene un curso asignado en este horario. ¿Desea actualizar el registro?";
            }
        } else {

            

            // Si no existe el registro, insertamos los datos
            $sqlInsert = "INSERT INTO `curso-horario` (`id_curso_horario`,`curso`, `horario`) VALUES (NULL,:curso, :horario)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bindParam(':curso', $curso, PDO::PARAM_STR);
            $stmtInsert->bindParam(':horario', $horario, PDO::PARAM_STR);
            $stmtInsert->execute();
            header("Location: ../public/crearhorarios.php");

            return "Curso y horario asignados con éxito.";
        }

        

   
    } catch (PDOException $e) {
        die("Error al asignar curso y horario: " . $e->getMessage());
    }
}
function buscarCursoPorHorario($horario) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para buscar un solo curso por su horario
        $sql = "SELECT * FROM `curso-horario` WHERE `horario` = :horario LIMIT 1";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Asociar el parámetro
        $stmt->bindParam(':horario', $horario, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró el curso
        if ($resultado) {
            // Devolver el curso encontrado
            return $resultado;
        } else {
            return "no asignado";
        }
    } catch (PDOException $e) {
        die("Error al buscar el curso por horario: " . $e->getMessage());
    }
}
function eliminarCursoHorarioPorCursoYHorario($curso = null, $horario = null) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Validar que al menos uno de los parámetros no sea null
        if ($curso === null && $horario === null) {
            return "Debes proporcionar al menos el código de curso o el horario para eliminar el registro.";
        }

        // Verificar si existe el registro con el curso o el horario proporcionado (OR)
        $sqlCheck = "SELECT * FROM `curso-horario` WHERE `curso` = :curso OR `horario` = :horario";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':curso', $curso, PDO::PARAM_STR);
        $stmtCheck->bindParam(':horario', $horario, PDO::PARAM_STR);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            // Si el registro existe, proceder con la eliminación (OR)
            $sqlDelete = "DELETE FROM `curso-horario` WHERE `curso` = :curso OR `horario` = :horario";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bindParam(':curso', $curso, PDO::PARAM_STR);
            $stmtDelete->bindParam(':horario', $horario, PDO::PARAM_STR);
            $stmtDelete->execute();

            return "El registro con curso '$curso' o horario '$horario' ha sido eliminado con éxito.";
        } else {
            return "No se encontró un registro con el curso '$curso' o el horario '$horario'.";
        }
    } catch (PDOException $e) {
        die("Error al eliminar el registro: " . $e->getMessage());
    }
}
function obtenerDetalleHorarioPorId($idHorario) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener los detalles del horario por ID
        $sql = "SELECT * FROM `horario` WHERE `id_horario` = :idHorario";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Asociar el parámetro
        $stmt->bindParam(':idHorario', $idHorario, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $horario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró el horario
        if ($horario) {
            return $horario;
        } else {
            return null;  // Si no se encuentra el horario
        }

    } catch (PDOException $e) {
        die("Error al obtener el detalle del horario: " . $e->getMessage());
    }
}

function validarAsignacion($idProfesor, $dia, $hora) {
    try {
        $conn = getDbConnection(); // Conexión a la base de datos
        
        // Verificar si el profesor ya está asignado en ese día y hora
        $sql = "SELECT COUNT(*) FROM horario WHERE profesor = :idProfesor AND dia = :dia AND hora = :hora";
        $stmt = $conn->prepare($sql);
        
        // Asociar los parámetros
        $stmt->bindParam(':idProfesor', $idProfesor, PDO::PARAM_INT);
        $stmt->bindParam(':dia', $dia, PDO::PARAM_STR);
        $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado
        $count = $stmt->fetchColumn();
        
        // Si el contador es mayor a 0, ya hay una asignación, no permitirlo
        if ($count > 0) {
            return false; // Ya está asignado
        }
        
        return true; // No está asignado, se puede realizar la asignación
        
    } catch (PDOException $e) {
        die("Error al validar la asignación: " . $e->getMessage());
    }
}
function actualizarHorario($idHorario, $profesor, $asignatura) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para actualizar solo profesor y asignatura
        $sql = "UPDATE horario 
                SET profesor = :profesor, asignatura = :asignatura 
                WHERE id_horario = :id_horario";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Asignar los valores a los parámetros
        $stmt->bindParam(':profesor', $profesor, PDO::PARAM_INT);
        $stmt->bindParam(':asignatura', $asignatura, PDO::PARAM_INT);
        $stmt->bindParam(':id_horario', $idHorario, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Confirmación
        echo "Horario actualizado correctamente.";
    } catch (PDOException $e) {
        echo "Error al actualizar el horario: " . $e->getMessage();
    }
}


?>


