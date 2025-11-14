<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        .sidebar {
            width: 280px;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            background: linear-gradient(180deg, #053b8c 0%, #085cd1 100%);
            border-right: 1px solid #30363d;
            z-index: 1000;
            padding-top: 60px;
        }

        .main-content {
            margin-left: 280px;
            height: calc(100vh - 60px);
            margin-top: 60px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .content-area {
            flex: 1;
            overflow-y: auto;
            position: relative;
            min-height: 0;
            background-color: #0c78ec;
        }

        .footer-area {
            flex-shrink: 0;
            background-color: transparent;
            margin-top: auto;
        }

        .sidebar-link {
            padding: 0.8rem 1rem;
            display: flex;
            align-items: center;
            color: #c9d1d9;
            text-decoration: none;
            border-left: 4px solid transparent;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: #ffffff0d;
            color: white;
            border-left-color: #2d7ff3;
        }

        .sidebar-link i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .top-navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            height: 60px;
            z-index: 1001;
            background: rgb(3, 50, 120);
            border-bottom: 1px solid #30363d;
            display: flex;
            align-items: center;
            padding: 0 20px;
            justify-content: space-between;
        }

        .dropdown-trigger {
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
        }

        .dropdown-menu-custom {
            background: #074a9e;
            border: 1px solid #30363d;
            border-radius: 0.375rem;
            margin-top: 0.25rem;
        }

        .dropdown-menu-custom a {
            padding: 0.5rem 1rem;
            display: block;
            color: #fff;
            text-decoration: none;
            transition: background 0.2s;
        }

        .dropdown-menu-custom a:hover {
            background: #0d6efd;
        }
    </style>

    @livewireStyles
</head>

<body class="bg-dark text-white h-100">

    <!-- Top Navbar -->
    <div class="top-navbar">
        <!-- Logo al extremo izquierdo -->
        <div>
            <img src="{{ asset('img/logoCashDigital.jpg') }}" alt="Logo Cash Digital" style="height: 60px;">
        </div>

        <!-- Profile y cerrar sesión al extremo derecho -->
        <form method="POST" action="{{ route('logout') }}" class="m-0 d-flex align-items-center gap-3">
            @csrf
            <i class="bi bi-person-gear"></i>
            <a href="{{ route('profile.edit') }}" class="text-white text-decoration-none" style="margin-right: 1.5rem">
                {{ Auth::user()->name }}
            </a>
            <button type="submit" class="btn btn-sm btn-outline-danger text-white">
                <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
            </button>
        </form>
    </div>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="sidebar d-lg-block bg-dark text-white">

        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="{{ route('dashboard') }}">
                    <p class="text-center"
                        style="margin-top: 1rem; font-size: 1.5rem; font-weight: bold; color: #FFEB3B">
                        Menu Principal
                    </p>
                </a>

                <!-- Menu Clientes -->
                <a href="{{ route('clientes.index') }}"
                    class="sidebar-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Clientes
                </a>

                <!-- Menu Operaciones -->
                <a href="{{ route('operaciones.index') }}"
                    class="sidebar-link {{ request()->routeIs('operaciones.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i> Operaciones
                </a>

                @role('admin')
                    <a href="{{ route('parametros.index') }}"
                        class="sidebar-link {{ request()->routeIs('parametros.*') ? 'active' : '' }}">
                        <i class="bi bi-sliders"></i> Parámetros
                    </a>

                    <!-- Menu Expandible Roles y Usuarios -->
                    <x-dropdown align="right" width="80">
                        <x-slot name="trigger">
                            <button type="button" class="sidebar-link dropdown-trigger">
                                <i class="bi bi-people-fill"></i>
                                <span class="flex-grow-1">Roles y Usuarios</span>
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="dropdown-menu-custom">
                                <a href="{{ route('roles.index') }}">
                                    <i class="bi bi-shield-lock"></i> Roles
                                </a>
                                <a href="{{ route('usuarios.index') }}">
                                    <i class="bi bi-person-badge"></i> Usuarios
                                </a>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @endrole
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-area">
            {{ $slot }}
        </div>

        <!-- Footer fijo -->
        <div class="footer-area">
            <x-footer />
        </div>
    </main>

    @livewireScripts
</body>

</html>
