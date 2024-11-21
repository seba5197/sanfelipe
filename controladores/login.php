<?php

include_once '../config/config.php';

session_start(); // Iniciar la sesión

function validarUsuario($username, $password) {
    // Simulando datos de usuarios con roles (en producción, estos datos vendrían de una base de datos)
    $usuarios = [
        'adminuser' => ['password' => '1234', 'role' => 'admin'],
        'docenteuser' => ['password' => 'abcd', 'role' => 'docente'],
        'alumnouser' => ['password' => 'pass123', 'role' => 'alumno']
    ];

    // Validar si el usuario existe y la contraseña es correcta
    if (isset($usuarios[$username]) && $usuarios[$username]['password'] === $password) {
        // Si las credenciales son válidas, devolver los datos del usuario
        return [
            'username' => $username,
            'role' => $usuarios[$username]['role']
        ];
    }

    // Retornar null si las credenciales no son válidas
    return null;
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']) ?? '';
    $password = trim($_POST['password']) ?? '';

    // Llamar a la función para validar el usuario
    $usuarioValido = validarUsuario($username, $password);

    if ($usuarioValido) {
        // Credenciales válidas - guardar datos en la sesión
        $_SESSION['username'] = $usuarioValido['username'];
        $_SESSION['role'] = $usuarioValido['role'];

        // Redireccionar a una página de bienvenida o panel de control
        header("Location: ../public/welcome.php");
        exit();
    } else {
        // Credenciales no válidas - mostrar mensaje de error
        echo 'Usuario o contraseña incorrectos. <a href="../public/login.php">Volver</a>';
    }
} else {
    // Si se accede directamente al archivo, redirigir al formulario de inicio de sesión
    header("Location: ../public/login.php");
    exit();
}
?>