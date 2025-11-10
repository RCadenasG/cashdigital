<div class="content-area" style="background-color: #0c78ec;">
    <div class="container-fluid p-4">
        <!-- Cabecera -->
        <div class="card mb-4 bg-primary bg-gradient text-white rounded-4 shadow">
            <div class="card-body p-3">
                <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">
                    <i class="bi bi-{{ $parametroId ? 'pencil-square' : 'plus-lg' }} me-2"></i>
                    {{ $parametroId ? 'Editar Parámetro' : 'Nuevo Parámetro' }}
                </h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-center">
                <div class="card bg-dark border-secondary shadow rounded-4"
                    style="border: 2px solid #fff; width: 50%; margin-left: 25%; margin-right: 25%;">
                    <div class="card-body p-4">
                        <form wire:submit="save">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div>
                                        <x-input-label class="text-white mb-2" for="tabla" :value="__('Tabla')" />
                                        <x-text-input id="tabla" class="block w-full text-black" type="text"
                                            name="tabla" wire:model.defer="tabla" required maxlength="20" />
                                        <x-input-error :messages="$errors->get('tabla')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div>
                                        <x-input-label class="text-white mb-2" for="secuencia" :value="__('Secuencia')" />
                                        <x-text-input id="secuencia" class="block w-full text-black" type="number"
                                            name="secuencia" wire:model.defer="secuencia" />
                                        <x-input-error :messages="$errors->get('secuencia')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div>
                                        <x-input-label class="text-white mb-2" for="descripcion_corta"
                                            :value="__('Descripción Corta')" />
                                        <x-text-input id="descripcion_corta" class="block w-full text-black"
                                            type="text" name="descripcion_corta" wire:model.defer="descripcion_corta"
                                            maxlength="10" />
                                        <x-input-error :messages="$errors->get('descripcion_corta')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div>
                                        <x-input-label class="text-white mb-2" for="descripcion_larga"
                                            :value="__('Descripción Larga')" />
                                        <x-text-input id="descripcion_larga" class="block w-full text-black"
                                            type="text" name="descripcion_larga" wire:model.defer="descripcion_larga"
                                            maxlength="50" />
                                        <x-input-error :messages="$errors->get('descripcion_larga')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <div style="display: flex; justify-content: space-between; margin: 0.75rem;">
                                <a href="{{ route('parametros.index') }}" class="btn btn-secondary btn-lg"
                                    style="background-color: #e11a4b; color: #fff; min-width: 220px; padding: 0.75rem 2rem; border-radius: 1rem; text-align: center;">
                                    <i class="bi bi-x-circle me-2"></i>
                                    <span>Cancelar</span>
                                </a>

                                <button type="submit" class="btn btn-success btn-lg"
                                    style="background-color: #28a745; color: #fff; min-width: 220px; padding: 0.75rem 2rem; border-radius: 1rem; align-items: center;">
                                    <i class="bi bi-save me-2"></i>
                                    <span>Guardar Parámetro</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
