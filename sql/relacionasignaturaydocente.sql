-- Relación entre Docentes y Asignaturas (un docente puede impartir varias asignaturas)
CREATE TABLE IF NOT EXISTS `docentes_asignaturas` (
    `id_docente` INT NOT NULL,
    `id_asignatura` INT NOT NULL,
    PRIMARY KEY (`id_docente`, `id_asignatura`),
    FOREIGN KEY (`id_docente`) REFERENCES `docentes`(`id_docente`) ON DELETE CASCADE,
    FOREIGN KEY (`id_asignatura`) REFERENCES `asignaturas`(`id_asignatura`) ON DELETE CASCADE
);