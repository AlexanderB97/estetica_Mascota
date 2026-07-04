<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estética Mascotas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

<div class="flex min-h-screen">

    @include('components.sidebar')

    <div class="flex-1 ml-64">
        <main class="p-6">
            {{ $slot }}
        </main>
    </div>

</div>

@livewireScripts
</body>
</html>