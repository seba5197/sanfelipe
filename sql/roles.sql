CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rol VARCHAR(50) NOT NULL UNIQUE
);

-- Insertar roles de ejemplo
INSERT INTO roles (rol) VALUES
('admin'),
('docente'),
('coordinador'),
('alumno'),
('gestor');