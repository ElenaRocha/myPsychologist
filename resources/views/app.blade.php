<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Psychologist</title>
    <!-- Cargar los estilos de tu aplicación -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <!-- Aquí se montará tu aplicación Vue -->
        <example-component></example-component> <!-- Ejemplo de componente Vue -->
    </div>

    <!-- Cargar el archivo JavaScript compilado -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>