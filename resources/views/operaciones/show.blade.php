<x-app-layout>
    <x-slot name="title">Detalle de Operación</x-slot>

    <div class="container-fluid p-2 p-md-4">
        <!-- Cabecera -->
        <div class="card mb-3 mb-md-4 bg-primary bg-gradient text-white rounded-4 shadow">
            <div class="card-body p-2 p-md-3">
                <h1 class="mb-0 fw-bold" style="font-size: clamp(1.5rem, 4vw, 2.5rem);">
                    <i class="bi bi-eye me-2"></i>
                    Detalle de Operación #{{ $operacion->id }}
                </h1>
            </div>
        </div>

        <!-- Formulario de solo lectura -->
        <div class="card bg-dark border-secondary shadow rounded-4" style="border: 2px solid #fff;">
            <div class="card-body p-2 p-md-4">
                <div class="row g-3">
                    <!-- Cliente -->
                    <div class="col-12 col-md-6">
                        <div style="display: flex; flex-direction: column;">
                            <label class="form-label text-white mb-2">Cliente</label>
                            <input class="form-control text-black" type="text"
                                value="{{ $operacion->cliente->name }}" readonly
                                style="border-radius: 0.5rem; background-color: #e9ecef;" />
                            <small class="text-white-50 mt-1">{{ $operacion->cliente->email }}</small>
                        </div>
                    </div>

                    <!-- Usuario -->
                    <div class="col-12 col-md-6">
                        <div style="display: flex; flex-direction: column;">
                            <label class="form-label text-white mb-2">Usuario que registró</label>
                            <input class="form-control text-black" type="text"
                                value="{{ $operacion->usuario->name }}" readonly
                                style="border-radius: 0.5rem; background-color: #e9ecef;" />
                        </div>
                    </div>

                    <!-- Tipo de Pago -->
                    @if ($operacion->tipo_pago === 1)
                        <div class="col-12 col-md-6">
                            <div style="display: flex; flex-direction: column;">
                                <label class="form-label text-white mb-2">Tipo de pago</label>
                                <input class="form-control text-black" type="text" value="Pago de servicios" readonly
                                    style="border-radius: 0.5rem; background-color: #e9ecef;" />
                            </div>
                        </div>
                    @else
                        <div class="col-12 col-md-6">
                            <div style="display: flex; flex-direction: column;">
                                <label class="form-label text-white mb-2">Tipo de Pago</label>
                                <input class="form-control text-black" type="text" value="Transferencia" readonly
                                    style="border-radius: 0.5rem; background-color: #e9ecef;" />
                            </div>
                        </div>
                    @endif

                    <!-- Servicio (visible solo si tipo_pago = 1) -->
                    @if ($operacion->tipo_pago === 1)
                        <div class="col-12 col-md-6">
                            <div style="display: flex; flex-direction: column;">
                                <label class="form-label text-white mb-2">Servicio</label>
                                <input class="form-control text-black" type="text"
                                    value="{{ $operacion->servicio_nombre }}" readonly
                                    style="border-radius: 0.5rem; background-color: #e9ecef;" />
                            </div>
                        </div>
                    @endif

                    <!-- Monto a Pagar -->
                    <div class="col-12 col-md-6">
                        <div style="display: flex; flex-direction: column;">
                            <label class="form-label text-white mb-2">Monto a Pagar (S/)</label>
                            <input class="form-control text-black" type="text"
                                value="S/ {{ number_format($operacion->monto_pago, 2) }}" readonly
                                style="border-radius: 0.5rem; background-color: #e3ca0a;" />
                        </div>
                    </div>

                    <!-- Comisión -->
                    <div class="col-12 col-md-6">
                        <div style="display: flex; flex-direction: column;">
                            <label class="form-label text-white mb-2">Comisión (S/)</label>
                            <input class="form-control text-black fw-bold" type="text"
                                value="S/ {{ number_format($operacion->monto_comision, 2) }}" readonly
                                style="border-radius: 0.5rem; background-color: #e3ca0a;" />
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="col-12 col-md-6">
                        <div style="display: flex; flex-direction: column;">
                            <label class="form-label text-white mb-2">Monto Total (S/)</label>
                            <input class="form-control text-black fw-bold" type="text"
                                value="S/ {{ number_format($operacion->monto_total, 2) }}" readonly
                                style="border-radius: 0.5rem; background-color: #e3ca0a;" />
                        </div>
                    </div>

                    <!-- Fecha -->
                    <div class="col-12 col-md-6">
                        <div style="display: flex; flex-direction: column;">
                            <label class="form-label text-white mb-2">Fecha</label>
                            <input class="form-control text-black" type="text"
                                value="{{ $operacion->fecha->format('d/m/Y') }}" readonly
                                style="border-radius: 0.5rem; background-color: #e9ecef;" />
                        </div>
                    </div>

                    <!-- Hora -->
                    <div class="col-12 col-md-6">
                        <div style="display: flex; flex-direction: column;">
                            <label class="form-label text-white mb-2">Hora</label>
                            <input class="form-control text-black" type="text"
                                value="{{ $operacion->hora->format('H:i') }}" readonly
                                style="border-radius: 0.5rem; background-color: #e9ecef;" />
                        </div>
                    </div>

                    <!-- Fecha de Registro -->
                    <div class="col-12 col-md-6">
                        <div style="display: flex; flex-direction: column;">
                            <label class="form-label text-white mb-2">Registrado el</label>
                            <input class="form-control text-black" type="text"
                                value="{{ $operacion->created_at->format('d/m/Y H:i') }}" readonly
                                style="border-radius: 0.5rem; background-color: #e9ecef;" />
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mt-4">
                    <a href="{{ route('operaciones.index') }}" class="btn btn-secondary btn-lg w-100 w-md-auto">
                        <i class="bi bi-arrow-left me-2"></i>
                        <span>Volver</span>
                    </a>

                    <a href="{{ route('operaciones.edit', $operacion->id) }}"
                        class="btn btn-warning btn-lg w-100 w-md-auto">
                        <i class="bi bi-pencil me-2"></i>
                        <span>Editar Operación</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
