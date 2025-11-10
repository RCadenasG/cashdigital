<?php

namespace App\Exports;

use App\Models\Operacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OperacionesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Operacion::with(['cliente', 'usuario', 'parametroServicio'])
            ->orderBy('fecha', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Cliente',
            'Usuario',
            'Tipo de Pago',
            'Servicio',
            'Monto Pago',
            'Comisión',
            'Total',
            'Fecha',
            'Hora',
            'Registrado',
        ];
    }

    public function map($operacion): array
    {
        return [
            $operacion->id,
            $operacion->cliente->name,
            $operacion->usuario->name,
            $operacion->tipo_pago_nombre,
            $operacion->servicio_nombre ?? '-',
            'S/ ' . number_format($operacion->monto_pago, 2),
            'S/ ' . number_format($operacion->monto_comision, 2),
            'S/ ' . number_format($operacion->monto_total, 2),
            $operacion->fecha->format('d/m/Y'),
            $operacion->hora->format('H:i'),
            $operacion->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
