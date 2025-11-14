<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    {{-- fondo con imagen --}}
    <div
        style="height: 100%; background-image: url('{{ asset('img/fondoCashDigital.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">
        <div class="container-fluid p-2 p-md-4">
            <!-- Bienvenida -->
            <div class="card bg-primary bg-gradient text-white rounded-4 shadow"
                style="max-width: 1400px; width: 100%; margin: 0 auto;">
                <div class="card-body p-3 p-md-4">
                    <h1 class="mb-0 fw-bold text-center" style="font-size: clamp(2rem, 4vw, 3.5rem);">
                        Bienvenido al sistema CashDigital
                    </h1>
                    <p class="text-center mb-0" style="font-size: clamp(1rem, 2vw, 1.75rem);">
                        Transferencias rápidas y seguras para ti.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
