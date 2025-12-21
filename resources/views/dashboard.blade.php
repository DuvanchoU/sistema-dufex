@extends('layouts.app')

@section('title','Panel de Control')

@section('content')

{{-- KPI CARDS --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

@php
$cards = [
    ['title'=>'Productos','value'=>$totalProductos,'icon'=>'box'],
    ['title'=>'Categorías','value'=>$totalCategorias,'icon'=>'grid'],
    ['title'=>'Producciones','value'=>$totalProducciones,'icon'=>'tool'],
    ['title'=>'Pedidos','value'=>$totalPedidos,'icon'=>'clipboard'],
    ['title'=>'Ventas','value'=>$totalVentas,'icon'=>'shopping-cart'],
    ['title'=>'Usuarios','value'=>$totalUsuarios,'icon'=>'users'],
    ['title'=>'Compras','value'=>$totalCompras,'icon'=>'truck'],
    ['title'=>'Roles','value'=>$totalRoles,'icon'=>'shield'],
];
@endphp

@foreach($cards as $card)
<div class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
    <div>
        <p class="text-sm text-gray-500 uppercase">{{ $card['title'] }}</p>
        <p class="text-3xl font-bold">{{ $card['value'] }}</p>
    </div>
    <div class="bg-[#EFE6D8] p-3 rounded-full">
        <i data-feather="{{ $card['icon'] }}" class="w-5 h-5 text-[#6B5B3E]"></i>
    </div>
</div>
@endforeach

</div>

{{-- GRAFICAS PEQUEÑAS EN UNA MISMA HILERA --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">

    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-sm font-semibold mb-2 text-gray-600">
            Ventas por Mes
        </h3>
        <div class="h-40">
            <canvas id="ventasChart"></canvas>
        </div>
    </div>

    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-sm font-semibold mb-2 text-gray-600">
            Pedidos por Mes
        </h3>
        <div class="h-40">
            <canvas id="pedidosChart"></canvas>
        </div>
    </div>

</div>

{{-- CHART JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const ventasCtx = document.getElementById('ventasChart');
    const pedidosCtx = document.getElementById('pedidosChart');

    if (ventasCtx) {
        new Chart(ventasCtx, {
            type: 'line',
            data: {
                labels: ['Ene','Feb','Mar','Abr','May','Jun'],
                datasets: [{
                    label: 'Ventas',
                    data: [12, 19, 8, 15, 22, 18],
                    borderColor: '#6B5B3E',
                    backgroundColor: 'rgba(107,91,62,0.15)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    if (pedidosCtx) {
        new Chart(pedidosCtx, {
            type: 'bar',
            data: {
                labels: ['Ene','Feb','Mar','Abr','May','Jun'],
                datasets: [{
                    label: 'Pedidos',
                    data: [20, 25, 18, 30, 28, 35],
                    backgroundColor: '#C8B89A'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

});
</script>
@endsection
