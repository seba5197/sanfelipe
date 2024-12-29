<?php
$docentes = [];

// Obtener el ID del rol de "docente"
$idrol = obtenerIdRolPorNombre("docente");

// Obtener los IDs de los usuarios asociados a ese rol
$idusuarios = obteneridusuariosxrol($idrol);

foreach ($idusuarios as $item) {
    // Extraer el ID del usuario del subarray
    $id = $item['usuario'];

    // Obtener los datos del usuario por su ID
    $usuario = obtenerUsuarioPorId($id);
    //$asignaturas = obtenerAsignaturasPorProfesorConComas($id);
    $idasignaturas = obtenerAsignaturasPorProfesorConComas($id);
    $asignaturas=nombreasignaturaporid($idasignaturas);

    if ($usuario) {
        // Agregar la información del usuario al array principal
        $docentes[] = [
            'id' => $usuario['id_usuarios'],
            'nombre' => $usuario['nombre'] . ' ' . $usuario['apellido'],
            'rut' => $usuario['rut'],
            'correo' => $usuario['correo'],
            'telefono' => $usuario['telefono'],
            'asignaturas' =>  [$asignaturas]
        ];
    }
}


// Función para mostrar la tabla de docentes
function mostrarTablaDocentes($docentes) {
    $url=protegerURL("../public/crearusuarios.php?opcion=docente");
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
        $id = $docente['id'];
        $urleditar = protegerURL('../controladores/usuarios.php?opcion=editar&id=' . $id);
        $urlelimnar = protegerURL('../controladores/usuarios.php?opcion=eliminar&id=' . $id);

        echo '<tr>
                <td>' . htmlspecialchars($docente['nombre']) . '</td>
                <td>' . htmlspecialchars($docente['rut']) . '</td>
                <td>' . htmlspecialchars($docente['correo']) . '</td>
                <td>' . htmlspecialchars($docente['telefono']) . '</td>
                <td>' . htmlspecialchars(implode(", ", $docente['asignaturas'])) . '</td>
                <td>';
                echo '<a href="' .  $urleditar . '" class="btn btn-primary btn-sm">Editar</a> ';
            echo '<a href="' .  $urlelimnar . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de eliminar este docente?\');">Eliminar</a>';
               echo' </td>
            </tr>';
    }

    echo '</tbody>
        </table>
         <!-- Botón para abrir el modal (popup) -->
           <a href="' . $url . '" class="btn btn-primary" data-bs-toggle="modal" >
    Crear Docentes
</a></div>
    ';

    // <!-- Botón para abrir el modal (popup) -->
    //<button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#formModal">
    //Crear Docentes
//</button>
}
?>