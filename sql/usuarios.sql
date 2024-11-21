CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL,
    FOREIGN KEY (rol_id) REFERENCES roles(id)
);

-- Insertar usuarios de ejemplo
INSERT INTO usuarios (nombre_usuario, contraseña, rol_id, correo, telefono) VALUES
('adminuser', SHA2('adminpass', 256), 1, 'admin@ejemplo.com', '123456789'),
('docenteuser', SHA2('docentepass', 256), 2, 'docente@ejemplo.com', '987654321');