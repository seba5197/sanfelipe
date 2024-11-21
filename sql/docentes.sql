-- Tabla de Docentes

CREATE TABLE IF NOT EXISTS `docentes` (
    `id_docente` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `apellido` VARCHAR(100) NOT NULL,
    `rut` VARCHAR(13) NOT NULL,
    `correo` VARCHAR(100) UNIQUE NOT NULL,
    `telefono` VARCHAR(20) DEFAULT NULL
);