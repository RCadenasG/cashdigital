<div class="content-area d-flex flex-column min-vh-100" style="background-color: #0c78ec; border: 2px solid #fff;">
    <div class="container-fluid p-4 flex-grow-1 d-flex flex-column" style="border: 2px solid #fff;">

        <!-- Cabecera -->
        <div class="card mb-4 bg-primary bg-gradient text-white shadow"
            style="border: 2px solid #fff; background-color: #22d968;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">
                            <i class="bi bi-people me-2"></i> Gestión de Usuarios
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <x-alert />

        <!-- Contenedor: Nuevo Usuario a la izquierda y Buscar Usuario a la derecha en la misma línea -->
        <div class="mb-3 w-100 mt-auto py-1 w-100 shadow-sm" style="background-color: #0d6efd; border: 2px solid #fff;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin: 0.75rem;">
                <!-- Botón Nuevo Usuario a la izquierda -->
                <a href="{{ route('usuarios.create') }}" class="btn fw-semibold shadow-sm"
                    style="background-color: #078437; color: white; border-color: #0d6efd; border-radius: 1rem; padding: 0.5rem;">
                    <i class="bi bi-person-plus"></i> Nuevo Usuario
                </a>
                <!-- Buscar usuario a la derecha -->
                <input style="color: #0a0707;" wire:model.live.debounce.300ms="search" type="text"
                    class="form-control rounded-pill border-0 shadow-sm" placeholder="🔍 Buscar usuarios..."
                    style="min-width: 250px;">
            </div>
        </div>
        <!-- Contenedor: Botones Excel y PDF -->
        <div class="mb-3 p-3 shadow-sm w-100 d-flex justify-content-end align-items-center"
            style="background-color: #0d6efd; border: 2px solid #fff;">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('export.usuarios.excel') }}" class="btn btn-sm"
                    style="background-color: #28a745; color: white; border-color: #28a745; border-radius: 1rem; padding: 0.5rem; margin-right: 0.5rem;">
                    <i class="bi bi-file-earmark-excel me-1"></i> Excel
                </a>
                <a href="{{ route('export.usuarios.pdf') }}" class="btn btn-sm"
                    style="background-color: #dc3545; color: white; border-color: #dc3545; border-radius: 1rem; padding: 0.5rem;">
                    <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                </a>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="card border-0 shadow flex-grow-1 d-flex flex-column"
            style="background-color: #0d6efd; border: 2px solid #fff;">
            <div class="card-body p-0 d-flex flex-column flex-grow-1">
                <div class="table-responsive flex-grow-1" style="border: 2px solid #fff;">
                    <table class="table table-hover align-middle mb-0 w-100" style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr style="background-color: #0d6efd; color: #fff;">
                                <th class="ps-3 py-3 text-start" style="width: 5%;">#</th>
                                <th class="py-3 text-start" style="width: 25%;">Nombre</th>
                                <th class="py-3 text-start" style="width: 30%;">Email</th>
                                <th class="py-3 text-start" style="width: 20%;">Teléfono</th>
                                <th class="py-3 text-start" style="width: 10%;">Rol</th>
                                <th class="text-center py-3" style="width: 12%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($usuarios as $usuario)
                                <tr style="color: #FFEB3B;">
                                    <td class="ps-3 text-muted" style="color: #FFEB3B;">{{ $usuario->getKey() }}</td>
                                    <td class="fw-semibold" style="color: #FFEB3B;">{{ $usuario->name }}
                                        @if ($usuario->getKey() === auth()->id())
                                            <span class="badge bg-warning text-dark rounded-pill ms-2">Tú</span>
                                        @endif
                                    </td>
                                    <td style="color: #FFEB3B;">{{ $usuario->email }}</td>
                                    <td style="color: #FFEB3B;">{{ $usuario->telefono ?? '-' }}</td>
                                    <td style="color: #FFEB3B;">
                                        {{ $usuario->roles->pluck('name')->join(', ') }}
                                    </td>
                                    <td class="text-center pe-3" style="color: #FFEB3B;">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('usuarios.edit', $usuario->getKey()) }}"
                                                class="btn rounded-start-3"
                                                style="background-color: #ffc107; color: #212529; border-color: #ffc107; margin-right: 0.5rem;"
                                                title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            @if ($usuario->getKey() !== auth()->id())
                                                <button wire:click="delete({{ $usuario->getKey() }})"
                                                    wire:confirm="¿Estás seguro de eliminar este usuario?"
                                                    class="btn rounded-end-3"
                                                    style="background-color: #dc3545; color: white; border-color: #dc3545;"
                                                    title="Eliminar">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-secondary rounded-end-3" disabled>
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5" style="color: #FFEB3B;">
                                        <div class="py-5">
                                            <i class="bi bi-people fs-1 d-block mb-2 text-secondary"></i>
                                            <h5 class="text-secondary" style="color: #FFEB3B;">No se encontraron
                                                usuarios
                                            </h5>
                                            <p class="text-muted" style="color: #FFEB3B;">Intente con otra búsqueda
                                                o
                                                agregue un nuevo usuario
                                            </p>
                                            <a href="{{ route('usuarios.create') }}"
                                                class="btn btn-primary rounded-pill mt-2">
                                                <i class="bi bi-person-plus me-1"></i> Agregar Usuario
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
                {{ $usuarios->onEachSide(1)->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
</div>
