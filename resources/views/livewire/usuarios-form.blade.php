<div class="container-fluid p-4">
    <!-- Cabecera -->
    <div class="card mb-4 bg-primary bg-gradient text-white rounded-4 shadow">
        <div class="card-body p-3">
            <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">
                <i class="bi bi-{{ $userId ? 'pencil-square' : 'person-plus' }} me-2"></i>
                {{ $userId ? 'Editar Usuario' : 'Nuevo Usuario' }}
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
                        <label class="form-label text-white mb-2" for="telefono">Teléfono</label>
                        <input id="telefono" class="form-control text-black" type="text" name="telefono"
                            wire:model.defer="telefono" autocomplete="tel" style="border-radius: 0.5rem;" />
                        <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                    </div>

                    <!-- Rol -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2" for="role_id">Rol</label>
                        <select id="role_id" name="role_id" wire:model.defer="role_id" class="form-select text-black"
                            style="border-radius: 0.5rem;">
                            <option value="">Seleccione un rol</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                    </div>

                    <!-- Contraseña -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2" for="password">Contraseña</label>
                        <input id="password" class="form-control text-black" type="password" name="password"
                            wire:model.defer="password" autocomplete="new-password" style="border-radius: 0.5rem;" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        @if ($userId)
                            <div class="form-text" style="color: yellow; font-weight: bold;">
                                Déjalo en blanco si no deseas cambiarla
                            </div>
                        @endif
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div style="display: flex; flex-direction: column;">
                        <label class="form-label text-white mb-2" for="password_confirmation">Confirmar
                            Contraseña</label>
                        <input id="password_confirmation" class="form-control text-black" type="password"
                            name="password_confirmation" wire:model.defer="password_confirmation"
                            autocomplete="new-password" style="border-radius: 0.5rem;" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <!-- Botones -->
                <div style="display: flex; justify-content: space-between; margin: 0.75rem;">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary btn-lg"
                        style="background-color: #e11a4b; color: #fff; min-width: 220px; padding: 0.75rem 2rem; border-radius: 1rem; text-align: center;">
                        <i class="bi bi-x-circle me-2"></i>
                        <span>Cancelar</span>
                    </a>

                    <button type="submit" class="btn btn-success btn-lg"
                        style="background-color: #28a745; color: #fff; min-width: 220px; padding: 0.75rem 2rem; border-radius: 1rem; align-items: center;">
                        <i class="bi bi-save me-2"></i>
                        <span>Guardar Usuario</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
