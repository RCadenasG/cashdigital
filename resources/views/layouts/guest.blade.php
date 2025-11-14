<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600" rel="stylesheet" />

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url('{{ asset('img/fondoCashDigital.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
        }
    </style>
</head>

<body class="bg-dark text-white">
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
        <div class="card bg-dark border-secondary shadow-lg" style="width: 100%; max-width: 450px;">
            <div class="card-body p-5">
                <div
                    style="display: flex; justify-content: center; align-items: center; width: 100%; margin-bottom: 1.5rem;">
                    <img src="{{ asset('img/logoCashDigital.jpg') }}" alt="Logo Cash Digital"
                        style="height: 180px; display: block; margin: 0 auto;">
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
