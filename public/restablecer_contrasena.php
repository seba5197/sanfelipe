<?php


// Carga configuración completa
include_once("../config/config.php");
include_once("../contenidos/login.php");
// Llamar a la función para verificar el primer uso
validarURL();

// Crea una instancia del generador de encabezado
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Conexión a la base de datos
        $conn = getDbConnection();

        // Obtener los datos
        $nuevaContrasena = codificarPass($_POST['nueva_contrasena']);
        $correo= $_POST['correo'];

        echo"$nuevacontrasena $correo";
        // Actualizar la contraseña en la base de datos
        $sqlActualizar = "UPDATE usuarios SET pass = :pass WHERE correo = :correo";
        $stmtActualizar = $conn->prepare($sqlActualizar);
        $stmtActualizar->bindParam(':pass', $nuevaContrasena, PDO::PARAM_STR);
        $stmtActualizar->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmtActualizar->execute();

        // Mensaje de éxito
        echo "Tu contraseña ha sido restablecida correctamente. Ahora puedes iniciar sesión con tu nueva contraseña. <br>
        Seras redirigido al login en 3 segundos";
        header('Refresh: 3; URL=../public/login.php');
    } catch (PDOException $e) {
        die("Error al restablecer la contraseña: " . $e->getMessage());
    }
}
?>
