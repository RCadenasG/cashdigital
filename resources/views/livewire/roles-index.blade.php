<div class="content-area d-flex flex-column min-vh-100" style="background-color: #0c78ec; border: 2px solid #fff;">
    <div class="container-fluid p-4 flex-grow-1 d-flex flex-column" style="border: 2px solid #fff;">
        <div class="card mb-4 bg-primary bg-gradient text-white shadow"
            style="border: 2px solid #fff; background-color: #22d968;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">
                            <i class="bi bi-shield-lock me-2"></i> Gestión de Roles
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <x-alert />

        <div class="mb-3 w-100 mt-auto py-1 w-100 shadow-sm" style="background-color: #0d6efd; border: 2px solid #fff;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin: 0.75rem;">
                <a href="{{ route('roles.create') }}" class="btn fw-semibold shadow-sm"
                    style="background-color: #078437; color: white; border-radius: 1rem; padding: 0.5rem 2rem;">
                    <i class="bi bi-plus-lg"></i> Nuevo Rol
                </a>
                <input style="color: #0a0707;" wire:model.live.debounce.300ms="search" type="text"
                    class="form-control rounded-pill border-0 shadow-sm" placeholder="🔍 Buscar roles..."
                    style="width: 250px;">
            </div>
        </div>

        <div class="card border-0 shadow flex-grow-1 d-flex flex-column"
            style="background-color: #0d6efd; border: 2px solid #fff;">
            <div class="card-body p-0 d-flex flex-column flex-grow-1">
                <div class="table-responsive flex-grow-1" style="border: 2px solid #fff;">
                    <table class="table table-hover align-middle mb-0 w-100" style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr style="background-color: #0d6efd; color: #fff;">
                                <th class="ps-3 py-3 text-start" style="width: 5%;">#</th>
                                <th class="py-3 text-start" style="width: 35%;">Nombre</th>
                                <th class="py-3 text-start" style="width: 35%;">Guard Name</th>
                                <th class="text-center py-3" style="width: 20%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr style="color: #FFEB3B;">
                                    <td class="ps-3" style="color: #FFEB3B;">{{ $role->id }}</td>
                                    <td style="color: #FFEB3B;">{{ $role->name }}</td>
                                    <td style="color: #FFEB3B;">{{ $role->guard_name }}</td>
                                    <td class="text-center pe-3" style="color: #FFEB3B;">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('roles.edit', $role) }}" class="btn rounded-start-3"
                                                style="background-color: #ffc107; color: #212529; border-color: #ffc107; margin-right: 0.5rem;"
                                                title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button wire:click="delete({{ $role->id }})"
                                                wire:confirm="¿Estás seguro de eliminar este rol?"
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
                                    <td colspan="4" class="text-center py-5" style="color: #FFEB3B;">
                                        <div class="py-5">
                                            <i class="bi bi-shield-lock fs-1 d-block mb-2 text-secondary"></i>
                                            <h5 class="text-secondary" style="color: #FFEB3B;">No se encontraron roles
                                            </h5>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <div class="d-flex justify-content-center">
                {{ $roles->onEachSide(1)->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
</div>
