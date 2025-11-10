<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Parametro;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;

class ParametrosForm extends Component
{
    public ?int $parametroId = null;
    public string $tabla = '';
    public string $secuencia = '';
    public ?string $descripcion_corta = null;
    public ?string $descripcion_larga = null;

    public function mount($id = null)
    {
        if ($id) {
            $parametro = Parametro::findOrFail($id);
            $this->parametroId = $parametro->id;
            $this->tabla = $parametro->tabla;
            $this->secuencia = $parametro->secuencia;
            $this->descripcion_corta = $parametro->descripcion_corta;
            $this->descripcion_larga = $parametro->descripcion_larga;
        }
    }

    protected function rules()
    {
        return [
            'tabla' => [
                'required',
                'string',
                'max:20',
            ],
            'secuencia' => 'required|numeric',
            'descripcion_corta' => 'nullable|string|max:10',
            'descripcion_larga' => 'nullable|string|max:50',
        ];
    }

    protected $messages = [
        'tabla.required' => 'La tabla es obligatoria',
        'tabla.max' => 'La tabla no puede exceder 20 caracteres',
        'secuencia.required' => 'La secuencia es obligatoria',
        'descripcion_corta.max' => 'La descripción corta no puede exceder 10 caracteres',
        'descripcion_larga.max' => 'La descripción larga no puede exceder 50 caracteres',
    ];

    public function save()
    {
        $validated = $this->validate();

        Parametro::updateOrCreate(
            ['id' => $this->parametroId],
            $validated
        );

        $mensaje = $this->parametroId
            ? 'Parámetro actualizado correctamente'
            : 'Parámetro creado correctamente';

        session()->flash('success', $mensaje);

        return redirect()->route('parametros.index');
    }

    #[Layout('layouts.app')]
    #[Title('Formulario de Parámetros')]
    public function render()
    {
        return view('livewire.parametros-form');
    }
}
