<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Listado de Operaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #2d3748;
        }

        .info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #4a5568;
            color: white;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 10px;
        }

        td {
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .totales {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #666;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9px;
        }

        .badge-info {
            background-color: #17a2b8;
            color: white;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Listado de Operaciones</h1>
        <p>Sistema CashDigital</p>
    </div>

    <div class="info">
        <p><strong>Fecha de generación:</strong> {{ $fecha }}</p>
        <p><strong>Total de operaciones:</strong> {{ $total }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">ID</th>
                <th style="width: 15%;">Cliente</th>
                <th style="width: 12%;">Usuario</th>
                <th style="width: 10%;">Tipo</th>
                <th style="width: 12%;">Servicio</th>
                <th style="width: 10%;">Monto</th>
                <th style="width: 10%;">Comisión</th>
                <th style="width: 10%;">Total</th>
                <th style="width: 9%;">Fecha</th>
                <th style="width: 8%;">Hora</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalMonto = 0;
                $totalComision = 0;
                $totalGeneral = 0;
            @endphp
            @foreach ($operaciones as $operacion)
                @php
                    $totalMonto += $operacion->monto_pago;
                    $totalComision += $operacion->monto_comision;
                    $totalGeneral += $operacion->monto_total;
                @endphp
                <tr>
                    <td>{{ $operacion->id }}</td>
                    <td>{{ $operacion->cliente->name }}</td>
                    <td>{{ $operacion->usuario->name }}</td>
                    <td>
                        @if ($operacion->tipo_pago === 1)
                            <span class="badge badge-info">Servicio</span>
                        @else
                            <span class="badge badge-success">Transfer</span>
                        @endif
                    </td>
                    <td>{{ $operacion->servicio_nombre ?? '-' }}</td>
                    <td>S/ {{ number_format($operacion->monto_pago, 2) }}</td>
                    <td>S/ {{ number_format($operacion->monto_comision, 2) }}</td>
                    <td>S/ {{ number_format($operacion->monto_total, 2) }}</td>
                    <td>{{ $operacion->fecha->format('d/m/Y') }}</td>
                    <td>{{ $operacion->hora->format('H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #e9ecef; font-weight: bold;">
                <td colspan="5" style="text-align: right;">TOTALES:</td>
                <td>S/ {{ number_format($totalMonto, 2) }}</td>
                <td>S/ {{ number_format($totalComision, 2) }}</td>
                <td>S/ {{ number_format($totalGeneral, 2) }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Documento generado automáticamente por Sistema CashDigital</p>
    </div>
</body>

</html>
