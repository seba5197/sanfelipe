<?php
//conexión BD reutilizable
function getDbConnection() {
    try {
        // Crear la conexión utilizando las constantes definidas
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $conn = new PDO($dsn, DB_USER, DB_PASS);
        // Establecer el modo de error de PDO a excepción
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        // Si ocurre un error, lo mostramos
        die("Error de conexión: " . $e->getMessage());
    }
}


$conn = getDbConnection();

if ($conn) {
    echo "Conexión exitosa a la base de datos '".DB_NAME."'.";
} else {
    echo "No se pudo establecer la conexión.";
}

?>