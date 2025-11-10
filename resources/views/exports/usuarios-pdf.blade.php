<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Usuarios Exportados</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background: #0d6efd;
            color: #fff;
        }

        .header {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Listado de Usuarios</h2>
        <p>Fecha de exportación: {{ $fecha }}</p>
        <p>Total de usuarios: {{ $total }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Verificado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->getKey() }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->telefono ?? '-' }}</td>
                    <td>{{ $usuario->activo ? 'Activo' : 'Inactivo' }}</td>
                    <td>{{ $usuario->email_verified_at ? 'Sí' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
