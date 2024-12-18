<?php
// Carga configuración completa
include_once("../config/config.php");
include_once("../contenidos/creadores.php");
include_once("../contenidos/horario.php");

//validar rol
validarRol(['admin', 'coordinador']);
$formulario = new Formularios();


// Incluye las clases necesarias para el encabezado y pie de página


// Crea una instancia del generador de encabezado
?>

<!DOCTYPE html>
<html lang="es">
<head>
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
            <div class="col-md-12 pop" id="popup"></div>
            <div class="col-md-12" >
        
        <?php 
           $horarios = [
            //new Horario(1, "08:00 - 08:45", "Matemática", "Profesor 1", "3°A", "Lunes", "28/11/2024", "28/12/2024","sala","codigo curso"),
            new Horario(1, "08:00 - 08:45", "Matemática", "Profesor 1", "3°A", "Lunes", "28/11/2024", "28/12/2024"),
            new Horario(2, "08:45 - 09:30", "Matemática", "Profesor 1", "3°A", "Lunes", "28/11/2024", "28/12/2024"),
            new Horario(3, "09:30 - 10:15", "Lenguaje", "Profesor 2", "3°A", "Martes", "28/11/2024", "28/12/2024"),
            new Horario(4, "10:15 - 11:00", "Ciencias", "Profesor 3", "3°A", "Miércoles", "28/11/2024", "28/12/2024"),
            new Horario(5, "11:00 - 11:45", "Historia", "Profesor 4", "3°A", "Jueves", "28/11/2024", "28/12/2024"),
            new Horario(6, "11:45 - 12:30", "Inglés", "Profesor 5", "3°A", "Viernes", "28/11/2024", "28/12/2024"),
            new Horario(7, "12:30 - 13:00", "Educación Física", "Profesor 6", "3°A", "Lunes", "28/11/2024", "28/12/2024"),
            new Horario(8, "14:00 - 14:45", "Artes", "Profesor 7", "3°A", "Lunes", "28/11/2024", "28/12/2024"),
            new Horario(9, "14:45 - 15:30", "Tecnología", "Profesor 8", "3°A", "Viernes", "28/11/2024", "28/12/2024"),
        ];
        $titulo="titulo "; 
           generarHorario($titulo, $horarios);
        ?>
            </div>
        <!-- Botón para abrir el menú lateral en dispositivos móviles -->
        <button class="btn btn-primary d-md-none" id="sidebarToggleBtn">
                <i class="fas fa-bars"></i>
            </button>
           
            <?php            
                // Llamar a la función para generar el menú lateral
                generateSidebarMenu("Horario docentes", $userName, $userRole);
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
