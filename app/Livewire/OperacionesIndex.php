<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Operacion;
use App\Models\Cliente;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Gestión de Operaciones')]
class OperacionesIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 8;
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public $fechaInicio = '';
    public $fechaFin = '';
    public $tipoPagoFiltro = '';
    public $clienteFiltro = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function limpiarFiltros()
    {
        $this->search = '';
        $this->fechaInicio = '';
        $this->fechaFin = '';
        $this->tipoPagoFiltro = '';
        $this->clienteFiltro = '';
        $this->resetPage();
    }

    public function delete($operacionId)
    {
        $operacion = Operacion::find($operacionId);

        if (!$operacion) {
            session()->flash('error', 'Operación no encontrada');
            return;
        }

        $operacion->delete();
        session()->flash('success', 'Operación eliminada correctamente');
    }

    public function render()
    {
        $operaciones = Operacion::query()
            ->with(['cliente', 'usuario', 'parametroServicio'])
            ->when($this->search, function($query) {
                $query->whereHas('cliente', function($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                })->orWhereHas('usuario', function($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
            })
            ->filtrarPorFecha($this->fechaInicio, $this->fechaFin)
            ->filtrarPorTipo($this->tipoPagoFiltro)
            ->filtrarPorCliente($this->clienteFiltro)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $clientes = Cliente::where('estado', 1)->orderBy('name')->get();

        return view('livewire.operaciones-index', [
            'operaciones' => $operaciones,
            'clientes' => $clientes,
        ]);
    }
}
