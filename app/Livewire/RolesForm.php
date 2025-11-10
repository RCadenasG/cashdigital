<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Role;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class RolesForm extends Component
{
    public ?int $roleId = null;
    public string $name = '';
    public string $guard_name = '';

    public function mount($id = null)
    {
        if ($id) {
            $role = Role::findOrFail($id);
            $this->roleId = $role->id;
            $this->name = $role->name;
            $this->guard_name = $role->guard_name;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
        ]);

        if ($this->roleId) {
            $role = Role::findOrFail($this->roleId);
            $role->update([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
            ]);
            session()->flash('success', 'Rol actualizado correctamente');
        } else {
            Role::create([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
            ]);
            session()->flash('success', 'Rol creado correctamente');
        }

        return redirect()->route('roles.index');
    }

    public function render()
    {
        return view('livewire.roles-form');
    }
}
