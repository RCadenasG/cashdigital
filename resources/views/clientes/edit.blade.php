<x-app-layout>
    <x-slot name="title">Editar Cliente</x-slot>

    @livewire('clientes-form', ['clienteId' => $cliente->id])
</x-app-layout>
