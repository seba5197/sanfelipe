<?php
function protegerURL($url) {
    // Usar la constante TOKEN definida previamente
    
    $token = hashtoken(TOKEN);
    // Verificar si la URL ya contiene parámetros
    $separador = (strpos($url, '?') === false) ? '?' : '&';

    // Agregar el token a la URL
    $urlProtegida = $url . $separador . 'token=' . $token;

    return $urlProtegida;
}



function validarURL() {
    // Obtener los parámetros de la URL
    $parametros = $_GET;

    // Obtener el token recibido
    $tokenRecibido = $parametros['token'] ?? null;

    
    $tokenRecibido=unhashtoken($tokenRecibido);
 
    // Si no hay token, redirigir o salir
    if (!$tokenRecibido) {
        echo '<div style="text-align: center; margin-top: 20px; font-family: Arial, sans-serif;">
                <p style="color: red; font-size: 18px;">Error: Token no proporcionado.</p>
                <p>Serás redirigido en breve...</p>
              </div>';
        echo '<script>
                setTimeout(function() {
                    window.location.href = "../public/"; // Cambia la ruta según tu estructura
                }, 3000);
              </script>';
        exit;
    }
    // Comparar el token recibido con el definido en la constante TOKEN
    if ($tokenRecibido !== TOKEN) {
        echo "Error: Tokens no coinciden.";
        exit;
    }

}



function hashtoken($data) {
    // Codificar el dato usando la clave secreta (TOKEN)
    $hash = hash_hmac('sha256', $data, TOKEN);
    return base64_encode($data . '::' . $hash); // Agregamos el dato original para reversibilidad
}


function unhashtoken($token) {
    try {
        // Decodificar el token de base64
        $decoded = base64_decode($token);
        if (!$decoded) {
            throw new Exception('Token no válido.');  // Si no se puede decodificar, lanzar una excepción
        }

        // Separar los datos y el hash
        $parts = explode('::', $decoded, 2);

        // Verificar si la separación fue exitosa y si tenemos dos partes
        if (count($parts) !== 2) {
            throw new Exception('El token tiene un formato incorrecto.');
        }

        $data = $parts[0];
        $hash = $parts[1];

        // Verificar si el hash coincide con el dato original
        $expectedHash = hash_hmac('sha256', $data, TOKEN);
        if (!hash_equals($expectedHash, $hash)) {
            throw new Exception('El token ha sido alterado o no coincide.');  // Si el hash no coincide, lanzar una excepción
        }

        // Si todo es válido, retornar los datos
        return $data;
    } catch (Exception $e) {
        // En caso de error, puedes manejarlo como desees
        // Puedes redirigir a una página de error o mostrar un mensaje amigable
        error_log($e->getMessage());  // Registrar el error en el log
        return false;  // Retornar false si el token no es válido
    }
}

function codificarPass($password) {
    // Crear un hash de la contraseña con bcrypt
    return password_hash($password, PASSWORD_BCRYPT);
}

function decodificarPass($password, $hash) {
    // Verificar si la contraseña coincide con el hash
    return password_verify($password, $hash);
}
function verificarUsuarioActivo($usuarioId) {
    // Crear la conexión a la base de datos
    $conexion = getDbConnection();

    // Consulta SQL para verificar si el usuario está activo
    $query = "SELECT * FROM `usuarios` WHERE `id_usuarios` = :usuarioId AND `activo` = 1";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
    $stmt->execute();

    // Verificar si el usuario está activo
    if ($stmt->rowCount() === 0) {
        echo "
        <div style='text-align: center; margin-top: 50px;'>
            <h3>Usuario no activo</h3>
            <p>Serás redirigido a la página de login en 5 segundos...</p>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 5000);
        </script>
    ";
    exit; // Detiene la ejecución del script
    }
}


function recuperacontrasena($correo){

    try {
        // Conexión a la base de datos
         // Asegúrate de tener tu archivo de conexión a la BD
        $conn = getDbConnection();

   

        // Verificar si el correo existe en la base de datos
        $sqlVerificar = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmtVerificar = $conn->prepare($sqlVerificar);
        $stmtVerificar->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmtVerificar->execute();

        $usuario = $stmtVerificar->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            // Generar una nueva contraseña aleatoria de 5 números
            $nuevaContrasena = strval(rand(10000, 99999));
            $pass = codificarPass( $nuevaContrasena);
            echo "tu nueva clave $nuevaContrasena";
require_once('../controladores/mail.php');
            // Actualizar la contraseña en la base de datos
            $sqlActualizar = "UPDATE usuarios SET pass = :pass WHERE correo = :correo";
            $stmtActualizar = $conn->prepare($sqlActualizar);
            $stmtActualizar->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmtActualizar->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmtActualizar->execute();

            // Notificar al usuario
            echo "Se envio un correo 
            Su contraseña ha sido restablecida. La nueva contraseña es: <strong>$nuevaContrasena</strong>";
            echo "<br><a href='login.php'>Ir al Login</a>";
        } else {
            echo "El correo electrónico no está registrado.";
        }
    } catch (PDOException $e) {
        die("Error al recuperar la contraseña: " . $e->getMessage());
    }


}

// Ejemplo de uso


?>
