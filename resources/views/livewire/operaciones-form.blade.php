<div class="container-fluid p-4">
    <!-- Cabecera -->
    <div class="card mb-4 bg-primary bg-gradient text-white rounded-4 shadow">
        <div class="card-body p-3">
            <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">
                <i class="bi bi-{{ $id ? 'pencil-square' : 'cash-coin' }} me-2"></i>
                {{ $id ? 'Editar Operación' : 'Nueva Operación' }}
            </h1>
        </div>
    </div>

    <!-- Formulario -->
    <div class="card bg-dark border-secondary shadow rounded-4" style="border: 2px solid #fff;">
        <div class="card-body p-4">
            <form wire:submit="save">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; align-items: start;">

                    <!-- Cliente -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2" for="cliente_id">Cliente *</label>
                        <select id="cliente_id" wire:model.live="cliente_id" class="form-select text-black"
                            style="border-radius: 0.5rem;">
                            <option value="">Seleccione un cliente</option>
                            @foreach ($this->clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('cliente_id')" class="mt-2" />
                    </div>

                    <!-- Usuario -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2" for="user_id">Usuario *</label>
                        <select id="user_id" wire:model.defer="user_id" class="form-select text-black"
                            style="border-radius: 0.5rem;">
                            @foreach ($this->usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                    </div>

                    <!-- Tipo de Pago -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2">Tipo de Pago *</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_pago" id="tipo_servicio"
                                    value="1" wire:model.live="tipo_pago">
                                <label class="form-check-label text-white" for="tipo_servicio">
                                    Pago de Servicio
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_pago" id="tipo_transfer"
                                    value="2" wire:model.live="tipo_pago">
                                <label class="form-check-label text-white" for="tipo_transfer">
                                    Transferencia
                                </label>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('tipo_pago')" class="mt-2" />
                    </div>

                    <!-- Servicio (visible solo si tipo_pago = 1) -->
                    @if ($tipo_pago == 1)
                        <div style="display: flex; flex-direction: column;">
                            <label class="form-label text-white mb-2" for="servicio">Servicio *</label>
                            <select id="servicio" wire:model.defer="servicio" class="form-select text-black"
                                style="border-radius: 0.5rem;">
                                <option value="">Seleccione un servicio</option>
                                @foreach ($this->servicios as $srv)
                                    <option value="{{ $srv->id }}">{{ $srv->descripcion_corta }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('servicio')" class="mt-2" />
                        </div>
                    @endif

                    <!-- Monto a Pagar -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2" for="monto_pago">Monto a Pagar (S/) *</label>
                        <input id="monto_pago" class="form-control text-black" type="number" step="0.01"
                            wire:model.live.debounce.500ms="monto_pago" style="border-radius: 0.5rem;" />
                        <x-input-error :messages="$errors->get('monto_pago')" class="mt-2" />
                    </div>

                    <!-- Comisión (calculada) -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2">Comisión (S/)</label>
                        <input class="form-control text-black" type="text"
                            value="S/ {{ number_format($monto_comision, 2) }}"
                            style="border-radius: 0.5rem; background-color: #e9ecef;" />
                        <small class="text-warning mt-1">Calculada automáticamente</small>
                    </div>

                    <!-- Fecha -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2" for="fecha">Fecha *</label>
                        <input id="fecha" class="form-control text-black" type="date" wire:model.defer="fecha"
                            style="border-radius: 0.5rem;" />
                        <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                    </div>

                    <!-- Hora -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2" for="hora">Hora *</label>
                        <input id="hora" class="form-control text-black" type="time" wire:model.defer="hora"
                            style="border-radius: 0.5rem;" />
                        <x-input-error :messages="$errors->get('hora')" class="mt-2" />
                    </div>
                </div>

                <!-- Botones -->
                <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                    <a href="{{ route('operaciones.index') }}" class="btn btn-secondary btn-lg"
                        style="background-color: #e11a4b; color: #fff; min-width: 220px; padding: 0.75rem 2rem; border-radius: 1rem; text-decoration: none; text-align: center;">
                        <i class="bi bi-x-circle me-2"></i>
                        <span>Cancelar</span>
                    </a>

                    <button type="submit" class="btn btn-success btn-lg"
                        style="background-color: #28a745; color: #fff; min-width: 220px; padding: 0.75rem 2rem; border-radius: 1rem;">
                        <i class="bi bi-save me-2"></i>
                        <span>Guardar Operación</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
