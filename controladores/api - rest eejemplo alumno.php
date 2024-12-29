<?php

include_once '../config/config.php';
//ejemplo de como implementar sistema de api - rest 


// Obtener el método de la solicitud HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Procesar según el tipo de solicitud
switch ($method) {
    case 'POST':
        // Crear un nuevo alumno
        crearAlumno();
        break;

    case 'PUT':
        // Editar un alumno existente
        editarAlumno();
        break;

    case 'DELETE':
        // Eliminar un alumno
        eliminarAlumno();
        break;

    default:
        // Si el método no es válido, responder con error
        header('HTTP/1.1 405 Method Not Allowed');
        echo json_encode(["message" => "Método no permitido"]);
        break;
}

// Función para crear un nuevo alumno (POST)
function crearAlumno() {
    // Obtener los datos en formato JSON enviados por el cliente
    $data = json_decode(file_get_contents('php://input'), true);

    // Validar que se hayan enviado los datos necesarios
    if (isset($data['nombre'], $data['apellidos'], $data['rut'], $data['fecha_nacimiento'])) {
        $nombre = $data['nombre'];
        $apellidos = $data['apellidos'];
        $rut = limpiarRut($data['rut']);
        $fecha_nacimiento = $data['fecha_nacimiento'];

        // Llamar a la función de DAO para insertar el nuevo alumno
        $resultado = crearAlumno($nombre, $apellidos, $rut, $fecha_nacimiento);

        if ($resultado === "Alumno creado exitosamente.") {
            echo json_encode(["message" => $resultado]);
        } else {
            echo json_encode(["message" => $resultado]);
        }
    } else {
        // Si faltan datos, responder con un error
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(["message" => "Faltan datos necesarios"]);
    }
}

// Función para editar un alumno (PUT)
function editarAlumno() {
    // Obtener los datos en formato JSON enviados por el cliente
    $data = json_decode(file_get_contents('php://input'), true);

    // Validar que se hayan enviado los datos necesarios
    if (isset($data['id_alumno'], $data['nombre'], $data['apellidos'], $data['rut'], $data['fecha_nacimiento'])) {
        $id_alumno = $data['id_alumno'];
        $nombre = $data['nombre'];
        $apellidos = $data['apellidos'];
        $rut = limpiarRut($data['rut']);
        $fecha_nacimiento = $data['fecha_nacimiento'];

        // Llamar a la función de DAO para editar el alumno
        editarAlumno($id_alumno, $nombre, $apellidos, $rut, $fecha_nacimiento);

        echo json_encode(["message" => "Alumno editado exitosamente"]);
    } else {
        // Si faltan datos, responder con un error
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(["message" => "Faltan datos necesarios"]);
    }
}

// Función para eliminar un alumno (DELETE)
function eliminarAlumno() {
    // Obtener el ID del alumno a eliminar (en el cuerpo de la solicitud)
    $data = json_decode(file_get_contents('php://input'), true);

    // Validar que se haya enviado el ID del alumno
    if (isset($data['id_alumno'])) {
        $id_alumno = $data['id_alumno'];

        // Llamar a la función de DAO para eliminar el alumno
        eliminarAlumno($id_alumno);

        echo json_encode(["message" => "Alumno eliminado exitosamente"]);
    } else {
        // Si falta el ID del alumno, responder con un error
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(["message" => "Faltan datos necesarios"]);
    }
}

// Función para limpiar el RUT (elimina caracteres no permitidos)
function limpiarRut($rut) {
    // Eliminar puntos, guiones y comas, y convertir la letra 'K' a minúscula
    return strtolower(preg_replace('/[^0-9kK]/', '', $rut));
}
?>

