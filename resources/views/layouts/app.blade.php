<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','DUFEX')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-[#F8F5F0]" x-data="{ sidebarOpen: true }">

<div class="flex min-h-screen">

<!-- SIDEBAR -->
<aside class="bg-[#EFE6D8] w-64 p-6 transition-all duration-300"
       :class="sidebarOpen ? 'block' : 'hidden md:block'">

    <!-- LOGO -->
    <div class="mb-3 flex justify-center items-center">
        <img src="{{ asset('images/logo dufex.png') }}" alt="DUFEX" class="max-h-24 w-auto">
    </div>

    <!-- PERFIL DEL USUARIO -->
    @auth
    <div class="mb-8 p-3 bg-[#e0d8c9] rounded-lg shadow-sm">
        <div class="flex items-center gap-3">
            <div class="bg-[#CBB8A0] text-white w-10 h-10 rounded-full flex items-center justify-center">
                <i data-feather="user"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-800">
                    {{ auth()->user()->nombres ?? 'Usuario' }}
                </p>
                <p class="text-xs text-[#6B5B3E]">
                    {{ auth()->user()->rol?->nombre_rol ?? 'Sin rol' }}
                </p>
            </div>
        </div>
    </div>
    @endauth

    <!-- MENÚ DE NAVEGACIÓN -->
    <nav class="space-y-1 text-sm text-[#6B5B3E]">

    <!-- DASHBOARD -->
    @auth
    <a href="{{ route('dashboard') }}"
    class="flex items-center gap-3 px-3 py-2 rounded-lg
    {{ request()->routeIs('dashboard') ? 'bg-[#E3D6C4] font-semibold' : 'hover:bg-[#E3D6C4]' }}">
        <i data-feather="home"></i> Dashboard
    </a>
    @endauth

    @auth
    <!-- OPERACIÓN -->
    <p class="mt-4 text-xs uppercase text-gray-500 px-3">Operación</p>

    @foreach([
        ['permiso'=>'ver_productos','route'=>'productos.*','url'=>route('productos.index'),'icon'=>'box','label'=>'Productos'],
        ['permiso'=>'ver_categorias','route'=>'categorias.*','url'=>route('categorias.index'),'icon'=>'grid','label'=>'Categorías'],
        ['permiso'=>'ver_inventario','route'=>'inventario.*','url'=>route('inventario.index'),'icon'=>'layers','label'=>'Inventario'],
        ['permiso'=>'ver_produccion','route'=>'produccion.*','url'=>route('produccion.index'),'icon'=>'tool','label'=>'Producción'],
        ['permiso'=>'ver_bodegas','route'=>'bodegas.*','url'=>route('bodegas.index'),'icon'=>'archive','label'=>'Bodegas'],
        ['permiso'=>'ver_proveedores','route'=>'proveedores.*','url'=>route('proveedores.index'),'icon'=>'truck','label'=>'Proveedores'],
    ] as $item)
    @if(auth()->user()->tienePermiso($item['permiso']))
    <a href="{{ $item['url'] }}"
    class="flex items-center gap-3 px-3 py-2 rounded-lg
    {{ request()->routeIs($item['route']) ? 'bg-[#E3D6C4] font-semibold' : 'hover:bg-[#E3D6C4]' }}">
        <i data-feather="{{ $item['icon'] }}"></i> {{ $item['label'] }}
    </a>
    @endif
    @endforeach
    @endauth

    @auth
    <!-- COMERCIAL -->
    <p class="mt-4 text-xs uppercase text-gray-500 px-3">Comercial</p>

    @foreach([
        ['permiso'=>'ver_clientes','route'=>'clientes.*','url'=>route('clientes.index'),'icon'=>'user','label'=>'Clientes'],
        ['permiso'=>'ver_ventas','route'=>'ventas.*','url'=>route('ventas.index'),'icon'=>'shopping-cart','label'=>'Ventas'],
        ['permiso'=>'ver_pedidos','route'=>'pedidos.*','url'=>route('pedidos.index'),'icon'=>'clipboard','label'=>'Pedidos'],
        ['permiso'=>'ver_compras','route'=>'compras.*','url'=>route('compras.index'),'icon'=>'shopping-bag','label'=>'Compras'],
        ['permiso'=>'ver_metodos_pago','route'=>'metodos_pago.*','url'=>route('metodos_pago.index'),'icon'=>'credit-card','label'=>'Métodos de Pago'],
    ] as $item)
    @if(auth()->user()->tienePermiso($item['permiso']))
    <a href="{{ $item['url'] }}"
    class="flex items-center gap-3 px-3 py-2 rounded-lg
    {{ request()->routeIs($item['route']) ? 'bg-[#E3D6C4] font-semibold' : 'hover:bg-[#E3D6C4]' }}">
        <i data-feather="{{ $item['icon'] }}"></i> {{ $item['label'] }}
    </a>
    @endif
    @endforeach
    @endauth

    @auth
    <!-- SEGURIDAD -->
    <p class="mt-4 text-xs uppercase text-gray-500 px-3">Seguridad</p>

    @foreach([
        ['permiso'=>'ver_usuarios','route'=>'usuarios.*','url'=>route('usuarios.index'),'icon'=>'users','label'=>'Usuarios'],
        ['permiso'=>'ver_roles','route'=>'roles.*','url'=>route('roles.index'),'icon'=>'shield','label'=>'Roles'],
        ['permiso'=>'ver_permisos','route'=>'permisos.*','url'=>route('permisos.index'),'icon'=>'lock','label'=>'Permisos'],
    ] as $item)
    @if(auth()->user()->tienePermiso($item['permiso']))
    <a href="{{ $item['url'] }}"
    class="flex items-center gap-3 px-3 py-2 rounded-lg
    {{ request()->routeIs($item['route']) ? 'bg-[#E3D6C4] font-semibold' : 'hover:bg-[#E3D6C4]' }}">
        <i data-feather="{{ $item['icon'] }}"></i> {{ $item['label'] }}
    </a>
    @endif
    @endforeach
    @endauth

    @auth
    <!-- CERRAR SESIÓN -->
            <div class="mt-6 pt-4 border-t border-gray-300">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full text-left px-3 py-2 text-sm text-gray-600 hover:bg-[#E3D6C4] rounded-lg">
                        <i data-feather="log-out"></i> Cerrar sesión
                    </button>
                </form>
            </div>
     @endauth
    </nav>
    </aside>

<!-- CONTENT -->
<main class="flex-1 flex flex-col min-h-screen">
    
    <header class="bg-white shadow px-6 py-4 flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-xl">☰</button>
        <h2 class="font-semibold text-lg">@yield('title')</h2>
    </header>

    <section class="flex-1 p-6">
        @yield('content')
    </section>

    <!-- FOOTER -->
    <footer class="border-t border-gray-200 py-6">
        <div class="flex flex-col items-center justify-center text-center gap-2">
            <img src="{{ asset('images/logo frase largo.JPG') }}"
                 alt="DUFEX"
                 class="h-12 mx-auto">

            <p class="text-xs text-gray-500">
                © {{ date('Y') }} DUFEX · ORDEN QUE VENDE
            </p>
        </div>
    </footer>

</main>


<script>feather.replace()</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</body>
</html>
