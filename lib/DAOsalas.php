<?php



function crearSala($sala, $capacidad) {
    try {
        $conn = getDbConnection();
        $sql = "INSERT INTO salas (sala, capacidad) VALUES (:sala, :capacidad)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sala', $sala, PDO::PARAM_STR);
        $stmt->bindParam(':capacidad', $capacidad, PDO::PARAM_INT);
        $stmt->execute();
        echo "Sala creada exitosamente.";
    } catch (PDOException $e) {
        die("Error al crear la sala: " . $e->getMessage());
    }
}
function editarSala($id_sala, $sala, $capacidad) {
    try {
        $conn = getDbConnection();
        $sql = "UPDATE salas SET sala = :sala, capacidad = :capacidad WHERE id_salas = :id_salas";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_salas', $id_sala, PDO::PARAM_INT);
        $stmt->bindParam(':sala', $sala, PDO::PARAM_STR);
        $stmt->bindParam(':capacidad', $capacidad, PDO::PARAM_INT);
        $stmt->execute();
        echo "Sala editada exitosamente.";
    } catch (PDOException $e) {
        die("Error al editar la sala: " . $e->getMessage());
    }
}
function eliminarSala($id_sala) {
    try {
        $conn = getDbConnection();
        $sql = "DELETE FROM salas WHERE id_salas = :id_salas";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_salas', $id_sala, PDO::PARAM_INT);
        $stmt->execute();
        echo "Sala eliminada exitosamente.";
    } catch (PDOException $e) {
        die("Error al eliminar la sala: " . $e->getMessage());
    }
}
function listarSalasEnGrid() {
    try {
        $conn = getDbConnection();
        $sql = "SELECT id_salas, sala, capacidad FROM salas";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $salas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($salas) {
            echo '<div class="row">';

            $contador = 0;
            foreach ($salas as $sala) {

                $urleditar = protegerURL('../controladores/salas.php?opcion=editar&id_sala='.$sala['id_salas']);
                $urleliminar = protegerURL('../controladores/salas.php?opcion=eliminar&id_sala='.$sala['id_salas']);

                
                if ($contador % 3 == 0 && $contador != 0) {
                    echo '</div><div class="row">';
                }

                echo '<div class="col-md-4">';
                echo '<div class="card mb-3">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">Sala: ' . htmlspecialchars($sala['sala']) . '</h5>';
                echo '<p class="card-text">Capacidad: ' . htmlspecialchars($sala['capacidad']) . '</p>';
                echo '<a href="' .$urleditar . '" class="btn btn-primary">Editar</a> ';
                echo '<a href="' .$urleliminar . '" class="btn btn-danger" onclick="return confirm(\'¿Estás seguro de eliminar esta sala?\');">Eliminar</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                $contador++;
            }

            echo '</div>';
        } else {
            echo 'No hay salas disponibles.';
        }
    } catch (PDOException $e) {
        die("Error al listar las salas: " . $e->getMessage());
    }
}
function listarSalasPorIdCurso($id_curso) {
    try {
        $conn = getDbConnection();

        // Consulta SQL para obtener los ID de las salas asociadas con el curso
        $sql = "SELECT id_sala FROM `curso-sala` WHERE `id_curso` = :id_curso";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
        $stmt->execute();

        $salas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si hay salas asociadas
        if ($salas) {
            $salasNombres = [];
            // Recorrer las salas obteniendo el nombre de cada una
            foreach ($salas as $sala) {
                // Obtener el nombre de la sala usando el id_sala
                $id_sala = $sala['id_sala'];
                $nombreSala = obtenerNombreSalaPorId($id_sala);
                if ($nombreSala) {
                    $salasNombres[] = $nombreSala;
                }
            }

            // Mostrar las salas como una lista separada por comas
            echo 'Sala asignada: ' . implode(', ', $salasNombres);
            $url=protegerURL("../controladores/cursos.php?opcion=asignarsala&id=$id_curso");
            echo '<br><a href="'.$url.'" class="btn btn-info">Editar Sala</a>';
        } else {

            $url=protegerURL("../controladores/cursos.php?opcion=asignarsala&id=$id_curso");
            echo '<a href="'.$url.'" class="btn btn-info">Asignar Sala</a>';
        }
    } catch (PDOException $e) {
        die("Error al obtener las salas: " . $e->getMessage());
    }
}

function obtenerNombreSalaPorId($id_sala) {
    try {
        $conn = getDbConnection();

        // Consulta SQL para obtener el nombre de la sala por id_sala
        $sql = "SELECT sala FROM `salas` WHERE `id_salas` = :id_sala";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_sala', $id_sala, PDO::PARAM_INT);
        $stmt->execute();

        $sala = $stmt->fetch(PDO::FETCH_ASSOC);
        return $sala ? $sala['sala'] : null;
    } catch (PDOException $e) {
        die("Error al obtener el nombre de la sala: " . $e->getMessage());
    }
}


function obtenerSalaPorId($idSala) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener la sala por ID
        $sql = "SELECT `id_salas`, `sala`, `capacidad` FROM `salas` WHERE `id_salas` = :id_salas";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_salas', $idSala, PDO::PARAM_INT);
        $stmt->execute();

        // Verificar si se obtuvo un resultado
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return null; // No se encontró la sala con ese ID
        }
    } catch (PDOException $e) {
        echo "Error al obtener la sala: " . $e->getMessage();
    }
}

function obtenerSalas() {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta para obtener las salas
        $sql = "SELECT id_salas, sala FROM salas";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Retornar las salas como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error al obtener las salas: " . $e->getMessage();
        return [];
    }
}