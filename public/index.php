<?php
// Carga configuración completa
include_once("../config/config.php");
include_once("../contenidos/creadores.php");
include_once("../contenidos/horario.php");

validasesion();
// Validar rol
validarRol(['admin', 'coordinador']);
if (isset($_SESSION['rol']) && $_SESSION['rol'] === "docente") {
    header("Location: horarioprofesor.php");
    exit; // Asegurarse de que no se ejecuta ningún código después de la redirección
}
$formulario = new Formularios();

// Incluye las clases necesarias para el encabezado y pie de página
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php
        $header = new HeaderGenerator("Inicio Colegio San Felipe", ["menu.css","table.css","popup.css"]);
        $header->renderHeader();
    ?>
    <!-- El encabezado ya se genera con la clase HeaderGenerator -->
</head>
<body>
    <header>
        <!-- Aquí puede ir una barra de navegación o contenido relacionado -->
    </header>
    
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="table-responsive mobile">Gestión usuarios actualizado</h1>
            </div>
  <!-- Botón para abrir el me   nú lateral en dispositivos móviles -->
  <button class="btn btn-primary d-md-none" id="sidebarToggleBtn">
                <i class="fas fa-bars"></i>
            </button>
            
             <!-- Menú lateral (solo en pantallas grandes) -->
             <?php
                // Llamar a la función para generar el menú lateral
             generateSidebarMenu("Inicio", $userName, $userRole);
            ?>
         


           

            <div class="container">
  <div class="row">
    <div class="col-md-12">
      <!-- Contenido aquí -->
      <?php
// Llamada a la función para mostrar la tabla
mostrarTablausuarios($todos);
?>
    </div>
  </div>
</div>
           

        </div>
    </div>

    <?php
    // Crea una instancia del generador de pie de página y carga los scripts
    $footer = new FooterGenerator(["menu.js"]);
    $footer->renderFooter();
    ?>

    <!-- Incluir Bootstrap JS (necesario para el modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
