<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Gestión de Clientes')]
class ClientesIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 8;
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

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

    public function delete($clienteId)
    {
        $cliente = Cliente::find($clienteId);

        if (!$cliente) {
            session()->flash('error', 'Cliente no encontrado');
            return;
        }

        // Eliminación lógica
        $cliente->update(['estado' => 0]);
        session()->flash('success', 'Cliente desactivado correctamente');
    }

    public function render()
    {
        $clientes = Cliente::query()
            ->where(function($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhere('telefono', 'like', "%{$this->search}%")
                      ->orWhere('direccion', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.clientes-index', [
            'clientes' => $clientes,
        ]);
    }
}
