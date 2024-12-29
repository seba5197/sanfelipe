<?php


// Carga configuración completa
include_once("../config/config.php");
include_once("../contenidos/login.php");
// Llamar a la función para verificar el primer uso
verificarPrimerUso();
session_destroy();

// Crea una instancia del generador de encabezado
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php
        $header = new HeaderGenerator("Login Colegio San Felipe", ["login.css"]);
        $header->renderHeader();
    ?>
    <!-- El encabezado ya se genera con la clase HeaderGenerator -->
</head>
<body>
  
    <?php            
                // Llamar a la función para generar el contenido del login
                renderLoginForm();
            ?>

 
<?php
    // Crea una instancia del generador de pie de página y carga los scripts
    $footer = new FooterGenerator(["menu.js"]);
    $footer->renderFooter();
    ?>


</body>
</html>
