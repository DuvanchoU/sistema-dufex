<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>@yield('title','ORDER RAE')</title>
@vite(['resources/css/app.css','resources/js/app.js'])
</head>


<body class="bg-[#F8F5F0]" x-data="{ sidebarOpen: true }">


<div class="flex min-h-screen">


<!-- SIDEBAR -->
<aside
class="bg-[#EFE6D8] w-64 p-6 transition-all duration-300"
:class="sidebarOpen ? 'block' : 'hidden md:block'">


<h1 class="text-xl font-bold text-[#6B5B3E] mb-8">ORDER RAE</h1>


<nav class="space-y-3">
        <a href="/dashboard" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Panel de Control</a>
        <a href="/bodegas" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Bodegas</a>
        <a href="/categorias" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Categorías</a>
        <a href="/clientes" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Clientes</a>
        <a href="/compras" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Compras</a>
        <a href="/inventario" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Inventario</a>
        <a href="/metodos_pago" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Metodos de Pago</a>
        <a href="/pedidos" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Pedidos</a>
        <a href="/permisos" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Permisos</a>
        <a href="/produccion" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Producciones</a>
        <a href="/productos" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Productos</a>
        <a href="/proveedores" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Proveedores</a>
        <a href="/roles" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Roles</a>
        <a href="/reportes" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Reportes</a>
        <a href="/usuarios" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Usuarios</a>
        <a href="/ventas" class="block px-3 py-2 rounded hover:bg-[#E3D6C4]">Ventas</a>
    </nav>
</aside>


<!-- CONTENIDO -->
<main class="flex-1">


<!-- HEADER -->
<header class="bg-white shadow px-6 py-4 flex items-center gap-4">
<button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-xl">☰</button>
<h2 class="font-semibold text-lg">@yield('title')</h2>
</header>


<!-- PAGE -->
<section class="p-6">
@yield('content')
</section>


</main>
</div>


</body>
</html>