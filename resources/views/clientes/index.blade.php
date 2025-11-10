<x-app-layout>
    <x-slot name="title">Clientes</x-slot>

    <div class="container-fluid p-4">
        <!-- Cabecera -->
        <div class="card mb-4 bg-primary bg-gradient text-white rounded-4 shadow">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">
                        <i class="bi bi-people me-2"></i>
                        Gestión de Clientes
                    </h1>
                    <a href="{{ route('clientes.create') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>
                        Nuevo Cliente
                    </a>
                </div>
            </div>
        </div>

        <!-- Mensajes de éxito -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tabla de Clientes -->
        <div class="card bg-dark border-secondary shadow rounded-4" style="border: 2px solid #fff;">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 20%;">Nombre</th>
                                <th style="width: 20%;">Email</th>
                                <th style="width: 10%;">Teléfono</th>
                                <th style="width: 20%;">Dirección</th>
                                <th style="width: 10%;">Estado</th>
                                <th style="width: 15%;" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clientes as $cliente)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $cliente->name }}</td>
                                    <td>{{ $cliente->email }}</td>
                                    <td>{{ $cliente->telefono ?? 'N/A' }}</td>
                                    <td>{{ $cliente->direccion ?? 'N/A' }}</td>
                                    <td>
                                        @if ($cliente->estado === 1)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-info"
                                                title="Ver">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('clientes.edit', $cliente) }}"
                                                class="btn btn-sm btn-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if ($cliente->estado === 1)
                                                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('¿Desactivar este cliente?')"
                                                        title="Desactivar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                        <p class="mt-2">No hay clientes registrados</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
