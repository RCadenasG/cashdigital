<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Parametro;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Parámetros del Sistema')]
class ParametrosIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $parametro = Parametro::find($id);

        if ($parametro) {
            $parametro->delete();
            session()->flash('success', 'Parámetro eliminado correctamente.');
        } else {
            session()->flash('error', 'Parámetro no encontrado.');
        }
    }

    public function toggleEstado($id)
    {
        $parametro = Parametro::find($id);

        if ($parametro) {
            $parametro->estado = !$parametro->estado;
            $parametro->save();
            session()->flash('success', 'Estado actualizado correctamente.');
        }
    }

    public function render()
    {
        $parametros = Parametro::query()
            ->where(function($query) {
                $query->where('tabla', 'like', "%{$this->search}%")
                      ->orWhere('secuencia', 'like', "%{$this->search}%")
                      ->orWhere('descripcion_corta', 'like', "%{$this->search}%")
                      ->orWhere('descripcion_larga', 'like', "%{$this->search}%");
            })
            ->orderBy('tabla', 'asc')->orderBy('secuencia', 'asc')
            ->paginate($this->perPage);

        return view('livewire.parametros-index', [
            'parametros' => $parametros
        ]);
    }
}
