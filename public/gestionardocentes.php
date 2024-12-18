<?php
// Carga configuración completa
include_once("../config/config.php");
include_once("../contenidos/creadores.php");
include_once("../contenidos/horario.php");
include_once("../contenidos/listas.php");

// Validar rol
validarRol(['admin', 'coordinador']);
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
            <div class="col-md-8">
                <h1 class="mobile">Gestión docente</h1>
            </div>

<?php
// Llamada a la función para mostrar la tabla
mostrarTablaDocentes($docentes);
?>

            <!-- Botón para abrir el modal (popup) -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal">
                Crear Docente
            </button>

            <!-- Modal (Popup) con el formulario -->
            <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formModalLabel">Formulario para Crear Docente</h5>
                            <!-- Botón de cierre con la X -->
                            <button type="button" class="btn-close btn btn-danger" data-bs-dismiss="modal" aria-label="Cerrar">X</button>
                        </div>
                        <div class="modal-body">
                            <?php 
                                // Llamar al formulario dentro del modal
                                $formulario->crearFormularioDocente();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
  <div class="row">
    <div class="col-md-12">
      <!-- Contenido aquí -->
      <p>Este es un contenedor que ocupa las 12 columnas en pantallas medianas o superiores.</p>
    </div>
  </div>
</div>
            <!-- Menú lateral (solo en pantallas grandes) -->
            <?php
                // Llamar a la función para generar el menú lateral
                generateSidebarMenu("Gestionar docentes", $userName, $userRole);
            ?>

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
