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


document.getElementById('descargar-pdf').addEventListener('click', function() {
    // Crear una instancia de jsPDF
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    // Obtener el contenido HTML que se desea convertir
    const contenido = document.getElementById('contenido-pdf');
    
    // Convertir el contenido HTML a PDF
    doc.html(contenido, {
        callback: function (doc) {
            // Descargar el PDF
            doc.save('documento.pdf');
        },
        x: 10,
        y: 10
    });
});

function imprimir(){
    var boton = document.getElementById('descargar');
    var boton1 = document.getElementById('cursos');
    var boton2 = document.getElementById('sidebarToggleBtn');

    // Ocultar el botón
    boton.style.display = 'none';
    boton1.style.display = 'none';
    boton2.style.display = 'none';

    // Mostrar el botón después de 3 segundos
    setTimeout(function() {
      boton.style.display = 'block';
      boton1.style.display = 'block';
      boton2.style.display = 'block';
    }, 3000);
    window.print();

    
}

function cargaprofe() {
    let idAsignatura = $(".selectasignatura").val();  // Obtener el valor de la asignatura seleccionada
    let dia = $(".dia").val();  // Obtener el valor de la asignatura seleccionada
    let hora = $(".hora").val();  // Obtener el valor de la asignatura seleccionada
    let id = $(".detalleid").val();  // Obtener el valor de la asignatura seleccionada
    $(".cargaprofe").html("");
    // Verificar si se seleccionó una asignatura
    if(idAsignatura) {
        $.ajax({
            url: 'dinamicos.php',  // El archivo al que se hará la solicitud
            type: 'POST',  // Método POST
            data: {
                opcion: 'profesorasignatura',  // Enviar la opción como 'profesorasignatura'
                idAsignatura: idAsignatura,     // Enviar el idAsignatura
                dia: dia,     // Enviar el idAsignatura
                id: id,     // Enviar el idAsignatura
                hora: hora     // Enviar el idAsignatura
            },
            success: function(response) {
                // En caso de éxito, colocar la respuesta en el div con clase 'cargaprofe'
                $(".cargaprofe").html(response);
            },
            error: function() {
                // Si ocurre un error, mostrar un mensaje de error
                //$(".cargaprofe").html("Hubo un error al cargar los profesores.");
                $(".cargaprofe").html("Hubo un error al cargar los profesores.");
            }
        });
    } else {
        // Si no se seleccionó una asignatura, limpiar la sección de profesores
        $(".cargaprofe").html("");
    }
}


function aplicarBuscadorSelects() {
    $('select').select2({
        placeholder: "Selecciona una opción",
        allowClear: true,
        width: '100%'
    });
}

$(document).ready(function () {
    aplicarBuscadorSelects();
});



