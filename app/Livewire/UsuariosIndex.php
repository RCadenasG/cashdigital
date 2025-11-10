<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
#[Title('Gestión de Usuarios')]
class UsuariosIndex extends Component
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

    public function delete($userId)
    {
        /** @var \App\Models\User|null $user */
        $user = User::find($userId);

        if (!$user) {
            session()->flash('error', 'Usuario no encontrado');
            return;
        }

        if ($user->getKey() === Auth::id()) {
            session()->flash('error', 'No puedes eliminar tu propio usuario');
            return;
        }

        $user->delete();
        session()->flash('success', 'Usuario eliminado correctamente');
    }

    public function render()
    {
        $usuarios = User::query()
            ->where(function($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhere('telefono', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.usuarios-index', [
            'usuarios' => $usuarios,
        ]);
    }
}
