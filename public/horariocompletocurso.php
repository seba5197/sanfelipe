<?php


// Carga configuración completa
include_once("../config/config.php");
include_once("../contenidos/login.php");
// Llamar a la función para verificar el primer uso

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
                if (isset($_POST['curso'])) {
                    // Obtener el valor del parámetro 'codigo' de la URL
                    $codigo=obtenerCodigoHorarioPorCurso($_POST['curso']);
                    
                    mostrarHorariosPorCodigo("$codigo");     
                
                } else {
                    $formulario = '
                    <div class="fullscreen-container">
                        
                        <form class="login-form" action="" method="post">
                            <h3>seleccionar Curso</h3>
                            <label for="curso">Selecciona un Curso</label>';
                
                    // Llamar a la función listarCursosEnSelect() para generar el select con los cursos
                    ob_start(); // Capturar la salida de listarCursosEnSelect()
                    listarCursosEnSelect();
                    $formulario .= ob_get_clean();  // Agregar el contenido generado a la variable $formulario
                    
                    // Botón de submit
                    $formulario .= '
                            <hr><button type="submit" class="btn btn-success">buscar horario</button>
                        </form>
                    </div>';
                   
                    
                        echo $formulario;
                }            ?>

 
<?php
    // Crea una instancia del generador de pie de página y carga los scripts
    $footer = new FooterGenerator(["menu.js"]);
    $footer->renderFooter();
    ?>


</body>
</html>
