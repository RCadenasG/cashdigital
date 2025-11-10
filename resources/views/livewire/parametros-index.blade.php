<div class="content-area d-flex flex-column min-vh-100" style="background-color: #0c78ec; border: 2px solid #fff;">
    <div class="container-fluid p-4 flex-grow-1 d-flex flex-column" style="border: 2px solid #fff;">
        <!-- Cabecera -->
        <div class="card mb-4 bg-primary bg-gradient text-white shadow"
            style="border: 2px solid #fff; background-color: #22d968;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">
                            <i class="bi bi-sliders me-2"></i> Parámetros del Sistema
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <x-alert />

        <!-- Contenedor: Nuevo Parámetro y Buscar -->
        <div class="mb-3 w-100 mt-auto py-1 w-100 shadow-sm" style="background-color: #0d6efd; border: 2px solid #fff;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin: 0.75rem;">
                <a href="{{ route('parametros.create') }}" class="btn fw-semibold shadow-sm"
                    style="background-color: #078437; color: white; border-radius: 1rem; padding: 0.5rem">
                    <i class="bi bi-plus-lg"></i> Nuevo Parámetro
                </a>
                <input style="color: #0a0707;" wire:model.live.debounce.300ms="search" type="text"
                    class="float-right form-control rounded-pill border-0 shadow-sm"
                    placeholder="🔍 Buscar parámetros..." style="min-width: 300px;">
            </div>
        </div>
        <!-- Tabla de parámetros -->
        <div class="card border-0 shadow flex-grow-1 d-flex flex-column"
            style="background-color: #0d6efd; border: 2px solid #fff;">
            <div class="card-body p-0 d-flex flex-column flex-grow-1">
                <div class="table-responsive flex-grow-1" style="border: 2px solid #fff;">
                    <table class="table table-hover align-middle mb-0 w-100" style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr style="background-color: #0d6efd; color: #fff;">
                                <th class="ps-3 py-3 text-start" style="width: 5%;">#</th>
                                <th class="py-3 text-start" style="width: 12%;">Tabla</th>
                                <th class="py-3 text-start" style="width: 15%;">Secuencia</th>
                                <th class="py-3 text-start" style="width: 20%;">Desc. Corta</th>
                                <th class="py-3 text-start" style="width: 33%;">Desc. Larga</th>
                                <th class="text-center py-3" style="width: 15%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($parametros as $parametro)
                                <tr style="color: #FFEB3B;">
                                    <td class="ps-3 text-muted" style="color: #FFEB3B;">{{ $parametro->getKey() }}</td>
                                    <td style="color: #FFEB3B;">{{ $parametro->tabla }}</td>
                                    <td style="color: #FFEB3B;">{{ $parametro->secuencia }}</td>
                                    <td style="color: #FFEB3B;">{{ $parametro->descripcion_corta }}</td>
                                    <td style="color: #FFEB3B;">{{ $parametro->descripcion_larga }}</td>
                                    <td class="text-center pe-3" style="color: #FFEB3B;">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('parametros.edit', $parametro->getKey()) }}"
                                                class="btn rounded-start-3"
                                                style="background-color: #ffc107; color: #212529; border-color: #ffc107; margin-right: 0.5rem;"
                                                title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button wire:click="delete({{ $parametro->getKey() }})"
                                                wire:confirm="¿Estás seguro de eliminar este parámetro?"
                                                class="btn rounded-end-3"
                                                style="background-color: #dc3545; color: white; border-color: #dc3545;"
                                                title="Eliminar">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5" style="color: #FFEB3B;">
                                        <div class="py-5">
                                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                            <h5 class="text-secondary" style="color: #FFEB3B;">No se encontraron
                                                parámetros</h5>
                                            <p class="text-muted" style="color: #FFEB3B;">Intente con otra búsqueda o
                                                agregue un nuevo parámetro
                                            </p>
                                            <a href="{{ route('parametros.create') }}"
                                                class="btn btn-primary rounded-pill mt-2">
                                                <i class="bi bi-plus-lg me-1"></i> Agregar Parámetro
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Paginación -->
        <div class="mt-3">
            <div class="d-flex justify-content-center">
                {{ $parametros->onEachSide(1)->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
</div>
