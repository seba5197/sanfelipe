<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo "cargando mail <br>";


require '../vendor/autoload.php';


// Autoload de Composer y archivo de configuración

require '../config/constantes.php';

// Configuración del correo
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = SMTP_SECURE;
    $mail->Port = 465;

    // Configuración del remitente y destinatario
    $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
    $mail->addAddress('sebastian5197@gmail.com', 'Seba'); // Correo del destinatario

    // Contenido del mensaje
    $mail->isHTML(true);
    $mail->Subject = 'Asunto del correo';
    $mail->Body = '<h1>Hola desde PHPMailer</h1><p>Este es un mensaje de prueba.</p>';
    $mail->AltBody = 'Este es un mensaje de prueba en texto plano.';

    // Enviar correo
    $mail->send();
    echo 'Correo enviado correctamente';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
