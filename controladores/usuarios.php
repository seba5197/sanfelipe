<?php

include_once '../config/config.php';
validarURL(); // Asegúrate de que esta función valide la URL correctamente


    // Si la opción es 'editar'
    if (isset($_GET['opcion'])) {
        $opcion = $_GET['opcion'];
        $idUsuario = $_GET['id'];
    
        // Si la opción es 'editar'
        if ($opcion == 'editar') {
            // Comprobar si el formulario se ha enviado
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Recibir los datos del formulario
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $correo = $_POST['correo'];
                $telefono = $_POST['telefono'];
                $rut = $_POST['rut'];
    
                // Llamar a la función para editar el usuario
                $mensaje = editarUsuario($idUsuario, $nombre, $apellido, $correo, $telefono, $rut);
    
                // Mostrar el mensaje de éxito o error
                echo $mensaje;
                // Redirigir o cargar una vista después de la actualización
               // header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }
    
            // Si no se ha enviado el formulario, mostrar el formulario de edición
            // Obtener los datos actuales del usuario (puedes agregar una función para esto)
            $usuario = obtenerUsuarioPorId($idUsuario); // Función que recupera el usuario por ID
    
            $formulario = '
                <div class="fullscreen-container">
                    <form class="login-form" action="" method="post">
                        <input type="hidden" name="idUsuario" value="' . htmlspecialchars($idUsuario) . '">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="' . htmlspecialchars($usuario['nombre']) . '" required>
    
                        <label for="apellido">Apellido:</label>
                        <input type="text" id="apellido" name="apellido" value="' . htmlspecialchars($usuario['apellido']) . '" required>
    
                        <label for="correo">Correo:</label>
                        <input type="email" id="correo" name="correo" value="' . htmlspecialchars($usuario['correo']) . '" required>
    
                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" value="' . htmlspecialchars($usuario['telefono']) . '" required>
    
                        <label for="rut">RUT:</label>
                        <input type="text" id="rut" name="rut" value="' . htmlspecialchars($usuario['rut']) . '" required>
    
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>
                </div>';
    
            // Llamar a la función para generar la página
            web($formulario);
        die(); // Detener ejecución

    } elseif ($opcion == 'eliminar') {
        $idUsuario = $_GET['id'];
        // Lógica para eliminar el usuario
        eliminarLogicoUsuario($idUsuario);
               //header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

// Lógica para crear un usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $pass = $_POST['pass']; // Contraseña proporcionada por el usuario
    $rut = $_POST['rut'];

    // Verificar si los campos están vacíos
    if ($nombre == "" || $apellido == "" || $correo == "" || $telefono == "" || $rut == "") {
        die("Error: Todos los campos son obligatorios.");
    }

    // Hashear la contraseña
    $passHash = codificarPass($pass);

    // Llamar a la función para crear el usuario
    $ultimoId = crearUsuario($nombre, $apellido, $correo, $telefono, $passHash, $rut);

    // Mensaje de éxito
    echo "<br>Usuario creado con éxito. ID del usuario: $ultimoId ahora asignaremos rol correspondiente <hr>";



    //verifica si viene el rol. 
    //roles existentes 1 -> admin 2-> docente 3->alumno 4 -> coordinador 99-> sin asignar (por defecto al crear usuario)

    if (isset($_GET['rol'])) {
        $opcion = $_GET['rol'];
    
        // Validar si la opción es de rol a asignar
        if ($opcion === 'docente') {
            echo "asignando rol docente";
            asignarRol($ultimoId, 2);
        }else if($opcion === 'coordinador'){
            echo "asignando rol coordinador";
            asignarRol($ultimoId, 4);
        }else if($opcion === 'admin'){
            echo "asignando rol administrador";
            asignarRol($ultimoId, 1);
        }




    }else{
        echo "asignando rol usuario por defecto sin rol";
        asignarRol($ultimo, 99);
    }

   //header('Location: ../public/');
    exit();
}





?>
