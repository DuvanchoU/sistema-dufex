<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'La Super Bodega del Mueble')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo">
                        <span class="ml-2 text-xl font-bold text-gray-900">Super Bodega del Mueble</span>
                    </div>
                    <nav class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('tienda.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 bg-gray-200">Inicio</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">Muebles</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">Decoración</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">Ofertas</a>
                    </nav>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('tienda.carrito') }}" class="mr-4 relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ $carritoCount ?? 0 }}
                        </span>
                    </a>
                    @auth
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">Cerrar Sesión</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">Iniciar Sesión</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="py-6">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <div>
                    <p>&copy; 2025 La Super Bodega del Mueble. Todos los derechos reservados.</p>
                </div>
                <div>
                    <a href="#" class="text-gray-300 hover:text-white mx-2"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-gray-300 hover:text-white mx-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-300 hover:text-white mx-2"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>