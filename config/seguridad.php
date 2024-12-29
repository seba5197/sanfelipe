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
        die("<br>usuario no activo");
    }
}

// Ejemplo de uso


?>
