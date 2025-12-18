@extends('layouts.app')


@section('title','Panel de Control')


@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">


<div class="bg-white p-6 rounded-xl shadow">
<h3 class="text-sm text-gray-500">Productos</h3>
<p class="text-3xl font-bold">{{ $totalProductos }}</p>
</div>


<div class="bg-white p-6 rounded-xl shadow">
<h3 class="text-sm text-gray-500">Categorías</h3>
<p class="text-3xl font-bold">{{ $totalCategorias }}</p>
</div>

<div class="bg-white p-6 rounded-xl shadow">
<h3 class="text-sm text-gray-500">Producciones</h3>
<p class="text-3xl font-bold">{{ $totalProducciones }}</p>
</div>

@endsection