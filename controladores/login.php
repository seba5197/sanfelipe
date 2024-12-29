<?php

include_once '../config/config.php';


function validarUsuario($rutOcorreo, $password) {

    //hasheo password esto se usa al registrar las pass
      //  $password = password_hash($password, PASSWORD_DEFAULT);
    //  password_verify($password, $usuario['pass'])
    //verifica la pass hasheada desde la bd

    //$rutOcorreo = preg_replace('/[^0-9kK]/', '', $rutOcorreo); // Eliminar caracteres no válidos
    //$rutOcorreo = strtolower($rutOcorreo); // Convertir cualquier 'K' a minúscula 'k'
    
    try {
     
        // Obtener la conexión
        $conn = getDbConnection();
        // Consulta SQL para obtener los datos del usuario
        $sqlUsuario = "SELECT `id_usuarios`, `pass`, `nombre` FROM `usuarios` WHERE `correo` = :rutOcorreo OR rut = :rutOcorreo";
        // Preparar la consulta
        $stmt = $conn->prepare($sqlUsuario);
        // Asociar el parámetro
        $stmt->bindParam(':rutOcorreo', $rutOcorreo, PDO::PARAM_STR);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener los datos del usuario
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar si el usuario existe y si la contraseña es válida
echo "usuario validado $rutOcorreo";
verificarUsuarioActivo($usuario['id_usuarios']);

        if ($usuario && decodificarPass($password, $usuario['pass'])) {
            //confirma nombre de la persona logeada
            $nombre =$usuario['nombre'];
            echo  "usuario validado $nombre <br>";
            //obtiene lista de roles, se puede colocar un midleware para multiples roles, selector de rol.
            $rol=obtenerRolesUsuario($usuario['id_usuarios']);
            //gestiona lista de roles
            foreach ($rol as $role) {
            $rolnombre= obtenerRolPorId($role['rol']);
            // listar roles 
            echo 'Rol: ' . $rolnombre . '<br>';
           

                }

                $rol=obtenerRolesUsuario($usuario['id_usuarios']);
                //muestra primer rol
                $primer_rol = obtenerRolPorId($rol[0]['rol']);
                session_start();
                $_SESSION['username'] = $nombre;
                $_SESSION['rol'] = $primer_rol;

            return true;
        } else {
            session_unset();

            // Destruir la sesión
            session_destroy();
            // Credenciales inválidas
            echo ' Usuario o contraseña incorrectos. <a href="../public/login.php">Volver</a>';

            return false;
        }
    } catch (PDOException $e) {
        die("<br>Error al validar usuario: " . $e->getMessage());
    }
}

echo "Iniciando sesión<br>";

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    $username = trim($_POST['username']) ?? '';
    $password = trim($_POST['password']) ?? '';

    echo "$username <br>";
    // Llamar a la función para validar el usuario
    $usuarioValido = validarUsuario($username, $password);
  
    
    if ($usuarioValido) {
        // Credenciales válidas - guardar datos en la sesión
      

        // Redireccionar a una página de bienvenida o panel de control
       header("Location: ../public/index.php");
        exit();
    } else {
        // Credenciales no válidas - mostrar mensaje de error
    
        session_unset();
    
        // Destruir la sesión
        session_destroy();
    }
} else {
    // Si se accede directamente al archivo, redirigir al formulario de inicio de sesión
    header("Location: ../public/login.php");
    exit();
}
?>