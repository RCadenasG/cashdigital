<x-app-layout>
    <x-slot name="title">Detalle de Operación</x-slot>

    <div class="container-fluid p-4">
        <!-- Cabecera -->
        <div class="card mb-4 bg-primary bg-gradient text-white rounded-4 shadow">
            <div class="card-body p-3">
                <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">
                    <i class="bi bi-eye me-2"></i>
                    Detalle de Operación #{{ $operacion->id }}
                </h1>
            </div>
        </div>

        <!-- Información de la Operación -->
        <div class="card bg-dark border-secondary shadow rounded-4" style="border: 2px solid #fff;">
            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- Cliente -->
                    <div class="col-md-6">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Cliente</label>
                            <p class="fs-5 mb-0 text-white fw-bold">{{ $operacion->cliente->name }}</p>
                            <small class="text-white-50">{{ $operacion->cliente->email }}</small>
                        </div>
                    </div>

                    <!-- Usuario -->
                    <div class="col-md-6">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Usuario que registró</label>
                            <p class="fs-5 mb-0 text-white fw-bold">{{ $operacion->usuario->name }}</p>
                        </div>
                    </div>

                    <!-- Tipo de Pago -->
                    <div class="col-md-6">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Tipo de Pago</label>
                            <p class="fs-5 mb-0">
                                @if ($operacion->tipo_pago === 1)
                                    <span class="badge bg-info">Pago de Servicio</span>
                                @else
                                    <span class="badge bg-success">Transferencia</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Servicio -->
                    @if ($operacion->tipo_pago === 1)
                        <div class="col-md-6">
                            <div class="p-3 bg-secondary bg-opacity-25 rounded">
                                <label class="form-label text-white-50 small">Servicio</label>
                                <p class="fs-5 mb-0 text-white fw-bold">{{ $operacion->servicio_nombre }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Monto a Pagar -->
                    <div class="col-md-4">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Monto a Pagar</label>
                            <p class="fs-5 mb-0 text-white fw-bold">S/ {{ number_format($operacion->monto_pago, 2) }}
                            </p>
                        </div>
                    </div>

                    <!-- Comisión -->
                    <div class="col-md-4">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Comisión</label>
                            <p class="fs-5 mb-0 text-warning fw-bold">S/
                                {{ number_format($operacion->monto_comision, 2) }}</p>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="col-md-4">
                        <div class="p-3 bg-success bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Monto Total</label>
                            <p class="fs-5 mb-0 text-white fw-bold">S/ {{ number_format($operacion->monto_total, 2) }}
                            </p>
                        </div>
                    </div>

                    <!-- Fecha -->
                    <div class="col-md-6">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Fecha</label>
                            <p class="fs-5 mb-0 text-white fw-bold">{{ $operacion->fecha->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <!-- Hora -->
                    <div class="col-md-6">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Hora</label>
                            <p class="fs-5 mb-0 text-white fw-bold">{{ $operacion->hora->format('H:i') }}</p>
                        </div>
                    </div>

                    <!-- Fecha de Registro -->
                    <div class="col-md-6">
                        <div class="p-3 bg-secondary bg-opacity-25 rounded">
                            <label class="form-label text-white-50 small">Registrado el</label>
                            <p class="fs-5 mb-0 text-white fw-bold">{{ $operacion->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-between mt-4 pt-4 border-top border-secondary">
                    <a href="{{ route('operaciones.index') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>
                        Volver
                    </a>

                    <a href="{{ route('operaciones.edit', $operacion->id) }}" class="btn btn-warning btn-lg">
                        <i class="bi bi-pencil me-2"></i>
                        Editar Operación
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
