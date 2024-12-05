function abrirPopupasignatura(id, dia) {
    // Construir la URL con los parámetros id y dia
    var url = "popupdinamicohorario.php?id=" + id + "&dia=" + dia;
    
    // Crear una ventana emergente
    var ventana = window.open(url, "popupHorario", "width=600,height=400,top=" + (window.innerHeight / 2 - 200) + ",left=" + (window.innerWidth / 2 - 300));
}


function abrirPopupfecha(id, dia) {
    // Construir la URL con los parámetros id y dia
    var url = "popupdinamicohorario.php?id=" + id + "&dia=" + dia;
    
    // Crear una ventana emergente
    var ventana = window.open(url, "popupHorario", "width=600,height=400,top=" + (window.innerHeight / 2 - 200) + ",left=" + (window.innerWidth / 2 - 300));
}