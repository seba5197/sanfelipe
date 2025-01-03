<?php
function web($formulario) {
    validarRol(['admin', 'coordinador']);

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
<script>
    $(document).ready(function() {
    // Agregar el enlace de "Volver atrás" a todos los formularios con la clase 'login-form'
    $('.login-form').each(function() {
        var volverLink = '<a href="javascript:history.back()" style="position: absolute; bottom: 10px; right: 10px; text-decoration: none; color: #007bff;">Volver atrás</a>';
        $(this).append(volverLink);  // Agregar el enlace al final de cada formulario
    });
});
</script>

    </html>
    <?php
}
