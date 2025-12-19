<?php

namespace App\Exports;

use App\Models\Reportes\ComprasPorCliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ComprasPorClienteExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ComprasPorCliente::orderBy('total_gastado', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Nombres',
            'Apellidos',
            'Documento',
            'Correo',
            'Total Compras',
            'Total Productos',
            'Total Gastado ($)',
            'Última Compra'
        ];
    }

    public function map($cliente): array
    {
        return [
            $cliente->nombres,
            $cliente->apellidos,
            $cliente->documento,
            $cliente->correo_usuario,
            $cliente->total_compras,
            $cliente->total_productos_comprados,
            number_format($cliente->total_gastado, 2, '.', ''), // CSV/Excel usa . para decimales
            $cliente->ultima_compra ? \Carbon\Carbon::parse($cliente->ultima_compra)->format('d/m/Y') : '—'
        ];
    }
}