<?php
include_once("../config/config.php");

// Definir las funciones de menú para cada rol

// Menú para Admin
function menuAdmin() {
    return [
        "Inicio" => "index.php",
        "Gestionar docentes" => "gestionardocentes.php",
        "Gestionar cursos" => "crearcursos.php",
        "Gestionar salas" => "crearsalas.php",

        "Gestionar alumnos" => "crearalumnos.php",
        "Gestionar asignaturas" => "crearasignaturas.php",
        "Gestionar Horario" => "crearhorarios.php",
       
    ];
}

// Menú para Docentes
function menuDocente() {
    return [
        "Inicio" => "#",
        "Mis Clases" => "#",
        "Notas" => "#",
        "Perfil" => "#"
    ];
}

// Menú para Coordinadores
function menuCoordinador() {
    return [
        "Inicio" => "#",
        "Gestión de Clases" => "#",
        "Gestión de Docentes" => "#",
        "Informes" => "#"
    ];
}

// Menú para Alumnos
function menuAlumno() {
    return [
        "Inicio" => "#",
        "Cursos" => "#",
        "Horario" => "#",
        
    ];
}

// Menú para Gestores
function menuGestor() {
    return [
        "Inicio" => "#",
        "Gestión de Estudiantes" => "#",
        "Reportes" => "#",
        "Configuración" => "#"
    ];
}

// Función para generar el menú lateral
function generateSidebarMenu($activePage = "", $userName = "Juan Pérez", $userRole = "Administrador") {
    // Obtener el menú según el rol del usuario
    $menuItems = switchRole('menu', $userRole); // Cambiar 'menu' según sea necesario (admin, docente, etc.)

    // Verificar si se generó un error con el menú
    if (isset($menuItems['error'])) {
        echo $menuItems['error']; // Si hay un error, mostrar el mensaje
        return; // Detener la ejecución si hay un error en la función de menú
    }

    // HTML del menú lateral con la información del usuario
    echo '
    <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
            <!-- Sección de usuario -->
            <div class="sidebar-user-info text-center p-3">
                <div class="avatar">
                    <i class="fas fa-user-circle fa-3x"></i>
                </div>
                <h5 class="mt-2">' . htmlspecialchars($userName) . '</h5>
                <p class="text-muted">' . htmlspecialchars($userRole) . '</p>
                '."<p class='text-muted'><a href='../public/login.php'>Cerrar sesión</a></p>".'
            </div>

            <!-- Menú lateral -->
            <ul class="nav flex-column">';

    // Iterar sobre los elementos del menú
    if (isset($menuItems) && is_array($menuItems) && !empty($menuItems)) {
        foreach ($menuItems as $page => $link) {
            // Si la página es la activa, agregar la clase "active"
            $activeClass = ($page == $activePage) ? 'active' : '';
            
            // Imprimir el enlace con la clase "active" si corresponde
            echo '<li class="nav-item">
                    <a class="nav-link ' . $activeClass . '" href="' . $link . '">
                        <i class="fas fa-' . strtolower($page) . '"></i> ' . $page . '
                    </a>
                </li>';
        }
    } else {
        // Mensaje si el menú no es un array válido o no contiene elementos
        echo '<p>Este menú no ha sido creado.</p>';
    }

    echo '  </ul>
        </div>
    </nav>';
}


?>
