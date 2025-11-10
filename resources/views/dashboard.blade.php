<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    {{-- fondo con imagen --}}
    <div
        style="height: calc(100vh - 95px); overflow: hidden; background-image: url('{{ asset('img/fondoCashDigital.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container-fluid" style="padding: 2rem;">
            <!-- Bienvenida -->
            <div class="card bg-primary bg-gradient text-white rounded-4 shadow"
                style="max-width: 1400px; width: 100%; margin: 0 auto;">
                <div class="card-body" style="padding: 2rem;">
                    <h1 style="font-size: 3.5rem; font-weight: bold; text-align: center; margin: 0;">
                        Bienvenido al sistema CashDigital
                    </h1>
                    <p style="font-size: 1.75rem; text-align: center; margin: 0;">Transferencias rapidas y
                        seguras para ti.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
