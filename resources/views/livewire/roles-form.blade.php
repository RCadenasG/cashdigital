<div class="content-area" style="background-color: #0c78ec;">
    <div class="container-fluid p-4">
        <!-- Cabecera -->
        <div class="card mb-4 bg-primary bg-gradient text-white rounded-4 shadow">
            <div class="card-body p-3">
                <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">
                    <i class="bi bi-{{ $roleId ? 'pencil-square' : 'plus-lg' }} me-2"></i>
                    {{ $roleId ? 'Editar Rol' : 'Nuevo Rol' }}
                </h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-center">
                <div class="card bg-dark border-secondary shadow rounded-4"
                    style="border: 2px solid #fff; width: 50%; margin-left: 25%; margin-right: 25%;">
                    <div class="card-body p-4">
                        <form wire:submit="save">
                            <div class="mb-4" style="border: 1px solid #fff; border-radius: 1rem; padding: 1.5rem;">
                                <x-input-label class="text-white mb-2" for="name" :value="__('Nombre')" />
                                <x-text-input id="name" class="block w-full text-black" type="text"
                                    name="name" wire:model.defer="name" required autofocus autocomplete="off" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="mb-4" style="border: 1px solid #fff; border-radius: 1rem; padding: 1.5rem;">
                                <x-input-label class="text-white mb-2" for="guard_name" :value="__('Guard Name')" />
                                <x-text-input id="guard_name" class="block w-full text-black" type="text"
                                    name="guard_name" wire:model.defer="guard_name" required autocomplete="off" />
                                <x-input-error :messages="$errors->get('guard_name')" class="mt-2" />
                            </div>
                            <div style="display: flex; justify-content: space-between; margin: 0.75rem;">
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-lg"
                                    style="background-color: #e11a4b; color: #fff; min-width: 220px; padding: 0.75rem 2rem; border-radius: 1rem; text-align: center;">
                                    <i class="bi bi-x-circle me-2"></i>
                                    <span>Cancelar</span>
                                </a>

                                <button type="submit" class="btn btn-success btn-lg"
                                    style="background-color: #28a745; color: #fff; min-width: 220px; padding: 0.75rem 2rem; border-radius: 1rem; align-items: center;">
                                    <i class="bi bi-save me-2"></i>
                                    <span>Guardar Rol</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
