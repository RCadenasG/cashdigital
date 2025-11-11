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

        <!-- Formulario de solo lectura -->
        <div class="card bg-dark border-secondary shadow rounded-4" style="border: 2px solid #fff;">
            <div class="card-body p-4">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; align-items: start;">

                    <!-- Cliente -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2">Cliente</label>
                        <input class="form-control text-black" type="text" value="{{ $operacion->cliente->name }}"
                            readonly style="border-radius: 0.5rem; background-color: #e9ecef;" />
                        <small class="text-white-50 mt-1">{{ $operacion->cliente->email }}</small>
                    </div>

                    <!-- Usuario -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2">Usuario que registró</label>
                        <input class="form-control text-black" type="text" value="{{ $operacion->usuario->name }}"
                            readonly style="border-radius: 0.5rem; background-color: #e9ecef;" />
                    </div>

                    <!-- Tipo de Pago -->
                    @if ($operacion->tipo_pago === 1)
                        <div style="display: flex; flex-direction: column;">
                            <label class="form-label text-white mb-2">Tipo de pago</label>
                            <input class="form-control text-black" type="text" value="Pago de servicios" readonly
                                style="border-radius: 0.5rem; background-color: #e9ecef;" />
                        </div>
                    @else
                        <div style="display: flex; flex-direction: column;">
                            <label class="form-label text-white mb-2">Tipo de Pago</label>
                            <input class="form-control text-black" type="text" value="Transferencia" readonly
                                style="border-radius: 0.5rem; background-color: #e9ecef;" />
                        </div>
                    @endif

                    <!-- Servicio (visible solo si tipo_pago = 1) -->
                    @if ($operacion->tipo_pago === 1)
                        <div style="display: flex; flex-direction: column;">
                            <label class="form-label text-white mb-2">Servicio</label>
                            <input class="form-control text-black" type="text"
                                value="{{ $operacion->servicio_nombre }}" readonly
                                style="border-radius: 0.5rem; background-color: #e9ecef;" />
                        </div>
                    @endif

                    <!-- Monto a Pagar -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2">Monto a Pagar (S/)</label>
                        <input class="form-control text-black" type="text"
                            value="S/ {{ number_format($operacion->monto_pago, 2) }}" readonly
                            style="border-radius: 0.5rem; background-color: #e3ca0a;" />
                    </div>

                    <!-- Comisión -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2">Comisión (S/)</label>
                        <input class="form-control text-black fw-bold" type="text"
                            value="S/ {{ number_format($operacion->monto_comision, 2) }}" readonly
                            style="border-radius: 0.5rem; background-color: #e3ca0a;" />
                    </div>

                    <!-- Total -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2">Monto Total (S/)</label>
                        <input class="form-control text-black fw-bold" type="text"
                            value="S/ {{ number_format($operacion->monto_total, 2) }}" readonly
                            style="border-radius: 0.5rem; background-color: #e3ca0a;" />
                    </div>

                    <!-- Fecha -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2">Fecha</label>
                        <input class="form-control text-black" type="text"
                            value="{{ $operacion->fecha->format('d/m/Y') }}" readonly
                            style="border-radius: 0.5rem; background-color: #e9ecef;" />
                    </div>

                    <!-- Hora -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2">Hora</label>
                        <input class="form-control text-black" type="text"
                            value="{{ $operacion->hora->format('H:i') }}" readonly
                            style="border-radius: 0.5rem; background-color: #e9ecef;" />
                    </div>

                    <!-- Fecha de Registro -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2">Registrado el</label>
                        <input class="form-control text-black" type="text"
                            value="{{ $operacion->created_at->format('d/m/Y H:i') }}" readonly
                            style="border-radius: 0.5rem; background-color: #e9ecef;" />
                    </div>
                </div>

                <!-- Botones -->
                <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                    <a href="{{ route('operaciones.index') }}" class="btn btn-secondary btn-lg"
                        style="background-color: #6c757d; color: #fff; min-width: 220px; padding: 0.75rem 2rem; border-radius: 1rem; text-decoration: none; text-align: center;">
                        <i class="bi bi-arrow-left me-2"></i>
                        <span>Volver</span>
                    </a>

                    <a href="{{ route('operaciones.edit', $operacion->id) }}" class="btn btn-warning btn-lg"
                        style="background-color: #ffc107; color: #212529; min-width: 220px; padding: 0.75rem 2rem; border-radius: 1rem; text-decoration: none; text-align: center;">
                        <i class="bi bi-pencil me-2"></i>
                        <span>Editar Operación</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
