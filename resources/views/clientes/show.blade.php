<x-app-layout>
    <x-slot name="title">Detalle del Cliente</x-slot>

    <div class="container-fluid p-4">
        <!-- Cabecera -->
        <div class="card mb-4 bg-primary bg-gradient text-white rounded-4 shadow">
            <div class="card-body p-3">
                <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">
                    <i class="bi bi-person-badge me-2"></i>
                    Detalle del Cliente
                </h1>
            </div>
        </div>

        <!-- Información del Cliente -->
        <div class="card bg-dark border-secondary shadow rounded-4" style="border: 2px solid #fff;">
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Nombre Completo</label>
                            <p class="fs-5 mb-0 text-white fw-bold">{{ $cliente->name }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Correo Electrónico</label>
                            <p class="fs-5 mb-0 text-white fw-bold">{{ $cliente->email }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Teléfono</label>
                            <p class="fs-5 mb-0 text-white fw-bold">{{ $cliente->telefono ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Dirección</label>
                            <p class="fs-5 mb-0 text-white fw-bold">{{ $cliente->direccion ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Estado</label>
                            <p class="fs-5 mb-0">
                                @if ($cliente->estado === 1)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Fecha de Registro</label>
                            <p class="fs-5 mb-0 text-white fw-bold">
                                {{ $cliente->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-between mt-4 pt-4 border-top border-secondary">
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>
                        Volver
                    </a>

                    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning btn-lg">
                        <i class="bi bi-pencil me-2"></i>
                        Editar Cliente
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
