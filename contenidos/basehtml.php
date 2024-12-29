<?php
function web($formulario) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php
            // Crea una instancia de HeaderGenerator y genera el encabezado
            $header = new HeaderGenerator("Editar contenido", ["login.css"]);
            $header->renderHeader();
        ?>
    </head>
    <body>
        <?php
            // Imprime el contenido dinámico del formulario
            echo $formulario; 
        ?>
        <?php
            // Crea una instancia de FooterGenerator y genera el pie de página
            $footer = new FooterGenerator(["menu.js"]);
            $footer->renderFooter();
        ?>
    </body>
    </html>
    <?php
}
