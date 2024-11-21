<?php
// Función para generar la tabla de horario
function generarHorario($titulo) {
    // Definir las horas de inicio y fin
    $startHour = 8;  // 8:00 AM
    $endHour = 18;   // 6:00 PM
    $minutesIncrement = 45; // Intervalos de 45 minutos

    // Iniciar el array de tiempos
    $horas = [];
    
    // Generar los horarios de 45 minutos
    for ($i = 0; $startHour < $endHour || ($startHour == $endHour && $i < 30); $startHour++) {
        for ($min = 0; $min < 60; $min += $minutesIncrement) {
            $hourDisplay = str_pad($startHour, 2, "0", STR_PAD_LEFT) . ":" . str_pad($min, 2, "0", STR_PAD_LEFT);
            $horas[] = $hourDisplay;
        }
    }

    // Crear la tabla HTML
    echo '<div class="container">';
    echo '<h2 class="text-center my-4">Tabla de Horario '.$titulo.'</h2>';
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>Hora</th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr></thead>';
    echo '<tbody>';

    // Rellenar la tabla con horarios
    foreach ($horas as $hora) {
        echo '<tr>';
        echo '<td>' . $hora . '</td>';
        for ($i = 0; $i < 5; $i++) { // 5 columnas para los días de la semana
            echo '<td><input type="text" class="form-control" placeholder="Asignar actividad"></td>';
        }
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

// Llamar a la función para mostrar la tabla

?>