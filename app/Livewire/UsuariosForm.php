<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Formulario de Usuarios')]
class UsuariosForm extends Component
{
    public ?int $userId = null;
    public string $name = '';
    public string $email = '';
    public ?string $telefono = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;
    public ?int $role_id = null;
    public $roles = [];

    public function mount($id = null)
    {
        $this->roles = Role::all();
        if ($id) {
            $user = User::findOrFail($id);
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->telefono = $user->telefono;
            $this->role_id = $user->roles()->first()?->id;
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->userId)
            ],
            'telefono' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'password' => $this->userId
                ? 'nullable|string|min:8|confirmed'
                : 'required|string|min:8|confirmed',
        ];
    }

    protected $messages = [
        'name.required' => 'El nombre es obligatorio',
        'name.max' => 'El nombre no puede exceder 255 caracteres',
        'email.required' => 'El correo electrónico es obligatorio',
        'email.email' => 'El correo electrónico debe ser válido',
        'email.unique' => 'Este correo electrónico ya está registrado',
        'telefono.max' => 'El teléfono no puede exceder 20 caracteres',
        'role_id.required' => 'El rol es obligatorio',
        'role_id.exists' => 'El rol seleccionado no es válido',
        'password.required' => 'La contraseña es obligatoria',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        'password.confirmed' => 'Las contraseñas no coinciden',
    ];

    public function save()
    {
        $validated = $this->validate();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user = User::updateOrCreate(
            ['id' => $this->userId],
            $data
        );

        // Asignar rol
        if ($this->role_id) {
            $user->roles()->sync([$this->role_id]);
        }

        $mensaje = $this->userId
            ? 'Usuario actualizado correctamente'
            : 'Usuario creado correctamente';

        session()->flash('success', $mensaje);

        return redirect()->route('usuarios.index');
    }

    public function render()
    {
        return view('livewire.usuarios-form');
    }
}
