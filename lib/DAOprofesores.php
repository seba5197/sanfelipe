<?php
$docentes = [];
$todos = [];

// Obtener el ID del rol de "docente"
$idrol = obtenerIdRolPorNombre("docente");

// Obtener los IDs de los usuarios asociados a ese rol
$iddocentes = obteneridusuariosxrol($idrol);
//trae todos los usuarios excepto el 99 

foreach ($iddocentes as $item) {
    // Extraer el ID del usuario del subarray
    $id = $item['usuario'];

    // Obtener los datos del usuario por su ID
    $usuario = obtenerUsuarioPorId($id);
    //$asignaturas = obtenerAsignaturasPorProfesorConComas($id);
    $idasignaturas = obtenerAsignaturasPorProfesorConComas($id);
    $asignaturas = nombreasignaturaporid($idasignaturas);

    if ($usuario) {
        // Agregar la información del usuario al array principal
        $docentes[] = [
            'id' => $usuario['id_usuarios'],
            'nombre' => $usuario['nombre'] . ' ' . $usuario['apellido'],
            'rut' => $usuario['rut'],
            'correo' => $usuario['correo'],
            'telefono' => $usuario['telefono'],
            'asignaturas' => [$asignaturas]
        ];
    }
}

$idusuarios = obteneridusuariosxrol(''); // Obtiene los usuarios según rol, si el rol está vacío, lo toma todo

foreach ($idusuarios as $items) {
    // Extraer el ID del usuario del subarray
    $id = $items['usuario'];

    // Obtener los datos del usuario por su ID
    $usuario = obtenerUsuarioPorId($id);

    // Asegúrate de que el usuario no tenga el rol 99
    if ($usuario && $usuario['rol'] != 99) {
        // Agregar la información del usuario al array principal
        $todos[] = [
            'id' => $usuario['id_usuarios'],
            'nombre' => $usuario['nombre'] . ' ' . $usuario['apellido'],
            'rut' => $usuario['rut'],
            'correo' => $usuario['correo'],
            'telefono' => $usuario['telefono']
        ];
    }
}

// Función para mostrar la tabla de docentes
function mostrarTablaDocentes($docentes) {
    $url = protegerURL("../public/crearusuarios.php?opcion=docente");
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

        // Enlaces de editar y eliminar
        $urleditar = protegerURL('../controladores/usuarios.php?opcion=editar&id=' . $id);
        $urlelimnar = protegerURL('../controladores/usuarios.php?opcion=eliminar&id=' . $id);
        
        // Mostrar la fila
        echo '<tr>
                <td>' . htmlspecialchars($docente['nombre']) . '</td>
                <td>' . htmlspecialchars($docente['rut']) . '</td>
                <td>' . htmlspecialchars($docente['correo']) . '</td>
                <td>' . htmlspecialchars($docente['telefono']) . '</td>
                <td>' . htmlspecialchars(implode(", ", $docente['asignaturas'])) . '</td>
                <td>
                    <a href="' . $urleditar . '" class="btn btn-primary btn-sm">Editar</a> 
                    <a href="' . $urlelimnar . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de eliminar este docente?\');">Eliminar</a>
                </td>
              </tr>';
    }

    echo '</tbody>
        </table>
         <!-- Botón para abrir el modal (popup) -->
           <a href="' . $url . '" class="btn btn-primary" data-bs-toggle="modal" >
    Crear Docente
</a></div>';
}

// Función para mostrar la tabla de usuarios
function mostrarTablausuarios($todos) {
    $url = protegerURL("../public/crearusuarios.php?opcion=usuarios");
    echo '<div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>RUT</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Roles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>';

    // Iteramos sobre la lista de usuarios y mostramos una fila para cada uno
    foreach ($todos as $usuario) {
        $id = $usuario['id'];
        $rol=obtenerRolPorId(obtenerRolPorIddeusuario($id));
        // Excluir el ID 99
        if ($id == 99) {
            continue; // Salta a la siguiente iteración sin procesar este usuario
        }

        // Enlaces de editar y eliminar
        $urleditar = protegerURL('../controladores/usuarios.php?opcion=editar&id=' . $id);
        $urlelimnar = protegerURL('../controladores/usuarios.php?opcion=eliminar&id=' . $id);
        $urlrol = protegerURL('../controladores/usuarios.php?opcion=selectrol&id=' . $id);
        
        // Mostrar la fila sin la columna Asignaturas
        echo '<tr>
                <td>' . htmlspecialchars($usuario['nombre']) . '</td>
                <td>' . htmlspecialchars($usuario['rut']) . '</td>
                <td>' . htmlspecialchars($usuario['correo']) . '</td>
                <td>' . htmlspecialchars($usuario['telefono']) . '</td>
                <td>' . htmlspecialchars($rol) . '</td>
                <td>
                    <a href="' . $urleditar . '" class="btn btn-primary btn-sm">Editar</a> 
                    <a href="' . $urlrol . '" class="btn btn-success btn-sm">Cambiar Rol</a> 
                    <a href="' . $urlelimnar . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de eliminar este usuario?\');">Eliminar</a>
                </td>
              </tr>';
    }

    echo '</tbody>
        </table>
         <!-- Botón para abrir el modal (popup) -->
           <a href="' . $url . '" class="btn btn-primary" data-bs-toggle="modal" >
    Crear Usuario
</a></div>';
}

?>

