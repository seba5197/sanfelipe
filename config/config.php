<?php



//carga de archivos de configuración
include_once("constantes.php");
include_once("roles.php");
include_once("../includes/head.php");
include_once("../includes/footer.php");
include_once("../includes/menu.php");
include_once("../lib/todaslasconsultas.php");
include_once("seguridad.php");
include_once('../contenidos/basehtml.php');

// Aplica la validación en cada solicitud


//simulamos la session
//session_start();

session_start();


// Si la sesión está iniciada, continuar con el código normal

$userRole = $_SESSION['rol'];
$userName=$_SESSION['username'];
?>