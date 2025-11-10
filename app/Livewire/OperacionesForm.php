<?php

namespace App\Livewire;

use App\Models\Operacion;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Parametro;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
#[Title('Formulario de Operación')]
class OperacionesForm extends Component
{
    public $id;
    public $cliente_id = '';
    public $user_id;
    public $tipo_pago = '';
    public $servicio = '';
    public $monto_pago = '';
    public $monto_comision = 0;
    public $fecha;
    public $hora;

    public function mount($id = null)
    {
        $this->id = $id;
        $this->user_id = Auth::id();
        $this->fecha = now()->format('Y-m-d');
        $this->hora = now()->format('H:i');

        if ($id) {
            $operacion = Operacion::findOrFail($id);
            $this->cliente_id = $operacion->cliente_id;
            $this->user_id = $operacion->user_id;
            $this->tipo_pago = $operacion->tipo_pago;
            $this->servicio = $operacion->servicio;
            $this->monto_pago = $operacion->monto_pago;
            $this->monto_comision = $operacion->monto_comision;
            $this->fecha = $operacion->fecha->format('Y-m-d');
            $this->hora = $operacion->hora->format('H:i');
        }
    }

    protected function rules()
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'user_id' => 'required|exists:users,id',
            'tipo_pago' => 'required|in:1,2',
            'servicio' => 'required_if:tipo_pago,1|nullable|exists:parametros,id',
            'monto_pago' => 'required|numeric|min:0.01',
            'fecha' => 'required|date',
            'hora' => 'required',
        ];
    }

    protected $messages = [
        'cliente_id.required' => 'Debe seleccionar un cliente.',
        'tipo_pago.required' => 'Debe seleccionar el tipo de pago.',
        'servicio.required_if' => 'Debe seleccionar un servicio.',
        'monto_pago.required' => 'El monto a pagar es obligatorio.',
        'monto_pago.min' => 'El monto debe ser mayor a 0.',
        'fecha.required' => 'La fecha es obligatoria.',
        'hora.required' => 'La hora es obligatoria.',
    ];

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['tipo_pago', 'monto_pago'])) {
            $this->calcularComision();
        }
    }

    public function calcularComision()
    {
        if (!$this->tipo_pago || !$this->monto_pago) {
            $this->monto_comision = 0;
            return;
        }

        try {
            if ($this->tipo_pago == 1) {
                // Comisión fija para Servicios
                $parametro = Parametro::where('tabla', 'COMISION')
                    ->where('descripcion_corta', 'SERVICIO')
                    ->first();

                if ($parametro) {
                    $this->monto_comision = (float) $parametro->descripcion_larga;
                }
            } else {
                // Comisión por factor para Transferencias
                $parametro = Parametro::where('tabla', 'COMISION')
                    ->where('descripcion_corta', 'TRANSFER')
                    ->first();

                if ($parametro) {
                    $factor = (float) $parametro->descripcion_larga;
                    if ($factor > 0) {
                        $division = $this->monto_pago / $factor;
                        $residuo = fmod($this->monto_pago, $factor);

                        if ($residuo == 0) {
                            $this->monto_comision = $division;
                        } else {
                            $this->monto_comision = ceil($division);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->monto_comision = 0;
        }
    }

    public function save()
    {
        $this->validate();
        $this->calcularComision();

        $data = [
            'cliente_id' => $this->cliente_id,
            'user_id' => $this->user_id,
            'tipo_pago' => $this->tipo_pago,
            'servicio' => $this->tipo_pago == 1 ? $this->servicio : null,
            'monto_pago' => $this->monto_pago,
            'monto_comision' => $this->monto_comision,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
        ];

        if ($this->id) {
            $operacion = Operacion::findOrFail($this->id);
            $operacion->update($data);
            session()->flash('success', 'Operación actualizada exitosamente.');
        } else {
            Operacion::create($data);
            session()->flash('success', 'Operación registrada exitosamente.');
        }

        return redirect()->route('operaciones.index');
    }

    #[Computed]
    public function clientes()
    {
        return Cliente::where('estado', 1)->orderBy('name')->get();
    }

    #[Computed]
    public function usuarios()
    {
        return User::orderBy('name')->get();
    }

    #[Computed]
    public function servicios()
    {
        return Parametro::where('tabla', 'SERVICIOS')->orderBy('descripcion_corta')->get();
    }

    public function render()
    {
        return view('livewire.operaciones-form');
    }
}
