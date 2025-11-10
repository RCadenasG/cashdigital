<div class="content-area d-flex flex-column min-vh-100" style="background-color: #0c78ec; border: 2px solid #fff;">
    <div class="container-fluid p-4 flex-grow-1 d-flex flex-column" style="border: 2px solid #fff;">

        <!-- Cabecera -->
        <div class="card mb-4 bg-primary bg-gradient text-white rounded-4 shadow"
            style="border: 2px solid #fff; background-color: #22d968;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">
                        <i class="bi bi-cash-coin me-2"></i>
                        Gestión de Operaciones
                    </h1>
                </div>
            </div>
        </div>

        <x-alert />

        <!-- Barra de acciones -->
        <div class="mb-3 w-100 shadow-sm" style="background-color: #0d6efd; border: 2px solid #fff;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin: 0.75rem;">
                <a href="{{ route('operaciones.create') }}" class="btn fw-semibold shadow-sm"
                    style="background-color: #078437; color: white; border-radius: 1rem; padding: 0.5rem;">
                    <i class="bi bi-plus-circle"></i> Nueva Operación
                </a>
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="form-control rounded-pill border-0 shadow-sm"
                    placeholder="🔍 Buscar por cliente o usuario..." style="min-width: 250px; color: #0a0707;">
            </div>
        </div>

        <!-- Botones de exportación -->
        <div class="mb-3 p-3 shadow-sm w-100 d-flex justify-content-end align-items-center"
            style="background-color: #0d6efd; border: 2px solid #fff;">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('export.operaciones.excel') }}" class="btn btn-sm"
                    style="background-color: #28a745; color: white; border-radius: 1rem; padding: 0.5rem; margin-right: 0.5rem;">
                    <i class="bi bi-file-earmark-excel me-1"></i> Excel
                </a>
                <a href="{{ route('export.operaciones.pdf') }}" class="btn btn-sm"
                    style="background-color: #dc3545; color: white; border-radius: 1rem; padding: 0.5rem;">
                    <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                </a>
            </div>
        </div>

        <!-- Tabla -->
        <div class="card border-0 shadow flex-grow-1 d-flex flex-column"
            style="background-color: #0d6efd; border: 2px solid #fff;">
            <div class="card-body p-0 d-flex flex-column flex-grow-1">
                <div class="table-responsive flex-grow-1" style="border: 2px solid #fff;">
                    <table class="table table-hover align-middle mb-0 w-100" style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr style="background-color: #0d6efd; color: #fff;">
                                <th class="ps-3 py-3 text-start" style="width: 5%; cursor: pointer;"
                                    wire:click="sortBy('id')">
                                    # @if ($sortField === 'id')
                                        <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th class="py-3 text-start" style="width: 25%;">Cliente</th>
                                <th class="py-3 text-start" style="width: 12%;">Usuario</th>
                                <th class="py-3 text-start" style="width: 12%;">Tipo Pago</th>
                                <th class="py-3 text-start" style="width: 10%;">Servicio</th>
                                <th class="py-3 text-start" style="width: 10%;">Monto</th>
                                <th class="py-3 text-start" style="width: 8%;">Comisión</th>
                                <th class="py-3 text-start" style="width: 8%;">Fecha</th>
                                <th class="text-center py-3" style="width: 10%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($operaciones as $operacion)
                                <tr style="color: #FFEB3B;">
                                    <td class="ps-3" style="color: #FFEB3B;">{{ $operacion->id }}</td>
                                    <td class="fw-semibold" style="color: #FFEB3B;">{{ $operacion->cliente->name }}</td>
                                    <td style="color: #FFEB3B;">{{ $operacion->usuario->name }}</td>
                                    <td style="color: #FFEB3B;">
                                        @if ($operacion->tipo_pago === 1)
                                            <span class="badge bg-info">Servicio</span>
                                        @else
                                            <span class="badge bg-success">Transferencia</span>
                                        @endif
                                    </td>
                                    <td style="color: #FFEB3B;">{{ $operacion->servicio_nombre ?? '-' }}</td>
                                    <td style="color: #FFEB3B;">S/ {{ number_format($operacion->monto_pago, 2) }}</td>
                                    <td style="color: #FFEB3B;">S/ {{ number_format($operacion->monto_comision, 2) }}
                                    </td>
                                    <td style="color: #FFEB3B;">{{ $operacion->fecha->format('d/m/Y') }}</td>
                                    <td class="text-center pe-3">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('operaciones.show', $operacion->id) }}" class="btn"
                                                style="background-color: #17a2b8; color: white;" title="Ver">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('operaciones.edit', $operacion->id) }}" class="btn"
                                                style="background-color: #ffc107; color: #212529;" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button wire:click="delete({{ $operacion->id }})"
                                                wire:confirm="¿Estás seguro de eliminar esta operación?" class="btn"
                                                style="background-color: #dc3545; color: white;" title="Eliminar">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5" style="color: #FFEB3B;">
                                        <div class="py-5">
                                            <i class="bi bi-cash-coin fs-1 d-block mb-2"></i>
                                            <h5 style="color: #FFEB3B;">No se encontraron operaciones</h5>
                                            <p style="color: #FFEB3B;">Intente con otra búsqueda o agregue una nueva
                                                operación</p>
                                            <a href="{{ route('operaciones.create') }}"
                                                class="btn btn-primary rounded-pill mt-2">
                                                <i class="bi bi-plus-circle me-1"></i> Agregar Operación
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
                {{ $operaciones->onEachSide(1)->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
</div>
