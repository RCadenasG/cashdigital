<?php

namespace App\Livewire;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Formulario de Cliente')]
class ClientesForm extends Component
{
    public $id;
    public $name;
    public $email;
    public $telefono;
    public $direccion;
    public $estado = 1;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clientes,email,' . $this->id,
            'telefono' => 'nullable|string|size:9',
            'direccion' => 'nullable|string|max:50',
            'estado' => 'required|integer|in:1,2',
        ];
    }

    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'email.required' => 'El email es obligatorio.',
        'email.email' => 'El email debe ser válido.',
        'email.unique' => 'Este email ya está registrado.',
        'telefono.size' => 'El teléfono debe tener exactamente 9 dígitos.',
        'direccion.max' => 'La dirección no puede exceder 50 caracteres.',
    ];

    public function mount($id = null)
    {
        $this->id = $id;

        if ($id) {
            $cliente = Cliente::findOrFail($id);
            $this->name = $cliente->name;
            $this->email = $cliente->email;
            $this->telefono = $cliente->telefono;
            $this->direccion = $cliente->direccion;
            $this->estado = $cliente->estado;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'estado' => $this->estado,
        ];

        if ($this->id) {
            $cliente = Cliente::findOrFail($this->id);
            $cliente->update($data);
            session()->flash('success', 'Cliente actualizado exitosamente.');
        } else {
            Cliente::create($data);
            session()->flash('success', 'Cliente creado exitosamente.');
        }

        return redirect()->route('clientes.index');
    }

    public function render()
    {
        return view('livewire.clientes-form');
    }
}
