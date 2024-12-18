<?php



//carga de archivos de configuración
include_once("../includes/head.php");
include_once("../includes/footer.php");
include_once("roles.php");
include_once("../includes/menu.php");
include_once("constantes.php");
//include_once("../lib/conexion.php");


//simulamos la session
session_start();
$_SESSION['rol'] = 'admin'; // Simular que el rol es admin (esto se obtiene de la base de datos o sesión)
$_SESSION['username'] = 'seba'; // Simular el nombre de usuario

// Obtener los valores de sesión
$userRole = $_SESSION['rol'] ?? 'guest'; // Si no hay rol en la sesión, asignar 'guest'
$userName = $_SESSION['username'] ?? 'Usuario'; // Si no hay nombre, asignar 'Usuario'
?>