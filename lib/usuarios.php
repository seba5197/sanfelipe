<?php
include_once '../config/config.php';

//verificación de usuarios 

function authenticateUser($username, $password) {
    // Obtener la conexión a la base de datos
    $conn = getDbConnection();

    // Consulta para verificar si el usuario y la contraseña coinciden
    $sql = "SELECT id, usuario, rol FROM usuarios WHERE usuario = :usuario AND contraseña = :contraseña";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuario', $username);
    $stmt->bindParam(':contraseña', $password); // En un sistema real, deberías usar hash para la contraseña
    $stmt->execute();

    // Verificar si se encontró el usuario
    if ($stmt->rowCount() > 0) {
        // Recuperar los datos del usuario (id y rol)
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Guardar los datos del usuario en la sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['role'] = $user['rol'];

        // Devolver los datos de sesión
        return [
            'session' => $_SESSION,
            'role' => $user['rol']
        ];
    } else {
        return false; // Usuario o contraseña incorrectos
    }
}

?>