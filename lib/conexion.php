<?php

//conexión BD reutilizable
function getDbConnection() {
    try {
        // Crear la conexión utilizando las constantes definidas
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $conn = new PDO($dsn, DB_USER, DB_PASS);
        
        // Establecer el modo de error de PDO a excepción
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Establecer el cotejamiento utf8mb4_unicode_ci
        $conn->exec("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");

        return $conn;
    } catch (PDOException $e) {
        // Si ocurre un error, lo mostramos
        die("Error de conexión: " . $e->getMessage());
    }
}


?>