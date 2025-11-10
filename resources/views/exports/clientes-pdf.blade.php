<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Listado de Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
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
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
        }

        .badge-success {
            background-color: #48bb78;
            color: white;
        }

        .badge-danger {
            background-color: #f56565;
            color: white;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Listado de Clientes</h1>
        <p>Sistema CashDigital</p>
    </div>

    <div class="info">
        <p><strong>Fecha de generación:</strong> {{ $fecha }}</p>
        <p><strong>Total de clientes:</strong> {{ $total }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 20%;">Nombre</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 12%;">Teléfono</th>
                <th style="width: 25%;">Dirección</th>
                <th style="width: 10%;">Estado</th>
                <th style="width: 13%;">Fecha Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->name }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>{{ $cliente->telefono ?? 'N/A' }}</td>
                    <td>{{ $cliente->direccion ?? 'N/A' }}</td>
                    <td>
                        @if ($cliente->estado === 1)
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>{{ $cliente->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Documento generado automáticamente por Sistema CashDigital</p>
    </div>
</body>

</html>
