<?php
    // Función que genera el formulario de inicio de sesión
    function renderLoginForm() {
        echo '
        <div class="fullscreen-container">
            <form class="login-form"  action="../controladores/login.php" method="post">
                <h2>Iniciar Sesión</h2>
                <input type="text" name="username" placeholder="Nombre de usuario" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="submit" value="Ingresar">
                <p class="recover-password">
           <center>         <a href="recuperar_contrasena.php">¿Olvidaste tu contraseña?</a>
                </center></p>
            </form>
        </div>';
    }

    // Llamar a la función para mostrar el formulario

    ?>