<?php

require_once '../lib/conexion.php';
// Roles.php

// Simulando roles como si vinieran de la base de datos
function obtenerRolPorId($id_roles) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();
        // Preparar la consulta SQL
        $sql = "SELECT rol FROM roles WHERE id_roles = :id_roles";
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);
        // Asociar el parámetro
        $stmt->bindParam(':id_roles', $id_roles, PDO::PARAM_INT);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener el resultado
        $rol = $stmt->fetch(PDO::FETCH_ASSOC);
        // Retornar el rol si existe, o null si no existe
        return $rol ? $rol['rol'] : null;
    } catch (PDOException $e) {
        die("Error al obtener el rol: " . $e->getMessage());
    }
}

function obtenerIdRolPorNombre($nombreRol) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Preparar la consulta SQL
        $sql = "SELECT id_roles FROM roles WHERE rol = :nombreRol";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Asociar el parámetro
        $stmt->bindParam(':nombreRol', $nombreRol, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $idRol = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retornar el ID del rol si existe, o null si no existe
        return $idRol ? $idRol['id_roles'] : null;
    } catch (PDOException $e) {
        die("Error al obtener el ID del rol: " . $e->getMessage());
    }
}

function obtenerRolesUsuario($id_usuario) {
    try {
        // Obtener la conexión a la base de datos
        $conn = getDbConnection();
        // Consulta SQL para obtener los roles del usuario
        $sqlRoles = "SELECT`rol` FROM `usuario-roles` WHERE `usuario` = :id_usuario";
        // Preparar la consulta
        $stmt = $conn->prepare($sqlRoles);
        // Asociar el parámetro
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener todos los roles
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Si hay roles, devolverlos; de lo contrario, devolver un arreglo vacío
        return $roles ? $roles : [];
    } catch (PDOException $e) {
        die("Error al obtener los roles: " . $e->getMessage());
    }
}

//validamos conexión, es ok.
function pruebarol(){
$id_roles = 2; // Cambia el valor según tu necesidad
$nombreRol = obtenerRolPorId($id_roles);

if ($nombreRol) {
    echo "El rol con ID $id_roles es: $nombreRol";
} else {
    echo "No se encontró un rol con ID $id_roles.";
}
}

function validasesion(){
    if (!isset($_SESSION['username'])) {
        // Si no hay una variable de sesión 'user', redirige al usuario a la página de login o a donde desees
     
        session_unset();
    
        // Destruir la sesión
        session_destroy();
        header('Location: login.php'); // Cambia 'login.php' a la URL de la página de inicio de sesión
        exit(); // Asegúrate de detener la ejecución después de redirigir
        
    }
}


// Función switch que ejecuta la función según el rol dinámicamente
function switchRole($funcion, $rol) {
    // Crear el nombre de la función dinámicamente con el rol
    $funcionRol = $funcion . ucfirst($rol);  // Ejemplo: 'funcionAdmin', 'funcionDocentes', etc.

    // Verificar si la función existe
    if (function_exists($funcionRol)) {
        return call_user_func($funcionRol);  // Ejecutar la función dinámica
    } else {
        return "Función no disponible para el rol '$rol'.";
    }
}


// Función para validar el rol del usuario con múltiples roles permitidos
function validarRol($rolesPermitidos) {
    // Iniciar la sesión
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Comprobar si la variable de sesión que contiene el rol existe
    if (isset($_SESSION['rol'])) {
        // Comprobar si el rol del usuario está en el array de roles permitidos
        if (!in_array($_SESSION['rol'], $rolesPermitidos)) {
            $paginaActual = basename($_SERVER['SCRIPT_NAME']); // Devuelve "index.php" si estás en esa página

            if ($paginaActual === "index.php" && isset($_SESSION['rol']) && $_SESSION['rol'] === "docente") {
                header("Location: horarioprofesor.php");
                exit; // Detener la ejecución
            }
            
            // Si el rol no es permitido, mostrar un mensaje de error y redirigir a login.php
            echo '<script>alert("No tienes permisos suficientes para acceder a esta página."); window.location.href = "login.php";</script>';
            exit();  // Detener la ejecución del código
        }
    } else {
        // Si no hay sesión o el rol no está definido, redirigir a login.php
        header("Location: login.php");
        
        exit();
    }

}

//roles existentes 1 -> admin 2-> docente 3->alumno 4 -> coordinador 99-> sin asignar (por defecto al crear usuario)
function asignarRol($idUsuario, $idRol) {
    try {
        // Obtener la conexión a la base de datos
        $conn = getDbConnection();

        // Verificar si el rol ya está asignado al usuario
        $sqlVerificar = "SELECT COUNT(*) FROM `usuario-roles` WHERE `usuario` = :idUsuario AND `rol` = :idRol";
        $stmt = $conn->prepare($sqlVerificar);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':idRol', $idRol, PDO::PARAM_INT);
        $stmt->execute();

        // Si el rol ya está asignado, no realizar ninguna acción
        if ($stmt->fetchColumn() > 0) {
            return "El rol ya está asignado al usuario.";
        }

        // Insertar el rol para el usuario
        $sqlInsertar = "INSERT INTO `usuario-roles` (`usuario`, `rol`) VALUES (:idUsuario, :idRol)";
        $stmt = $conn->prepare($sqlInsertar);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':idRol', $idRol, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "Rol asignado correctamente.";
        } else {
            return "Error al asignar el rol.";
        }
    } catch (PDOException $e) {
        return "Error al asignar rol: " . $e->getMessage();
    }
}

//asigna rol automatico en el primer uso al usuario para admin
function asignarRolAdminAutomatico($idUsuario) {
    try {
        // Obtener la conexión a la base de datos
        $conn = getDbConnection();

        // Verificar si hay datos en la tabla `usuario-roles`
        $sqlVerificar = "SELECT COUNT(*) FROM `usuario-roles`";
        $stmtVerificar = $conn->prepare($sqlVerificar);
        $stmtVerificar->execute();
        
        // Si el conteo es 0, significa que la tabla está vacía
        $count = $stmtVerificar->fetchColumn();
        
        if ($count == 0) {
            // Si la tabla está vacía, asignamos el rol admin (rol = 1) al primer usuario
            $sqlInsertar = "INSERT INTO `usuario-roles` (`usuario`, `rol`) VALUES (:idUsuario, 1)";
            $stmtInsertar = $conn->prepare($sqlInsertar);
            $stmtInsertar->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmtInsertar->execute();
           
            echo "La tabla estaba vacía, se asignó el rol de admin al primer usuario.";
        } else {
            //echo "La tabla ya tiene datos, no se asignó ningún rol.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

function obtenerListaRoles() {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener todos los roles
        $sql = "SELECT id_roles, rol FROM roles";

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Obtener todos los resultados
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $roles;
    } catch (PDOException $e) {
        die("Error al obtener la lista de roles: " . $e->getMessage());
    }
}
function mostrarSelectRoles($roles) {
    $select = '<select class="form-control" name="id_roles" required>';
    $select .= '<option value="" disabled selected>Seleccione un rol</option>';
    
    // Recorrer los roles y agregar las opciones al select
    foreach ($roles as $rol) {
        $select .= '<option value="' . htmlspecialchars($rol['id_roles']) . '">' . htmlspecialchars($rol['rol']) . '</option>';
    }

    $select .= '</select>';
    return $select;
}
function obtenerRolPorIddeusuario($id) {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Consulta SQL para obtener el rol del usuario por su ID
        $sql = "SELECT * FROM `usuario-roles`
 WHERE usuario = :id";

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el resultado
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si se encontró un rol, devolverlo
        return $resultado ? $resultado['rol'] : null;
    } catch (PDOException $e) {
        die("Error al obtener el rol del usuario: " . $e->getMessage());
    }
}

?>