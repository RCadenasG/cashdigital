<div class="container-fluid p-2 p-md-4">
    <!-- Cabecera -->
    <div class="card mb-3 mb-md-4 bg-primary bg-gradient text-white rounded-4 shadow">
        <div class="card-body p-2 p-md-3">
            <h1 class="mb-0 fw-bold" style="font-size: clamp(1.5rem, 4vw, 2.5rem);">
                <i class="bi bi-{{ $userId ? 'pencil-square' : 'person-plus' }} me-2"></i>
                {{ $userId ? 'Editar Usuario' : 'Nuevo Usuario' }}
            </h1>
        </div>
    </div>

    <!-- Formulario -->
    <div class="card bg-dark border-secondary shadow rounded-4" style="border: 2px solid #fff;">
        <div class="card-body p-2 p-md-4">
            <form wire:submit="save">
                <div class="row g-3">
                    <!-- Nombre Completo -->
                    <div class="col-12 col-md-6">
                        <label class="form-label text-white mb-2" for="name">Nombre Completo</label>
                        <input id="name" class="form-control text-black" type="text" name="name"
                            wire:model.defer="name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="col-12 col-md-6">
                        <label class="form-label text-white mb-2" for="email">Correo Electrónico</label>
                        <input id="email" class="form-control text-black" type="email" name="email"
                            wire:model.defer="email" required autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Teléfono -->
                    <div class="col-12 col-md-6">
                        <label class="form-label text-white mb-2" for="telefono">Teléfono</label>
                        <input id="telefono" class="form-control text-black" type="text" name="telefono"
                            wire:model.defer="telefono" autocomplete="tel" />
                        <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                    </div>

                    <!-- Rol -->
                    <div class="col-12 col-md-6">
                        <label class="form-label text-white mb-2" for="role_id">Rol</label>
                        <select id="role_id" name="role_id" wire:model.defer="role_id" class="form-select text-black">
                            <option value="">Seleccione un rol</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                    </div>

                    <!-- Contraseña -->
                    <div class="col-12 col-md-6">
                        <label class="form-label text-white mb-2" for="password">Contraseña</label>
                        <input id="password" class="form-control text-black" type="password" name="password"
                            wire:model.defer="password" autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        @if ($userId)
                            <small class="text-warning">Déjalo en blanco si no deseas cambiarla</small>
                        @endif
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="col-12 col-md-6">
                        <label class="form-label text-white mb-2" for="password_confirmation">Confirmar
                            Contraseña</label>
                        <input id="password_confirmation" class="form-control text-black" type="password"
                            name="password_confirmation" wire:model.defer="password_confirmation"
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mt-4">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary btn-lg w-100 w-md-auto"
                        style="background-color: #e11a4b; color: #fff;">
                        <i class="bi bi-x-circle me-2"></i>
                        <span>Cancelar</span>
                    </a>

                    <button type="submit" class="btn btn-success btn-lg w-100 w-md-auto"
                        style="background-color: #28a745; color: #fff;">
                        <i class="bi bi-save me-2"></i>
                        <span>Guardar Usuario</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
