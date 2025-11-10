<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Role;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Gestión de Roles')]
class RolesIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;
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

    public function delete($roleId)
    {
        /** @var \App\Models\Role|null $role */
        $role = Role::find($roleId);

        if (!$role) {
            session()->flash('error', 'Rol no encontrado');
            return;
        }

        $role->delete();
        session()->flash('success', 'Rol eliminado correctamente');
    }

    public function render()
    {
        $roles = Role::query()
            ->where(function($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('guard_name', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.roles-index', [
            'roles' => $roles
        ]);
    }
}
