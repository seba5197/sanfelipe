<?php

// Variable de ejemplo con docentes (simulando que viene de una fuente externa)
$docentes = [
    [
        'id' => 1,
        'nombre' => 'Carlos Pérez',
        'rut' => '12.345.678-9',
        'correo' => 'carlos.perez@colegio.cl',
        'telefono' => '+56 9 8765 4321',
        'asignaturas' => ['Matemáticas', 'Física']
    ],
    [
        'id' => 2,
        'nombre' => 'Ana María Gómez',
        'rut' => '98.765.432-1',
        'correo' => 'ana.gomez@colegio.cl',
        'telefono' => '+56 9 1234 5678',
        'asignaturas' => ['Lenguaje y Comunicación', 'Historia']
    ],
    [
        'id' => 3,
        'nombre' => 'Luis Martínez',
        'rut' => '11.223.344-5',
        'correo' => 'luis.martinez@colegio.cl',
        'telefono' => '+56 9 9988 7766',
        'asignaturas' => ['Química', 'Biología']
    ],
    [
        'id' => 4,
        'nombre' => 'Elena Sánchez',
        'rut' => '22.334.455-6',
        'correo' => 'elena.sanchez@colegio.cl',
        'telefono' => '+56 9 5544 3322',
        'asignaturas' => ['Arte', 'Música']
    ],
    [
        'id' => 5,
        'nombre' => 'Roberto Díaz',
        'rut' => '33.445.566-7',
        'correo' => 'roberto.diaz@colegio.cl',
        'telefono' => '+56 9 6677 8899',
        'asignaturas' => ['Educación Física', 'Matemáticas']
    ]
];

// Función para mostrar la tabla de docentes
function mostrarTablaDocentes($docentes) {
    echo '<div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>RUT</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Asignaturas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>';

    // Iteramos sobre la lista de docentes y mostramos una fila para cada uno
    foreach ($docentes as $docente) {
        echo '<tr>
                <td>' . htmlspecialchars($docente['nombre']) . '</td>
                <td>' . htmlspecialchars($docente['rut']) . '</td>
                <td>' . htmlspecialchars($docente['correo']) . '</td>
                <td>' . htmlspecialchars($docente['telefono']) . '</td>
                <td>' . htmlspecialchars(implode(", ", $docente['asignaturas'])) . '</td>
                <td>
                    <button class="btn btn-warning btn-sm" 
                            data-id="' . htmlspecialchars($docente['id']) . '" 
                            onclick="editarDocente(this)">
                        <i class="fas fa-pencil-alt"></i> Editar
                    </button>
                    <button class="btn btn-danger btn-sm" 
                            data-id="' . htmlspecialchars($docente['id']) . '" 
                            onclick="eliminarDocente(this)">
                        <i class="fas fa-trash-alt"></i> Borrar
                    </button>
                </td>
            </tr>';
    }

    echo '</tbody>
        </table>
    </div>';
}



?>
