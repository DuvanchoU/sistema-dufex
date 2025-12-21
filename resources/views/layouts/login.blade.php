<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'ORDER RAE')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F8F5F0] min-h-screen flex items-center justify-center p-4">

    <!-- Contenedor principal -->
    <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden flex">

        <!-- Columna izquierda: Logo -->
        <div class="w-1/2 bg-[#EFE6D8] p-8 flex flex-col justify-center items-center text-center">
            <!-- Logo -->
            <img src="{{ asset('images/logo dufex.png') }}" alt="ORDER R.A.E" class="max-h-64 max-w-full object-contain">
        </div>

        <!-- Columna derecha: Formulario de login -->
        <div class="w-1/2 p-8 flex flex-col justify-center">
            <div class="max-w-md mx-auto w-full">

                <h1 class="text-2xl font-bold text-gray-800 mb-6">Iniciar Sesión</h1>

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#CBB8A0] focus:border-[#CBB8A0]"
                            required
                        >
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#CBB8A0] focus:border-[#CBB8A0]"
                            required
                        >
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                class="h-4 w-4 text-[#CBB8A0] rounded focus:ring-[#CBB8A0]"
                            >
                            <label for="remember" class="ml-2 text-sm text-gray-700">Recordarme</label>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full px-4 py-2 bg-[#CBB8A0] hover:bg-[#B9A489] text-white rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                        Iniciar Sesión
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</body>
</html>