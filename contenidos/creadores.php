<?php
//crear formulario
class Formularios {

    // Función para crear el formulario de Crear Docente
    public function crearFormularioDocente() {
        echo '
        <div class="fullscreen-container">
            <form class="formulario-crear-docente" action="../controladores/crear_docente.php" method="post" enctype="multipart/form-data">
                <h2>Crear Docente</h2>
                <div class="form-group">
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="apellido" placeholder="Apellido" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="rut" placeholder="RUT" required>
                </div>
                <div class="form-group">
                    <input type="tel" class="form-control" name="telefono" placeholder="Teléfono" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="correo" placeholder="Correo electrónico" required>
                </div>
                <div class="form-group">
                    <input type="date" class="form-control" name="fecha_nacimiento" required>
                </div>
                <div class="form-group">
                Titulo
                    <input type="file" class="form-control-file" name="titulo" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Docente</button>
            </form>
        </div>';
    }

    // Función para crear el formulario de Crear Asignatura
    public function crearFormularioAsignatura() {
        echo '
        <div class="fullscreen-container">
            <form class="formulario-crear-asignatura" action="../controladores/crear_asignatura.php" method="post">
                <h2>Crear Asignatura</h2>
                <div class="form-group">
                    <input type="text" class="form-control" name="nombre_asignatura" placeholder="Nombre de la asignatura" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Asignatura</button>
            </form>
        </div>';
    }

    // Función para crear el formulario de Crear Curso
    public function crearFormularioCurso() {
        echo '
        <div class="fullscreen-container">
            <form class="formulario-crear-curso" action="../controladores/crear_curso.php" method="post">
                <h2>Crear Curso</h2>
                <div class="form-group">
                    <input type="text" class="form-control" name="nombre_curso" placeholder="Nombre del curso" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="sala" placeholder="Sala" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Curso</button>
            </form>
        </div>';
    }

    // Función para crear el formulario de Crear Sala
    public function crearFormularioSala() {
        echo '
        <div class="fullscreen-container">
            <form class="formulario-crear-sala" action="../controladores/crear_sala.php" method="post">
                <h2>Crear Sala</h2>
                <div class="form-group">
                    <input type="text" class="form-control" name="nombre_sala" placeholder="Nombre de la sala" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Sala</button>
            </form>
        </div>';
    }

    // Función para crear el formulario de Crear Alumno
    public function crearFormularioAlumno() {
        echo '
        <div class="fullscreen-container">
            <form class="formulario-crear-alumno" action="../controladores/crear_alumno.php" method="post">
                <h2>Crear Alumno</h2>
                <div class="form-group">
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="apellido" placeholder="Apellido" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="rut" placeholder="RUT" required>
                </div>
                <div class="form-group">
                    <!-- Campo para la fecha de nacimiento -->
                    <input type="date" class="form-control" name="fecha_nacimiento" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Alumno</button>
            </form>
        </div>';
    }
    

    // Función para crear el formulario de Crear Apoderado
    public function crearFormularioApoderado() {
        echo '
        <div class="fullscreen-container">
            <form class="formulario-crear-apoderado" action="../controladores/crear_apoderado.php" method="post">
                <h2>Crear Apoderado</h2>
                <div class="form-group">
                    <input type="text" class="form-control" name="nombre_completo" placeholder="Nombre completo" required>
                </div>
                <div class="form-group">
                    <input type="tel" class="form-control" name="telefono" placeholder="Teléfono" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="rut" placeholder="RUT" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="correo" placeholder="Correo electrónico" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Apoderado</button>
            </form>
        </div>';
    }

    // Función para crear el formulario de Relación Docente y Asignaturas
    public function crearFormularioRelacionDocenteAsignaturas() {
        echo '
        <div class="fullscreen-container">
            <form class="formulario-relacion-docente-asignaturas" action="../controladores/relacion_docente_asignatura.php" method="post">
                <h2>Asignar Asignaturas a Docente</h2>
                <div class="form-group">
                    <select name="docente_id" class="form-control" required>
                        <option value="">Seleccionar Docente</option>
                        <!-- Aquí iría el código para obtener los docentes -->
                    </select>
                </div>
                <div class="form-group">
                    <select name="asignaturas[]" class="form-control" multiple required>
                        <option value="">Seleccionar Asignaturas</option>
                        <!-- Aquí iría el código para obtener las asignaturas -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Asignar Asignaturas</button>
            </form>
        </div>';
    }

    // Función para crear el formulario de Relación Curso y Alumnos
    public function crearFormularioRelacionCursoAlumnos() {
        echo '
        <div class="fullscreen-container">
            <form class="formulario-relacion-curso-alumnos" action="../controladores/relacion_curso_alumno.php" method="post">
                <h2>Asignar Alumnos a Curso</h2>
                <div class="form-group">
                    <select name="curso_id" class="form-control" required>
                        <option value="">Seleccionar Curso</option>
                        <!-- Aquí iría el código para obtener los cursos -->
                    </select>
                </div>
                <div class="form-group">
                    <select name="alumnos[]" class="form-control" multiple required>
                        <option value="">Seleccionar Alumnos</option>
                        <!-- Aquí iría el código para obtener los alumnos -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Asignar Alumnos</button>
            </form>
        </div>';
    }

    // Función para crear el formulario de Relación Alumno y Apoderados
    public function crearFormularioRelacionAlumnoApoderados() {
        echo '
        <div class="fullscreen-container">
            <form class="formulario-relacion-alumno-apoderados" action="../controladores/relacion_alumno_apoderado.php" method="post">
                <h2>Asignar Apoderado a Alumno</h2>
                <div class="form-group">
                    <select name="alumno_id" class="form-control" required>
                        <option value="">Seleccionar Alumno</option>
                        <!-- Aquí iría el código para obtener los alumnos -->
                    </select>
                </div>
                <div class="form-group">
                    <select name="apoderados[]" class="form-control" multiple required>
                        <option value="">Seleccionar Apoderados</option>
                        <!-- Aquí iría el código para obtener los apoderados -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Asignar Apoderados</button>
            </form>
        </div>';
    }
}

?>
