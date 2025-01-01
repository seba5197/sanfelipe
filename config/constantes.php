<?php
//constantes de conexión BD

// Definir constantes para la conexión a la base de datos
define('DB_HOST', 'localhost');  // Dirección del servidor
define('DB_NAME', 'promarke_websanfelipe');  // Nombre de la base de datos
define('DB_USER', 'promarke_sanfelipe');  // Usuario de la base de datos
define('DB_PASS', 'websanfelipe123');  // Contraseña del usuario

// Configuración del servidor SMTP
define('SMTP_HOST', 'mail.notalo.cl'); // Puerto SMTP (587 para TLS, 465 para SSL)
define('SMTP_USERNAME', 'mailer@notalo.cl'); // Usuario SMTP (correo)
define('SMTP_PASSWORD', '@notalo.cl123'); // Contraseña del correo
define('SMTP_SECURE', 'ssl'); // Seguridad (tls o ssl)

// Configuración del remitente
define('MAIL_FROM', 'mailer@notalo.cl'); // Correo del remitente
define('MAIL_FROM_NAME', 'Mail system'); // Nombre del remitent

define('TOKEN', 'miClaveSuperSecreta');

const HORARIOS = [
    ['08:00', '08:45'],
    ['08:45', '09:30'],
    ['09:30', '10:15'],
    ['10:15', '11:00'],
    ['11:00', '11:45'],
    ['11:45', '12:30'],
    ['12:30', '13:00'],
    ['14:00', '14:45'],
    ['14:45', '15:30']
];

define('NIVELES', [
    'basica' => 'Básica',
    'media' => 'Media',
    'kinder' => 'Kinder'
]);
?>