<?php
class FooterGenerator {

    private $scripts;

    public function __construct($scripts = []) {
        $this->scripts = $scripts;
    }

    public function renderFooter() {
      // Enlace a jQuery
    echo '<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>';
    
    // Enlace a Bootstrap JS y dependencias
    echo '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>';
    echo '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';

    // Enlace a Select2 CSS y JS
    echo '<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>';

    // Archivo de funciones personalizadas
    echo '<script src="../assets/js/funciones.js"></script>';



        
        // Enlace a archivos JavaScript adicionales
        foreach ($this->scripts as $script) {
            echo '<script src="../assets/js/' . htmlspecialchars($script) . '"></script>';
        }
    }
}
?>
