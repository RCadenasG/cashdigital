<div class="container-fluid p-4">
    <!-- Cabecera -->
    <div class="card mb-4 bg-primary bg-gradient text-white rounded-4 shadow">
        <div class="card-body p-3">
            <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">
                <i class="bi bi-{{ $id ? 'pencil-square' : 'person-plus' }} me-2"></i>
                {{ $id ? 'Editar Cliente' : 'Nuevo Cliente' }}
            </h1>
        </div>
    </div>

    <!-- Formulario a todo ancho -->
    <div class="card bg-dark border-secondary shadow rounded-4" style="border: 2px solid #fff;">
        <div class="card-body p-4">
            <form wire:submit="save">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; align-items: start;">
                    <!-- Nombre Completo -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2" for="name">Nombre Completo</label>
                        <input id="name" class="form-control text-black" type="text" name="name"
                            wire:model.defer="name" required autofocus autocomplete="name"
                            style="border-radius: 0.5rem;" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Correo Electrónico -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2" for="email">Correo Electrónico</label>
                        <input id="email" class="form-control text-black" type="email" name="email"
                            wire:model.defer="email" required autocomplete="email" style="border-radius: 0.5rem;" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Teléfono -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2" for="telefono">Teléfono (9 dígitos)</label>
                        <input id="telefono" class="form-control text-black" type="text" name="telefono"
                            wire:model.defer="telefono" maxlength="9" autocomplete="tel"
                            style="border-radius: 0.5rem;" />
                        <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                    </div>

                    <!-- Dirección -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2" for="direccion">Dirección</label>
                        <input id="direccion" class="form-control text-black" type="text" name="direccion"
                            wire:model.defer="direccion" maxlength="50" style="border-radius: 0.5rem;" />
                        <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                    </div>

                    @if ($id)
                        <!-- Estado -->
                        <div style="display: flex; flex-direction: column;">
                            <label class="form-label text-white mb-2" for="estado">Estado</label>
                            <select id="estado" name="estado" wire:model.defer="estado"
                                class="form-select text-black" style="border-radius: 0.5rem;">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                            <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                        </div>
                    @endif
                </div>

                <!-- Botones -->
                <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary btn-lg"
                        style="background-color: #e11a4b; color: #fff; min-width: 220px; padding: 0.75rem 2rem; border-radius: 1rem; text-decoration: none; text-align: center;">
                        <i class="bi bi-x-circle me-2"></i>
                        <span>Cancelar</span>
                    </a>

                    <button type="submit" class="btn btn-success btn-lg"
                        style="background-color: #28a745; color: #fff; min-width: 220px; padding: 0.75rem 2rem; border-radius: 1rem;">
                        <i class="bi bi-save me-2"></i>
                        <span>Guardar Cliente</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
