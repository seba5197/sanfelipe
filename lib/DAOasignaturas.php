<?php

function obtenerAsignaturaPorId($id_asignaturas) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener el nombre de la asignatura
        $sql = "SELECT asignatura FROM asignaturas WHERE id_asignaturas = :id_asignaturas";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Asociar el parámetro
        $stmt->bindParam(':id_asignaturas', $id_asignaturas, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $asignatura = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retornar el nombre de la asignatura si existe, o null si no existe
        return $asignatura ? $asignatura['asignatura'] : null;
    } catch (PDOException $e) {
        die("Error al obtener la asignatura: " . $e->getMessage());
    }
}

    
function mostrarAsignaturasConProfesor() {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener las asignaturas junto con los profesores que las imparten
        $sql = "SELECT id_asignaturas, asignatura FROM asignaturas";


        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Obtener los resultados como un arreglo asociativo
        $asignaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($asignaturas)) {
            echo '<p>No hay asignaturas registradas.</p>';
            return;
        }

        // Mostrar en formato tabla
        echo '<table class="table table-bordered table-striped">';
        echo '<thead><tr><th>ID</th><th>Asignatura</th>';
        //muestra profesor columna
        //echo'<th>Profesor</th>';
        echo'<th>Acciones</th></tr></thead>';
        echo '<tbody>';
        foreach ($asignaturas as $asignatura) {
            //protegemos url 
            $id = $asignatura['id_asignaturas'];
            $urleditar = protegerURL('../controladores/asignaturas.php?opcion=editar&id=' . $id);
            $urlelimnar = protegerURL('../controladores/asignaturas.php?opcion=eliminar&id=' . $id);
            $profesores = obtenerProfesoresPorAsignatura($id);
            $nombresProfesores = '';

            foreach ($profesores as $profesor) {
                $profesor = obtenerUsuarioPorId(2);
              
                if ($profesor) {
                    $nombresProfesores .= $profesor['nombre'] ." ".$profesor['apellido']. ', '; // Concatenar los nombres
                }
            }
            if ($asignatura['id_asignaturas'] != 99) {
                // Aquí va el código que deseas mostrar cuando el id_asignaturas no sea igual a 99
                echo '<tr>';
                echo '<td>' . htmlspecialchars($asignatura['id_asignaturas']) . '</td>';
                echo '<td>' . htmlspecialchars($asignatura['asignatura']) . '</td>';
                  //muestra profesor columna 
               // echo '<td>' .$nombresProfesores . '</td>';
                echo '<td>';
                echo '<a href="' .  $urleditar . '" class="btn btn-primary btn-sm">Editar</a> ';
                echo '<a href="' .  $urlelimnar . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de eliminar esta asignatura?\');">Eliminar</a>';
                echo '</td>';
                echo '</tr>';
            } else {
                // Opcional: si el ID es igual a 99, puedes manejar otra acción
                
            }
           
        }
        echo '</tbody>';
        echo '</table>';
    } catch (PDOException $e) {
        die("Error al obtener la lista de asignaturas: " . $e->getMessage());
    }
}



function obtenerAsignaturasPorProfesor($idProfesor) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener las asignaturas por profesor
        $sql = "SELECT asignatura FROM `profesor-asignatura` WHERE profesor = :idProfesor";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Asociar el parámetro
        $stmt->bindParam(':idProfesor', $idProfesor, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados
        $asignaturas = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Retornar la lista de IDs de asignaturas
        return $asignaturas;
    } catch (PDOException $e) {
        die("Error al obtener las asignaturas del profesor: " . $e->getMessage());
    }
}
function obtenerAsignaturasPorProfesorConComas($idProfesor) {
    // Obtener las asignaturas del profesor
    $asignaturas = obtenerAsignaturasPorProfesor($idProfesor);
    foreach ($asignaturas as $id_asignatura) {
        // Obtener el nombre de cada asignatura por su ID
        $nombreAsignatura = obtenerAsignaturaPorId($id_asignatura);
    
        // Imprimir el nombre de la asignatura (puedes hacer lo que necesites con el nombre aquí)
        //echo $nombreAsignatura . ", ";
    }
    // Convertir el array de asignaturas a una cadena separada por comas
    return $asignaturas;
}

function nombreasignaturaporid($asignaturas){
    $nombreAsignatura="";
    foreach ($asignaturas as $id_asignatura) {
        // Obtener el nombre de cada asignatura por su ID
        $nombreAsignatura = obtenerAsignaturaPorId($id_asignatura).", ".$nombreAsignatura;
    
        // Imprimir el nombre de la asignatura (puedes hacer lo que necesites con el nombre aquí)
       // echo $nombreAsignatura . ", ";
    }
    return $nombreAsignatura;
}


function crearAsignatura($asignatura) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para insertar la asignatura
        $sql = "INSERT INTO `asignaturas` (`id_asignaturas`, `asignatura`) VALUES (NULL, :asignatura);";
        
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Asociar el parámetro
        $stmt->bindParam(':asignatura', $asignatura, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Confirmación de éxito
        return "Asignatura creada con éxito.";
    } catch (PDOException $e) {
        die("Error al crear la asignatura: " . $e->getMessage());
    }
}


function editarAsignatura($id_asignatura, $asignatura) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para actualizar la asignatura
        $sql = "UPDATE asignaturas SET asignatura = :asignatura WHERE id_asignaturas = :id_asignatura";
        
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Asociar los parámetros
        $stmt->bindParam(':asignatura', $asignatura, PDO::PARAM_STR);
        $stmt->bindParam(':id_asignatura', $id_asignatura, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Confirmación de éxito
        return "Asignatura actualizada con éxito.";
    } catch (PDOException $e) {
        die("Error al editar la asignatura: " . $e->getMessage());
    }
}


function eliminarAsignatura($id_asignatura) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para eliminar la asignatura
        $sql = "DELETE FROM asignaturas WHERE id_asignaturas = :id_asignatura";
        
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Asociar el parámetro
        $stmt->bindParam(':id_asignatura', $id_asignatura, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Confirmación de éxito
        return "Asignatura eliminada con éxito.";
    } catch (PDOException $e) {
        die("Error al eliminar la asignatura: " . $e->getMessage());
    }
}


function obtenerProfesoresPorAsignatura($idAsignatura) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener todos los registros relacionados con la asignatura
        $sql = "SELECT `profesor` FROM `profesor-asignatura` WHERE asignatura = :idAsignatura";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Asociar el parámetro
        $stmt->bindParam(':idAsignatura', $idAsignatura, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados
        $profesores = $stmt->fetchAll(PDO::FETCH_ASSOC); // Cambiado a fetchAll(PDO::FETCH_ASSOC)

        // Verificar si no hay registros
        if (empty($profesores)) {
            $profesores[] = ['id_profesor' => 99, 'profesor' => '99']; // Agregar el valor predeterminado
        }

        // Retornar la lista de profesores
        return $profesores;

    } catch (PDOException $e) {
        die("Error al obtener los profesores de la asignatura: " . $e->getMessage());
    }
}



function obtenerAsignaturas() {
    try {
        $conn = getDbConnection();
        $sql = "SELECT * FROM `asignaturas`"; // Consulta para obtener todas las asignaturas
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve todas las asignaturas como un array asociativo
    } catch (PDOException $e) {
        echo "Error al obtener las asignaturas: " . $e->getMessage();
        return [];
    }
}
