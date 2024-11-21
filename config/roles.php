<?php


// Roles.php

// Simulando roles como si vinieran de la base de datos
function getRolesFromDatabase() {
    // Simulando que estos roles vienen de la base de datos
    return [
        'admin',
        'docentes',
        'coordinadores',
        'alumnos',
        'gestor'
    ];
}
function getUserRole() {
    // Verifica si la variable de sesión 'role' está definida y tiene un valor
    if (isset($_SESSION['role'])) {
        return $_SESSION['role'];
    } else {
        // Si no está definido el rol en la sesión, puedes devolver un valor por defecto o null
        return null;  // o podrías devolver 'guest' si prefieres tener un rol por defecto
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
            // Si el rol no es permitido, mostrar un mensaje de error y redirigir a login.php
            echo '<script>alert("No tienes permisos suficientes para acceder a esta página."); window.location.href = "login.php";</script>';
            exit();  // Detener la ejecución del código
        }
    } else {
        // Si no hay sesión o el rol no está definido, redirigir a login.php
        //header("Location: login.php");
        
        exit();
    }

}
?>