<?php


// Carga configuración completa
include_once("../config/config.php");
include_once("../contenidos/login.php");
// Llamar a la función para verificar el primer uso
validarURL();

// Crea una instancia del generador de encabezado
?>






<!DOCTYPE html>
<html lang="es">
<head>
    <?php
        $header = new HeaderGenerator("recuperar pass Colegio San Felipe", ["login.css"]);
        $header->renderHeader();
    ?>
    <!-- El encabezado ya se genera con la clase HeaderGenerator -->
</head>
<body>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['opcion']) && $_GET['opcion'] == 'restablecer') {
    
    $correo=$_GET['correo'] ;

$url=protegerURL("restablecer_contrasena.php");
    $formulario='Pendiente terminar codigo
    <form action="'.$url.'" method="POST">
        <label for="nueva_contrasena">Ingrese su nueva contraseña:</label>
        <input type="hidden" id="correo" name="correo" value="'. $correo.'">
        <input type="password" id="nueva_contrasena" name="nueva_contrasena" required>
        <button type="submit" class="btn btn-submit">Restablecer Contraseña</button>
    </form>';

    echo $formulario;
    die();
   
}        
                

    
                // Llamar a la función para generar el contenido del login
                if (isset($_POST['correo'])) {
                  
                    // Obtener el valor del parámetro 'codigo' de la URL
                    recuperacontrasena($_POST['correo']);
                    
           
                } 
                
                else{
                    
                    $formulario = '
                    <div class="fullscreen-container">
                        
                        <form class="login-form" action="'.$url.'" method="post">
                            <h3>Recuperar pass</h3>
                            <label for="correo">Ingresa tu correo</label>
                
                        <input type="email" id="correo" name="correo" placeholder="ejemplo@dominio.com" required>

                            <hr><button type="submit" class="btn btn-success">Restablecer</button>
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
