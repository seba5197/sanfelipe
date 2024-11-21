<?php

class HeaderGenerator {
    private $title;
    private $stylesheets;
   

    public function __construct($title = "Colegio San Felipe", $stylesheets = []) {
        $this->title = $title;
        $this->stylesheets = $stylesheets;
    
    }


    public function renderHeader() {

      
        
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>' . htmlspecialchars($this->title) . '</title>';
        // Enlace a Bootstrap CSS
        echo '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">';
        echo '<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">';
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">';
        // Enlace a hojas de estilo adicionales
        foreach ($this->stylesheets as $stylesheet) {
            echo '<link rel="stylesheet" href="../assets/css/' . htmlspecialchars($stylesheet) . '">';
        }
        

    }

}
?>