<?php

namespace App\Exports;

use App\Models\Parametro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class ParametrosExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithMapping
{
    public function collection()
    {
        return Parametro::orderBy('id', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Valor',
            'Descripción',
            'Estado',
            'Fecha de Creación',
            'Última Actualización'
        ];
    }

    public function map($parametro): array
    {
        return [
            $parametro->id,
            $parametro->nombre,
            $parametro->valor,
            $parametro->descripcion ?? 'Sin descripción',
            $parametro->estado ? 'Activo' : 'Inactivo',
            Carbon::parse($parametro->created_at)->format('d/m/Y H:i'),
            Carbon::parse($parametro->updated_at)->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 25,
            'C' => 30,
            'D' => 40,
            'E' => 12,
            'F' => 20,
            'G' => 20,
        ];
    }
}
