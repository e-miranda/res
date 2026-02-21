<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Restaurante' }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-gray-800 text-white p-4">
    <div class="container mx-auto flex justify-between">
        <span class="font-bold">Restaurante</span>
        <span>{{ auth()->user()->name }}</span>
    </div>
</nav>

<main class="container mx-auto mt-6">
    {{ $slot }}
</main>

</body>
</html>
