<?php
//crear formularios
class Formularios {

// $url=protegerURL("URL POST"); asigna un token valido para seguridad 
    
    // Función para crear el formulario de Crear Docente
    public function crearFormularioDocente() {
        $url=protegerURL("../controladores/docentes.php");
        echo '
        <div class="fullscreen-container">
            <form class="formulario-crear-docente" action="'.$url.'" method="post" enctype="multipart/form-data">
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
        $url=protegerURL("../controladores/asignaturas.php");
        echo '
        <div class="fullscreen-container">
            <form class="formulario-crear-asignatura" action="'.$url.'"" method="post">
                <h2>Crear Asignatura</h2>
                <div class="form-group">
                    <input type="text" class="form-control" name="asignatura" placeholder="Nombre de la asignatura" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Asignatura</button>
            </form>
        </div>';
    }

    // Función para crear el formulario de Crear Curso
    public function crearFormularioCurso() {
        $url=protegerURL("../controladores/cursos.php?opcion=crear");
        echo '
        <div class="fullscreen-container">
            <form class="formulario-crear-curso" action="' . htmlspecialchars($url) . '" method="post">
                <h2 class="text-center">Crear Curso</h2>
                <div class="form-group">
                    <input type="text" class="form-control" name="curso" placeholder="Nombre del curso" required>
                </div>
                <div class="form-group">
                    <select class="form-control" name="nivel" required>
                        <option value="" disabled selected>Seleccione el nivel</option>';
        
                        // Iterar sobre los niveles y agregar las opciones dinámicamente
                        foreach (NIVELES as $value => $label) {
                            echo '<option value="' . $value . '">' . $label . '</option>';
                        }
        
        echo '
                    </select>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Crear Curso</button>
                </div>
            </form>
        </div>';
    }

    // Función para crear el formulario de Crear Sala
    public function crearFormularioSala() {
        $url=protegerURL("../controladores/salas.php?opcion=crearsala");
        echo '
        <div class="fullscreen-container">
            <form class="formulario-crear-sala" action="'.$url.'" method="post">
                <h2>Crear Sala</h2>
                <div class="form-group">
                    <input type="text" class="form-control" name="nombre_sala" placeholder="Nombre de la sala" required>
                    <input type="number" class="form-control" name="capacidad" placeholder="Capacidad de la sala" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Sala</button>
            </form>
        </div>';
    }


    public function crearFormularioHorario() {
        $url=protegerURL("../controladores/horarios.php?opcion=crearhorario");
        echo '
        <div class="fullscreen-container">
            <form class="formulario-crear-sala" action="'.$url.'" method="post">
                <h2>Crear Horario</h2>
                <div class="form-group">
                    <input type="text" class="form-control" name="nombre_horario" placeholder="Nombre del horario" required>
                    <input type="text"  style="text-transform: uppercase;" class="form-control" name="codigo_horario" placeholder="Codigo del horario" required>
                    <input type="text" class="form-control" name="descripcion" placeholder="Descripción del horario">
                </div>
                <button type="submit" class="btn btn-primary">Crear horario</button>
            </form>
        </div>';
    }


    // Función para crear el formulario de Crear Alumno
    public function crearFormularioAlumno() {
        $url=protegerURL("../controladores/alumnos.php");
        echo '
        <div class="fullscreen-container">
            <form class="formulario-crear-alumno" action="'.$url.'" method="post">
                <h2>Crear Alumno</h2>
                <div class="form-group">
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="apellidos" placeholder="Apellidos" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="rut" placeholder="RUT" required>
                </div>
                <div class="form-group">
                    <!-- Campo para la fecha de nacimiento -->
                    Fecha de nacimiento<br>
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
        $url=protegerURL("../controladores/profesor_asignatura.php");
        echo '
        <div class="fullscreen-container">
            <form class="formulario-relacion-docente-asignaturas" action="'.$url.'" method="post">
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
        $url=protegerURL("../controladores/curso_alumno.php");
        echo '
        <div class="fullscreen-container">
            <form class="formulario-relacion-curso-alumnos" action="'.$url.'" method="post">
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
