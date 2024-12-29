<?php

function obtenerUsuarioPorId($idUsuario) {
    try {
        // Obtener la conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener los datos del usuario
        $sql = "SELECT * FROM usuarios WHERE id_usuarios = :idUsuario AND activo = 1";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Asociar el parámetro
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retornar los datos del usuario o false si no se encontró
        return $usuario ? $usuario : false;
    } catch (PDOException $e) {
        // Manejo de errores
        die("Error al obtener el usuario: " . $e->getMessage());
    }
}


function obteneridusuariosxrol($idrol) {


    try {
        // Obtener la conexión
        $conn = getDbConnection();
        // Consulta SQL para obtener los datos del usuario-roles se obtienen todos los id de docentes
        $sqlUsuario = "SELECT `usuario` FROM `usuario-roles` WHERE `rol` = :rol";
        // Preparar la consulta
        $stmt = $conn->prepare($sqlUsuario);
        $stmt->bindParam(':rol', $idrol, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();
        // Obtener id de todos los id x rol
        $listadeidxrol = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    return $listadeidxrol;

                
    } catch (PDOException $e) {
        die("<br>Error al obtener lista de id por rol " . $e->getMessage());
    }
}



function crearUsuario($nombre, $apellido, $correo, $telefono, $pass, $rut) {
    try {

        $rut = preg_replace('/[^0-9kK]/', '', $rut); // Eliminar caracteres no válidos
        $rut = strtolower($rut); // Convertir cualquier 'K' a minúscula 'k'
        // Obtener la conexión a la base de datos
        $conn = getDbConnection(); // Asegúrate de tener esta función que devuelve la conexión a la base de datos.

        // Preparar la consulta SQL para insertar los datos del nuevo usuario
        $sql = "INSERT INTO usuarios (nombre, apellido, correo, telefono, pass, rut) 
                VALUES (:nombre, :apellido, :correo, :telefono, :pass, :rut)";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Asociar los parámetros
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el último ID insertado
        $ultimoId = $conn->lastInsertId();
        asignarRolAdminAutomatico($ultimoId);
        // Retornar el último ID insertado
        return $ultimoId;
    } catch (PDOException $e) {
        // Manejar errores en caso de fallo en la conexión o ejecución
        die("Error al crear el usuario: " . $e->getMessage());
    }
}



function verificarPrimerUso() {
    try {
        // Obtener la conexión a la base de datos
        $conn = getDbConnection();

        // Verificar si la tabla `usuario-roles` tiene datos
        $sqlVerificar = "SELECT COUNT(*) FROM `usuario-roles`";
        $stmtVerificar = $conn->prepare($sqlVerificar);
        $stmtVerificar->execute();
        
        // Obtener el conteo de registros
        $count = $stmtVerificar->fetchColumn();

        // Si la tabla está vacía, redirigir a la creación del primer usuario
        if ($count ==    0) {
            $url=protegerURL("../public/crearusuarios.php?opcion=primeruso");
            header('Location:'.$url); // Reemplaza con la ruta correcta para crear el primer usuario
            exit();
        } 
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

function eliminarUsuario($idUsuario) {
    try {
        // Obtener la conexión a la base de datos
        $conn = getDbConnection(); // Asegúrate de tener esta función que devuelve la conexión a la base de datos.

        // Preparar la consulta SQL para eliminar al usuario
        $sql = "DELETE FROM usuarios WHERE id_usuarios = :idUsuario";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Asociar el parámetro
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si se eliminó al menos un usuario
        if ($stmt->rowCount() > 0) {
            return "Usuario eliminado exitosamente.";
        } else {
            return "No se encontró el usuario o no se eliminó.";
        }
    } catch (PDOException $e) {
        // Manejar errores en caso de fallo en la conexión o ejecución
        die("Error al eliminar el usuario: " . $e->getMessage());
    }
}

function editarUsuario($idUsuario, $nombre, $apellido, $correo, $telefono, $rut) {
    // Establecer la conexión a la base de datos
    global $conn;

    // SQL para actualizar los datos del usuario sin modificar la contraseña
    $sql = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, correo = :correo, telefono = :telefono, rut = :rut WHERE id_usuarios = :idUsuario";
    $stmt = $conn->prepare($sql);

    // Asociar los valores con los parámetros
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
    $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

    // Ejecutar la consulta
    try {
        $stmt->execute();
        return "Usuario actualizado con éxito.";
    } catch (PDOException $e) {
        return "Error al actualizar el usuario: " . $e->getMessage();
    }
}



function asignarRolAUsuario($idUsuario) {
    try {
        // Obtener la conexión a la base de datos
        $conn = getDbConnection();

        // Verificar si el usuario ya tiene el rol 1
        $sqlVerificar = "SELECT COUNT(*) FROM `usuario-roles` WHERE `usuario` = :idUsuario AND `rol` = 1";
        $stmtVerificar = $conn->prepare($sqlVerificar);
        $stmtVerificar->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmtVerificar->execute();
        
        // Si el conteo es mayor que 0, significa que el rol ya está asignado
        $count = $stmtVerificar->fetchColumn();
        
        if ($count == 0) {
            // Si no existe, entonces insertamos el nuevo rol para el usuario
            $sqlInsertar = "INSERT INTO `usuario-roles` (`usuario`, `rol`) VALUES (:idUsuario, 1)";
            $stmtInsertar = $conn->prepare($sqlInsertar);
            $stmtInsertar->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmtInsertar->execute();

            echo "Rol asignado correctamente al usuario $idUsuario.";
        } else {
            echo "El rol 1 ya está asignado al usuario $idUsuario.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
function eliminarLogicoUsuario($usuarioId) {
    try {
        // Crear la conexión a la base de datos
        $conexion = getDbConnection();

        // Consulta SQL para el eliminado lógico
        $query = "UPDATE `usuarios` SET `activo` = 0 WHERE `id_usuarios` = :usuarioId";
        $stmt = $conexion->prepare($query);

        // Vincular el parámetro
        $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "El usuario con ID $usuarioId ha sido desactivado correctamente.";
        } else {
            echo "Error al intentar desactivar el usuario.";
        }
    } catch (PDOException $e) {
        // Manejo de errores
        error_log("Error al eliminar lógicamente al usuario: " . $e->getMessage());
        die("Ocurrió un error al intentar desactivar el usuario.");
    }
}


?>
