function abrirPopupasignatura(id, dia) {
    // Construir la URL con los parámetros id y dia
    var url = "popupdinamicohorario.php?id=" + id + "&dia=" + dia;
    
    // Crear una ventana emergente
    var ventana = window.open(url, "popupHorario", "width=600,height=400,top=" + (window.innerHeight / 2 - 200) + ",left=" + (window.innerWidth / 2 - 300));
}

function abrirPopupfecha(id, dia) {
    // Hacer una solicitud AJAX para cargar el contenido en el div con ID 'popup'
    

    $.ajax({
        url: "popupdinamicohorario.php",
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
