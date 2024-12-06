<?php

class Horario {
    // Definir todas las propiedades de la clase
    public $id;
    public $hora;
    public $asignatura;
    public $docente;
    public $curso;
    public $dia;
    public $fechaInicio;
    public $fechaFin;

    // Constructor para inicializar los valores
    public function __construct($id, $hora, $asignatura, $docente, $curso, $dia, $fechaInicio, $fechaFin) {
        $this->id = $id;               // Asignar el ID
        $this->hora = $hora;           // Asignar la hora
        $this->asignatura = $asignatura; // Asignar la asignatura
        $this->docente = $docente;      // Asignar el docente
        $this->curso = $curso;          // Asignar el curso
        $this->dia = $dia;              // Asignar el día
        $this->fechaInicio = $fechaInicio; // Asignar fecha de inicio
        $this->fechaFin = $fechaFin;     // Asignar fecha de fin
    }
}

// Datos ficticios del horario
$horarios = [
    new Horario(1, "08:00 - 08:45", "Matemática", "Profesor 1", "3°A", "Lunes", "28/11/2024", "28/12/2024"),
    new Horario(2, "08:45 - 09:30", "Matemática", "Profesor 1", "3°A", "Lunes", "28/11/2024", "28/12/2024"),
    new Horario(3, "09:30 - 10:15", "Lenguaje", "Profesor 2", "3°A", "Martes", "28/11/2024", "28/12/2024"),
    new Horario(4, "10:15 - 11:00", "Ciencias", "Profesor 3", "3°A", "Miércoles", "28/11/2024", "28/12/2024"),
    new Horario(5, "11:00 - 11:45", "Historia", "Profesor 4", "3°A", "Jueves", "28/11/2024", "28/12/2024"),
    new Horario(6, "11:45 - 12:30", "Inglés", "Profesor 5", "3°A", "Viernes", "28/11/2024", "28/12/2024"),
    new Horario(7, "12:30 - 13:00", "Educación Física", "Profesor 6", "3°A", "Lunes", "28/11/2024", "28/12/2024"),
    new Horario(8, "14:00 - 14:45", "Artes", "Profesor 7", "3°A", "Lunes", "28/11/2024", "28/12/2024"),
    new Horario(9, "14:45 - 15:30", "Tecnología", "Profesor 8", "3°A", "Viernes", "28/11/2024", "28/12/2024"),
];

function generarHorario($titulo, $horarios) {

    $fechaInicio = $horarios[0]->fechaInicio;
    $fechaFin = $horarios[0]->fechaFin;
    // Crear la tabla HTML
    echo '<div class="container">';
    echo '<h2 class="text-center my-4">Horario de ' . $titulo ." ". $fechaInicio ." - ". $fechaFin.  '</h2>';
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Hora</th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Agrupar horarios por curso
    $cursos = [];
    foreach ($horarios as $horario) {
        $cursos[$horario->curso][] = $horario;
    }

    // Recorrer los cursos y generar las filas para la tabla
    foreach ($cursos as $curso => $horariosCurso) {
        foreach ($horariosCurso as $index => $horario) {
            echo '<tr>';
            
            // Hora
            echo '<td>' . $horario->hora . '</td>';
            
            // Lunes a Viernes
            $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
            foreach ($dias as $dia) {
                $actividad = array_filter($horariosCurso, function($h) use ($dia) {
                    return $h->dia === $dia;
                });

                if (!empty($actividad)) {
                    $actividad = array_values($actividad)[0]; // Obtener el primer resultado
                    echo '<td>';
                    echo $actividad->asignatura . ' <br> ' . $actividad->docente;
                    // Agregar ícono y texto "Editar"
                    echo ' <a href="#" onclick="abrirPopupasignatura(\'' . $actividad->id . '\', \'' . $dia . '\')" class="edit-icon" data-dia="' . $dia . '" data-id="' . $actividad->id . '">';
                    echo '<img src="lapiz.png" alt="Editar" class="edit-icon-img"> Editar';
                    echo '</a>';
                    
                    echo '</td>';
                } else {
                    echo '<td></td>';
                }
            }
            
           
        }
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}






?>