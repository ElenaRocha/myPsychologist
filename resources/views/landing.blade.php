<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Cabecera -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-gray-800">
                Mi Aplicación
            </div>
            <nav>
                <a href="{{ route('login') }}" class="text-gray-800 hover:text-blue-500 px-4">Login</a>
                <a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Registrarse</a>
            </nav>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="container mx-auto px-6 py-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenido a Mi Aplicación</h1>
            <p class="text-gray-600 mb-8">Una solución increíble para tus necesidades.</p>
            <a href="{{ route('register') }}" class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600">Comenzar</a>
        </div>
    </main>

    <!-- Pie de página -->
    <footer class="bg-white shadow mt-8">
        <div class="container mx-auto px-6 py-4 text-center text-gray-600">
            &copy; {{ date('Y') }} Mi Aplicación. Todos los derechos reservados.
        </div>
    </footer>
</body>
</html>