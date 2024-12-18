function abrirPopupasignatura(id) {
    // Hacer una solicitud AJAX para cargar el contenido en el div con ID 'popup'
    $.ajax({
        url: "popups/popupdinamicohorario.php",
        method: "GET",
        data: { id: id },
        success: function(response) {
            $('#popup').html(response); // Insertar el contenido en el div
            $('#popup').fadeIn(); // Mostrar el div
        },
        error: function() {
            alert("Error al cargar el contenido.");
        }
    });
}


function abrirPopupfecha(id, dia) {
    // Hacer una solicitud AJAX para cargar el contenido en el div con ID 'popup'
    

    $.ajax({
        url: "popups/popupdinamicohorario.php",
        method: "GET",
        data: { id: id, dia: dia },
        success: function(response) {
            $('#popup').html(response); // Insertar el contenido en el div
            $('#popup').fadeIn(); // Mostrar el div
        },
        error: function() {
            alert("Error al cargar el contenido.");
        }
    });
}

function cerrarPopup() {
    $('#popup').fadeOut(function() {
        $('#popup').html(''); // Limpiar el contenido después de cerrar
    });
}
