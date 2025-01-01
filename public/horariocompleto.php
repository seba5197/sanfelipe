<?php
// Carga configuración completa
include_once("../config/config.php");
include_once("../contenidos/creadores.php");
include_once("../contenidos/horario.php");
validasesion();
//validar rol
validarRol(['admin', 'coordinador']);
$formulario = new Formularios();
validarURL();
if (isset($_GET['codigo'])) {
    // Obtener el valor del parámetro 'codigo' de la URL
    $codigo = $_GET['codigo'];
    echo "El código es: " . htmlspecialchars($codigo);
} else {
    // Mostrar mensaje si el parámetro 'codigo' no está en la URL
    echo "El código no está disponible. Serás redirigido a la página anterior en <span id='countdown'>3</span> segundos.";
    echo "<script>
            let countdown = 3;
            const countdownElement = document.getElementById('countdown');
            const interval = setInterval(function() {
                countdown--;
                countdownElement.textContent = countdown;
                if (countdown <= 0) {
                    clearInterval(interval);
                    window.history.back(); // Redirige a la página anterior
                }
            }, 1000); // Actualiza el contador cada segundo
          </script>";
}


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
mostrarHorariosPorCodigo("$codigo");        ?>
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
