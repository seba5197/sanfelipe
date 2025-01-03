<?php
// Carga configuración completa
include_once("../config/config.php");
include_once("../contenidos/creadores.php");
include_once("../contenidos/horario.php");
validasesion();
//validar rol
validarRol(['admin', 'coordinador','docente']);
$formulario = new Formularios();




// Incluye las clases necesarias para el encabezado y pie de página


// Crea una instancia del generador de encabezado
?>

<!DOCTYPE html>
<html lang="es">
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <?php
        $header = new HeaderGenerator("Inicio Colegio San Felipe", ["menu.css"]);
        $header->renderHeader();
    ?>
    <!-- El encabezado ya se genera con la clase HeaderGenerator -->
</head>
<body>
    <header>
        
        <!-- Aquí puede ir una barra de navegación o contenido relacionado -->
    </header>
    <div class="container-fluid">
        <div class="row">
        

        
        <?php 
           
        $titulo="titulo "; 
// Llamada a la función para mostrar los horarios
$idProfesor = $_SESSION['id_usuarios'];

generarTablasHorarios($idProfesor);        ?>
            </div>
        <!-- Botón para abrir el menú lateral en dispositivos móviles -->
        <button class="btn btn-primary d-md-none" id="sidebarToggleBtn">
                <i class="fas fa-bars"></i>
            </button>
           
            <?php            
                // Llamar a la función para generar el menú lateral
                generateSidebarMenu("Inicio", $userName, $userRole);
            ?>

            <!-- Contenido Principal -->
          
        </div>
      
       
    </div>

 
    <?php
    
    // Crea una instancia del generador de pie de página y carga los scripts
    $footer = new FooterGenerator(["menu.js"]);
    $footer->renderFooter();
    ?>

</body>
</html>
