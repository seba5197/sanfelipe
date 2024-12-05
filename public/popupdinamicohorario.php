<?php
// Obtener los parámetros enviados por la URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
$dia = isset($_GET['dia']) ? $_GET['dia'] : '';

// Ejemplo de datos de asignaturas y profesores
$asignaturas = ["Matemática", "Lenguaje", "Ciencias", "Historia", "Inglés"];
$profesores = ["Profesor 1", "Profesor 2", "Profesor 3", "Profesor 4", "Profesor 5"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popup Dinámico</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Estilos para centrar el popup */
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .popup-content {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .popup-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group select {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="popup-content">
    <div class="popup-header">
        <h3>Horario del Día: <?php echo $dia; ?></h3>
        <h4>Hora: <?php echo $id; ?></h4>
    </div>

    <form action="guardar_horario.php" method="post">
        <!-- Asignatura -->
        <div class="form-group">
            <label for="asignatura">Asignatura</label>
            <select id="asignatura" name="asignatura" class="form-control">
                <?php foreach ($asignaturas as $asignatura): ?>
                    <option value="<?php echo $asignatura; ?>"><?php echo $asignatura; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Profesor -->
        <div class="form-group">
            <label for="profesor">Profesor</label>
            <select id="profesor" name="profesor" class="form-control">
                <?php foreach ($profesores as $profesor): ?>
                    <option value="<?php echo $profesor; ?>"><?php echo $profesor; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Botón para guardar -->
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>

<!-- Inclusión de Select2 para el buscador en los select -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Aplicar el estilo de select2 para los selects con búsqueda
        $('#asignatura').select2();
        $('#profesor').select2();
    });
</script>

</body>
</html>
