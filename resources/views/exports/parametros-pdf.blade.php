<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Parámetros</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #4472C4;
        }

        .header h1 {
            font-size: 20px;
            color: #4472C4;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 9px;
            color: #666;
        }

        .info {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }

        .info-item {
            font-size: 9px;
        }

        .info-label {
            font-weight: bold;
            color: #4472C4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background-color: #4472C4;
            color: white;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            font-weight: bold;
            font-size: 10px;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            display: inline-block;
        }

        .badge-activo {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-inactivo {
            background-color: #f8d7da;
            color: #721c24;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 8px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>📋 Listado de Parámetros del Sistema</h1>
        <p>Reporte generado automáticamente</p>
    </div>

    <div class="info">
        <div class="info-item">
            <span class="info-label">Fecha de Generación:</span> {{ $fecha }}
        </div>
        <div class="info-item">
            <span class="info-label">Total de Registros:</span> {{ $total }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 20%;">Nombre</th>
                <th style="width: 25%;">Valor</th>
                <th style="width: 30%;">Descripción</th>
                <th style="width: 10%;">Estado</th>
                <th style="width: 10%;">Creado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($parametros as $parametro)
                <tr>
                    <td>{{ $parametro->id }}</td>
                    <td><strong>{{ $parametro->nombre }}</strong></td>
                    <td>{{ Str::limit($parametro->valor, 40) }}</td>
                    <td>{{ $parametro->descripcion ?? 'Sin descripción' }}</td>
                    <td>
                        <span class="badge {{ $parametro->estado ? 'badge-activo' : 'badge-inactivo' }}">
                            {{ $parametro->estado ? 'ACTIVO' : 'INACTIVO' }}
                        </span>
                    </td>
                    <td>{{ $parametro->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #999;">
                        No hay parámetros registrados
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Sistema de Configuraciones - Generado el {{ $fecha }}</p>
    </div>
</body>

</html>
